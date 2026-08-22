<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use PDO;

/**
 * Migrates the `leads` table directly from a PostgreSQL source to the current
 * MySQL database, without writing any PII to the filesystem or repository.
 *
 * Usage (run on the cPanel server after the main seeder):
 *   php artisan migrate:leads-from-postgres --pg-url="postgres://user:pass@host/dbname"
 *
 * The command reads each row from PostgreSQL, normalises timestamps, and
 * upserts into MySQL. It reports source vs. destination counts so the operator
 * can confirm no records were lost.
 */
class MigrateLeadsFromPostgres extends Command
{
    protected $signature = 'migrate:leads-from-postgres
                            {--pg-url= : PostgreSQL DSN (overrides POSTGRES_URL env var)}
                            {--truncate : Truncate the MySQL leads table before importing}
                            {--dry-run : Show what would be imported without writing anything}';

    protected $description = 'Migrate leads directly from PostgreSQL → MySQL (no PII stored in files or repo)';

    public function handle(): int
    {
        $pgUrl = $this->option('pg-url') ?: env('POSTGRES_URL');

        // Build PDO DSN.  Priority:
        //   1. --pg-url / POSTGRES_URL  (URL or raw PDO DSN)
        //   2. Standard PG* env vars (PGHOST, PGPORT, PGDATABASE, PGUSER, PGPASSWORD)
        if ($pgUrl) {
            if (str_starts_with($pgUrl, 'pgsql:')) {
                // Already a PDO DSN — use as-is (user/pass must be in the DSN or PG* vars)
                $dsn    = $pgUrl;
                $pgUser = getenv('PGUSER') ?: '';
                $pgPass = getenv('PGPASSWORD') ?: '';
            } else {
                $parsed  = parse_url($pgUrl);
                $rawHost = urldecode($parsed['host'] ?? 'localhost');
                $port    = isset($parsed['port']) ? ";port={$parsed['port']}" : '';
                $dbname  = ltrim($parsed['path'] ?? '', '/');
                $dsn     = "pgsql:host={$rawHost}{$port};dbname={$dbname}";
                $pgUser  = $parsed['user'] ?? getenv('PGUSER') ?: '';
                $pgPass  = urldecode($parsed['pass'] ?? getenv('PGPASSWORD') ?: '');
            }
        } elseif (getenv('PGHOST')) {
            $host   = getenv('PGHOST');
            $port   = getenv('PGPORT') ?: '5432';
            $dbname = getenv('PGDATABASE') ?: 'postgres';
            $dsn    = "pgsql:host={$host};port={$port};dbname={$dbname}";
            $pgUser = getenv('PGUSER') ?: '';
            $pgPass = getenv('PGPASSWORD') ?: '';
        } else {
            $this->error('PostgreSQL connection URL is required. Pass --pg-url, set POSTGRES_URL, or set PGHOST/PGDATABASE/PGUSER/PGPASSWORD.');
            return self::FAILURE;
        }

        $this->info("Connecting to PostgreSQL…");
        try {
            $pgPdo = new PDO($dsn, $pgUser, $pgPass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]);
        } catch (\PDOException $e) {
            $this->error("PostgreSQL connection failed: " . $e->getMessage());
            return self::FAILURE;
        }

        // Fetch all leads from PostgreSQL
        $stmt = $pgPdo->query("SELECT * FROM leads ORDER BY id");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $sourceCount = count($rows);
        $this->info("Found {$sourceCount} lead(s) in PostgreSQL.");

        if ($sourceCount === 0) {
            $this->warn("No leads to migrate.");
            return self::SUCCESS;
        }

        if ($this->option('dry-run')) {
            $this->table(['id', 'name', 'email', 'course_slug', 'created_at'],
                array_map(fn($r) => [
                    $r['id'], $r['name'], '***@***', $r['course_slug'] ?? '', $r['created_at'] ?? ''
                ], $rows)
            );
            $this->info("[dry-run] No data written.");
            return self::SUCCESS;
        }

        if ($this->option('truncate')) {
            DB::table('leads')->truncate();
            $this->info("Truncated MySQL leads table.");
        }

        $inserted = 0;
        DB::beginTransaction();
        try {
            foreach ($rows as $row) {
                DB::table('leads')->insertOrIgnore([
                    'id'          => $row['id'],
                    'name'        => $row['name'],
                    'email'       => $row['email'],
                    'phone'       => $row['phone'] ?? null,
                    'course_slug' => $row['course_slug'] ?? null,
                    'message'     => $row['message'] ?? null,
                    'created_at'  => $this->normaliseTimestamp($row['created_at'] ?? null),
                ]);
                $inserted++;
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->error("Migration failed after {$inserted} row(s): " . $e->getMessage());
            return self::FAILURE;
        }

        // Reset AUTO_INCREMENT on MySQL
        if (DB::getDriverName() === 'mysql') {
            $maxId = DB::table('leads')->max('id') ?? 0;
            DB::statement("ALTER TABLE leads AUTO_INCREMENT = " . ($maxId + 1));
        }

        $destCount = DB::table('leads')->count();

        $this->info("✓ Migrated {$inserted} lead(s) from PostgreSQL.");
        $this->info("  PostgreSQL source : {$sourceCount}");
        $this->info("  MySQL destination : {$destCount}");

        if ($destCount !== $sourceCount) {
            $this->error("COUNT MISMATCH — expected {$sourceCount}, got {$destCount}. Investigate before proceeding.");
            return self::FAILURE;
        }

        $this->info("✓ Source and destination counts match. Leads migration complete.");
        return self::SUCCESS;
    }

    private function normaliseTimestamp(?string $ts): ?string
    {
        if ($ts === null) return null;
        try {
            return (new \DateTime($ts))->format('Y-m-d H:i:s');
        } catch (\Exception) {
            return $ts;
        }
    }
}

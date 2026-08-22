<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImportFromJsonSeeder extends Seeder
{
    /**
     * Import data exported by scripts/export-pg-to-json.js into MySQL.
     *
     * Run AFTER migrations:
     *   php artisan db:seed --class=ImportFromJsonSeeder
     */
    public function run(): void
    {
        $dataDir = __DIR__ . '/../../scripts/data';

        $this->importTable(
            $dataDir . '/categories.json',
            'categories',
            fn($row) => [
                'id'               => $row['id'],
                'slug'             => $row['slug'],
                'name'             => $row['name'],
                'tagline'          => $row['tagline'],
                'description'      => $row['description'],
                'icon_key'         => $row['icon_key'],
                'course_count'     => $row['course_count'] ?? 0,
                'rating'           => $row['rating'] ?? 4.8,
                'learners_enrolled'=> $row['learners_enrolled'] ?? 0,
            ]
        );

        $this->importTable(
            $dataDir . '/courses.json',
            'courses',
            fn($row) => [
                'id'             => $row['id'],
                'slug'           => $row['slug'],
                'title'          => $row['title'],
                'category_slug'  => $row['category_slug'],
                'category_name'  => $row['category_name'],
                'level'          => $row['level'],
                'summary'        => $row['summary'],
                'description'    => $row['description'],
                'duration_hours' => $row['duration_hours'],
                'mode'           => $row['mode'],
                'price'          => $row['price'],
                'rating'         => $row['rating'] ?? 4.7,
                'total_rating'   => $row['total_rating'] ?? 0,
                'enrolled'       => $row['enrolled'] ?? 0,
                'featured'       => $row['featured'] ? 1 : 0,
                'skills'         => is_array($row['skills']) ? json_encode($row['skills']) : ($row['skills'] ?? '[]'),
                'image_url'      => $row['image_url'] ?? '',
                'curriculum'     => is_array($row['curriculum']) ? json_encode($row['curriculum']) : ($row['curriculum'] ?? '[]'),
                'faq'            => is_array($row['faq']) ? json_encode($row['faq']) : ($row['faq'] ?? '[]'),
            ]
        );

        $this->importTable(
            $dataDir . '/testimonials.json',
            'testimonials',
            fn($row) => [
                'id'         => $row['id'],
                'name'       => $row['name'],
                'role'       => $row['role'],
                'company'    => $row['company'],
                'quote'      => $row['quote'],
                'rating'     => $row['rating'] ?? 5,
                'avatar_url' => $row['avatar_url'] ?? '',
                'source'     => $row['source'] ?? 'other',
                'visible'    => $row['visible'] ? 1 : 0,
            ]
        );

        // ─── Leads: PII – NOT committed to the repository ────────────────────────
        // leads.json is git-ignored because it contains real names, email
        // addresses, and phone numbers.  Migrate leads separately via the
        // dedicated Artisan command (requires live access to the PostgreSQL DB):
        //
        //   php artisan migrate:leads-from-postgres \
        //       --pg-url="postgres://user:pass@host/dbname" \
        //       --truncate
        //
        // The command reads directly from PostgreSQL, applies the same timestamp
        // normalisation, resets AUTO_INCREMENT, and asserts source == target count.
        if (!file_exists($dataDir . '/leads.json')) {
            $this->command->warn('');
            $this->command->warn('⚠  LEADS NOT MIGRATED – leads.json is intentionally absent (PII).');
            $this->command->warn('   Run the following to migrate leads from PostgreSQL:');
            $this->command->warn('   php artisan migrate:leads-from-postgres --pg-url="<POSTGRES_URL>" --truncate');
            $this->command->warn('');
        } else {
            $this->importTable(
                $dataDir . '/leads.json',
                'leads',
                fn($row) => [
                    'id'          => $row['id'],
                    'name'        => $row['name'],
                    'email'       => $row['email'],
                    'phone'       => $row['phone'] ?? null,
                    'course_slug' => $row['course_slug'] ?? null,
                    'message'     => $row['message'] ?? null,
                    'created_at'  => $this->normaliseTimestamp($row['created_at'] ?? null) ?? now(),
                ]
            );
        }

        $this->importTable(
            $dataDir . '/proofs.json',
            'proofs',
            fn($row) => [
                'id'         => $row['id'],
                'image_data' => $row['image_data'],
                'caption'    => $row['caption'] ?? '',
                'proof_date' => $row['proof_date'],
                'created_at' => $this->normaliseTimestamp($row['created_at'] ?? null) ?? now(),
            ]
        );

        $this->importTable(
            $dataDir . '/whatsapp_chats.json',
            'whatsapp_chats',
            fn($row) => [
                'id'         => $row['id'],
                'image_data' => $row['image_data'],
                'caption'    => $row['caption'] ?? '',
                'created_at' => $this->normaliseTimestamp($row['created_at'] ?? null) ?? now(),
            ]
        );

        // Translation cache — pre-warmed on Replit; importing it means the PHP
        // server serves non-English catalog text instantly with zero LLM spend.
        $this->importTable(
            $dataDir . '/translations.json',
            'translations',
            fn($row) => [
                'id'          => $row['id'],
                'lang'        => $row['lang'],
                'source_hash' => $row['source_hash'],
                'translation' => $row['translation'],
                'created_at'  => $this->normaliseTimestamp($row['created_at'] ?? null) ?? now(),
            ]
        );

        $this->importTable(
            $dataDir . '/video_stories.json',
            'video_stories',
            fn($row) => [
                'id'         => $row['id'],
                'video_data' => $row['video_data'],
                'label'      => $row['label'] ?? '',
                'sort_order' => $row['sort_order'] ?? 0,
                'created_at' => $this->normaliseTimestamp($row['created_at'] ?? null) ?? now(),
            ]
        );
    }

    /**
     * Normalise a PostgreSQL timestamp to MySQL-compatible format (Y-m-d H:i:s).
     * Handles ISO-8601 strings like "2026-06-08T08:01:00.356976+00:00"
     * as well as already-normalised "2026-06-08 08:01:00" strings.
     */
    private function normaliseTimestamp(?string $ts): ?string
    {
        if ($ts === null) return null;
        try {
            return (new \DateTime($ts))->format('Y-m-d H:i:s');
        } catch (\Exception) {
            return $ts;
        }
    }

    private function importTable(string $filePath, string $table, callable $mapper): void
    {
        if (!file_exists($filePath)) {
            $this->command->warn("Skipping {$table}: data file not found at {$filePath}");
            return;
        }

        $rows = json_decode(file_get_contents($filePath), true);
        if (!is_array($rows) || count($rows) === 0) {
            $this->command->info("Skipping {$table}: no rows to import.");
            return;
        }

        DB::table($table)->truncate();

        $mapped = array_map($mapper, $rows);

        // Insert in chunks to avoid memory issues with large datasets
        foreach (array_chunk($mapped, 100) as $chunk) {
            DB::table($table)->insert($chunk);
        }

        // Reset auto-increment to max id + 1 (MySQL only; SQLite manages this automatically)
        if (DB::getDriverName() === 'mysql') {
            $maxId = DB::table($table)->max('id') ?? 0;
            DB::statement("ALTER TABLE {$table} AUTO_INCREMENT = " . ($maxId + 1));
        }

        $this->command->info("✓ {$table}: imported " . count($rows) . " rows.");
    }
}

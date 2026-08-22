#!/usr/bin/env node
/**
 * export-pg-to-json.js
 *
 * Exports all 7 tables from the existing PostgreSQL database to JSON files
 * so they can be imported into MySQL via Laravel seeders.
 *
 * Usage:
 *   DATABASE_URL=postgres://... node laravel-backend/scripts/export-pg-to-json.js
 *
 * Output: laravel-backend/scripts/data/{table}.json
 */

import { createRequire } from 'module';
import { mkdir, writeFile } from 'fs/promises';
import { fileURLToPath } from 'url';
import path from 'path';

const require = createRequire(import.meta.url);
const __dirname = path.dirname(fileURLToPath(import.meta.url));

const DATA_DIR = path.join(__dirname, 'data');

const DATABASE_URL = process.env.DATABASE_URL;
if (!DATABASE_URL) {
  console.error('ERROR: DATABASE_URL environment variable is required.');
  process.exit(1);
}

// Dynamically import pg (must be installed: npm install pg in the workspace root)
let pg;
try {
  pg = require('pg');
} catch {
  console.error('ERROR: pg package not found. Run: npm install pg');
  process.exit(1);
}

const { Pool } = pg;

const TABLES = [
  'categories',
  'courses',
  'testimonials',
  'leads',
  'proofs',
  'whatsapp_chats',
  'video_stories',
  // Server-side translation cache (lang + sha256(source text) -> translation).
  // Importing it means the MySQL server starts with every already-purchased
  // LLM translation, so non-English pages render instantly with no LLM spend.
  'translations',
];

async function main() {
  const pool = new Pool({ connectionString: DATABASE_URL });

  try {
    await mkdir(DATA_DIR, { recursive: true });
    console.log(`Exporting to: ${DATA_DIR}\n`);

    for (const table of TABLES) {
      try {
        const result = await pool.query(`SELECT * FROM ${table} ORDER BY id`);
        const outPath = path.join(DATA_DIR, `${table}.json`);
        await writeFile(outPath, JSON.stringify(result.rows, null, 2), 'utf8');
        console.log(`✓ ${table}: ${result.rows.length} rows → ${outPath}`);
      } catch (err) {
        console.warn(`✗ ${table}: ${err.message} (table may not exist — skipping)`);
      }
    }

    console.log('\nExport complete. Run Laravel seeders next:');
    console.log('  cd laravel-backend && php artisan db:seed --class=ImportFromJsonSeeder');
  } finally {
    await pool.end();
  }
}

main().catch((err) => {
  console.error('Export failed:', err);
  process.exit(1);
});

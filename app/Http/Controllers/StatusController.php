<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class StatusController extends Controller
{
    /**
     * How long a cached check result is considered fresh (seconds).
     * Matches the 5-minute interval shown on the page.
     */
    private const FRESHNESS_TTL = 300;

    /**
     * Maximum number of historical check results kept per endpoint.
     * 288 = 24 h at one check every 5 minutes.
     */
    private const MAX_HISTORY = 288;

    /**
     * Endpoints to monitor.
     */
    private const ENDPOINTS = [
        'healthz' => ['name' => 'API Health',      'path' => '/api/healthz'],
        'courses' => ['name' => 'Course Catalog',  'path' => '/api/courses'],
    ];

    // ─── Public routes ────────────────────────────────────────────────────────

    public function html(): Response
    {
        $data = $this->buildSummary();
        $html = $this->renderHtml($data);

        return response($html, 200)
            ->header('Content-Type', 'text/html; charset=utf-8')
            ->header('Cache-Control', 'no-store');
    }

    public function json(): JsonResponse
    {
        return response()->json([
            'generatedAt' => now()->toISOString(),
            'endpoints'   => $this->buildSummary(),
        ])->header('Cache-Control', 'no-store');
    }

    // ─── Core logic ───────────────────────────────────────────────────────────

    /**
     * For each monitored endpoint, refresh if stale, then return a summary.
     *
     * @return array<int, array<string, mixed>>
     */
    private function buildSummary(): array
    {
        $summaries = [];

        foreach (self::ENDPOINTS as $key => $meta) {
            $cacheKey = "status_history_{$key}";
            /** @var array<int, array<string, mixed>> $history */
            $history = Cache::get($cacheKey, []);

            // Refresh if we have no history or the last check is stale.
            $lastTs = empty($history) ? 0 : ($history[count($history) - 1]['timestamp'] ?? 0);
            if ((time() - $lastTs) >= self::FRESHNESS_TTL) {
                $check   = $this->probe($meta['path']);
                $history = array_merge($history, [$check]);

                // Trim to the rolling window.
                if (count($history) > self::MAX_HISTORY) {
                    $history = array_slice($history, -self::MAX_HISTORY);
                }

                // Store indefinitely; we manage freshness ourselves.
                Cache::forever($cacheKey, $history);
            }

            $last      = empty($history) ? null : $history[count($history) - 1];
            $okCount   = count(array_filter($history, fn($c) => $c['ok']));
            $total     = count($history);
            $uptimePct = $total > 0
                ? round(($okCount / $total) * 10000) / 100
                : null;

            $summaries[] = [
                'key'          => $key,
                'name'         => $meta['name'],
                'path'         => $meta['path'],
                'current'      => $last === null ? 'unknown' : ($last['ok'] ? 'operational' : 'outage'),
                'uptimePct'    => $uptimePct,
                'lastCheck'    => $last,
                // Last 12 checks ≈ 1 hour for the sparkline.
                'recentChecks' => array_slice($history, -12),
            ];
        }

        return $summaries;
    }

    /**
     * Hit a local API path and return a check result.
     *
     * @return array<string, mixed>
     */
    private function probe(string $path): array
    {
        $base  = rtrim(config('app.url'), '/');
        $url   = $base . $path;
        $start = (int) round(microtime(true) * 1000);

        try {
            $response = Http::timeout(10)->get($url);
            $ok         = $response->successful();
            $httpStatus = $response->status();
        } catch (\Throwable) {
            $ok         = false;
            $httpStatus = 0;
        }

        return [
            'timestamp'     => time(),
            'ok'            => $ok,
            'httpStatus'    => $httpStatus,
            'responseTimeMs' => (int) round(microtime(true) * 1000) - $start,
        ];
    }

    // ─── HTML renderer ────────────────────────────────────────────────────────

    /**
     * @param array<int, array<string, mixed>> $endpoints
     */
    private function renderHtml(array $endpoints): string
    {
        $now = now()->format('M j, Y H:i:s T');

        $overallHtml   = $this->overallBanner($endpoints);
        $endpointCards = implode("\n", array_map([$this, 'endpointCard'], $endpoints));

        return <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Corporate Academy — API Status</title>
  <meta http-equiv="refresh" content="60" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --green:   #16a34a; --green-bg:  #dcfce7;
      --red:     #dc2626; --red-bg:    #fee2e2;
      --yellow:  #d97706; --yellow-bg: #fef9c3;
      --grey:    #6b7280; --grey-bg:   #f3f4f6;
      --primary: #e85d26;
      --surface: #ffffff; --border: #e5e7eb;
      --text:    #111827; --muted:  #6b7280;
      --radius:  12px;
    }
    body { font-family: system-ui, -apple-system, sans-serif; background: #f9fafb; color: var(--text); min-height: 100vh; padding: 2rem 1rem; }
    .container { max-width: 760px; margin: 0 auto; }
    .site-header { display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem; }
    .logo { font-size: 1.25rem; font-weight: 700; color: var(--primary); letter-spacing: -0.02em; }
    .logo span { color: var(--text); font-weight: 400; }
    .header-meta { margin-left: auto; font-size: 0.75rem; color: var(--muted); text-align: right; }
    .overall { display: flex; align-items: center; gap: 0.75rem; padding: 1rem 1.25rem; border-radius: var(--radius); font-weight: 600; font-size: 1rem; margin-bottom: 1.5rem; }
    .operational-bg { background: var(--green-bg); color: var(--green); }
    .outage-bg      { background: var(--red-bg);   color: var(--red); }
    .unknown-bg     { background: var(--grey-bg);  color: var(--grey); }
    .dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
    .dot-green { background: var(--green); box-shadow: 0 0 0 3px #86efac; }
    .dot-red   { background: var(--red);   box-shadow: 0 0 0 3px #fca5a5; }
    .dot-grey  { background: var(--grey); }
    .card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 1.25rem 1.5rem; margin-bottom: 1rem; box-shadow: 0 1px 3px rgb(0 0 0/.06); }
    .card-header { display: flex; align-items: center; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 1rem; }
    .ep-name { font-weight: 600; font-size: 1rem; }
    .ep-path { font-family: ui-monospace, monospace; font-size: 0.75rem; background: var(--grey-bg); padding: 2px 6px; border-radius: 4px; color: var(--muted); }
    .badge { margin-left: auto; font-size: 0.7rem; font-weight: 700; letter-spacing: 0.06em; text-transform: uppercase; padding: 3px 10px; border-radius: 99px; }
    .badge.operational { background: var(--green-bg); color: var(--green); }
    .badge.outage      { background: var(--red-bg);   color: var(--red); }
    .badge.unknown     { background: var(--grey-bg);  color: var(--grey); }
    .card-metrics { display: flex; flex-wrap: wrap; gap: 1.25rem; margin-bottom: 1rem; }
    .metric { display: flex; flex-direction: column; gap: 2px; }
    .metric-label { font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--muted); }
    .metric-value { font-size: 0.9rem; font-weight: 600; }
    .metric-value.small { font-weight: 400; font-size: 0.8rem; }
    .uptime-green  { color: var(--green); }
    .uptime-yellow { color: var(--yellow); }
    .uptime-red    { color: var(--red); }
    .uptime-na     { color: var(--muted); }
    .spark-row { display: flex; align-items: center; gap: 0.75rem; }
    .spark-label { font-size: 0.7rem; color: var(--muted); white-space: nowrap; }
    .sparkline { display: flex; gap: 3px; align-items: flex-end; }
    .bar { width: 10px; height: 24px; border-radius: 3px; flex-shrink: 0; cursor: default; }
    .bar-ok   { background: var(--green); opacity: 0.8; }
    .bar-fail { background: var(--red);   opacity: 0.9; }
    .spark-empty { font-size: 0.75rem; color: var(--muted); font-style: italic; }
    .page-footer { margin-top: 2.5rem; text-align: center; font-size: 0.75rem; color: var(--muted); }
    .page-footer a { color: var(--primary); text-decoration: none; }
    .page-footer a:hover { text-decoration: underline; }
    @media (prefers-color-scheme: dark) {
      body { background: #0f172a; color: #f1f5f9; }
      .card { background: #1e293b; border-color: #334155; }
      .ep-path { background: #0f172a; color: #94a3b8; }
      .metric-label, .spark-label, .page-footer { color: #64748b; }
      .header-meta { color: #64748b; }
    }
  </style>
</head>
<body>
  <div class="container">
    <header class="site-header">
      <div class="logo">Corporate<span> Academy</span></div>
      <div class="header-meta">
        Updated: {$now}<br>
        <small>Auto-refreshes every 60 s &middot; Checks run every 5 min</small>
      </div>
    </header>

    {$overallHtml}

    {$endpointCards}

    <p style="font-size:0.75rem;color:var(--muted);margin-bottom:2rem;">
      Checks run on-demand every 5 minutes and are cached server-side.
      Uptime % reflects all data since the server was first checked.
      Hover over sparkline bars to see per-check details.
    </p>

    <footer class="page-footer">
      <a href="/">Corporate Academy</a> &middot;
      <a href="/api/status.json">JSON</a> &middot;
      <a href="/api/healthz">Healthz</a>
    </footer>
  </div>
</body>
</html>
HTML;
    }

    /**
     * @param array<int, array<string, mixed>> $endpoints
     */
    private function overallBanner(array $endpoints): string
    {
        $hasOutage = collect($endpoints)->contains(fn($e) => $e['current'] === 'outage');
        $allOk     = collect($endpoints)->every(fn($e)  => $e['current'] === 'operational');

        if ($hasOutage) {
            return '<div class="overall outage-bg"><span class="dot dot-red"></span>Partial Outage</div>';
        }
        if ($allOk) {
            return '<div class="overall operational-bg"><span class="dot dot-green"></span>All Systems Operational</div>';
        }
        return '<div class="overall unknown-bg"><span class="dot dot-grey"></span>Checking&hellip;</div>';
    }

    /**
     * @param array<string, mixed> $ep
     */
    private function endpointCard(array $ep): string
    {
        $name    = htmlspecialchars((string) $ep['name']);
        $path    = htmlspecialchars((string) $ep['path']);
        $current = (string) $ep['current'];

        $badge = match ($current) {
            'operational' => '<span class="badge operational">Operational</span>',
            'outage'      => '<span class="badge outage">Outage</span>',
            default       => '<span class="badge unknown">No data yet</span>',
        };

        // Uptime
        $uptimePct = $ep['uptimePct'];
        if ($uptimePct === null) {
            $uptimeHtml = '<span class="uptime-na">—</span>';
        } else {
            $pct  = (float) $uptimePct;
            $cls  = $pct >= 99 ? 'uptime-green' : ($pct >= 95 ? 'uptime-yellow' : 'uptime-red');
            $uptimeHtml = "<span class=\"{$cls}\">{$pct}%</span>";
        }

        // Response time
        $last      = $ep['lastCheck'];
        $respTime  = $last ? ($last['responseTimeMs'] . ' ms') : '—';

        // Last checked
        $lastChecked = $last
            ? date('M j, H:i:s T', (int) $last['timestamp'])
            : 'Not yet checked';

        // Sparkline
        $recentChecks = (array) $ep['recentChecks'];
        if (empty($recentChecks)) {
            $sparkHtml = '<span class="spark-empty">No checks recorded yet</span>';
        } else {
            $bars = '';
            foreach ($recentChecks as $check) {
                $cls   = $check['ok'] ? 'bar-ok' : 'bar-fail';
                $label = ($check['ok'] ? 'OK' : 'FAIL')
                    . ' · ' . $check['responseTimeMs'] . ' ms'
                    . ' · ' . date('M j, H:i:s', (int) $check['timestamp']);
                $bars .= "<span class=\"bar {$cls}\" title=\"{$label}\"></span>";
            }
            $sparkHtml = "<div class=\"sparkline\" aria-label=\"Recent checks\">{$bars}</div>";
        }

        return <<<CARD
    <div class="card">
      <div class="card-header">
        <span class="ep-name">{$name}</span>
        <code class="ep-path">{$path}</code>
        {$badge}
      </div>
      <div class="card-metrics">
        <div class="metric">
          <span class="metric-label">Uptime (since first check)</span>
          <span class="metric-value">{$uptimeHtml}</span>
        </div>
        <div class="metric">
          <span class="metric-label">Last response time</span>
          <span class="metric-value">{$respTime}</span>
        </div>
        <div class="metric">
          <span class="metric-label">Last checked</span>
          <span class="metric-value small">{$lastChecked}</span>
        </div>
      </div>
      <div class="spark-row">
        <span class="spark-label">Last hour (newest &rarr;)</span>
        {$sparkHtml}
      </div>
    </div>
CARD;
    }
}

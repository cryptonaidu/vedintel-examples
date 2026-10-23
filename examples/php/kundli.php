<?php
// Planet details + panchang with PHP's curl extension.
// Run: VEDINTEL_API_KEY=... php examples/php/kundli.php
$key = getenv('VEDINTEL_API_KEY');
if (!$key) { fwrite(STDERR, "Set VEDINTEL_API_KEY first\n"); exit(1); }
const BASE = 'https://vedintelastroapi.com/api/v1';

function vedintel(string $path, array $params, string $key): array {
    $ch = curl_init(BASE . $path . '?' . http_build_query($params));
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTPHEADER => ["X-API-Key: $key"],
    ]);
    $raw = curl_exec($ch);
    if ($raw === false) throw new RuntimeException(curl_error($ch));
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    $body = json_decode($raw, true) ?? [];
    if ($status >= 400) throw new RuntimeException("$status: " . ($body['message'] ?? $body['error'] ?? 'request failed'));
    return $body;
}

$birth = ['dob' => '01/10/1990', 'tob' => '08:30', 'lat' => 28.61, 'lon' => 77.20, 'tz' => 5.5];
$planets = vedintel('/horoscope/planet-details', $birth, $key);
foreach (($planets['response'] ?? []) as $p) {
    if (is_array($p) && isset($p['name'])) {
        echo $p['name'] . ': ' . ($p['zodiac'] ?? $p['sign'] ?? '') . ' ' . ($p['local_degree'] ?? $p['degree'] ?? '') . "\n";
    }
}
$panchang = vedintel('/panchang/panchang', $birth + ['date' => date('d/m/Y')], $key);
echo 'Panchang: ' . substr(json_encode($panchang['response'] ?? null, JSON_UNESCAPED_UNICODE), 0, 400) . "\n";

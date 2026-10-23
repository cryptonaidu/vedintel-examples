# VedIntel AstroAPI examples

Minimal, copy-paste examples for [VedIntel AstroAPI](https://vedintelastroapi.com/?utm_source=github&utm_campaign=launch_oct26): a REST API for Vedic astrology (kundli, planet positions, panchang, matching and more). Calculations run on a commercially licensed Swiss Ephemeris (Professional License from Astrodienst).

## First call in 2 minutes

1. Get a key at [vedintelastroapi.com](https://vedintelastroapi.com/pricing?utm_source=github&utm_campaign=launch_oct26): 7-day free trial, 500 API calls. No credit card required.
2. Export it (keys start with `vai_`):
   ```bash
   export VEDINTEL_API_KEY="your_key_here"
   ```
3. Call the API:
   ```bash
   curl -H "X-API-Key: $VEDINTEL_API_KEY" \
     "https://vedintelastroapi.com/api/v1/horoscope/planet-details?dob=01/10/1990&tob=08:30&lat=28.61&lon=77.20&tz=5.5"
   ```

Base URL: `https://vedintelastroapi.com/api/v1`. Authenticate with the `X-API-Key` header or the `?api_key=` query parameter.

## Examples

Each one fetches planet details and today's panchang for a sample birth (01/10/1990, 08:30, New Delhi, UTC+5.5) and reads the key from `VEDINTEL_API_KEY`.

| Language | File | Run |
|---|---|---|
| curl | [examples/curl.sh](examples/curl.sh) | `bash examples/curl.sh` |
| JavaScript (Node 18+) | [examples/javascript/kundli.mjs](examples/javascript/kundli.mjs) | `node examples/javascript/kundli.mjs` |
| Python (requests) | [examples/python/kundli.py](examples/python/kundli.py) | `python examples/python/kundli.py` |
| PHP (curl ext) | [examples/php/kundli.php](examples/php/kundli.php) | `php examples/php/kundli.php` |

## Endpoint overview

Common birth inputs: `dob` (DD/MM/YYYY), `tob` (HH:MM), `lat`, `lon`, `tz` (UTC offset in hours), optional `lang` and `ayanamsa`.

- `/horoscope/*`: planet details, planet report, aspects, planets in houses, charts
- `/extended-horoscope/*`: KP planets and ruling planets, dignity and more
- `/panchang/*`: daily and monthly panchang, planet positions (`date` as DD/MM/YYYY)
- Matching, dasha and more: see the full reference at [vedintelastroapi.com/docs](https://vedintelastroapi.com/docs?utm_source=github&utm_campaign=launch_oct26) and the OpenAPI spec at `/api/v1/openapi.json`.

Rahu/Ketu default to the mean node; add `node_type=true` for the true node.

## Accuracy

Checked against Drik Panchang: every Amavasya, Purnima, Ekadashi and festival date we tested matches, and tithi times are within 2 minutes. [Read the accuracy article](https://vedintelastroapi.com/blog/panchang-api-accuracy-drikpanchang-verified).

## WordPress

No code needed: the [VedIntel Astro Widgets plugin](https://wordpress.org/plugins/vedintel-astro-widgets/) adds kundli, panchang and matching widgets to your site.

## Support

[vedintelastroapi.com/contact](https://vedintelastroapi.com/contact?utm_source=github&utm_campaign=launch_oct26)

## Licence

Examples: MIT (see [LICENSE](LICENSE)). The API runs on a commercially licensed Swiss Ephemeris (Professional License from Astrodienst).

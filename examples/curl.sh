#!/usr/bin/env bash
# Planet details + panchang. Requires: export VEDINTEL_API_KEY=...
set -euo pipefail
: "${VEDINTEL_API_KEY:?Set VEDINTEL_API_KEY first}"
BASE="https://vedintelastroapi.com/api/v1"
BIRTH="dob=01/10/1990&tob=08:30&lat=28.61&lon=77.20&tz=5.5"
TODAY=$(date +%d/%m/%Y)

echo "== Planet details =="
curl -sf -H "X-API-Key: $VEDINTEL_API_KEY" "$BASE/horoscope/planet-details?$BIRTH"
echo
echo "== Panchang ($TODAY) =="
curl -sf -H "X-API-Key: $VEDINTEL_API_KEY" "$BASE/panchang/panchang?$BIRTH&date=$TODAY"
echo

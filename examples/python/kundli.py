"""Planet details + panchang with requests.
Run: pip install requests; VEDINTEL_API_KEY=... python examples/python/kundli.py
"""
import json
import os
import sys
from datetime import date

import requests

KEY = os.environ.get("VEDINTEL_API_KEY")
if not KEY:
    sys.exit("Set VEDINTEL_API_KEY first")
BASE = "https://vedintelastroapi.com/api/v1"


def vedintel(path, **params):
    r = requests.get(BASE + path, params=params, headers={"X-API-Key": KEY}, timeout=30)
    body = r.json()
    if not r.ok:
        raise RuntimeError(f"{r.status_code}: {body.get('message') or body.get('error')}")
    return body


birth = dict(dob="01/10/1990", tob="08:30", lat=28.61, lon=77.20, tz=5.5)
planets = vedintel("/horoscope/planet-details", **birth)
for p in (planets.get("response") or {}).values():
    if isinstance(p, dict) and p.get("name"):
        print(f"{p['name']}: {p.get('zodiac', p.get('sign', ''))} {p.get('local_degree', p.get('degree', ''))}")

panchang = vedintel("/panchang/panchang", **birth, date=date.today().strftime("%d/%m/%Y"))
print("Panchang:", json.dumps(panchang.get("response"), ensure_ascii=False)[:400])

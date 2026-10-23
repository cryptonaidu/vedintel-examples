// Planet details + panchang with fetch (Node 18+).
// Run: VEDINTEL_API_KEY=... node examples/javascript/kundli.mjs
const KEY = process.env.VEDINTEL_API_KEY;
if (!KEY) { console.error("Set VEDINTEL_API_KEY first"); process.exit(1); }
const BASE = "https://vedintelastroapi.com/api/v1";

async function vedintel(path, params) {
  const qs = new URLSearchParams(Object.entries(params).map(([k, v]) => [k, String(v)]));
  const res = await fetch(`${BASE}${path}?${qs}`, { headers: { "X-API-Key": KEY } });
  const body = await res.json();
  if (!res.ok) throw new Error(`${res.status}: ${body.message || body.error || "request failed"}`);
  return body;
}

const birth = { dob: "01/10/1990", tob: "08:30", lat: 28.61, lon: 77.2, tz: 5.5 };
const d = new Date();
const today = [d.getDate(), d.getMonth() + 1].map(n => String(n).padStart(2, "0")).join("/") + "/" + d.getFullYear();

const planets = await vedintel("/horoscope/planet-details", birth);
for (const p of Object.values(planets.response ?? {})) {
  if (p && p.name) console.log(`${p.name}: ${p.zodiac ?? p.sign ?? ""} ${p.local_degree ?? p.degree ?? ""}`);
}
const panchang = await vedintel("/panchang/panchang", { ...birth, date: today });
console.log("Panchang:", JSON.stringify(panchang.response).slice(0, 400));

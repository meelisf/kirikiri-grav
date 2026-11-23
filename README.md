# Kirikiri

Kirikiri veebileht — Grav CMS põhine.

## Mis on repos

- `user/themes/kirikiri/` — kohandatud teema
- `user/pages/` — sisu ja postitused
- `user/config/` — Grav seadistused
- `Dockerfile`, `.htaccess`, `robots.txt` — deploy

Konteinerit (`kirikiri-production`) EI käivitata siit kaustast: teenus on
kirjas ülemkausta `~/koduserver/docker-compose.yml`-is (`docker compose up -d kirikiri`).
Port on seotud ainult `127.0.0.1:8080`-ga; avalik liiklus tuleb Cloudflare Tunneli
kaudu Dockeri võrgus (`http://kirikiri-production:8080`).

## Mis EI ole repos

Grav tuum (`system/`, `vendor/`, `index.php`, `bin/`), pluginad (`user/plugins/`)
ja vaiketeemad uuenevad admin paneeli või `bin/gpm` kaudu.

## Värskelt paigaldatud (kloonist)

```bash
bin/grav install
```

## Deploy & haldus

- `.instructions.md` — serveri seadistus, uuendamine, õigused
- `PROJEKTI_DOKUMENTATSIOON.md` — teema, mallid, sisuhaldus
- `docs/2026-08-23-grav2-otsus-ja-pluginauuendused.md` — Grav 2 migreerimise ajalugu

# Kirikiri

Kirikiri veebileht — Grav CMS põhine.

## Mis on repos

- `user/themes/kirikiri/` — kohandatud teema
- `user/pages/` — sisu ja postitused
- `user/config/` — Grav seadistused
- `user/blueprints/` — kohandatud blueprintid
- `Dockerfile`, `docker-compose.yml`, `.htaccess`, `robots.txt` — deploy

## Mis EI ole repos

Grav tuum (`system/`, `vendor/`, `index.php`, `bin/`), pluginad (`user/plugins/`)
ja vaiketeemad uuenevad admin paneeli või `bin/gpm` kaudu.

## Värskelt paigaldatud (kloonist)

```bash
bin/grav install
```

## Deploy & haldus

Vaata `.instructions.md`, `PROJEKTI_DOKUMENTATSIOON.md` ja `docs/`.
Eriti `docs/2026-06-20-repo-umberkorraldus.md` (repo ümberkorralduse ja
turvauuenduste ülevaade).

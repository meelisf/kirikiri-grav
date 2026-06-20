# Reposse ümberkorraldus ja turvauuendused

**Kuupäev:** 20. juuni 2026 (ajakohastatud: lisatud §4 — Grav 2.0 migreerimisplaan)
**Repo:** `meelisf/kirikiri-grav` (privaatne GitHub)
**Viimane commit:** `bf18dc7`

---

## 1. Taust

Kirikiri veebileht jookseb Grav CMS-il (Dockeris, Apache konteineris). Repo
oli ajapikku kogunud **üle 8400 tracked faili**: Grav tuum (`system/`,
`vendor/`, `bin/`, `index.php`), kõik pluginad, vaiketeema `quark`, ja
isegi kasutajakontod koos parooli hash'idega. See tekitas kolm probleemi:

1. **Plugin/tuum uuendused tekitasid tohutu müra** — `git status` näitas
   sadu muudatusi iga `bin/gpm update` järel, mistõttu oli raske eristada
   "meie" muudatusi GPM'i uuendustest.
2. **Turvariskid** — admin konto bcrypt parooli hash ja emailiaadressid
   olid commit'itud nii tööpuus kui ka ajaloos.
3. **Segane töövoog** — pluginad/teemad uuenevad admin paneeli kaudu,
   seega neid pole mõtet gitis hoida.

## 2. Tehtud tööd

### 2.1 Repo muutmine "skinny"-ks

Lähenemine: **gitis hoitakse ainult seda, mida me ise arendame** — teema,
sisu, config ja blueprintid. Kõik muu uueneb admin/GPM kaudu.

**Muudatused `.gitignore`'is:**

| Kaust / fail | Põhjus |
|---|---|
| `/system/`, `/vendor/`, `/index.php`, `/bin/`, `/composer.*` | Grav tuum — `bin/gpm self-upgrade` kaudu |
| `/user/plugins/*` (v.a `.gitkeep`) | Pluginad — admin paneelist |
| `/user/themes/*` (v.a `.gitkeep` ja `kirikiri/`) | Vaiketeemad — `quark` jne |
| `/user/accounts/*` (v.a `.gitkeep`) | Kontod — turvalisus (parooli hash'id) |
| `/user/data/*` (v.a `.gitkeep`) | Runtime andmed |
| `/cache/`, `/logs/`, `/images/`, `/assets/`, `/backup/`, `/tmp/` | Grav genereeritud |
| `/CHANGELOG.md`, `/LICENSE.txt`, `/SECURITY.md`, jne. | Grav'i enda repo failid |
| `/needs_fixing.txt` | PHPStan väljundi müra |

**Tulemus:** 8400 → **68 tracked faili**.

### 2.2 Git ajaloo ümberkirjutamine (turvalisus)

Lihtsalt `.gitignore` ei eemaldanud saladusi ajaloost. Kasutasin
`git-filter-repo`'t, et puhastada **kogu ajalugu**:

- Eemaldati: `system/`, `vendor/`, `bin/`, `tmp/`, `cache/`, pluginad,
  `quark`, kontod (`user/accounts/`), `user/data/`.
- **Tulemus:** bcrypt parooli hash ja emailiaadressid kaovad igast
  commit'ist (ka vanadest), mitte ainult tulevikust.

Turvaline, sest privaatne repo + `--force` push.

**Suurus:** `.git` 31 MiB → **11 MiB** (−65%). Ülejäänud 11 MiB on
postituste pildid (legitiimne sisu).

**Varukoopia:** tehti enne ümberkirjutamist `git bundle`'ga, pärast
edukat push'i kustutatud.

### 2.3 Uus minimaalne README.md

Grav'i vaike-README asendati lühikese enda omaga, mis selgitab:
- mis on repos (teema, sisu, config)
- mis **ei ole** repos (tuum, pluginad — admin/GPM kaudu)
- kuidas värskelt kloonist käivitada (`bin/grav install`)

### 2.4 Turvateate lahendamine (GHSA-46jp-rc59-w2gc)

Pärast admin uuendusi ilmus hoiatus:

> Email links are not yet pinned to a trusted host, so password reset
> and activation emails fall back to the request host.

Põhjus: ründaja saab võltsida `Host` päist, mis võimaldab suunata
paroolilähtestuslingid phishing saidile.

**Lahendus** (`user/config/system.yaml`):
```yaml
custom_base_url: 'https://kirikiri.eu'   # oli: null
```

Dokumentatsioon: https://learn.getgrav.org/17/security/trusted-host

Valitud Variant 1 (system.yaml `custom_base_url`) Variant 2 asemel
(login plugin `site_host`), sest see katab kogu saidi, mitte ainult
emaililinke.

## 3. Praegune seis

### 3.1 Mis on repos (68 faili)

```
docker-compose.yml, Dockerfile, .env.example, .htaccess, robots.txt
README.md, .instructions.md, PROJEKTI_DOKUMENTATSIOON.md, nuc_deployment_guide.md
docs/                                   ← see dokumentatsioon
user/blueprints/admin/pages/new_post.yaml
user/config/                            ← site, system, security, media, versions, plugins/
user/pages/                             ← kogu sisu + pildid
  01.home/, 02.blog/, 03.tags/, 04.authors/, 05.info/
user/themes/kirikiri/                   ← kohandatud teema (css, js, templates, images)
```

### 3.2 Versioonide olukord

Saidis jooksevad **beta** versioonid, sest `user/config/system.yaml`:
```yaml
gpm:
  releases: testing
```

| Komponent | Versioon | Tüüp |
|---|---|---|
| Grav tuum | `1.8.0-beta.29` | beta |
| Admin | `1.11.0-beta.5` | beta |
| flex-objects | `1.4.0-beta.4` | beta |
| email | `5.0.3` | stabiilne |
| form | `9.1.6` | stabiilne |
| login | `3.8.9` | stabiilne |
| shortcode-core | `6.0.0` | stabiilne |
| sitemap | `5.2.1` | stabiilne |

Viimane **stabiilne** Grav on hetkel `1.7.17` — 1.8.0 pole veel
stabiilsena väljas. Kuna 1.8.0 on juba beta.29 juures, on stabiilne
ilmumine tõenäoliselt lähedal.

### 3.3 Töövoog

```
Arendus (läpakas)              →  git push origin main
                                    ↓
Server (live)                  →  git pull
(see kaust = docker volume)        docker exec kirikiri-production bin/grav clearcache
```

Pluginad/tuum uuenevad serveris admin paneeli või `bin/gpm` kaudu —
need ei lähe repose.

## 4. Edasised plaanid — migreerimine Grav 2.0-le

### 4.1 Tähtis uuendus (20. juuni 2026)

Algne plaan (vt ajalugu allpool) eeldas, et jätkame 1.8 beta'd ja
liigume siis 1.8.0 stabiilsele, kui see välja tuleb. **See plaan on
nüüd muutunud.**

Grav meeskond teatas, et **1.8 ei lähe kunagi stabiilseks** — 1.8
beta tsüklist õpitu viiakse hoopis **Grav 2.0**sse. Seega:

- **1.8.0-beta.29** (meil praegu) on viimane selle rea staadium
- **Grav 2.0** on juba **Release Candidate** staatuses (alates 05.07.2026)
- Migreerimistee on **1.7/1.8 → 2.0** (1.8 kaardub otse 2.0-ks)
- **1.7.52** jääb toetatud (ainult turvaparandused), 1.8 ei toetata

Otsus: **jääme 1.8 beta peale ja ootame 2.0 GA-d**, siis migreerume.
Asi töötab praegu hästi ja ei ole kiiret.

### 4.2 Mida Grav 2.0 toob

- **Admin 2** (Admin Next) — täiesti uus SPA admin (SvelteKit 5, Vite,
  Tailwind 4), asendab klassikalise Twigi-admini
- **First-party REST API** — Grav muutub võimalik-ka headless CMS-iks
- **MCP server** (`grav-mcp`) — AI agentidele (Claude Code) samale
  tasemele ligipääs kui inimesele
- **PHP 8.3 minimaalne**, täistugi 8.4 ja 8.5 (meil juba 8.3.29 ✓)
- **Quark 2** uus vaiketeema (Pico CSS v2, Font Awesome 7) — meie
  kohandatud `kirikiri` teema jääb alles (Twig 3 compat mode)
- Värskendatud Symfony 7 / Twig 3 sõltuvused

### 4.3 Meie soodne lähtepositsioon

| Aspekt | Meie seis | Mõju |
|---|---|---|
| Versioon | 1.8.0-beta.29 | ✓ 1.8 → 2.0 on otsene rada |
| GPM kanal | `testing` | ✓ 2.0 RC elab just testing kanalis |
| PHP | 8.3.29 | ✓ sobib (2.0 min = 8.3) |
| Veebiserver | Apache (Dockeris) | ✓ enim testitud `.htaccess` tee |
| Repo | skinny (teema+sisu gitis) | ✓ lihtne taastada |
| Turvaline uuendamine | `safe_upgrade: true` | ✓ snapshot enne muutusi |

### 4.4 Migreerimismeetod: Migrate to 2.0 plugin

Grav 2.0 ei toeta **in-place** uuendust (1.8 safe-upgrade leidis liiga
palju edge case'e). Selle asemel on **side-by-side staged install**:

1. Plugin paigaldab värske Grav 2.0 subfolderisse (`grav-2/`) — live
   said (1.8) jääb puutumatuks
2. Wizard kopeerib `user/` kausta, kontrollib pluginade compatibility't
3. Testid `http://said/grav-2/` kaudu (live said jookseb edasi)
4. Kui rahul → **Promote** (backup + vahetab webroot); kui mitte → **Reset**

Ohutu ja korratav. Dokumentatsioon:
- https://getgrav.org/migrate-to-2
- https://getgrav.org/blog/migrating-to-grav-2
- https://getgrav.org/blog/grav-2-rc-released

### 4.5 Dockeri-spetsiifilised ohud (teadaolevalt)

Kuna meie said jookseb Dockeris (`./kirikiri-grav:/var/www/html`
volume mount), siis:

1. **Promote** vahetab kogu webroot — see juhtub docker volume'is.
   `system/`, `vendor/`, `index.php`, `.htaccess` muutuvad 2.0 vastu.
   Need on `.gitignore`'is, nii et **git ei näe müra**. ✓
2. **Nginx reverse proxy** ees — `/grav-2/` testimiseks võib vaja minna
   manuaalset rewrite reeglit Nginxis. Apache flow on automaatne, aga
   proxy võib segada. **See tuleb testida enne migreerimist.**
3. **Plugin eeldab kirjutatavat webroot'i** — meil on õigused juba
   korras (`meelis:www-data`, setgid bit).

### 4.6 Pluginade seis 2.0 migreerimisel

| Plugin | Praegu | 2.0 käitumine |
|---|---|---|
| `admin` (klassikaline) | 1.11.0-beta.5 | **eemaldatakse**, asendatakse Admin2 + API-ga |
| `email`, `form`, `login`, `flex-objects`, `problems`, `shortcode-core`, `sitemap` | stabiilne | juba 2.0 compatible (compat flag lisatud) |
| `markdown-notices` | 1.2.0 | soovitatav asendada `github-markdown-alerts`'ga |
| `taxonomylist` | 1.4.2 | 3. osa plugin — võib vajada ülevaatamist (compat flag puudub) |
| **Teema `kirikiri`** (meie oma) | 1.0.0 | **hoitakse**, Twig 3 compat mode renderdab |

### 4.7 Ajakava otsus

- **Nüüd:** ei midagi. Ootame 2.0 **GA-d** (General Availability).
- **Kui GA ilmub:** käivitage Variant B allpool (või oota veel, kui
  tahad, et teised leiavad esimesi vigu).
- **Allikad jälgimiseks:**
  - https://getgrav.org/blog (kuulutused)
  - https://github.com/getgrav/grav/releases
  - https://twitter.com/getgrav

### 4.8 Migreerimise töövoog (kui 2.0 GA ilmub)

**Eeltingimus:** kõik commit'd push'itud, tööpuhas seisund.

1. Varunda: `docker exec kirikiri-production bin/grav backup`
2. Admin → paigalda **Migrate to Grav 2.0** plugin (ilmub bannerisse,
   kuna `gpm.releases: testing` juba sees)
3. **Start Migration** → wizard paigaldab `grav-2/` subfolderisse
4. **Testi** `/grav-2/` (võib-olla vaja Nginx rewrite reegel — vaata §4.5)
5. Kui kõik korras → **Promote**; kui mitte → **Reset** (live said
   puutumatu)
6. Commit + push (ainult `user/` muutused, mida me jälgime)
7. Eemalda Migrate plugin (ainult migreerimise ajaks)

### Ajalooline plaan (ülekirjutatud §4.1 poolt)

Algne (naiivne) plaan oli liikuda 1.8 beta → 1.8.0 stabiilne. See ei
kehti enam — 1.8 ei saa kunagi stabiilseks, rada läheb 2.0-sse.
Esialgne soovitus 'muuda `gpm.releases: stable` ja uuenda' enam ei
kehti, sest stabiilne kanal on 1.7.52 (mitte 1.8). Allapoole liikumine
1.8 → 1.7 ei ole soovitatav.

### Üldine uuendushaldus (kehtib endiselt)

- **Plugin uuendused** → admin paneel või `bin/gpm update` (ei mõjuta
  repo'd).
- **safe_upgrade** on juba `true` (`updates.safe_upgrade`) — enne iga
  tuuma uuendust tehakse automaatselt snapshot. Rollback on võimalik
  `bin/gpm rollback`.
- **Enne suuremaid uuendusi** → `docker exec kirikiri-production
  bin/grav backup`.

## 5. Kuidas uuendada uues keskkonnas

### Serverisse (juba live)

```bash
cd /home/meelis/koduserver/kirikiri-grav
git pull
docker exec kirikiri-production bin/grav clearcache
```

### Värskelt kloonist

```bash
git clone git@github.com:meelisf/kirikiri-grav.git
cd kirikiri-grav
bin/grav install      # laeb tuuma, pluginad, vaiketeemad
```

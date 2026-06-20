# Reposse ümberkorraldus ja turvauuendused

**Kuupäev:** 20. juuni 2026
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

## 4. Edasised plaanid

### Kui Grav 1.8.0 stabiilne välja tuleb

1. Muuda `user/config/system.yaml`:
   ```yaml
   gpm:
     releases: stable    # 'testing' → 'stable'
   ```
2. Uuenda:
   ```bash
   docker exec kirikiri-production bin/gpm update
   ```
3. Commit + push config muudatus.

### Üldine uuendushaldus

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

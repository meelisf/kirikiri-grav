# Grav 2.0 migreerimisotsus + pluginauuendused

**Kuupäev:** 23. august 2026
**Staatus:** pluginad uuendatud ✅ · migreerimine 2.0-le **TEHTUD 14.09.2026** —
vt §8. §3–§6 on alles otsuse ajalooks, aga §3 ("miks täna ei migreerunud") ja
§4 (käivitustingimus) on nüüdseks möödas.
**Asendab:** `2026-06-20-repo-umberkorraldus.md` §4.1 ja §4.7 (need on aegunud —
seal seisab "ootame 2.0 GA-d", GA on nüüdseks ammu käes)

---

## 1. Lühikokkuvõte — mis on nüüd teisiti

| | 20.06.2026 seis | 23.08.2026 seis |
|---|---|---|
| Grav 2.0 | Release Candidate | **GA (2.0.0 ilmus 21.06), praegu 2.0.21** |
| Migreerimisplugin | "tuleb kunagi" | **olemas: GPM slug `migrate-grav`, v1.0.15** |
| Meie tuum 1.8.0-beta.29 | "ootame" | **surnud: 28.12.2025, viimane 1.8 tag üldse** |
| Otsus | ootame GA-d | ootame 2.0 liini rahunemist (§3) |

**Tehtud täna:** 7 pluginauuendust + Quark teema (§2).
**Tegemata:** migreerimine ise — põhjendus §3, käivitustingimus §4.

---

## 2. Tehtud: pluginauuendused (23.08.2026)

Kõik uuendused paigalduvad 1.8-le, sest need deklareerivad `grav >= 1.7.x`.
Migreerimisest sõltumatu — seda ei olnud vaja oodata.

| Plugin | Enne → pärast | Miks |
|---|---|---|
| `shortcode-core` | 6.2.2 → **6.2.5** | GHSA-hvm8-wx3f-j774 stored XSS (high, ≤6.2.4) |
| `form` | 9.1.13 → **9.1.23** | GHSA-33m4, GHSA-89j6, GHSA-5jrr |
| `login` | 3.8.13 → **3.9.3** | minor-hüpe, admin-login testitud ✓ |
| `email` | 5.0.3 → **5.0.6** | |
| `sitemap` | 5.2.1 → **5.2.2** | |
| `error` | 2.0.1 → **2.0.2** | |
| `problems` | 3.0.0 → **3.0.1** | |
| Quark teema | 2.1.4 → **2.1.5** | vaikimisi väljas, aga fallback |

**Töövoog, mis läks käiku:**

```bash
docker exec kirikiri-production bin/grav backup       # ENNE
docker exec kirikiri-production bin/gpm update -y     # kõik korraga
docker exec kirikiri-production bin/grav clearcache
```

**Varukoopia:** `backup/default_site_backup--20260823205743.zip` (29,6 MB).
Taastatavus **tõestatud**, mitte eeldatud: `unzip -t` puhas + neli faili
(`shortcode-core.php`, üks blogipostitus, `system.yaml`, teema blueprint)
pakiti lahti ja `diff`-iti originaali vastu → identsed. Arhiiv sisaldab ka
`user/plugins/`, seega rollback on reaalne, mitte teoreetiline.

**Verifitseerimine** (päris otspunktid, mitte "konteiner käivitus"):
- `https://kirikiri.eu/et`, `/et/blog`, `/sitemap.xml` läbi Cloudflare → 200
- Enne/pärast HTML-i `diff`: **ainus erinevus on asseti cache-buster**
  (`lightbox.js?v=20260823205814` → `...205856`). Sisu bait-identne.
- `localhost:8080/admin` → 200, `<title>Grav Admin Login | Kirikiri</title>`
- `bin/gpm index -U` → PLUGINS [0], THEMES [0]
- `logs/grav.log`: ainsad vead on **5. maist** (vana `flex-objects`
  `Undefined array key "path"`), uuendusest uusi vigu ei tulnud

**Rollback, kui midagi ilmneb:** paki varukoopiast `user/plugins/<nimi>`
tagasi ja `bin/grav clearcache`. Tuuma ei puutunud, seega `gpm rollback`
pole vaja.

---

## 3. Miks 2.0-le EI migreerunud täna

Kaks jõudu töötavad vastassuundades — kumbki üksi annaks vale vastuse.

### 3.1 Ootamine ei ole tasuta (argument migreerimise POOLT)

Meie praegune positsioon ei ole "stabiilne", vaid **külmutatud**:

| Komponent | Meil | Tegelik seis |
|---|---|---|
| Grav tuum | 1.8.0-beta.29 | **28.12.2025**, viimane 1.8 tag kunagi. 1.8 ei saa iial stabiilseks |
| `admin` | 1.11.0-beta.5 | surnud haru (jäi 5 beeta peale); hooldatav liin on 1.10.55, aga see on 1.7 jaoks |
| `flex-objects` | 1.4.0-beta.4 | **GitHubi repo on kadunud** (2.0-s liideti tuuma). GHSA-x929 (high, ≤1.4.7) jääb igaveseks parandamata |

`flex-objects` auk puudutab `[flex-objects]` shortcode'i — kontrollitud,
meie sisus seda **ei kasutata** (`grep -rn "\[flex-objects" user/pages/`
on tühi), seega reaalne risk on väike. Aga muster on selge: **see seis ei
parane ootamisega.** Tuum on 8 kuud turvaparandusteta.

### 3.2 2.0 liin ei ole veel rahunenud (argument VASTU)

**21 paranduskorda kahe kuuga.** August tõi tiheda turvaklastri, mis tabab
2.0 **uut** rünnakupinda:

- Twig-in-content liivakast: GHSA-8hgv (≤2.0.19), GHSA-96xm, GHSA-752r
- Admin2 MarkdownEditor XSS
- Uus `api` plugin: **7+ advisory't kolme nädalaga**, viimased 21.08 (≤1.0.19)
- **2.0.20 (21.08) lõhkus Twigi uuendusega kõik vormid** — parandati
  2.0.21-ga järgmisel päeval (22.08)

Rütm on praegu "parandus → regressioon → parandus". Täna migreerudes
maandume ühepäevasele väljalaskele.

### 3.3 Nüanss, mis otsuse lahendab

Need augusti augud puudutavad enamjaolt asju, mida me **lisaksime**, mitte
mida meil juba on: `api` pluginat me ei paigaldaks, Twig-in-content saab
välja lülitada. Nii et need ei ole absoluutne blokeerija — need on
**näitaja, et liin pole settinud**.

Seega: ei ole hädaolukorda kummaski suunas. Pluginaaugud (§2) said täna
kinni, ja need olid ainsad, mis meid reaalselt puudutasid. Migreerimine
võib oodata paar nädalat, aga **mitte kuid**.

---

## 4. Millal migreerida — konkreetne käivitustingimus

Ära oota "kuni tunne on hea". Oota mõõdetavat signaali:

> **Üks kalendrinädal, kus getgrav/grav ei ole avaldanud uut
> 2.0.x patchi EGA uut security advisory't.**

Kontrolli nii:

```bash
curl -s "https://api.github.com/repos/getgrav/grav/releases?per_page=10" \
  | python3 -c "import json,sys; [print(r['tag_name'], r['published_at'][:10]) for r in json.load(sys.stdin)]"

curl -s "https://api.github.com/repos/getgrav/grav/security-advisories?per_page=10" \
  | python3 -c "import json,sys; [print(a['ghsa_id'], a['published_at'][:10], a['severity'], a['summary'][:70]) for a in json.load(sys.stdin)]"
```

Realistlik aken: **september 2026**. Kui augusti tempo jätkub ka oktoobris,
migreeru sellest hoolimata — 8 kuud parandusteta tuuma ei ole parem valik
kui aktiivselt parandatav tuum.

---

## 5. Enne migreerimist kõrvaldada (kontroll-loend)

- [ ] **Commit'imata muudatus:** `user/pages/02.blog/vutt/item.et.md`
      (1 rida). §4.8 vana plaanis eeldab puhast tööpuud — kas commit'i või
      viska `git checkout`-iga.
- [ ] **Värske varukoopia** vahetult enne migreerimist (tänane, 23.08, on
      pluginauuenduse-eelne — migreerimise ajaks aegunud)
- [ ] **`/grav-2/` testimine:** vana plaan §4.5 räägib Nginx rewrite'ist,
      aga meil on **Apache + Cloudflare Tunnel**. Ära tegele tunneliga —
      testi LAN-ist otse: `http://192.168.1.196:8080/grav-2/`. See jätab
      Cloudflare'i täiesti mängust välja.
- [ ] **Kettaruum:** 197 GB vaba, sait 76 MB (`user/` 46M, `vendor/` 24M,
      `system/` 6,4M). Pole probleem.

## 6. Migreerimise käik (ajakohastatud)

Plugina õige GPM slug on **`migrate-grav`** (mitte "migrate" — seda ei
eksisteeri, ja `grav-plugin-migrate` GitHubis annab 404):

```bash
docker exec kirikiri-production bin/gpm info migrate-grav      # kontrolli enne
docker exec kirikiri-production bin/gpm install migrate-grav
```

Edasi wizard: stage'ib 2.0 `grav-2/` alamkausta → testid LAN-ist →
**Promote** (varundab + vahetab webroot'i) või **Reset** (live jääb
puutumatuks). Pärast: eemalda `migrate-grav`, commit'i ainult `user/`
muutused (tuum ja pluginad on `.gitignore`'is, seega repo müra ei teki).

**Teema `kirikiri`** jääb alles — 2.0 renderdab Twig 3 compat mode'is.

---

## 7. Kõrvalmärkused

- **Pluginakaustade omanik on `www-data:www-data 2755`** (nt
  `user/plugins/login`), sest GPM jookseb konteineris www-data'na. `meelis`
  on `www-data` grupis, aga grupil on ainult `r-x` → **käsitsi ei saa
  pluginafaile redigeerida**. See ei ole uus ega vigane: uuendamata
  `taxonomylist` on täpselt sama. Pluginaid haldab niikuinii GPM/admin.
  Meie oma teema `user/themes/kirikiri/` on `meelis:www-data 2775` —
  kirjutatav, nagu peab.
- **`logs/grav.log` sisaldab 5. mai `flex-objects` CRITICAL-kirjeid**
  (`Undefined array key "path"` → `fallbackUrl()`). Vana, ei ole tänasest.
  Kaob 2.0-le minnes, sest `flex-objects` liidetakse tuuma.
- **GPM kanal on endiselt `testing`** (`user/config/system.yaml`). See on
  migreerimiseks õige — 2.0 elab seal. Pärast migreerimist tasub kaaluda
  `stable`'ile lülitumist, sest siis on 2.0.x stabiilses kanalis olemas.
- **`markdown-notices` 1.2.0** — viimane release 06.05.2026. Vana plaan
  soovitas asendada `github-markdown-alerts`'ga 2.0 juures. Jäta
  migreerimise järgseks, mitte eelseks.

---

## 8. Migreerimine tehtud — 14.09.2026

§4 käivitustingimus **ei olnud täidetud** (14.09 kontroll: 2.0.22…2.0.27 +
2.1.0…2.1.4 kahe nädalaga, advisory-klaster 09.–10.09). Migreeriti sellest
hoolimata, sest §3.1 pool kaalus üles: 1.8.0-beta.29 on 28.12.2025 külmutatud
tuum, mis ei saa enam ühtki turvaparandust, ja §5 admini umbtee ei olnud muul
viisil lahendatav.

**Sihtversioon 2.0.27, mitte `latest` (2.1.4) — teadlik valik.** Ükski meie
plugin ei deklareeri `compatibility: 2.1`, ainult `2.0`. Wizardi vaikimisi
`latest` oleks andnud 2.1.4 ilma ühegi ühilduvusdeklaratsioonita.

| | Enne | Pärast |
|---|---|---|
| Tuum | 1.8.0-beta.29 | **2.0.27** |
| Admin | `admin` 1.10.59 | **`admin2` 2.1.17** |
| API | — | **`api` 1.0.30** (uus, admin2 sõltuvus) |
| flex-objects | 1.3.8 | **1.4.15** |
| Teema `kirikiri` | 1.0.0 | 1.0.0, muutmata |

§5 umbtee (`flex-objects` `blocked_upgrade` nõudis `grav >= 2.0.0-rc.10`)
**lahenes iseenesest** — 2.0 juures pakutakse 1.4.15.

### 8.1 Mis läks migreerimisel valesti

**Promote kustutas kaks jälgitavat faili:** `.gitignore` ja `robots.txt`.
Mõlemad taastatud `git checkout`-iga. `.gitignore` kadumine on ohtlik — ilma
selleta läheb kogu Gravi tuum, `vendor/` ja pluginad sellesse "skinny" reposse.
**Kontrolli `git status`-iga iga major-uuenduse järel.** Wizard säilitas `.git`
korrektselt; kontod, paroolid ja jaanuse granuleeritud õigused migreerusid,
juurde tekkisid `access.api.*` plokid.

**Promote chownis kogu repo `www-data:www-data 644`-ks** — 66 jälgitavat faili
70-st, sh `docs/`, `.htaccess`, `docker-compose.yml` ja kogu
`user/themes/kirikiri/`. Tagajärg: `meelis` ei saa enam oma teemat ega
dokumentatsiooni redigeerida (grupil on ainult `r--`). `.git` ise jäi
`meelis:www-data`, seega git töötab. Vt §8.5 — vajab käsitsi parandamist
`meelis:www-data` + `664`/`2775` peale.

**`security.salt` oli avalikus gitis.** 2.0 tõstis soola jälgitavast
`user/config/security.yaml`-ist faili `user/config/security-private.php`
(0600), **aga ei genereerinud uut väärtust** — sama sool oli repos
`github.com/meelisf/kirikiri-grav` (avalik) alates esimesest commitist.
Kasutus: CSRF-nonce'ide allkirjastamine + admini rate-limit.
**Lahendatud:** `security-private.php` kustutatud, Grav kirjutas uue soola
(sessioonid logiti välja). Vana väärtus jääb git-ajalukku, aga ei ole enam
kasutuses. `api-private.php` JWT-saladus oli algusest peale värskelt
genereeritud.

### 8.2 Uued ignore-reeglid

Grav 2.0 kirjutab saladusi kohtadesse, mida repo varem jälgis:

- `/user/config/security-private.php` — CSRF-sool
- `/user/config/plugins/*-private.php` — nt `api-private.php` JWT-võti
- `/user/config/plugins/api.yaml` — `popularity.salt`, külastaja-IP-de
  pseudonüümimise HMAC-võti. Plugina enda kood ütleb: *"a committed salt would
  be globally known and defeat the keyed-hash protection entirely."* Kui siia
  tekib kunagi päris api-seadistusi, tuleb sool eraldi failiks tõsta.
- `/.migration-complete` — wizardi lõpumarker, viitab `backup/`-i zip-ile

### 8.3 Muud selle commit'i muudatused

- **`.htaccess`** — wizard tõstis `mod_expires` ploki faili algusesse ja tõi
  2.0 karmimad turvareeglid: kõik `[F]` → `[F,NC]` (tõstutundetu),
  `user/config`, `user/env`, `user/accounts` ja `user/data` blokeeritud
  failitüübist sõltumata (avatarid ja meediafailid lubatud eranditega, SVG
  blokitud stored-XSS-i tõttu). `user/pages` reegel on **kommenteeritud** —
  selle sisselülitamine ilma `pages.media_route_urls: true`-ta muudaks iga
  meedia-URL-i 403-ks.
- **`Dockerfile`** — `a2enmod rewrite` → `a2enmod rewrite expires`. `.htaccess`
  `ExpiresByType` plokk oli failis juba varem olemas, aga moodul puudus, seega
  vahemälupäiseid ei saadetudki.
- **`system.yaml`** — `twig.undefined_functions` / `undefined_filters`
  eemaldatud (2.0-s pole enam), `gpm.releases: testing` → **`stable`** (§7
  märkus: 2.0.x on stabiilses kanalis olemas).
- **`kirikiri/blueprints.yaml`** — lisatud `compatibility.grav: ['1.7', '1.8',
  '2.0']`. Teema testiti enne migreerimist eraldi liivakastis 2.0.27 ja 2.1.4
  vastu: kõik lehed 200, null PHP-hoiatust, `<body>` väljund identne peale
  Gravi enda pildimõõtude parandust.

### 8.4 Verifitseeritud pärast migreerimist

- `https://kirikiri.eu/` → 302 → `/et` → **200** (läbi Cloudflare Tunneli)
- Live-väljund vastab liivakasti ennustusele (erinevad ainult pildivahemälu
  hashid ja siltide järjekord)
- `logs/grav.log`-is pole uusi PHP-vigu ega CRITICAL-kirjeid

### 8.5 Lahtised otsad

- **Failide omand (§8.1)** — parandus: jälgitavad failid `meelis:www-data`,
  failid `664`, kaustad `2775`. See annab kirjutusõiguse nii Meelisele kui
  Gravi adminile (`user/config/*.yaml` ja `user/pages/**` peavad jääma
  www-data'le kirjutatavaks). Nõuab `sudo`.
- **Üleslaadimise piir on 2 MiB** ja see lõi admin2-s välja juba esimesel
  katsel (`logs/grav.log` 14.09 20:55, neli korda `422 File exceeds maximum
  upload size`). Piirang on kolmes kohas: PHP `upload_max_filesize=2M`,
  `post_max_size=8M` ja Grav `system.yaml: upload_limit: 2097152`. Ei ole
  migreerimise tekitatud, aga telefoni- või skanneripilt on tavaliselt 3–8 MB,
  seega praktikas ei saa artiklile pilti lisada. Parandus nõuab `php.ini`
  ülekirjutust `Dockerfile`-is **ja** `upload_limit`-i tõstmist.
- **`add_modals` ("Lisa artikkel" nupp) on pöördumatult kadunud.** Kinnitatud
  15.09: `grep -rl add_modals user/plugins/ system/` ei anna ühtki tabamust —
  see oli klassikalise `admin` plugina funktsioon, `admin2` ega `api` seda ei
  tunne. Seega on orvud **kaks** jälgitavat faili:
  `user/config/plugins/admin.yaml` (ainult see `add_modals` plokk) ja
  `user/blueprints/admin/pages/new_post.yaml` (nupu vorm: eeltäidetud autor,
  märksõna `uudised`, `header.date` teema meetodist `getCurrentDate`,
  `route: /blog`, `name: item`).
  Uus töövoog: **Lisa leht → tüüp `Item`**. Eeltäitmine on kadunud. Kui seda
  tahetakse tagasi, tuleb autori/märksõna/kuupäeva `default:` väärtused tõsta
  `new_post.yaml`-ist teema blueprinti `blueprints/item.yaml` — siis
  rakenduvad need iga uue Item-lehe vormil.
- **`user/config/plugins/migrate-grav.yaml`** (`enabled: false`) jäi maha
  pärast plugina eemaldamist — jälgimata, võib kustutada.
- **`user/pages/02.blog/test/`** — migreerimise testartikkel
  (`published: false`) koos pildiga. Jälgimata: kustuta või avalda.
- **`markdown-notices` 1.2.0** (§7) — 2.0 juures kaaluda asendamist
  `github-markdown-alerts`-iga. Endiselt tegemata.

---

## 9. Migreerimisjärgne vahemälu — kaks sümptomit, üks põhjus (15.09.2026)

**Sümptomid:** admin2-s puudus artiklil väli *Featured Image*, ja uue lehe
lisamisel ei saanud malli valida (testleht tekkis `default.et.md`-na, mitte
`item.et.md`-na, seega ilma teema hero-pildi ja kuupäevata).

**Põhjus:** Promote tõi Grav 1.8 `cache/` kausta muutmata kujul üle — see on
`.migration-complete` `promoted` nimekirjas. `Pages::getTypes()`
(`system/src/Grav/Common/Page/Pages.php:1511`) vahemälustab serialiseeritud
`Types` objekti võtme `md5('types')` all. 1.8 ajal serialiseeritud objekt
loeti 2.0 koodiga tagasi ja tuli **tühjana** välja.

Mõõdetud enne ja pärast (`bin/grav clearcache`):

| | Enne | Pärast |
|---|---|---|
| `Pages::getTypes()` | **0 tüüpi** | **12 tüüpi**, sh `item` |
| `Pages::types()` (admin2 mallivalik) | tühi | `archives, authors, blog, default, external, home, item, modular, root, tags, taxonomy` |
| blueprint `item` title | `NULL` | `Blog Post` |
| `header.image` väli | **PUUDUB** | **OLEMAS** (`filepicker`, "Featured Image") |

**Lahendus:** `docker exec -w /var/www/html kirikiri-production bin/grav clearcache`.
Käsk on `clearcache`, **mitte** `clear-cache` (viimane pakub Symfony
sarnasusotsinguna hoopis midagi muud ja ei tee midagi).

**Kõrvaltee, mis maksis aega — ja mille kohta siin seisis liiga tugev väide.**
`Themes.php:97` registreerib teema blueprintid ainult siis, kui
`theme://blueprints/pages/` on olemas; meie failid olid `blueprints/*.yaml`, st
ühe kausta võrra "vales" kohas. See ei olnud selle vea põhjus:
`Pages.php:1497` proovib teadlikult mõlemat asukohta (`theme://blueprints/pages/`,
kui pole, siis `theme://blueprints/`), ja vana asukohaga + tühja vahemäluga on
väli päriselt olemas.

Aga "täiesti töötav" oli liiga tugev. Vana asukoht töötab **ainult**
`Pages::getTypes()` tagavaravariandi kaudu, mis registreerib iga tüübi tee
eraldi (`$locator->addPath('blueprints', "pages/$type.yaml", ...)`) — ja just
see funktsioon on see, mille tulemust vahemälustatakse. Uues asukohas
registreerib `Themes.php:97` terve `theme://blueprints` kataloogi striimi, mis
ei sõltu `types` vahemälust üldse. Seepärast **kolitud 15.09 ikkagi**
asukohta `user/themes/kirikiri/blueprints/pages/` — vt §10.

**Õppetund, mis kehtib igale major-uuendusele:** kui wizard toob `cache/` üle,
**tühjenda vahemälu kohe pärast Promote'i**. Serialiseeritud objektid vanast
tuumast ei pruugi uue koodiga ühilduda ja viga ei näita ennast veateatena,
vaid vaikselt puuduva funktsionaalsusena.

**Verifitseeritud pärast tühjendamist:** `https://kirikiri.eu/et` → 200,
`/et/blog/esimene` → 200 ja hero-pilt renderdub
(`article-hero-image-img ... derivative=webp`).

---

## 10. `default` on nüüd artiklimall (15.09.2026)

**Probleem:** `add_modals` nupu kadumisega (§8.5) tuli uut postitust luues mall
käsitsi valida, ja vale mall (`default`) andis artikli ilma hero-pildi,
kuupäeva, autori ja siltideta. Meelis: *"paneme, et default oleks see item, st
et ei ole vaja otsida õiget malli."*

**Miks see on õige koht parandada:** uue lehe mall on Grav 2.0-s **alati**
`default`, mõlemas kihis —
`api/classes/Api/Controllers/PagesController.php:475`
(`$template = $body['template'] ?? 'default'`) ja admin2 redaktor
(`?.template||"default"`). Seega on ainus viis "malli mitte otsida" see, et
`default` ISE oleks artiklimall.

### 10.1 Mallid

| Mall | Roll |
|---|---|
| `default.html.twig` | **artikkel** — hero-pilt, kuupäev, autor, sildid |
| `item.html.twig` | alias: `{% extends 'default.html.twig' %}` |
| `page.html.twig` | **lihtleht** — ainult pealkiri + sisu (kasutab /info) |

Artikli märgistus on baitide kaupa sama, mis varem `item.html.twig`-is;
`item` jääb alles, sest kõik olemasolevad postitused on failid `item.et.md`.
`/info` sai päisesse `template: page` — `Page.php:617` lubab päises malli üle
kirjutada, seega faili ümber nimetada ei olnud vaja.

### 10.2 Blueprintid: `blueprints/pages/`

Kõik teema lehe-blueprintid kolisid `blueprints/`-ist **`blueprints/pages/`**-i
(põhjus §9). `pages/default.yaml` sisaldab:

- `header.image` (`filepicker`, Featured Image) + `header.media_order`
- **eeltäitmine**, mis varem tuli `add_modals` nupust:
  `header.taxonomy` vaikimisi `author: [Meelis Friedenthal]`, `tag: [uudised]`,
  ja `header.date` vaikimisi `\Grav\Theme\Kirikiri::getCurrentDate`.

**`header.date` juures on `toggleable: false` HÄDAVAJALIK.** Süsteemi
blueprintis on see väli `toggleable: true`, ja api `blueprintHeaderDefaults()`
jätab toggleable väljad teadlikult vahele ("their `default:` is a placeholder
the form shows until the field is toggled on"). Päritud kujul ei kirjutataks
kuupäeva uuele lehele üldse.

### 10.3 Naelutatud blueprintid — lõks, mida tasub mäista

`default` blueprint on see, mille saavad **kõik ilma oma blueprintita mallid**.
Mõõdetud: enne naelutamist pärisid artiklivälju ka `home`, `archives`, `tags`,
`authors`, `blog` ja `taxonomy`. Praktiline oht ei olnud kosmeetiline: kui
mõnda neist adminis salvestada, kirjutataks sisse eeltäidetud
`taxonomy.tag: [uudised]` ja **koondleht satuks ise `uudised`-sildi alla**.

Seepärast on igal neist nüüd oma blueprint, mille vanem on naelutatud
süsteemi külge:

```yaml
'@extends':
    type: default
    context: system://blueprints/pages   # MITTE blueprints://, muidu pärib teema oma
```

Kontrollitud, et `blueprints://` kaudu iseendale viitamine EI tekita
rekursiooni (`pages/default.yaml` laiendab `blueprints://pages` kaudu süsteemi
faili ja pärib korrektselt `header.title`, `content: markdown`,
`header.media_order` ning options-tabi).

**LÕKS:** iga uus mall, mis lisatakse `templates/`-isse ilma oma blueprintita,
pärib artiklivälju ja eeltäitmise. Kui see pole soovitud, lisa talle
naelutatud blueprint.

### 10.4 Ajavöönd

`system.timezone` oli `null` → konteineri PHP jooksis **UTC**-s ja eeltäidetud
kuupäev oleks tulnud 3 tundi taha (mõõdetud: `05:28` vs hosti `08:28 EEST`).
Seatud **`Europe/Tallinn`**. Rakendub `InitializeProcessor.php:374` juures, st
veebipäringus; olemasolevate lehtede kuvatavad kuupäevad ei muutu, sest need
on salvestatud `d-m-Y H:i` stringina ja parsitakse+vormindatakse samas
ajavööndis.

### 10.5 Kustutatud surnud failid

- `user/config/plugins/admin.yaml` — sisaldas ainult `add_modals` plokki
- `user/blueprints/admin/pages/new_post.yaml` — selle nupu vorm
  (`user/blueprints/` jäi tühjaks ja kadus)
- `user/config/plugins/migrate-grav.yaml` (oli jälgimata)

**Täpsustus §8.5-le:** `admin.yaml` ei olnud päris orb — api loeb endiselt
`plugins.admin.hide_page_types` ja `hide_modular_page_types`
(`BlueprintController.php:146`), millega saab mallivalikut kärpida. Meie fail
neid ei seadnud, seega kustutamisega ei kadunud midagi.

### 10.6 Verifitseeritud

- Kõik lehed 200: `/et`, `/et/blog`, `/et/blog/esimene`,
  `/et/blog/suhtumine-religiooni`, `/et/blog/vutt`, `/et/info`, `/et/tags`,
  `/et/authors`
- Artikkel sisaldab endiselt `article-hero-image-img`, `article-date`,
  `article-category`
- `/et/info` renderdub lihtlehena (`article-hero card no-image`, **ei** sisalda
  `article-date` ega `article-category`)
- `/et/blog/toyota-avensis` ja `/et/blog/test` on 404, mõlemal
  `published: false` — puutumata failid, mitte selle muudatuse tagajärg
- Blueprint: `default` ja `item` = Featured Image JAH; `page`, `home`,
  `archives`, `tags`, `authors`, `blog`, `taxonomy` = ei
- Eeltäitmine, api `blueprintHeaderDefaults()` loogikat täpselt korrates:
  `header.date` = kohalik aeg, `header.taxonomy` =
  `{"author":["Meelis Friedenthal"],"tag":["uudised"]}`

**NB testimise kohta:** CLI-s `InitializeProcessor::initializeCli()` **ei
registreeri `theme://` striimi üldse** (`isStream('theme://') === false`),
seega seal ei ole teema blueprintid nähtavad ja `Pages::getTypes()` annab 2
tüüpi. See on CLI eripära, mitte veebipäringu käitumine — ära aja sellega ennast
segadusse. Usaldusväärne CLI-proov peab ise tegema
`$grav['config']->init(); $grav['streams']; $grav['themes']->init();`.

### 10.7 Mallivaliku sildid on eestikeelsed (`onAdminPageTypes`)

**Probleem:** pärast §10.1 muudatust ei olnud rippmenüüs ühtki kirjet nimega
"Artikkel" — seal seisid `Default`, `Item`, `Page`. Põhjus: admini
mallivaliku sildid tulevad Gravis **paljalt failinimest**,
`Types::pageSelect()` (`system/src/Grav/Common/Page/Types.php:126`) teeb
`ucfirst(str_replace('_', ' ', $name))`. Blueprinti `title:` sinna **ei jõua
kunagi** — see paistab ainult vormi päises. Nii et "Default" oli tegelikult
artikkel, aga seda ei olnud kuidagi näha.

**Lahendus:** teema `kirikiri.php` tellib `onAdminPageTypes` sündmuse. Api
`BlueprintController::filterPageTypes()` laseb nimekirja sellest läbi (sama
leping, mis klassikalisel adminil oli), seega sildid saab ümber nimetada ilma
plugina puutumist. Ümber nimetatakse **ainult sildid** — mallide võtmed jäävad
samaks, sest sama nimekiri toidab ka redigeerimisvormi mallivalikut.

`default` tõstetakse ühtlasi nimekirja etteotsa, sest admin2 tagavaraloogika
(`nodes/19`: `V.find(t => t.type === "default") ?? V[0]`) langeks siis
halvimalgi juhul artikli peale.

Mõõdetud tulemus (api loogikat täpselt korrates):

| enne | pärast |
|---|---|
| `default → Default` | **`default → Artikkel`** (nimekirjas esimene) |
| `item → Item` | `item → Artikkel (vana mall)` |
| `page → Page` | `page → Lihtleht` |
| `home → Home` | `home → Avaleht` |
| `archives → Archives` | `archives → Artiklite koond` |
| `tags → Tags` | `tags → Siltide koond` |
| `authors → Authors` | `authors → Autorite koond` |

`external`, `modular` ja `root` jäid ingliskeelseks — neid ei kasutata.

### 10.8 Malli eelvalimine URL-ist

Admin2 "Lisa leht" (`/admin/pages/new`, `nodes/19`) loeb algväärtused
päringuparameetritest: `template`, `parent`, `title`, `kind`
(`page` / `folder` / `module`). Seega asendab endist "Lisa artikkel" nuppu
lihtsalt brauseri järjehoidja:

```
https://kirikiri.eu/admin/pages/new?kind=page&template=item&parent=/blog
```

Kui `template=` väärtust nimekirjas ei ole, langeb admin2 tagasi `default`-ile
ja selle puudumisel nimekirja esimesele kirjele.

**Mis EI tööta, kontrollitud:**
- Admin2-l **ei ole** vaikemalli seadet — `admin2.yaml`-is on kokku `enabled`
  ja `route`.
- `default`-i peitmine `plugins.admin.hide_page_types`-iga **ei vali** `item`-it:
  tagavara on nimekirja esimene kirje. Ja sama filtreeritud nimekiri toidab
  redigeerimisvormi mallivalikut, seega peidetud mall võib olemasoleval lehel
  salvestamisel vahetuda.
- **`child_type: item`** ("/blog alamlehed on vaikimisi artiklid") ei ole
  admin2-s realiseeritud — api serveerib välja
  (`BlueprintController.php:1383`), aga admin2 bundle'is ei esine sõna
  `child_type` kordagi.

### 10.7 Lahtine

`user/config/plugins/add-page-by-form.yaml` on jälgitav, aga plugin
`add-page-by-form` ei ole paigaldatud (`enabled: false`) — järgmine orb,
puutumata jäetud.

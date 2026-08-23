# Grav 2.0 migreerimisotsus + pluginauuendused

**Kuupäev:** 23. august 2026
**Staatus:** pluginad uuendatud ✅ · migreerimine 2.0-le EDASI LÜKATUD (vt §3)
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

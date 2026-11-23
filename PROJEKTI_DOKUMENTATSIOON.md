# Kirikiri Grav CMS - Projekti Dokumentatsioon

See dokument võtab kokku Kirikiri veebilehe migreerimise Astro-st Grav CMS-i, kirjeldab teema ehitust ja annab juhised edasiseks haldamiseks.

## 1. Projekti Ülevaade
Kirikiri on viidud üle failipõhisele Grav CMS-ile, et lihtsustada sisuhaldust läbi Admin paneeli, säilitades samal ajal kiiruse ja paindlikkuse.

## 2. Tehniline Arhitektuur
- **CMS**: Grav 2.2.x (migreeritud 1.8-lt 14.09.2026)
- **PHP Versioon**: 8.3
- **Server**: Apache (Dockeris `php:8.3-apache`)
- **Vajalikud PHP moodulid**: `gd`, `zip`, `intl`, `opcache`
- **Ruutimine**: Apache `mod_rewrite` peab olema sisse lülitatud ja `.htaccess` fail peab asuma juurkataloogis.

## 3. Kirikiri Teema (`user/themes/kirikiri`)
Teema on ehitatud nullist, järgides minimalistlikku ja "editorial" stiili.

### 3.1 Disainisüsteem (`css/custom.css`)
- **Font**: Läbivalt **Merriweather** (Google Fonts).
- **Värvid**: 
  - Taust: `#fefefe`
  - Tekst: `#111111`
  - Aktsent (punane): `#8B0000`
- **Side-by-side Hero**: Üksikpostituste päises on tekst vasakul ja pilt paremal (50/50), kõrgused on joondatud. Kui pilti pole, on tiitel keskel (lisatud `no-image` klass).
- **Pildiallkirjad**: Kasutame JS skripti `base.html.twig`-is, mis muundab md `![Alt](src "Title")` pildid `<figure>` elementideks. 
- **Joonealused märkused**: CSS-põhine lahendus (`hr + .footnotes { border: none }`), mis peidab topeltjooned ja tagab visuaalse korrektsuse.
- **Lokaliseerimine**: Kuupäevade tõlkimine ("22. detsember 2025") on lahendatud Twig-i massiiviga templiidi sees, et vältida serveri lokaadi sõltuvust.
- **Info leht**: Mall `page` (päises `template: page`), sama `.article-hero` stiilis päis.

### 3.2 Olulised Templiidid
- `base.html.twig`: Üldine HTML struktuur, menüüd ja jalus.
- `home.html.twig` / `blog.html.twig`: Artiklite loendi kuvamine kaardiruudustikuna.
- `default.html.twig`: **Artikkel** (Grav 2 admin loob uue lehe alati `default` malliga, seepärast on artiklimall just see). Blueprint `blueprints/pages/default.yaml` lisab Featured Image välja ja eeltäidab autori, sildi `uudised` ja kuupäeva.
- `item.html.twig`: alias (`{% extends 'default.html.twig' %}`) vanadele postitustele, mis on failid `item.et.md`.
- `page.html.twig`: Lihtleht (nt `/info`).
- `archives`, `tags`, `authors`, `taxonomy`: koondlehed. **Igal mallil peab olema oma blueprint** `blueprints/pages/`-is (vanem naelutatud süsteemi `default`-ile), muidu pärib see artiklivälju.
- Mallivaliku sildid (Artikkel, Lihtleht jne) tulevad `kirikiri.php`-st (`onAdminPageTypes`), mitte blueprinti `title:`-ist.

## 4. Sisuhaldus (`user/pages`)
Sisu on organiseeritud kaustadesse. Iga kaust on üks leht või artikkel.
- `01.home`: Esileht.
- `02.blog`: Artiklite peakaust (sisaldab alamkaustu iga artikli jaoks).

**Artikli sisu näide (`default.et.md`, vanadel `item.et.md`):**
```yaml
---
title: Pealkiri
date: '27-12-2025 22:00'
image: pilt.jpg
taxonomy:
    tag: [uudised]
    author: ['Meelis Friedenthal']
---
Markdown sisu siia...
```

## 5. Administreerimine
- **Admin Paneel**: `/admin` (plugin `admin2`, taustal `api`)
- **Pluginad**: 
  - `admin2`, `api`, `flex-objects`, `login`, `form`, `email`: Süsteemsed.
  - `markdown-notices`: Märkuste kuvamiseks.
  - `taxonomylist`, `sitemap`, `shortcode-core`, `error`, `problems`.
- **Uue artikli järjehoidja**: `/admin/pages/new?kind=page&template=default&parent=/blog`

## 6. Korduvad Probleemid ja Lahendused
- **Muudatused ei paista**: Jookse käsk `bin/grav clearcache`. Brauseris kasuta `Ctrl+F5`.
- **404 vead lehtedel**: Veendu, et `.htaccess` fail on olemas.
- **Adminis puudub mallivalik või Featured Image väli**: aegunud vahemälu, vt eelmist punkti.
- **Õigused**: vt `.instructions.md` → "Failide õigused".

## 7. Serveri seadistus ja uuendamine
Vt `.instructions.md`.

## 8. Funktsioonid (lisatud 28.12.2025)

### ✅ Esileht vs Artiklid
Esileht (`home.html.twig`) näitab nüüd:
- **Esiletõstetud artikkel** - Suuremas formaadis esimene/värskeim artikkel
- **Viimased artiklid** - 5 järgmist artiklit grid-formaadis
- **"Vaata kõiki artikleid"** nupp mis viib arhiivi

### ✅ Artiklite arhiiv
Blogi leht (`blog.html.twig`) on nüüd täielik arhiiv:
- Pealkiri "Artiklite arhiiv"
- Pagination tugi (lehekülgede vahel liikumine)
- Filtreerimine teemade ja autorite kaupa

### ✅ Märksõnade/Teemade vaated
- Uus mall `tags.html.twig` - kuvab kõik märksõnad pilve formaadis
- Leht aadressil `/tags`
- Iga märksõna juures artiklite arv
- Klõpsates märksõnal kuvatakse selle teema artiklid

### ✅ Autorite lehekülg
- Uus mall `authors.html.twig` - kuvab kõik autorid
- Leht aadressil `/authors`
- Autorite kaardid koos artiklite arvuga
- Klõpsates autoril kuvatakse tema artiklid

### ✅ Pildid postituse sees korda
CSS-is lisatud reeglid, mis tagavad et pildid ei ületa `.article-content` laiust:
```css
.article-content img {
    max-width: 100%;
    height: auto;
}
```

### ✅ Esilehe kujundusmuutus
Implementeeritud uus "editorial" stiilis esileht:
- Suur esiletõstetud artikkel ülaosas (50/50 pilt ja tekst)
- Väiksemad kaardid alamosas
- Selge "Vaata kõiki artikleid" nupp

## 9. Uued Templiidid ja Failid

### 9.1 Loodud templiidid
- `templates/tags.html.twig` - Märksõnade pilv
- `templates/authors.html.twig` - Autorite nimekiri
- `templates/taxonomy.html.twig` - Üksiku märksõna/autori artiklid

### 9.2 Loodud lehed
- `user/pages/04.tags/tags.md` - Teemade leht
- `user/pages/05.authors/authors.md` - Autorite leht

### 9.3 Uuendatud templiidid
- `templates/home.html.twig` - Uus esiletõstetud artikli layout
- `templates/blog.html.twig` - Arhiiv koos pagination-iga

### 9.4 Uuendatud CSS (`css/custom.css`)
Lisatud stiilid:
- `.featured-section`, `.featured-article` - Esilehe esiletõstetud artikkel
- `.pagination` - Lehekülgede navigatsioon
- `.tags-cloud`, `.tag-item` - Märksõnade pilv
- `.authors-grid`, `.author-card` - Autorite kaardid
- `.view-more`, `.view-more-link` - "Vaata kõiki" nupp
- `.article-content img` - Piltide laiuse piiramine

---
*Viimati uuendatud: 23. november 2026*

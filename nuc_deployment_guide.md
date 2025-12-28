# Kirikiri Grav CMS - Paigaldusjuhend NUC serverile

See juhend on mõeldud selleks, et saaksid oma Kirikiri veebi kiiresti ja probleemideta NUC serveris tööle panna, vältides uuesti samu seadistusvigu.

## 1. Nõuded süsteemile

Grav CMS vajab kaasaegset PHP versiooni. Enne alustamist veendu, et serveris on:
- **PHP 8.3 või uuem** (kriitiline Admin plugina jaoks).
- **Apache** (mod_rewrite lubatud) või **Nginx**.
- Vajalikud PHP laiendused: `gd`, `zip`, `intl`, `opcache`, `mbstring`.

## 2. Paigaldamine (Git või FTP kaudu)

Kui kopeerid failid olemasolevast arenduskeskkonnast:
1. Kopeeri kogu `kirikiri-grav` kausta sisu serverisse.
2. **Kriitiline:** Veendu, et ka `.htaccess` fail kopeeriti veebi juurkataloogi. Ilma selleta töötavad ainult staatilised failid, aga Gravi sisemine ruutimine (lehed) mitte.


Grav peab saama teatud kaustadesse kirjutada. Jookse järgmised käsud oma serveri terminalis (eeldades, et veebiserveri kasutaja on `www-data`):

```bash
cd /path/to/kirikiri-grav
sudo chown -R www-data:www-data .
sudo chmod -R 775 cache logs images user/pages user/config user/data tmp assets backup
```

## 4. Grav-i ja pluginate värskendamine

Kui soovid alustada puhtalt lehelt, tee järgmist:

```bash
# Liigu kausta
cd /path/to/kirikiri-grav

# Värskenda Gravi ennast
bin/gpm selfupgrade -y

# Paigalda Admin plugin (see küsib luba paigaldada ka login, forms ja email)
bin/gpm install admin -y
```

## 5. Veebiserveri seadistus (Apache)

Veendu, et Apache konfiguratsioonis on lubatud `.htaccess` failide kasutamine (`AllowOverride All`).

```apache
<Directory /var/www/html>
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>
```

Pärast muutmist taaskäivita Apache: `sudo systemctl restart apache2`

## 6. Dockeriga paigaldamine (Soovituslik kiireim viis)

Kui su NUC-is on Docker, saad kogu keskkonna püsti panna ühe käsuga:

```bash
docker run -d \
  --name kirikiri-veeb \
  -p 80:80 \
  -v $(pwd):/var/www/html \
  php:8.3-apache
```

Pärast konteineri käivitamist sisene sellesse ja paigalda vajalikud moodulid:

```bash
docker exec -it kirikiri-veeb bash
apt-get update && apt-get install -y libpng-dev libjpeg-dev libzip-dev libicu-dev
docker-php-ext-install gd zip opcache intl
a2enmod rewrite
service apache2 restart
```

## 7. Teema kontroll

Veendu, et teema on aktiivne failis `user/config/system.yaml`:
```yaml
pages:
  theme: kirikiri
```

Ja et vajalikud templiidid on olemas:
- `user/themes/kirikiri/templates/home.html.twig`
- `user/themes/kirikiri/templates/blog.html.twig`
- `user/themes/kirikiri/templates/item.html.twig`
- `user/themes/kirikiri/templates/default.html.twig`

## 8. Probleemide lahendamine

- **Valge leht:** Kontrolli `logs/grav.log` faili. Tavaliselt on see märk puuduvast PHP laiendusest või õiguste probleemist.
- **404 Port:** Veendu, et `.htaccess` on olemas ja Apache `mod_rewrite` on sisse lülitatud.
- **Admin panel ei tööta:** Kontrolli, et PHP versioon on vähemalt 8.3 ja pluginad `login`, `forms` ning `email` on paigaldatud.


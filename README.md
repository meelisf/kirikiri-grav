# Kirikiri

Märkmed, artiklid ja muud kirjatükid. See repositoorium sisaldab veebilehe **kirikiri.eu** lähtekoodi ja sisu, mis põhineb [Grav CMS](https://getgrav.org) platvormil.

## Staatus
Projekt on migreeritud Astro platvormilt Grav CMS-ile (detsember 2025), et lihtsustada sisuhaldust ja pakkuda toimetajatele mugavat admin-liidest.

## Tehniline ülevaade
- **CMS**: Grav v1.7.x
- **Teema**: Kohandatud teema `kirikiri` (kaustas `user/themes/kirikiri`)
- **PHP**: 8.3+
- **Disain**: Minimalistlik, tekstikeskne, kasutab Merriweather fonti.

## Arendus ja Paigaldus

### Nõuded
- PHP 8.3+
- Apache/Nginx (`mod_rewrite` toega)
- Composer (soovituslik)

### Dockeriga käivitamine (Arendus)
Kõige lihtsam on alustada Dockeriga:

```bash
# 1. Käivita konteiner
docker run -d --name kirikiri-web -p 8080:80 -v $(pwd):/var/www/html php:8.3-apache

# 2. Sisene konteinerisse ja paigalda sõltuvused
docker exec -it kirikiri-web bash

# Konteineris:
apt-get update && apt-get install -y libpng-dev libjpeg-dev libzip-dev libicu-dev git unzip
docker-php-ext-install gd zip opcache intl
a2enmod rewrite
service apache2 restart
```

### Administreerimine
- Admin paneel asub: `/admin`
- Kasutaja loomine: `bin/gpm create-user`

## Dokumentatsioon
Täpsem tehniline dokumentatsioon ja paigaldusjuhendid asuvad failis:
- [PROJEKTI_DOKUMENTATSIOON.md](PROJEKTI_DOKUMENTATSIOON.md)
- [nuc_deployment_guide.md](nuc_deployment_guide.md) (Serverisse paigaldamine)

## Litsents
Sisu on autoriõigusega kaitstud. Teema kood on MIT litsentsiga.

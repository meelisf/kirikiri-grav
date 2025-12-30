# Kirikiri Grav CMS - Paigaldusjuhend NUC serverile

See juhend aitab sul Kirikiri veebilehe NUC serveris tööle panna, kasutades **Dockerit**. See on kõige stabiilsem ja turvalisem viis, eriti kuna sinu serveris jookseb juba teisi teenuseid (Nginx, Jekyll).

## 1. Ettevalmistus serveris

Eeldame, et sul on serveris juba **Docker** ja **Git** olemas.

1.  Logi serverisse sisse.
2.  Liigu kausta, kuhu soovid veebi paigaldada (nt `/home/kasutaja/veebid`).
3.  Klooni repo (või kopeeri failid):
    ```bash
    git clone <repo_url> kirikiri
    cd kirikiri
    ```

## 2. Käivitamine Dockeriga (Soovituslik)

Olen lisanud projekti `Dockerfile` ja `docker-compose.yml`, mis teevad käivitamise väga lihtsaks.

### Samm 1: Konfigureeri port
Vaikimisi paneb `docker-compose.yml` Gravi tööle pordil **8080**.
Kui see port on hõivatud, ava `docker-compose.yml` ja muuda rida:
```yaml
ports:
  - "8080:80"  <-- Muuda esimest numbrit (nt "8081:80")
```

### Samm 2: Käivita
Projektis olles kirjuta:
```bash
docker compose up -d --build
```
See ehitab PHP 8.3 + Apache konteineri ja paneb selle taustal käima.

### Samm 3: Õiguste kontroll
Kuna Grav kirjutab failisüsteemi (cache, logs, images), peab veebiserveril (kasutaja `www-data`, ID 33) olema õigus kirjutada.
Kõige lihtsam on anda kausta omanikuõigus konteineri kasutajale:

```bash
docker exec -u root kirikiri-production chown -R www-data:www-data /var/www/html
```

Nüüd peaks sait olema kättesaadav aadressil `http://<serveri-ip>:8080`.

## 3. Nginx Reverse Proxy (kui soovid ilusat domeeni)

Kuna sul on Nginx juba serveris (“ees”), siis seadista see suunama liiklust Gravi Docker konteinerile.

Loo Nginx konfiguratsioon (nt `/etc/nginx/sites-available/kirikiri.conf`):

```nginx
server {
    listen 80;
    server_name kirikiri.ee www.kirikiri.ee; # Sinu domeen

    location / {
        proxy_pass http://localhost:8080; # Seesama port, mis docker-compose.yml failis
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}
```
Aktiveeri sait ja lae Nginx uuesti:
```bash
sudo ln -s /etc/nginx/sites-available/kirikiri.conf /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

## 4. Hooldus ja uuendamine

- **Koodi uuendamine**:
  ```bash
  git pull
  docker compose restart
  ```
- **Cache tühjendamine** (kui teed muudatusi):
  ```bash
  docker exec -i -u www-data kirikiri-production bin/grav clearcache
  ```



<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>

</p>
##Projecte intermodular 2 de Desenvolupament d'aplicacions WEB


Projecte intermodular per a l'automatització i gestió de les programacions didàctiques del centre. Aquesta entrega conté la documentació i codi corresponents al **Mòdul B: CRUD de Cicles Formatius**.

---

## Entorn del Sistema Operatiu
L'entorn base utilitzat per al desenvolupament ha estat configurat sobre una màquina virtual amb **Ubuntu 24.04 LTS** corrent sota **VirtualBox**.

---

## Arquitectura de l'Entorn Virtual (Docker)
Per a aïllar l'entorn de treball i assegurar la replicabilitat de l'aplicació, s'utilitza **Docker** i **Docker Compose**, gestionant tres serveis independents integrats dins d'una mateixa xarxa virtual (`172.21.0.0/16`):

* **Base de Dades (db):** Servidor MySQL 5.7 accessible localment a través del port `3306`.
* **Aplicació Laravel (myapp):** Servidor de producció/desenvolupament exposat a l'exterior a través del port web `8010`.
* **Administrador SQL (phpmyadmin):** Interfície gràfica de gestió web mapejada al port `8005`.

---

## Guia d'Instal·lació i Configuració des de Zero

### Pas 1: Preparació del Dipòsit i instal·lació de Docker en Ubuntu
Instal·la les claus oficials de Docker GPG i munta les fonts APT en el teu sistema base:
```bash Add Docker's official GPG key:
sudo apt update
sudo apt install ca-certificates curl
sudo install -m 0755 -d /etc/apt/keyrings
sudo curl -fsSL https://docker.com -o /etc/apt/keyrings/docker.asc
sudo chmod a+r /etc/apt/keyrings/docker.asc

sudo tee /etc/apt/sources.list.d/docker.sources <<EOF
Types: deb
URIs: https://docker.com
Suites: $(. /etc/os-release && echo "${UBUNTU_CODENAME:-$VERSION_CODENAME}")
Components: stable
Architectures: $(dpkg --print-architecture)
Signed-By: /etc/apt/keyrings/docker.asc
EOF

sudo apt update
sudo apt install docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin
```

*Opcional: Si vols executar Docker sense necessitat de fer `sudo`, afegeix el teu usuari al grup de Docker:*
```bash
sudo groupadd docker
sudo usermod -aG docker $USER
```
*(Es requereix reiniciar el sistema per a aplicar el canvi d'usuari).*

### Pas 2: Aixecar el Contenidor i Enllaç de Seguretat de MySQL
1. Executa la instal·lació dels contenidors des de l'arrel on resideix el fitxer `docker-compose.yml`:
   ```bash
   docker compose up -d
   ```
2. Un cop iniciat, s'ha de configurar l'usuari amb privilegis d'accés dins del contenidor de la base de dades. Obre una terminal interactiva:
   ```bash
   docker exec -it laravel-db-1 bash
   mysql -u root -p
   ```
   *(Prem `Enter` quan et demani contrasenya, ja que per defecte està configurada com a buida).*

3. Executa les següents sentències SQL per atorgar els permisos complets del node:
   ```sql
   CREATE USER 'jose'@'172.21.0.3' IDENTIFIED BY '';
   GRANT ALL PRIVILEGES ON *.* TO 'jose'@'172.21.0.3';
   FLUSH PRIVILEGES;
   exit
   ```

### Pas 3: Sincronització de l'Entorn Laravel (`.env`)
Configura el fitxer de variables d'entorn `.env` situat a l'arrel de la teva aplicació amb els paràmetres de connexió del contenidor Docker:
```env
DB_CONNECTION=mysql
DB_HOST=172.21.0.2
DB_PORT=3306
DB_DATABASE=BD_myapp
DB_USERNAME=jose
DB_PASSWORD=
```
Dins de l'arxiu `config/database.php` assegura't que s'utilitza la connexió per defecte:
```php
'default' => env('DB_CONNECTION', 'mysql'),
```

### Pas 4: Estructuració de Dades i Dependències Front-end
Accedeix a la terminal del contenidor de l'aplicació web per a generar les estructures físiques i dependències de Bootstrap:
```bash
docker exec -it laravel-myapp-1 bash

# Executar migracions i alimentar dades amb seeders
php artisan migrate:fresh --seed

# Instal·lar paquets de NodeJS i Bootstrap 5
npm install
composer require laravel/ui
php artisan ui bootstrap
npm install sass --save-dev

# Compilar els recursos estàtics del projecte (Obligatori per a visualitzar estils)
npm run build
```

---

## Estructura de la Base de Dades i Taules

L'estructura física de la taula `ciclos_formativos` creada a la base de dades a través de les migracions de Laravel és la següent:

* **`id`**: INT (Primary Key, Autoincremental).
* **`nombre`**: VARCHAR(150) - Nom descriptiu del cicle formatiu.
* **`familia_profesional`**: VARCHAR(100) - Àrea a la qual pertany.
* **`grado`**: VARCHAR(50) - Grau Mitjà / Grau Superior (Controlat per llista selectiva).
* **`modalidad`**: VARCHAR(80) - Presencial / Semipresencial.
* **`decreto_referencia`**: VARCHAR(250) - Marc legal DOGV/BOE.
* **`activo`**: BOOLEAN - Indica l'estat actiu al centre (Gestionat gràficament amb Checkbox).

---

## Taula de Rutes i Operacions RESTful (CRUD)


| Mètode HTTP | URI | Acció de la Ruta | Descripció Operativa |
|---|---|---|---|
| **GET** | `/ciclosFormativos` | `ciclosFormativos.index` | Visualitza el llistat amb paginació de 5 registres i barra de cerca. |
| **GET** | `/ciclosFormativos/create` | `ciclosFormativos.create` | Mostra el formulari de creació del cicle. |
| **POST** | `/ciclosFormativos` | `ciclosFormativos.store` | Emmagatzema el cicle des del Form Request. |
| **GET** | `/ciclosFormativos/{id}` | `ciclosFormativos.show` | Desplega la fitxa sencera de dades del cicle seleccionat. |
| **GET** | `/ciclosFormativos/{id}/edit` | `ciclosFormativos.edit` | Carrega el formulari d'edició amb dades existents. |
| **PUT** | `/ciclosFormativos/{id}` | `ciclosFormativos.update` | Desa els canvis realitzats prèvia validació de dades. |
| **DELETE** | `/ciclosFormativos/{id}` | `ciclosFormativos.destroy` | Elimina permanentment el registre de la base de dades. |

---

## Disseny de Qualitat: Validacions amb Form Request
Sota l'arquitectura i bones pràctiques de desenvolupament, les regles de validació es gestionen en una capa de control externa mitjançant la comanda `php artisan make:request CicloFormativoRequest`.

D'aquesta manera, el controlador no conté lògica de validació encastada en els mètodes `store` o `update`, la qual cosa garanteix la seguretat en els llindars de longitud i tipus de dades dels camps (`nombre`, `familia_profesional`, `decreto_referencia`), oferint alertes visuals gràfiques en color vermell utilitzant la directiva `@error` de Bootstrap 5 en el cas que un camp estigui buit o incomplet.

---

## Complements del Workspace recomanats (VS Code)
Per a garantir la continuïtat del projecte per un altre tècnic o programador, es recomana l'ús de la versió de Visual Studio Code per a Linux amb les següents extensions del marketplace actives:
* **Docker Extension** (Microsoft)
* **Laravel Extension Pack** (Winnie Lin) - Ofereix auto-completat intel·ligent del Framework Laravel, Blade i Artisan.
nem a crear un CRUD (create, read, update i delete) dins d'un projecte de laravel por poder gestionar les programacions didàctiques de L'IES Sant Vicent Ferrer d'Algemesí.

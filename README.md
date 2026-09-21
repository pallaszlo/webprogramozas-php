# Webprogramozás PHP-ben

**Szerző:** Dr. Pál László, egyetemi docens  
**E-mail:** pallaszlo@uni.sapientia.ro

A *Webprogramozás PHP-ben* című kötet kódpéldái és gyakorló feladatainak megoldásai.  
A kötet a Sapientia Erdélyi Magyar Tudományegyetem Csíkszeredai Karán készült.

## A kötet

Pál László: *Webprogramozás PHP-ben*. Scientia Kiadó, Kolozsvár, 2026. ISBN 978-606-975-123-7.  
https://scientiakiado.ro/hu/kiadvanyok/webprogramozas-php-ben

A tíz fejezet egymásra épülve vezeti be a szerveroldali webfejlesztés főbb fogalmait:

| Fejezet | Cím |
|---------|-----|
| 1 | Webes alapok és PHP-bevezetés |
| 2 | A PHP-nyelv elemei |
| 3 | Objektumorientált programozás |
| 4 | Űrlapok kezelése |
| 5 | Sütik és munkamenetek kezelése |
| 6 | Adatbázis-kezelés |
| 7 | REST API-fejlesztés |
| 8 | Composer és csomagkezelés |
| 9 | MVC típusú alkalmazások |
| 10 | Tesztelés és verziókövetés |

## Kódpéldák és megoldások

A `kodpeldak/` mappában fejezetenként megtalálhatók a kötetben szereplő kódpéldák, a `megoldasok/` mappában pedig a gyakorló feladatok megoldásai.

A fájlokban a kódpéldák a kötetbeli sorszámukkal szerepelnek. Ahol egy példa önmagában nem futna, ott „Előkészítés a futtatáshoz” megjegyzéssel jelölt rész egészíti ki. A kötetben nem szereplő példákat „Kiegészítés” jelöli.

### Követelmények

- PHP 8.2 vagy újabb. A 3. fejezet három példája (property hooks, aszimmetrikus láthatóság) PHP 8.4-et igényel, ezért a 8.4 ajánlott.
- MySQL vagy MariaDB (a 6., 7. és 9. fejezethez)
- Composer (a 8–10. fejezethez)

### Futtatás

A legtöbb példa a PHP beépített szerverével közvetlenül futtatható. A példa mappájában:

```bash
php -S localhost:8000
```

Ezután a böngészőben nyissuk meg a `http://localhost:8000/<fájlnév>.php` címet.

Az 1–3. fejezet példáinak és megoldásainak többsége szöveges kimenetű, ezért parancssorból érdemes futtatni őket: `php <fájlnév>.php`.

### Adatbázist használó példák (6., 7. és 9. fejezet)

Ezekhez a fejezetekhez MySQL- vagy MariaDB-szerver kell (például XAMPP). Az adatbázist először létre kell hozni. Ehhez a 6., 7. és 9. fejezet mappájában egy `setup.php` telepítőszkript található, amelyet egyszer kell lefuttatni böngészőből vagy parancssorból (`php setup.php`). A szkript létrehozza az adatbázist és a táblákat, majd feltölti őket mintaadatokkal. Ugyanez a mellette lévő SQL-fájllal is elvégezhető.

| Mappa | Adatbázis | Telepítés |
|-------|-----------|-----------|
| `kodpeldak/06_adatbazis` | `mydb` | `setup.php` vagy `setup.sql` |
| `megoldasok/06_adatbazis` | `webshop` | `setup.php` vagy `setup.sql` |
| `kodpeldak/07_rest_api` | `student_api` | `setup.php` vagy `database.sql` |
| `megoldasok/07_rest_api` | `stocks_api` | `setup.php` vagy `setup.sql` |
| `kodpeldak/09_mvc` | `student_mvc` | `setup.php` vagy `setup.sql` |
| `megoldasok/09_mvc/film-mvc` | `film_mvc` | `setup.php` vagy `setup.sql` |

Az SQL-fájlok parancssorból így futtathatók:

```bash
mysql -u root -p < setup.sql
```

A példák a XAMPP alapbeállítását használják: `root` felhasználó, üres jelszó. A jelszókérésnél ezért elég Entert nyomni.
Ettől eltérő beállítás esetén a kapcsolati adatokat a `setup.php`-ban és a példák konfigurációs fájljában is módosítani kell:

- 6\. fejezet: `db.php` (a megoldásokban `01_db.php`),
- 7\. fejezet: `api/config.php`,
- 9\. fejezet: `src/Core/Database.php` (a megoldásban `public/index.php`).

### A REST API indítása (7. fejezet)

A 7. fejezet API-ja az adatbázis telepítése után két mappából indítható:

- `06_rest_api_implementacio`: hitelesítés nélkül,
- `07_biztonsag_rest_api_kban`: tokenes hitelesítéssel.

```bash
php -S localhost:8080 api/index.php
```

A megoldások API-ja ugyanígy indítható, a 8081-es porton.

### Composer-projektek (8–10. fejezet)

A `vendor/` mappa nincs a tárolóban. Használat előtt a projekt mappájában telepíteni kell a függőségeket:

```bash
composer install
```

- **8. fejezet:** a kódpéldák között minden alfejezet külön kis projekt, ezért a `composer install` parancsot abban az almappában kell futtatni, amelyik példát ki szeretnénk próbálni. A megoldások egyetlen projektet alkotnak. A `kodpeldak/08_composer/06_projektstruktura` projektben futtatás előtt a `.env.example` fájlt `.env` néven le kell másolni, a megoldásban erre csak az e-mail-küldéshez van szükség.
- **9. fejezet:** a példaalkalmazás a fejezet során fokozatosan bővül. Az egyes változatai a `02_`, `03_`, `04_` és `06_` kezdetű mappákban vannak, mindegyik önálló projekt. Az MVC-projektek a `public/` mappából indíthatók: `php -S localhost:8000 -t public`.
- **10. fejezet:** a tesztek a `vendor/bin/phpunit` paranccsal futtathatók. Az API-tesztek (`UserApiTest`) a 7. fejezet API-ját hívják, ezért ha az API nem fut, a PHPUnit kihagyja őket. Az API a `kodpeldak/07_rest_api/06_rest_api_implementacio` mappából indítható: `php -S localhost:8080 api/index.php`.

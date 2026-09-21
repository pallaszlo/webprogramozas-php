# 1. feladat: a részvénykatalógus API végpontjai

A módosító műveletekhez (POST, PUT, PATCH, DELETE) érvényes
`Authorization: Bearer {token}` fejléc kell. Token a `POST /api/auth` végponttól kérhető.

| Metódus | URL | Sikeres válasz | Hibás válaszok | Leírás |
|---------|-----|----------------|----------------|--------|
| GET | `/api/stocks` | 200 | 500 | Részvények listája (szűrés: `sector`, rendezés: `sort=price_asc\|price_desc`, lapozás: `page`, `limit`) |
| GET | `/api/stocks/{id}` | 200 | 400 (érvénytelen azonosító), 404 | Egy részvény adatai |
| POST | `/api/stocks` | 201 | 401, 409 (foglalt ticker), 422 (validációs hiba) | Új részvény létrehozása |
| PUT | `/api/stocks/{id}` | 200 | 400, 401, 404, 409, 422 | A teljes rekord módosítása |
| PATCH | `/api/stocks/{id}` | 200 | 400, 401, 404, 422 | Csak az ár (`price`) módosítása |
| DELETE | `/api/stocks/{id}` | 204 | 400, 401, 404 | Részvény törlése |
| GET | `/api/sectors` | 200 | 500 | Szektorok listája |
| GET | `/api/sectors/{id}` | 200 | 400, 404 | Egy szektor adatai |
| POST | `/api/auth` | 200 | 400 (hiányzó adat), 401 (hibás adatok) | Bejelentkezés, token kérése |

Minden végpontra érvényes: nem támogatott metódus esetén 405, ismeretlen erőforrás esetén 404.

## Postman-gyűjtemény (6. feladat)

A `stocks_api.postman_collection.json` a Postmanből exportált gyűjtemény (Collection v2.1), mind a 14 kéréssel. Betöltése: Postmanben **Import**, majd a fájl kiválasztása. Előbb a *Bejelentkezés* kérést kell elküldeni, a kapott tokent a gyűjtemény automatikusan a `{{token}}` változóba menti. Az API-nak közben futnia kell: `php -S localhost:8081 api/index.php`.

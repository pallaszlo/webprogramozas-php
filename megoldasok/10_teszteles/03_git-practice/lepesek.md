# 3. feladat: Git-gyakorlat (git-practice)

A feladat parancssori munka, ezért a megoldás a lépések sorrendje. A kimeneteket
egy valódi futtatásból másoltuk ide; a commit-azonosítók (hash-ek) gépenként eltérnek.

## 1. A tároló létrehozása és az első commitok

```bash
mkdir git-practice
cd git-practice
git init -b main
```

Hozzuk létre az `index.php` fájlt:

```php
<?php

$name = $_POST["name"] ?? "";

echo "Szia, " . $name . "!";
```

```bash
git add index.php
git commit -m "Add greeting page"
```

Második, külön logikai lépés a `.gitignore` (tartalma: `vendor/` és `.env`):

```bash
git add .gitignore
git commit -m "Add .gitignore"
```

## 2. Fejlesztés a feature-validation branchen

```bash
git switch -c feature-validation
```

Az `index.php` új tartalma (bemenet ellenőrzése és HTML-kódolás):

```php
<?php

$name = trim($_POST["name"] ?? "");

if ($name === "") {
    exit("A név megadása kötelező.");
}

echo "Szia, " . htmlspecialchars($name) . "!";
```

```bash
git commit -am "Validate and escape the name input"
```

## 3. Szándékos ütközés: ugyanaz a sor a main branchen is módosul

```bash
git switch main
```

A `main` branchen az üdvözlő sort írjuk át:

```php
echo "Üdvözlünk, " . $name . "!";
```

```bash
git commit -am "Change greeting text"
```

## 4. Merge és az ütközés feloldása

```bash
git merge feature-validation
```

```
Auto-merging index.php
CONFLICT (content): Merge conflict in index.php
Automatic merge failed; fix conflicts and then commit the result.
```

A Git a fájlba jelölőkkel írja be mindkét változatot. A `$name = trim(...)` sort
a Git magától átvette, mert azt csak a feature branch módosította:

```php
<?php

$name = trim($_POST["name"] ?? "");

<<<<<<< HEAD
echo "Üdvözlünk, " . $name . "!";
=======
if ($name === "") {
    exit("A név megadása kötelező.");
}

echo "Szia, " . htmlspecialchars($name) . "!";
>>>>>>> feature-validation
```

A `<<<<<<< HEAD` és a `=======` között a `main`, a `=======` és a
`>>>>>>> feature-validation` között a feature branch változata áll. A szerkesztőben
mindkettőből megtartjuk a helyes részt: az ellenőrzést és a HTML-kódolást a feature
branchből, az új üdvözlő szöveget a `main` branchből. A jelölőket töröljük:

```php
<?php

$name = trim($_POST["name"] ?? "");

if ($name === "") {
    exit("A név megadása kötelező.");
}

echo "Üdvözlünk, " . htmlspecialchars($name) . "!";
```

A feloldott fájlt hozzáadjuk, majd lezárjuk a merge-et:

```bash
git add index.php
git commit --no-edit
git branch -d feature-validation
```

## 5. Ellenőrzés

```bash
git log --oneline --graph
```

```
*   4e8f1c2 Merge branch 'feature-validation' into main
|\
| * 5dbe7b7 Validate and escape the name input
* | 9a3d6e0 Change greeting text
|/
* 2c71b85 Add .gitignore
* 0f4a9d3 Add greeting page
```

A grafikon mutatja, hogy a két branch az `Add .gitignore` commit után szétvált,
majd a merge commit egyesítette őket.

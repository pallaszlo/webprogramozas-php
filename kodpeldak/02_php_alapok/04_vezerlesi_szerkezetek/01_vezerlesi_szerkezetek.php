<?php

// =============================================================
// 2.4. Vezérlési szerkezetek
// =============================================================


// --- 2.24. Utasítás és utasításblokk -------------------------
$total = 0; // Egyetlen utasítás

{
    $price = 100;
    $tax = 0.2;
    $total = $price * (1 + $tax);
}

echo "Összesen: $total";


// --- 2.25. Egyszerű if utasítás ------------------------------
$age = 18;

if ($age >= 18) {
    echo "Felnőtt.";
}


// --- 2.26. Kétágú if utasítás --------------------------------
$balance = 1000;
$withdrawal = 1200;

if ($balance >= $withdrawal) {
    echo "Sikeres tranzakció.";
    $balance -= $withdrawal;
} else {
    echo "Nincs elég fedezet.";
}


// --- 2.27. Többágú if utasítás -------------------------------
$grade = 75;

if ($grade >= 90) {
    echo "Jeles";
} elseif ($grade >= 80) {
    echo "Jó";
} elseif ($grade >= 70) {
    echo "Közepes";
} elseif ($grade >= 60) {
    echo "Elégséges";
} else {
    echo "Elégtelen";
}


// --- 2.28. Egymásba ágyazott if utasítások -------------------
$username = "kovacs.anna";
$password = "titok123";
$isAdmin = false;

if ($username === "kovacs.anna") {
    if ($password === "titok123") {
        echo "Sikeres bejelentkezés. ";

        if ($isAdmin) {
            echo "Üdvözöljük az admin felületen!";
        } else {
            echo "Üdvözöljük a felhasználói felületen!";
        }

    } else {
        echo "Hibás jelszó.";
    }
} else {
    echo "A felhasználó nem található.";
}


// --- 2.29. Egyszerű switch utasítás --------------------------
$color = "piros";

switch ($color) {
    case "piros":
        echo "A szín piros.";
        break;

    case "kék":
        echo "A szín kék.";
        break;

    default:
        echo "A szín nem piros vagy kék.";
}
// Kimenet: A szín piros.


// --- 2.30. Switch utasítás több eset összevonásával ----------
$day = "Hétfő";

switch ($day) {
    case "Hétfő":
        echo "A munkahét első napja.";
        break;

    case "Kedd":
    case "Szerda":
    case "Csütörtök":
        echo "Hétköznap.";
        break;

    case "Péntek":
        echo "Közeleg a hétvége!";
        break;

    case "Szombat":
    case "Vasárnap":
        echo "Hétvége van!";
        break;

    default:
        echo "Érvénytelen nap.";
}


// --- 2.31. Egyszerű match kifejezés --------------------------
$role = 'szerkesztő';

$label = match ($role) {
    'admin'      => 'Rendszergazda',
    'szerkesztő' => 'Szerkesztő',
    'olvasó'     => 'Olvasó',
    default      => 'Ismeretlen szerepkör'
};

echo $label; // Kimenet: Szerkesztő


// --- 2.32. Match kifejezés több értékkel ---------------------
$day = 'Szombat';

$dayType = match ($day) {
    'Hétfő', 'Kedd', 'Szerda', 'Csütörtök', 'Péntek' => 'hétköznap',
    'Szombat', 'Vasárnap' => 'hétvége',
};

echo $dayType; // Kimenet: hétvége


// --- 2.33. Match kifejezés feltételekkel ---------------------
$age = 25;

$category = match (true) {
    $age < 18               => 'kiskorú',
    $age >= 18 && $age < 65 => 'felnőtt',
    $age >= 65              => 'idős',
};

echo $category; // Kimenet: felnőtt


// --- 2.34. A switch és match összehasonlítása ----------------
$value = "1";

// Switch - laza összehasonlítás
switch ($value) {
    case 1:
        echo "Szám\n";
        break;

    case "1":
        echo "String\n";
        break;
}

// Kimenet: Szám

// Match - szigorú összehasonlítás
$result = match ($value) {
    1   => "Szám",
    "1" => "String",
};

echo $result; // Kimenet: String


// --- 2.35. Egyszerű while ciklus -----------------------------
$i = 1;

while ($i <= 5) {
    echo $i . " ";
    $i++;
}
// Kimenet: 1 2 3 4 5


// --- 2.36. Összetettebb while ciklus -------------------------
$attempts = 0;
$maxAttempts = 5;

while ($attempts < $maxAttempts) {
    echo "Próbálkozás: " . ($attempts + 1) . "\n";

    // Sikertelen próbálkozás szimulálása
    $success = (rand(0, 1) == 1);

    if ($success) {
        echo "Sikeres művelet!\n";
        break;
    }

    $attempts++;
}

if ($attempts == $maxAttempts) {
    echo "Elérte a maximális próbálkozások számát.";
}
// Kimenet: a véletlen függvényében változó


// --- 2.38. Egyszerű for ciklus -------------------------------
for ($i = 1; $i <= 5; $i++) {
    echo $i . " ";
}
// Kimenet: 1 2 3 4 5


// --- 2.39. For ciklus visszafelé léptetéssel -----------------
for ($i = 5; $i >= 1; $i--) {
    echo $i . " ";
}
// Kimenet: 5 4 3 2 1


// --- 2.40. Összetettebb for ciklus ---------------------------
$total = 0;
$items = [10, 20, 30, 40, 50];

for ($i = 0; $i < count($items); $i++) {
    $total += $items[$i];
    echo "Részösszeg a " . ($i + 1) . ". tétel után: $total\n";
}

echo "Végösszeg: $total";


// --- 2.41. Egyszerű foreach ciklus ---------------------------
$colors = ["piros", "kék", "zöld"];

foreach ($colors as $color) {
    echo $color . " ";
}
// Kimenet: piros kék zöld


// --- 2.42. Összetettebb foreach ciklus -----------------------
$prices = [1200, 350, 89, 4500, 275];
$total = 0;

foreach ($prices as $index => $price) {
    echo ($index + 1) . ". termék ára: $price RON\n";
    $total += $price;
}

echo "Összesen: $total RON";


// --- 2.43. Ciklusvezérlő utasítások használata ---------------
$numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
$sum = 0;

foreach ($numbers as $number) {
    if ($number % 2 != 0) {
        continue; // a páratlan számokat kihagyjuk
    }

    if ($sum + $number > 20) {
        break; // megállunk, ha az összeg meghaladná a 20-at
    }

    $sum += $number;
}

echo "Páros számok összege (max. 20): $sum";  // Kimenet: 20


// --- 2.44. Egyszerű egymásba ágyazott ciklusok ---------------
for ($i = 1; $i <= 3; $i++) {
    for ($j = 1; $j <= 3; $j++) {
        echo "($i, $j) ";
    }

    echo "<br>";
}
// Kimenet:
// (1, 1) (1, 2) (1, 3)
// (2, 1) (2, 2) (2, 3)
// (3, 1) (3, 2) (3, 3)


// --- 2.45. Egymásba ágyazott ciklusok tömbbel ----------------
$students = ["Anna", "Béla", "Csilla"];
$subjects = ["Webprogramozás", "Adatbázisok", "Algoritmusok"];

foreach ($students as $student) {
    foreach ($subjects as $subject) {
        echo "$student - $subject\n";
    }
}


// --- 2.46. Kilépés több ciklusból ----------------------------
foreach ($students as $student) {
    foreach ($subjects as $subject) {
        if ($subject === "Adatbázisok") {
            break 2; // mindkét ciklusból kilép
        }
        echo "$student - $subject\n";
    }
}
// Kimenet: Anna - Webprogramozás


// =============================================================
// Kiegészítés: további példák, ezek nem szerepelnek a könyvben
// =============================================================
echo "\n--- Kiegészítés ---\n";

// A match több értéket is csoportosíthat egy ágba
$status = 2;
$label = match ($status) {
    1       => "Aktív",
    2, 3    => "Függőben",
    4       => "Lezárva",
    default => "Ismeretlen",
};
echo $label . PHP_EOL;  // Függőben

// A do...while hamis feltétel mellett is egyszer lefut
$n = 10;
do {
    echo $n . " ";
    $n++;
} while ($n <= 5);
echo PHP_EOL;  // 10

// Szorzótábla egymásba ágyazott for ciklusokkal
for ($row = 1; $row <= 3; $row++) {
    for ($col = 1; $col <= 3; $col++) {
        echo "{$row}×{$col}=" . ($row * $col) . "  ";
    }
    echo PHP_EOL;
}
// 1×1=1  1×2=2  1×3=3
// 2×1=2  2×2=4  2×3=6
// 3×1=3  3×2=6  3×3=9

// Csak a páratlan számok kiírása continue-val
for ($p = 0; $p < 10; $p++) {
    if ($p % 2 === 0) {
        continue;
    }
    echo $p . " ";
}
echo PHP_EOL;  // 1 3 5 7 9

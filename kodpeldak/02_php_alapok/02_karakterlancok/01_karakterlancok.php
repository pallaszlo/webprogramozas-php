<?php

// =============================================================
// 2.2. Karakterláncok kezelése
// =============================================================


// --- 2.11. Karakterláncok megadási módjai --------------------
$name = "Kovács Anna";
$age = 30;

// Aposztrófok - változók NEM értékelődnek ki
echo 'Helló $name, $age éves vagy.';
// Kimenet: Helló $name, $age éves vagy.

// Idézőjelek - változók kiértékelődnek
echo "Helló $name, $age éves vagy.";
// Kimenet: Helló Kovács Anna, 30 éves vagy.

// Heredoc - többsoros, változók kiértékelődnek
echo <<<EOT
Helló $name,
$age éves vagy.
Ez egy többsoros karakterlánc.
EOT;
// Kimenet:
// Helló Kovács Anna,
// 30 éves vagy.
// Ez egy többsoros karakterlánc.

// Nowdoc - többsoros literál
echo <<<'EOT'
Helló $name,
$age éves vagy.
A változók itt nem értékelődnek ki.
EOT;
// Kimenet:
// Helló $name,
// $age éves vagy.
// A változók itt nem értékelődnek ki.


// --- 2.12. Összetett változóbehelyettesítés ------------------
$fruit = "alma";
$count = 5;

// Egyszerű változók (kapcsos zárójelek nélkül is működik)
echo "$count darab $fruit van a kosárban.";
// Kimenet: 5 darab alma van a kosárban.

// Tömbelem behelyettesítése kapcsos zárójelekkel
$fruits = ['alma', 'körte', 'szilva'];
echo "A kedvenc gyümölcsöm: {$fruits[0]}";
// Kimenet: A kedvenc gyümölcsöm: alma

// Objektumtulajdonság behelyettesítése
$obj = new stdClass();
$obj->name = "Kovács Anna";

echo "A nevem: {$obj->name}";
// Kimenet: A nevem: Kovács Anna

// Kifejezések esetén összefűzést használunk
echo "Gyümölcsök száma: " . ($count + 1);
// Kimenet: Gyümölcsök száma: 6


// --- 2.13. Escape karakterek használata ----------------------
$name = "Kovács Anna";

// Idézőjeles karakterláncban az escape szekvenciák értelmeződnek
echo "Új sor:\nTabulátor:\tBackslash:\\";
// Kimenet: Új sor:(új sor)Tabulátor:(tab)Backslash:\

// Aposztrófos karakterláncban az escape szekvenciák többsége nem értelmeződik
echo 'Új sor:\nTabulátor:\tBackslash:\\';
// Kimenet: Új sor:\nTabulátor:\tBackslash:\

// Változóbehelyettesítés elkerülése
echo "A nevem: \$name";  // Kimenet: A nevem: $name
echo "A nevem: $name";   // Kimenet: A nevem: Kovács Anna

// Idézőjelek használata karakterláncban
echo "Azt mondta: \"Helló!\"";  // Kimenet: Azt mondta: "Helló!"
echo 'Azt mondta: "Helló!"';    // Kimenet: Azt mondta: "Helló!"


// --- 2.14. Karakterlánc-műveletek és függvények példái -------
// Összefűzés és módosítás
$str1 = "Helló";
$str2 = "világ";
$result = $str1 . " " . $str2;             // Helló világ

$str = "Helló";
$str .= " világ";                          // Helló világ

$newStr = str_replace("világ", "PHP", $str); // Helló PHP
$sub = substr($str, 0, 4);                 // "Hell"
$mbSub = mb_substr($str, 0, 5);            // "Helló"

// Hossz és indexelés
$char = $str[0];                           // 'H'
$length = strlen($str);                    // 13 (bájtok száma)
$mbLength = mb_strlen($str);               // 11 (karakterek száma)

// Keresés és összehasonlítás
$position = strpos($str, "világ");         // 7 (bájtpozíció)
$comparison = strcmp("alma", "körte");     // negatív érték

// Formázás és átalakítás
echo strtolower("HELLO");                  // hello
echo strtoupper("hello");                  // HELLO

$trimmed = trim("  Helló  ");              // "Helló"

$formatted = sprintf("Név: %s, Kor: %d", "Kovács Anna", 30);
// Név: Kovács Anna, Kor: 30

// Szétbontás és egyesítés
$parts = explode(" ", $str);               // ["Helló", "világ"]
$joined = implode(", ", $parts);           // "Helló, világ"

// Reguláris kifejezés
$pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,}$/";
$email = "anna@example.ro";

if (preg_match($pattern, $email)) {
    echo "Érvényes e-mail cím";
}


// --- 2.15. sprintf() használata ------------------------------
$price = 1499.9;
echo sprintf("Ár: %.2f RON", $price);        // Ár: 1499.90 RON

$name = "Kovács Anna";
$age  = 30;

echo sprintf("%s (%d éves)", $name, $age);  // Kovács Anna (30 éves)
echo sprintf("%05d", 42);                   // 00042


// =============================================================
// Kiegészítés: további példák, ezek nem szerepelnek a könyvben
// =============================================================
echo "\n--- Kiegészítés ---\n";

// Kezdőbetűk nagybetűsítése
echo ucfirst("kovács anna") . PHP_EOL;  // Kovács anna
echo ucwords("kovács anna") . PHP_EOL;  // Kovács Anna

// Karakter ismétlése
echo str_repeat("-", 20) . PHP_EOL;     // --------------------

// Vezető nullák és szöveg egy formátumsztringben
$label = sprintf("Termék #%03d: %s", 7, "Notebook");
echo $label . PHP_EOL;                  // Termék #007: Notebook

// Aposztrófos sztringben a \' aposztrófot jelent
echo 'Aposztróf: \'' . PHP_EOL;          // Aposztróf: '

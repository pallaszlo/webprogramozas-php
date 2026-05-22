<?php

// ============================================================
// Karakterláncok: megadási módok, escape, függvények, sprintf
// Kapcsolódó fejezet: 2.2. Karakterláncok kezelése
// ============================================================


// --- Megadási módok --------------------------------------------

$name = "Kovács Anna";
$age  = 30;

// Aposztrófok – változók NEM értékelődnek ki
echo 'Helló $name, $age éves vagy.' . PHP_EOL;
// Kimenet: Helló $name, $age éves vagy.

// Idézőjelek – változók kiértékelődnek
echo "Helló $name, $age éves vagy." . PHP_EOL;
// Kimenet: Helló Kovács Anna, 30 éves vagy.

// Heredoc – többsoros, változók kiértékelődnek
echo <<<EOT
Helló $name,
$age éves vagy.
Ez egy többsoros karakterlánc.
EOT;

// Nowdoc – többsoros literál, változók NEM értékelődnek ki
echo <<<'EOT'
Helló $name,
$age éves vagy.
A változók itt nem értékelődnek ki.
EOT;
echo PHP_EOL;


// --- Változók behelyettesítése összetett kifejezésekben --------

$count  = 5;
$fruits = ['alma', 'körte', 'szilva'];

echo "Gyümölcsök száma: {$count}" . PHP_EOL;
echo "A kedvenc gyümölcsöm: {$fruits[0]}" . PHP_EOL;

$obj       = new stdClass();
$obj->name = "Kovács Anna";
echo "A nevem: {$obj->name}" . PHP_EOL;


// --- Escape karakterek -----------------------------------------

// Idézőjeles stringben minden escape működik
echo "Új sor:\nTabulátor:\tBackslash:\\" . PHP_EOL;

// Aposztrófos stringben csak \' és \\
echo 'Aposztróf: \'' . PHP_EOL;

// Változóbehelyettesítés elkerülése
echo "A nevem: \$name" . PHP_EOL;  // $name jelenik meg, nem az érték

// Idézőjel a stringben
echo "Azt mondta: \"Helló!\"" . PHP_EOL;
echo 'Azt mondta: "Helló!"'   . PHP_EOL;


// --- Karakterlánc-függvények -----------------------------------

$str = "Hello Vilag";

// Összefűzés
$result = "Hello" . " " . "Vilag";
$str   .= "!";

// Hossz, indexelés
echo strlen($str)  . PHP_EOL;  // 12
echo $str[0]       . PHP_EOL;  // H

// Keresés, csere, részstring
echo strpos($str, "Vilag")           . PHP_EOL;  // 6
echo str_replace("Vilag", "PHP", $str) . PHP_EOL;
echo substr($str, 0, 5)              . PHP_EOL;  // Hello

// Kis-/nagybetű, vágás
echo strtolower("HELLO")   . PHP_EOL;  // hello
echo strtoupper("hello")   . PHP_EOL;  // HELLO
echo trim("  Helló  ")     . PHP_EOL;  // Helló
echo ucfirst("kovács anna") . PHP_EOL; // Kovács anna
echo ucwords("kovács anna") . PHP_EOL; // Kovács Anna

// Szétbontás és összefűzés
$parts  = explode(" ", "Helló Világ");  // ["Helló", "Világ"]
$joined = implode(", ", $parts);        // "Helló, Világ"
echo $joined . PHP_EOL;

// Reguláris kifejezés – e-mail validáció
$pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
$email   = "anna@example.ro";
if (preg_match($pattern, $email)) {
    echo "Érvényes e-mail cím" . PHP_EOL;
}


// --- sprintf() -------------------------------------------------

$price = 1499.9;
echo sprintf("Ár: %.2f RON", $price) . PHP_EOL;        // Ár: 1499.90 RON

$name = "Kovács Anna";
$age  = 30;
echo sprintf("%s (%d éves)", $name, $age) . PHP_EOL;   // Kovács Anna (30 éves)

echo sprintf("%05d", 42) . PHP_EOL;                    // 00042

// sprintf visszaadja az értéket – el lehet tárolni, tovább lehet adni
$label = sprintf("Termék #%03d: %s", 7, "Notebook");
echo $label . PHP_EOL;  // Termék #007: Notebook

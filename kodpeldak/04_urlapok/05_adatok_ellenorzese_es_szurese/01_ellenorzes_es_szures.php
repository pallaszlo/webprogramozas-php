<?php

// =============================================================
// 4.5. Adatok ellenőrzése és szűrése: 4.26., 4.29–4.32. kódpélda
// =============================================================


// --- 4.26. htmlspecialchars() használata ---------------------
$userInput = '<script>alert("XSS");</script>';
$safeInput = htmlspecialchars($userInput, ENT_QUOTES, 'UTF-8');

echo $safeInput;
// Kimenet:
// &lt;script&gt;alert(&quot;XSS&quot;);&lt;/script&gt;


// --- 4.29. filter_var() használata ---------------------------
$email = "user@example.com";

// Email validálása
if (filter_var($email, FILTER_VALIDATE_EMAIL) !== false) {
    echo "Érvényes email cím.";
} else {
    echo "Érvénytelen email cím.";
}

// Egész szám validálása tartománnyal
$age = 25;
$options = [
    "options" => [
        "min_range" => 18,
        "max_range" => 99
    ]
];

if (filter_var($age, FILTER_VALIDATE_INT, $options) !== false) {
    echo "Érvényes életkor.";
} else {
    echo "Érvénytelen életkor.";
}


// --- 4.30. Irányítószám ellenőrzése --------------------------
$zip = "400001";

if (preg_match('/^\d{6}$/', $zip)) {
    echo "Érvényes irányítószám.";
} else {
    echo "Érvénytelen irányítószám.";
}


// --- 4.31. Részminták kinyerése ------------------------------
$email = "kovacs.peter@example.com";

if (preg_match('/^([^@]+)@(.+)$/', $email, $matches)) {
    echo "Felhasználónév: " . $matches[1] . "<br>";
    echo "Domain: " . $matches[2];
}


// --- 4.32. Jelszó ellenőrzése reguláris kifejezéssel ---------
$password = "Abcd1234!";

$pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";

if (preg_match($pattern, $password)) {
    echo "A jelszó megfelel a követelményeknek.";
} else {
    echo "A jelszó nem felel meg a követelményeknek.";
}

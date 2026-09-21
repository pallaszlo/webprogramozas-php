<?php
// Szimulált felhasználók
$felhasznalok = [
    'admin'  => password_hash('admin123',  PASSWORD_DEFAULT),
    'tanulo' => password_hash('jelszo456', PASSWORD_DEFAULT),
];

// A süti aláírásához használt titkos kulcs. Éles környezetben .env fájlból
// töltjük be (lásd a 8. fejezetet), és nem kerül a forráskódba.
const TITKOS_KULCS = 'csereljuk-le-egy-hosszu-veletlen-kulcsra';

// A süti értéke "felhasználónév|aláírás". Az aláírást csak a szerver tudja
// előállítani, így a felhasználó nem írhat át a sütiben egy másik nevet.
function sutiErtek(string $nev): string
{
    return $nev . '|' . hash_hmac('sha256', $nev, TITKOS_KULCS);
}

function sutiEllenoriz(string $ertek): ?string
{
    $reszek = explode('|', $ertek, 2);
    if (count($reszek) !== 2) {
        return null;
    }
    [$nev, $alairas] = $reszek;
    $vart = hash_hmac('sha256', $nev, TITKOS_KULCS);

    return hash_equals($vart, $alairas) ? $nev : null;
}

$uzenet      = '';
$sikeres     = false;
$belepettNev = '';

// Kijelentkezés
if (isset($_GET['kilepes'])) {
    setcookie('emlekezz', '', ['expires' => time() - 3600, 'path' => '/']);
    header('Location: index.php');
    exit;
}

// Automatikus felismerés a süti alapján
if (isset($_COOKIE['emlekezz'])) {
    $sutiNev = sutiEllenoriz($_COOKIE['emlekezz']);
    if ($sutiNev !== null && isset($felhasznalok[$sutiNev])) {
        $uzenet      = "Automatikusan felismerve: {$sutiNev}";
        $sikeres     = true;
        $belepettNev = $sutiNev;
    }
}

// Bejelentkezés
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nev      = trim($_POST['nev'] ?? '');
    $jelszo   = $_POST['jelszo'] ?? '';
    $emlekezz = isset($_POST['emlekezz']);

    if (isset($felhasznalok[$nev]) && password_verify($jelszo, $felhasznalok[$nev])) {
        $sikeres     = true;
        $belepettNev = $nev;
        $uzenet      = "Sikeres bejelentkezés!";

        if ($emlekezz) {
            setcookie('emlekezz', sutiErtek($nev), [
                'expires'  => time() + 86400 * 30,
                'path'     => '/',
                'httponly' => true,
                'secure'   => true,  // a böngészők localhoston HTTPS nélkül is elfogadják
                'samesite' => 'Strict',
            ]);
        }
    } else {
        $uzenet = 'Hibás felhasználónév vagy jelszó.';
    }
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Emlékezz rám</title>
</head>
<body>

<h1>Bejelentkezés – „Emlékezz rám”</h1>
<p><em>Teszt fiókok: <code>admin / admin123</code>, <code>tanulo / jelszo456</code></em></p>

<?php if ($uzenet): ?>
    <p style="color:<?= $sikeres ? 'green' : 'red' ?>;"><?= htmlspecialchars($uzenet) ?></p>
<?php endif; ?>

<?php if ($sikeres): ?>
    <p>Üdvözöljük, <strong><?= htmlspecialchars($belepettNev) ?></strong>!</p>
    <a href="?kilepes=1">Kijelentkezés (süti törlése)</a>
<?php else: ?>
    <form method="POST">
        <p><label>Felhasználónév: <input type="text" name="nev"></label></p>
        <p><label>Jelszó: <input type="password" name="jelszo"></label></p>
        <p><label>
            <input type="checkbox" name="emlekezz" value="1"> Emlékezz rám (30 nap)
        </label></p>
        <button type="submit">Bejelentkezés</button>
    </form>
<?php endif; ?>

</body>
</html>

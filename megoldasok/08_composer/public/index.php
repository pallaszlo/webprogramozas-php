<?php
// Telepítés: composer install
// Indítás:   composer start  (vagy: php -S localhost:8000 -t public), majd http://localhost:8000
// Az e-mail-küldéshez (5. feladat) a .env.example fájlt másoljuk .env néven,
// és töltsük ki az SMTP-adatokat.

use App\Models\Event;
use App\Services\Calendar;
use App\Services\Mailer;
use Carbon\Carbon;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

require __DIR__ . '/../vendor/autoload.php';

// A safeLoad() nem áll le, ha nincs .env fájl, így az 1–4. feladat nélküle is fut
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->safeLoad();

Carbon::setLocale('hu');

// --- 1. feladat: Carbon dátumműveletek ---
$today    = Carbon::today();
$tomorrow = Carbon::tomorrow();
$daysLeft = (int) $today->diffInDays(Carbon::today()->endOfYear()->startOfDay());

// --- 2. feladat: Event és Calendar osztályok ---
$calendar = new Calendar();
$calendar->addEvent(new Event('PHP konferencia', 'Budapest', Carbon::now()->addDays(10)));
$calendar->addEvent(new Event('Composer workshop', 'Debrecen', Carbon::now()->addDays(3)));
$calendar->addEvent(new Event('Régi meetup', 'Pécs', Carbon::now()->subDays(5)));  // múltbeli, nem jelenik meg
$calendar->addEvent(new Event('Laravel meetup', 'Kolozsvár', Carbon::now()->addDays(21)));

$upcoming = $calendar->getUpcomingEvents();

// --- 5. feladat: a következő esemény elküldése e-mailben ---
$mailStatus = null;
if (!empty($upcoming) && !empty($_ENV['SMTP_HOST']) && !empty($_ENV['MAIL_TO'])) {
    $next = $upcoming[0];
    $body = sprintf(
        "Következő esemény:\n\nCím:      %s\nHelyszín: %s\nDátum:    %s\n",
        $next->getTitle(),
        $next->getLocation(),
        $next->getDate()->isoFormat('YYYY. MMMM D., dddd')
    );

    try {
        (new Mailer())->send($_ENV['MAIL_TO'], 'Következő esemény: ' . $next->getTitle(), $body);
        $mailStatus = 'Az e-mail elküldve: ' . $_ENV['MAIL_TO'];
    } catch (PHPMailerException $e) {
        error_log($e->getMessage());
        $mailStatus = 'Az e-mail küldése sikertelen. Ellenőrizzük az SMTP-beállításokat.';
    }
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Eseménynaptár</title>
</head>
<body>

<h1>Dátumok</h1>
<ul>
    <li>Ma: <?= htmlspecialchars($today->isoFormat('YYYY. MMMM D., dddd')) ?></li>
    <li>Holnap: <?= htmlspecialchars($tomorrow->isoFormat('YYYY. MMMM D., dddd')) ?></li>
    <li>Napok az év végéig: <?= $daysLeft ?></li>
</ul>

<h1>Közelgő események</h1>
<?php if (function_exists('dump')): ?>
    <?php // 3. feladat: a dump() csak fejlesztői telepítésnél (require-dev) érhető el ?>
    <?php dump($upcoming); ?>
<?php endif; ?>

<?php if (empty($upcoming)): ?>
    <p>Nincs közelgő esemény.</p>
<?php else: ?>
    <table border="1" cellpadding="6">
        <tr><th>Esemény</th><th>Helyszín</th><th>Dátum</th></tr>
        <?php foreach ($upcoming as $event): ?>
            <tr>
                <td><?= htmlspecialchars($event->getTitle()) ?></td>
                <td><?= htmlspecialchars($event->getLocation()) ?></td>
                <td><?= htmlspecialchars($event->getDate()->isoFormat('YYYY. MMMM D.')) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<h1>E-mail-értesítés</h1>
<?php if ($mailStatus === null): ?>
    <p>Az e-mail-küldéshez töltsük ki a .env fájlt (lásd .env.example).</p>
<?php else: ?>
    <p><?= htmlspecialchars($mailStatus) ?></p>
<?php endif; ?>

</body>
</html>

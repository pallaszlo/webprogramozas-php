<?php
// Telepítés: composer install
// Indítás:   composer start  (vagy: php -S localhost:8000 -t public)
// .env fájl: másold a .env.example-t .env névre, és töltsd ki az SMTP-adatokat

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

use Carbon\Carbon;
use App\Models\Event;
use App\Services\Calendar;
use App\Services\Mailer;

Carbon::setLocale('hu');

// --- 1. feladat: Carbon dátumműveletek ---
$today    = Carbon::today();
$tomorrow = Carbon::tomorrow();
$daysLeft = $today->diffInDays(Carbon::parse('last day of December'));

echo "=== Dátumok ===" . PHP_EOL;
echo "Ma:             " . $today->isoFormat('YYYY. MMMM D., dddd') . PHP_EOL;
echo "Holnap:         " . $tomorrow->isoFormat('YYYY. MMMM D., dddd') . PHP_EOL;
echo "Napok az év végéig: $daysLeft" . PHP_EOL . PHP_EOL;

// --- 2. feladat: Event és Calendar osztályok ---
$calendar = new Calendar();

$calendar->addEvent(new Event(
    'PHP konferencia',
    'Budapest',
    Carbon::now()->addDays(10),
));
$calendar->addEvent(new Event(
    'Composer workshop',
    'Debrecen',
    Carbon::now()->addDays(3),
));
$calendar->addEvent(new Event(
    'Régi meetup',
    'Pécs',
    Carbon::now()->subDays(5),   // múltbeli – nem jelenik meg
));
$calendar->addEvent(new Event(
    'Laravel meetup',
    'Kolozsvár',
    Carbon::now()->addDays(21),
));

$upcoming = $calendar->getUpcomingEvents();

// --- 5. feladat: e-mail küldés PHPMailerrel ---
if (!empty($upcoming)) {
    $next    = $upcoming[0];
    $mailer  = new Mailer();
    $subject = 'Következő esemény: ' . $next->getTitle();
    $body    = sprintf(
        "Következő esemény:\n\nCím:      %s\nHelyszín: %s\nDátum:    %s\n",
        $next->getTitle(),
        $next->getLocation(),
        $next->getDate()->isoFormat('YYYY. MMMM D., dddd')
    );
    $mailer->send($_ENV['MAIL_TO'], $subject, $body);
    echo "E-mail elküldve: " . $_ENV['MAIL_TO'] . PHP_EOL . PHP_EOL;
}

echo "=== Közelgő események ===" . PHP_EOL;

// --- 3. feladat: symfony/var-dumper (csak dev módban telepítve) ---
if (function_exists('dump')) {
    dump($upcoming);
} else {
    foreach ($upcoming as $event) {
        printf(
            "%-25s | %-15s | %s\n",
            $event->getTitle(),
            $event->getLocation(),
            $event->getDate()->isoFormat('YYYY. MMMM D.')
        );
    }
}

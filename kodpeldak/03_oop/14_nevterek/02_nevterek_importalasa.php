<?php

// =============================================================
// 3.56. Névterek importálása és álnevek
// =============================================================

// Előkészítés a futtatáshoz (nem része a könyvbeli kódpéldának)
require_once 'Models/User.php';
require_once 'Services/UserService.php';
require_once 'Helpers/functions.php';
require_once 'Config/constants.php';

use MyProject\Models\User;
use MyProject\Services\UserService as Service;
use function MyProject\Helpers\formatDate;
use const MyProject\Config\MAX_USERS;

$user    = new User(1, 'Kovács János');
$service = new Service();

echo formatDate('2024-01-01');
echo MAX_USERS;

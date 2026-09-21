<?php

// =============================================================
// 5.11. A „headers already sent” hiba elkerülése
// =============================================================

// Helyes: süti beállítása a kimenet előtt
setcookie("user", "John");
echo "Hello World!";

// Helytelen: hibát okoz
echo "Hello World!";
setcookie("user", "John"); // Hiba: Headers already sent
?>

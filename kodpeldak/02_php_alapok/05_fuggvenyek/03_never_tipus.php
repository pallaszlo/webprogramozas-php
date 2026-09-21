<?php

// =============================================================
// 2.54. Never típus használata
// =============================================================

function redirect(string $url): never
{
    header("Location: $url");
    exit();
}

function throwError(string $message): never
{
    throw new Exception($message);
}

function infiniteLoop(): never
{
    while (true) {
        // végtelen ciklus
    }
}

// A never típusú függvény után a kód nem fut tovább
redirect('/home');
echo "Ez nem fog lefutni"; // elérhetetlen kód

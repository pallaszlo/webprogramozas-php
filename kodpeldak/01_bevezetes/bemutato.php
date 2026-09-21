<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bemutató PHP program</title>
</head>
<body>
    <h1>Üdvözöl a PHP!</h1>

    <?php
        // Ez egy egysoros megjegyzés

        /*
        Ez egy többsoros
        megjegyzés blokk
        */

        // Változók és echo használata
        $name = "Felhasználó";
        $age = 25;
        echo "<p>Helló, $name! {$age} éves vagy.</p>";

        // Feltételes utasítás
        if ($age >= 18) {
            echo "<p>Felnőtt vagy.</p>";
        } else {
            echo "<p>Kiskorú vagy.</p>";
        }

        // Tömbök
        $fruits = ["alma", "körte", "banán", "narancs"];
        echo "<p>A kedvenc gyümölcsöm: " . $fruits[2] . "</p>";

        // Ciklus
        echo "<ul>";
        foreach ($fruits as $fruit) {
            echo "<li>$fruit</li>";
        }
        echo "</ul>";

        // Függvény definiálása és használata
        function add($a, $b) {
            return $a + $b;
        }

        $result = add(5, 3);
        echo "<p>5 + 3 = $result</p>";

        // Dátum és idő
        echo "<p>Mai dátum: " . date("Y-m-d") . "</p>";
        echo "<p>Jelenlegi idő: " . date("H:i:s") . "</p>";
    ?>
</body>
</html>

<?php

// =============================================================
// 7.5. JSON-válaszok
// =============================================================


// --- 7.3. json_encode() alapvető használata ------------------
$data = ["name" => "Kovács János", "age" => 30];

// Alapértelmezés: az ékezetes karakterek \uXXXX alakban jelennek meg
echo json_encode($data);
// {"name":"Kov\u00e1cs J\u00e1nos","age":30}

// Ékezetek megtartása és formázott kimenet
echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
// {
//     "name": "Kovács János",
//     "age": 30
// }


// --- 7.4. json_decode() objektumként és tömbként -------------
$json = '{"name":"Kovács János","age":30}';

// Objektumként (alapértelmezett)
$obj = json_decode($json);
echo $obj->name; // Kovács János

// Asszociatív tömbként
$arr = json_decode($json, true);
echo $arr['name']; // Kovács János


// --- 7.5. JSON-hibakezelés kivétellel ------------------------
// Előkészítés a futtatáshoz (nem része a könyvbeli kódpéldának)
$json = '{"name": "Kovács János", }'; // hibás JSON (vessző a végén)

try {
    $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
} catch (JsonException $e) {
    echo "JSON hiba: " . $e->getMessage();
}

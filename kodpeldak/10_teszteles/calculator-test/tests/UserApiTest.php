<?php

// =============================================================
// 10.11. API-tesztelés
// =============================================================
// Integrációs teszt: futó API-t igényel. Indítsuk el a 7. fejezet API-ját
// (kodpeldak/07_rest_api/06_rest_api_implementacio mappából):
//   php -S localhost:8080 api/index.php
// Ha az API nem fut, a PHPUnit ezeket a teszteket kihagyja (skipped).

use PHPUnit\Framework\TestCase;

class UserApiTest extends TestCase
{
    private string $baseUrl = 'http://localhost:8080/api';

    public function testGetUsersReturnsSuccess(): void
    {
        $response = $this->makeHttpRequest('GET', '/students');

        // Státuszkód ellenőrzése
        $this->assertEquals(200, $response['status']);

        // JSON struktúra ellenőrzése
        $this->assertArrayHasKey('data', $response['body']);
        $this->assertIsArray($response['body']['data']);
    }

    public function testCreateUserWithValidData(): void
    {
        $newUser = [
            'name' => 'Test User',
            'email' => uniqid('test') . '@example.com'
        ];

        $response = $this->makeHttpRequest('POST', '/students', $newUser);

        // 201 Created státuszkód
        $this->assertEquals(201, $response['status']);

        // Új felhasználó adatai visszaérkeznek
        $this->assertArrayHasKey('id', $response['body']['data']);
    }

    public function testCreateUserWithInvalidEmail(): void
    {
        $invalidUser = [
            'name' => 'Test',
            'email' => 'invalid-email'
        ];

        $response = $this->makeHttpRequest('POST', '/students', $invalidUser);

        // 422 Unprocessable Entity, mezőnkénti hibaüzenetekkel
        $this->assertEquals(422, $response['status']);
        $this->assertArrayHasKey('errors', $response['body']);
    }

    // Segédmetódus HTTP-kérésekhez
    private function makeHttpRequest(
        string $method,
        string $endpoint,
        ?array $data = null
    ): array {
        // cURL használata a HTTP-kérés végrehajtásához
        // Visszaadja: ['status' => ..., 'body' => ...]

        // Kiegészítés (nem szerepel a könyvben): a segédmetódus megvalósítása
        $ch = curl_init($this->baseUrl . $endpoint);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => $method,
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
        ]);
        if ($data !== null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $body = curl_exec($ch);
        if ($body === false) {
            $this->markTestSkipped('Az API nem érhető el: ' . $this->baseUrl);
        }

        return [
            'status' => curl_getinfo($ch, CURLINFO_HTTP_CODE),
            'body'   => json_decode($body, true) ?? [],
        ];
    }
}

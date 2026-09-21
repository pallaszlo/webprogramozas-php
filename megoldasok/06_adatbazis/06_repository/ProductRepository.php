<?php

/**
 * A termékek adatbázis-műveletei.
 * Az adatbázis-hibákat az osztály kezeli: naplózza őket, és a hívónak semleges értéket ad
 * vissza (null, üres tömb vagy false).
 */
class ProductRepository
{
    public function __construct(
        private PDO $pdo
    ) {}

    /** Új termék mentése. Az új azonosítót adja vissza, hiba esetén null-t. */
    public function create(string $name, float $price, int $stock, ?int $categoryId): ?int
    {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO products (name, price, stock, category_id)
                VALUES (:name, :price, :stock, :category_id)
            ");
            $stmt->execute([
                'name'        => $name,
                'price'       => $price,
                'stock'       => $stock,
                'category_id' => $categoryId,
            ]);
            return (int)$this->pdo->lastInsertId();
        } catch (PDOException $e) {
            error_log("ProductRepository::create hiba: " . $e->getMessage());
            return null;
        }
    }

    /** Egy termék az azonosítója alapján, vagy null, ha nincs ilyen. */
    public function findById(int $id): ?array
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $result = $stmt->fetch();
            return $result ?: null;
        } catch (PDOException $e) {
            error_log("ProductRepository::findById hiba: " . $e->getMessage());
            return null;
        }
    }

    /** Az összes termék név szerinti sorrendben. */
    public function findAll(): array
    {
        try {
            return $this->pdo->query("SELECT * FROM products ORDER BY name ASC")->fetchAll();
        } catch (PDOException $e) {
            error_log("ProductRepository::findAll hiba: " . $e->getMessage());
            return [];
        }
    }

    /** Egy termék módosítása. Igaz, ha legalább egy sor megváltozott. */
    public function update(int $id, string $name, float $price, int $stock): bool
    {
        try {
            $stmt = $this->pdo->prepare("
                UPDATE products
                SET name = :name, price = :price, stock = :stock
                WHERE id = :id
            ");
            $stmt->execute([
                'name'  => $name,
                'price' => $price,
                'stock' => $stock,
                'id'    => $id,
            ]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("ProductRepository::update hiba: " . $e->getMessage());
            return false;
        }
    }

    /** Egy termék törlése. Hamis, ha nincs ilyen, vagy rendelési tétel hivatkozik rá. */
    public function delete(int $id): bool
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM products WHERE id = :id");
            $stmt->execute(['id' => $id]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            // pl. SQLSTATE 23000: rendelési tétel hivatkozik a termékre
            error_log("ProductRepository::delete hiba: " . $e->getMessage());
            return false;
        }
    }
}

<?php

class ProductRepository
{
    public function __construct(
        private PDO $pdo
    ) {}

    public function create(string $name, float $price, int $stock, ?int $categoryId): int
    {
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
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function findAll(): array
    {
        return $this->pdo->query("SELECT * FROM products ORDER BY name ASC")->fetchAll();
    }

    public function update(int $id, string $name, float $price, int $stock): bool
    {
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
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount() > 0;
    }
}

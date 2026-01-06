<?php
class Product {
  private string $id;
  private string $name;
  private float $price;
  private int $qty;

  public function __construct(string $id, string $name, float $price, int $qty) {
    $this->id = $id;
    $this->name = $name;
    $this->price = $price;
    $this->qty = $qty;
  }

  public function getId(): string { return $this->id; }
  public function getName(): string { return $this->name; }
  public function getPrice(): float { return $this->price; }
  public function getQty(): int { return $this->qty; }

  public function amount(): float {
    return $this->price * $this->qty;
  }

  public function qtyStatus(): string {
    return ($this->qty <= 0) ? "Invalid qty" : "OK";
  }
}
?>

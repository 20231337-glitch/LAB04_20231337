<?php
function h($s){ return htmlspecialchars((string)$s, ENT_QUOTES, "UTF-8"); }
function money($x){ return number_format((float)$x, 0, ",", "."); }

$cart = [
  ["name"=>"Áo sơ mi", "price"=>220000, "qty"=>2],
  ["name"=>"Quần jean", "price"=>350000, "qty"=>1],
  ["name"=>"Váy", "price"=>420000, "qty"=>1],
  ["name"=>"Áo khoác", "price"=>520000, "qty"=>1],
];

$total = 0;
$maxItem = null;

foreach ($cart as &$item) {
  $item["amount"] = $item["price"] * $item["qty"];
  $total += $item["amount"];
  if ($maxItem === null || $item["amount"] > $maxItem["amount"]) $maxItem = $item;
}
unset($item);

$sorted = $cart;
usort($sorted, function($a, $b){
  return $b["price"] <=> $a["price"]; // price giảm dần
});
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>LAB04 - Bài 3</title>
  <style>
    body{font-family:Arial; padding:18px;}
    table{border-collapse:collapse; width:720px; max-width:100%;}
    th,td{border:1px solid #999; padding:8px;}
    th{background:#f3f3f3;}
  </style>
</head>
<body>
  <h2>Bài 3 – Giỏ hàng (mảng nhiều chiều)</h2>

  <h3>Danh sách</h3>
  <table>
    <tr>
      <th>STT</th><th>Name</th><th>Price</th><th>Qty</th><th>Amount</th>
    </tr>
    <?php foreach ($cart as $i => $it): ?>
      <tr>
        <td><?= $i+1 ?></td>
        <td><?= h($it["name"]) ?></td>
        <td><?= h(money($it["price"])) ?></td>
        <td><?= h($it["qty"]) ?></td>
        <td><?= h(money($it["amount"])) ?></td>
      </tr>
    <?php endforeach; ?>
    <tr>
      <th colspan="4" style="text-align:right">Tổng tiền</th>
      <th><?= h(money($total)) ?></th>
    </tr>
  </table>

  <p><b>Sản phẩm có Amount lớn nhất:</b>
    <?= h($maxItem["name"]) ?> (<?= h(money($maxItem["amount"])) ?>)
  </p>

  <h3>Sau khi sort theo price giảm dần</h3>
  <table>
    <tr>
      <th>STT</th><th>Name</th><th>Price</th><th>Qty</th><th>Amount</th>
    </tr>
    <?php foreach ($sorted as $i => $it): ?>
      <tr>
        <td><?= $i+1 ?></td>
        <td><?= h($it["name"]) ?></td>
        <td><?= h(money($it["price"])) ?></td>
        <td><?= h($it["qty"]) ?></td>
        <td><?= h(money($it["amount"])) ?></td>
      </tr>
    <?php endforeach; ?>
  </table>

  <p><a href="index.php">← Về index</a></p>
</body>
</html>

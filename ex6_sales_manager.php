<?php
require_once "Product.php";

function h($s){ return htmlspecialchars((string)$s, ENT_QUOTES, "UTF-8"); }
function money($x){ return number_format((float)$x, 0, ",", "."); }

$defaultData = "P001-Ao so mi-220000-2;P002-Quan jean-350000-1;P003-Vay-420000-0;P004-Ao khoac-520000-1;BAD;P005-Mu-abc-2";
$data = $_POST["data"] ?? $defaultData;

$minPriceRaw = $_POST["minPrice"] ?? "0";
$minPrice = is_numeric($minPriceRaw) ? (float)$minPriceRaw : 0.0;

$sortAmountDesc = isset($_POST["sortAmountDesc"]);
$submitted = ($_SERVER["REQUEST_METHOD"] === "POST");

$products = [];
$ignored = 0;

if ($submitted) {
  $records = array_filter(array_map("trim", explode(";", $data)), fn($x)=>$x!=="");

  foreach ($records as $rec) {
    $parts = array_map("trim", explode("-", $rec));
    if (count($parts) !== 4) { $ignored++; continue; }

    [$id, $name, $priceRaw, $qtyRaw] = $parts;
    if ($id==="" || $name==="") { $ignored++; continue; }
    if (!is_numeric($priceRaw) || !is_numeric($qtyRaw)) { $ignored++; continue; }

    $price = (float)$priceRaw;
    $qty = (int)$qtyRaw;
    $products[] = new Product($id, $name, $price, $qty);
  }

  // Filter by minPrice (Price >= minPrice)
  $products = array_values(array_filter($products, fn($p)=>$p->getPrice() >= $minPrice));

  // Sort by amount desc
  if ($sortAmountDesc) {
    usort($products, fn($a,$b)=> $b->amount() <=> $a->amount());
  }
}

$stats = null;
if ($submitted && count($products) > 0) {
  $totalAmount = 0.0;
  $maxAmount = null;
  $sumPrice = 0.0;
  $invalidQtyCount = 0;

  foreach ($products as $p) {
    $totalAmount += $p->amount();
    $sumPrice += $p->getPrice();
    if ($maxAmount === null || $p->amount() > $maxAmount->amount()) $maxAmount = $p;
    if ($p->getQty() <= 0) $invalidQtyCount++;
  }

  $avgPrice = round($sumPrice / count($products), 2);

  $stats = [
    "totalAmount" => $totalAmount,
    "maxProduct" => $maxAmount,
    "avgPrice" => $avgPrice,
    "invalidQtyCount" => $invalidQtyCount
  ];
}
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>LAB04 - Bài 6B</title>
  <style>
    body{font-family:Arial; padding:18px;}
    textarea{width:820px; max-width:100%; height:120px;}
    table{border-collapse:collapse; width:820px; max-width:100%; margin-top:10px;}
    th,td{border:1px solid #999; padding:8px;}
    th{background:#f3f3f3;}
    .bad{color:#b00; font-weight:700;}
    code{background:#f3f3f3; padding:2px 6px; border-radius:4px;}
  </style>
</head>
<body>
  <h2>Bài 6B – Sales Manager (POST parse + filter + sort + thống kê)</h2>

  <form method="post">
    <p><b>Định dạng:</b> <code>ProductID-Name-Price-Qty;ProductID-Name-Price-Qty;...</code></p>
    <textarea name="data"><?= h($data) ?></textarea>

    <p>
      Lọc Price >=
      <input type="text" name="minPrice" value="<?= h($minPriceRaw) ?>" style="width:110px">
      <label style="margin-left:14px">
        <input type="checkbox" name="sortAmountDesc" <?= $sortAmountDesc ? "checked" : "" ?>>
        Sort Amount giảm dần
      </label>
      <button type="submit" style="margin-left:10px">Parse & Show</button>
    </p>
  </form>

  <?php if ($submitted): ?>
    <hr>
    <p><b>Số dòng bỏ qua (sai định dạng):</b> <?= h($ignored) ?></p>

    <?php if (count($products) === 0): ?>
      <p class="bad">Không có sản phẩm hợp lệ sau khi parse/lọc.</p>
    <?php else: ?>
      <table>
        <tr>
          <th>STT</th><th>ID</th><th>Name</th><th>Price</th><th>Qty</th><th>Amount</th><th>Status</th>
        </tr>
        <?php foreach ($products as $i => $p): ?>
          <?php $isBad = ($p->getQty() <= 0); ?>
          <tr>
            <td><?= $i+1 ?></td>
            <td><?= h($p->getId()) ?></td>
            <td><?= h($p->getName()) ?></td>
            <td><?= h(money($p->getPrice())) ?></td>
            <td class="<?= $isBad ? "bad" : "" ?>"><?= h($p->getQty()) ?></td>
            <td><?= h(money($p->amount())) ?></td>
            <td class="<?= $isBad ? "bad" : "" ?>"><?= h($p->qtyStatus()) ?></td>
          </tr>
        <?php endforeach; ?>
      </table>

      <h3>Thống kê</h3>
      <ul>
        <li><b>Tổng tiền (Total Amount):</b> <?= h(money($stats["totalAmount"])) ?></li>
        <li><b>Avg Price:</b> <?= h($stats["avgPrice"]) ?></li>
        <li><b>Số sản phẩm Qty &lt;= 0:</b> <?= h($stats["invalidQtyCount"]) ?></li>
        <li><b>Amount lớn nhất:</b>
          <?= h($stats["maxProduct"]->getName()) ?> (<?= h(money($stats["maxProduct"]->amount())) ?>)
        </li>
      </ul>
    <?php endif; ?>
  <?php endif; ?>

  <p><a href="index.php">← Về index</a></p>
</body>
</html>

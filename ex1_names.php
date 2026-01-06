<?php
function h($s){ return htmlspecialchars((string)$s, ENT_QUOTES, "UTF-8"); }

$raw = $_GET["names"] ?? "";
$names = [];

if (trim($raw) !== "") {
  $parts = explode(",", $raw);
  foreach ($parts as $p) {
    $t = trim($p);
    if ($t !== "") $names[] = $t;
  }
}
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>LAB04 - Bài 1</title>
  <style>body{font-family:Arial; padding:18px;}</style>
</head>
<body>
  <h2>Bài 1 – Chuỗi: tách danh sách tên</h2>
  <p><b>Input (GET):</b> <code>?names=An, Binh, Chi, ,Dung</code></p>

  <form method="get">
    <label>names:</label>
    <input type="text" name="names" style="width:420px" value="<?= h($raw) ?>">
    <button type="submit">Xử lý</button>
  </form>

  <hr>
  <p><b>Chuỗi gốc:</b> <?= h($raw) ?></p>

  <?php if (count($names) === 0): ?>
    <p style="color:#b00"><b>Chưa có dữ liệu hợp lệ.</b></p>
  <?php else: ?>
    <p><b>Số lượng tên hợp lệ:</b> <?= count($names) ?></p>
    <ol>
      <?php foreach ($names as $n): ?>
        <li><?= h($n) ?></li>
      <?php endforeach; ?>
    </ol>
  <?php endif; ?>

  <p><a href="index.php">← Về index</a></p>
</body>
</html>

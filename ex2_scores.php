<?php
function h($s){ return htmlspecialchars((string)$s, ENT_QUOTES, "UTF-8"); }

// Mảng điểm mẫu (có thể đổi theo đề nếu cần)
$scores = [8.5, 7.2, 9.0, 6.8, 8.0, 5.4, 9.5, 7.9, 4.2, 8.1];

$avg = array_sum($scores) / max(count($scores), 1);
$avg2 = round($avg, 2);

$max = max($scores);
$min = min($scores);

$good = array_values(array_filter($scores, fn($x) => $x >= 8.0));

$asc = $scores; sort($asc);
$desc = $scores; rsort($desc);
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>LAB04 - Bài 2</title>
  <style>
    body{font-family:Arial; padding:18px;}
    code{background:#f3f3f3; padding:2px 6px; border-radius:4px;}
  </style>
</head>
<body>
  <h2>Bài 2 – Mảng điểm: thống kê & sắp xếp</h2>

  <p><b>Mảng gốc:</b> <code><?= h(implode(", ", $scores)) ?></code></p>
  <ul>
    <li><b>Điểm trung bình:</b> <?= h($avg2) ?></li>
    <li><b>Max:</b> <?= h($max) ?> | <b>Min:</b> <?= h($min) ?></li>
    <li><b>Số điểm >= 8.0:</b> <?= count($good) ?> (<?= h(implode(", ", $good)) ?>)</li>
  </ul>

  <h3>Sắp xếp (không làm mất mảng gốc)</h3>
  <p><b>Tăng dần:</b> <code><?= h(implode(", ", $asc)) ?></code></p>
  <p><b>Giảm dần:</b> <code><?= h(implode(", ", $desc)) ?></code></p>

  <p><a href="index.php">← Về index</a></p>
</body>
</html>

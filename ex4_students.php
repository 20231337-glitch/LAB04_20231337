<?php
require_once "Student.php";
function h($s){ return htmlspecialchars((string)$s, ENT_QUOTES, "UTF-8"); }

$students = [
  new Student("SV001", "An", 3.6),
  new Student("SV002", "Bình", 2.8),
  new Student("SV003", "Chi", 3.1),
  new Student("SV004", "Dũng", 2.2),
  new Student("SV005", "Hà", 3.4),
];

$total = 0.0;
$countRank = ["Giỏi"=>0, "Khá"=>0, "Trung bình"=>0];

foreach ($students as $st) {
  $total += $st->getGpa();
  $countRank[$st->rank()]++;
}
$avg = round($total / max(count($students), 1), 2);
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>LAB04 - Bài 4</title>
  <style>
    body{font-family:Arial; padding:18px;}
    table{border-collapse:collapse; width:720px; max-width:100%;}
    th,td{border:1px solid #999; padding:8px;}
    th{background:#f3f3f3;}
  </style>
</head>
<body>
  <h2>Bài 4 – OOP Student</h2>

  <table>
    <tr>
      <th>STT</th><th>ID</th><th>Name</th><th>GPA</th><th>Rank</th>
    </tr>
    <?php foreach ($students as $i => $st): ?>
      <tr>
        <td><?= $i+1 ?></td>
        <td><?= h($st->getId()) ?></td>
        <td><?= h($st->getName()) ?></td>
        <td><?= h($st->getGpa()) ?></td>
        <td><?= h($st->rank()) ?></td>
      </tr>
    <?php endforeach; ?>
  </table>

  <p><b>GPA trung bình:</b> <?= h($avg) ?></p>
  <ul>
    <li>Giỏi: <?= h($countRank["Giỏi"]) ?></li>
    <li>Khá: <?= h($countRank["Khá"]) ?></li>
    <li>Trung bình: <?= h($countRank["Trung bình"]) ?></li>
  </ul>

  <p><a href="index.php">← Về index</a></p>
</body>
</html>

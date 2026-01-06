<?php
require_once "Student.php";

function h($s){ return htmlspecialchars((string)$s, ENT_QUOTES, "UTF-8"); }

$defaultData = "SV001-An-3.4;SV002-Binh-2.6;SV003-Chi-3.1;SV004-Dung-2.2;SV005-Ha-3.8;BAD-ROW;SV006-Lan-x";
$data = $_POST["data"] ?? $defaultData;
$thresholdRaw = $_POST["threshold"] ?? "0";
$threshold = is_numeric($thresholdRaw) ? (float)$thresholdRaw : 0.0;
$sortDesc = isset($_POST["sortDesc"]);

$students = [];
$ignored = 0;
$submitted = ($_SERVER["REQUEST_METHOD"] === "POST");

if ($submitted) {
  $records = array_filter(array_map("trim", explode(";", $data)), fn($x)=>$x!=="");

  foreach ($records as $rec) {
    $parts = array_map("trim", explode("-", $rec));
    if (count($parts) !== 3) { $ignored++; continue; }

    [$id, $name, $gpaRaw] = $parts;
    if ($id==="" || $name==="" || !is_numeric($gpaRaw)) { $ignored++; continue; }

    $gpa = (float)$gpaRaw;
    $students[] = new Student($id, $name, $gpa);
  }

  // Filter by threshold
  $students = array_values(array_filter($students, fn($st)=>$st->getGpa() >= $threshold));

  // Sort
  if ($sortDesc) {
    usort($students, fn($a,$b)=> $b->getGpa() <=> $a->getGpa());
  }
}

// Stats
$stats = null;
if ($submitted && count($students) > 0) {
  $gpas = array_map(fn($st)=>$st->getGpa(), $students);
  $avg = round(array_sum($gpas)/count($gpas), 2);
  $max = max($gpas);
  $min = min($gpas);

  $cnt = ["Giỏi"=>0,"Khá"=>0,"Trung bình"=>0];
  foreach ($students as $st) $cnt[$st->rank()]++;

  $stats = ["avg"=>$avg,"max"=>$max,"min"=>$min,"cnt"=>$cnt];
}
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>LAB04 - Bài 5</title>
  <style>
    body{font-family:Arial; padding:18px;}
    textarea{width:720px; max-width:100%; height:110px;}
    table{border-collapse:collapse; width:720px; max-width:100%; margin-top:10px;}
    th,td{border:1px solid #999; padding:8px;}
    th{background:#f3f3f3;}
    .err{color:#b00;}
  </style>
</head>
<body>
  <h2>Bài 5 – Student Manager (POST parse + filter + sort)</h2>

  <form method="post">
    <p><b>Định dạng:</b> <code>SV001-An-3.2;SV002-Binh-2.6;...</code></p>
    <textarea name="data"><?= h($data) ?></textarea>
    <p>
      Lọc GPA >=
      <input type="text" name="threshold" value="<?= h($thresholdRaw) ?>" style="width:80px">
      <label style="margin-left:14px">
        <input type="checkbox" name="sortDesc" <?= $sortDesc ? "checked" : "" ?>>
        Sort GPA giảm dần
      </label>
      <button type="submit" style="margin-left:10px">Parse & Show</button>
    </p>
  </form>

  <?php if ($submitted): ?>
    <hr>
    <p><b>Số dòng bỏ qua (sai định dạng):</b> <?= h($ignored) ?></p>

    <?php if (count($students) === 0): ?>
      <p class="err"><b>Không có sinh viên hợp lệ sau khi parse/lọc.</b></p>
    <?php else: ?>
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

      <h3>Thống kê</h3>
      <ul>
        <li><b>Avg GPA:</b> <?= h($stats["avg"]) ?></li>
        <li><b>Max GPA:</b> <?= h($stats["max"]) ?> | <b>Min GPA:</b> <?= h($stats["min"]) ?></li>
        <li>Giỏi: <?= h($stats["cnt"]["Giỏi"]) ?> | Khá: <?= h($stats["cnt"]["Khá"]) ?> | Trung bình: <?= h($stats["cnt"]["Trung bình"]) ?></li>
      </ul>
    <?php endif; ?>
  <?php endif; ?>

  <p><a href="index.php">← Về index</a></p>
</body>
</html>

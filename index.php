<?php
function h($s){ return htmlspecialchars((string)$s, ENT_QUOTES, "UTF-8"); }
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>LAB04 - IT3220</title>
  <style>
    body{font-family: Arial, sans-serif; line-height:1.5; padding:18px;}
    a{display:inline-block; margin:6px 0;}
    code{background:#f3f3f3; padding:2px 6px; border-radius:4px;}
  </style>
</head>
<body>
  <h2>LAB04 – Chuỗi, Mảng, OOP, Parse dữ liệu</h2>
  <h3>Menu bài</h3>
  <div>
    <a href="ex1_names.php?names=An,%20Binh,%20Chi,%20,%20Dung">Bài 1 – Chuỗi (names GET)</a><br>
    <a href="ex2_scores.php">Bài 2 – Mảng điểm (thống kê + sort)</a><br>
    <a href="ex3_cart.php">Bài 3 – Giỏ hàng (mảng nhiều chiều + sort)</a><br>
    <a href="ex4_students.php">Bài 4 – OOP Student (bảng + thống kê)</a><br>
    <a href="ex5_student_manager.php">Bài 5 – Student Manager (POST parse + filter + sort)</a><br>
    <a href="ex6_sales_manager.php">Bài 6B – Sales Manager (POST parse + filter + sort + stats)</a><br>
  </div>
  <hr>
</body>
</html>

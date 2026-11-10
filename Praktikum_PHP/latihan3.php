<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Praktikum PHP</title>
</head>
<body>
    <h1>Belajar PHP</h1>
    <h2>Latihan 3</h2>
 <?php
$mahasiswa = ["Alya", "Bima", "Citra", "Doni", "Eka", "Fajar", "Gita"];
echo "<h3>Daftar Mahasiswa</h3><ol>";
foreach ($mahasiswa as $nama) {
echo "<li>" . htmlspecialchars($nama) . "</li>";
}
echo "</ol>";
?>
</body>
</html>

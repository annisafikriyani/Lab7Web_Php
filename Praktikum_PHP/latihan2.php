<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Praktikum PHP</title>
</head>
<body>
    <h1>Belajar PHP</h1>
    <h2>Latihan 2</h2>
 <?php
$mahasiswa = [
    ["nama" => "Siti",    "tugas" => 85, "uts" => 78, "uas" => 90],
    ["nama" => "Bambang", "tugas" => 90, "uts" => 95, "uas" => 88],
    ["nama" => "Citra",   "tugas" => 70, "uts" => 75, "uas" => 60],
    ["nama" => "Doni",    "tugas" => 50, "uts" => 40, "uas" => 55],
];

foreach ($mahasiswa as $m) {
    $nilaiAkhir = ($m["tugas"] * 0.30) + ($m["uts"] * 0.30) + ($m["uas"] * 0.40);

    if ($nilaiAkhir >= 85) {
        $predikat = "A";
    } elseif ($nilaiAkhir >= 75) {
        $predikat = "B";
    } elseif ($nilaiAkhir >= 60) {
        $predikat = "C";
    } else {
        $predikat = "D";
    }

    echo "Nama: " . htmlspecialchars($m["nama"]) . "<br>";
    echo "Nilai akhir: " . number_format($nilaiAkhir, 2) . "<br>";
    echo "Predikat: " . $predikat . "<br><br>";
}
?>
</body>
</html>

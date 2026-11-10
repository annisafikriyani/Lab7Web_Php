<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Praktikum PHP</title>
</head>
<body>
    <h1>Belajar PHP</h1>
    <h2>Latihan 4</h2>
 <?php
function hitungDiskon($harga, $persen) {
    $potongan = $harga * ($persen / 100);
    return $harga - $potongan;
}

// Function tambahan 1: hitung luas persegi panjang
function hitungLuasPersegiPanjang($panjang, $lebar) {
    return $panjang * $lebar;
}

// Function tambahan 2: tentukan kelulusan berdasarkan nilai
function cekKelulusan($nilai) {
    if ($nilai >= 60) {
        return "Lulus";
    } else {
        return "Tidak Lulus";
    }
}

// Pemanggilan function
$hargaAkhir = hitungDiskon(150000, 10);
echo "Harga setelah diskon: Rp" . number_format($hargaAkhir, 0, ",", ".") . "<br>";

echo "Luas persegi panjang (8 x 4): " . hitungLuasPersegiPanjang(8, 4) . "<br>";

echo "Nilai 75: " . cekKelulusan(75) . "<br>";
echo "Nilai 45: " . cekKelulusan(45) . "<br>";
?>




</body>
</html>

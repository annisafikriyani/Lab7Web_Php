<?php

// ===================== PENGATURAN =====================
const PANJANG_NIM = 10;   // Eksperimen 4: NIM hanya angka, tepat 10 digit

// Eksperimen 2: array data sederhana untuk dicari
$daftarMahasiswa = ["Alya", "Bima", "Citra", "Doni", "Eka", "Fajar", "Gita", "Bambang", "Siti"];

// ===================== FUNCTION =====================
// Keamanan output
function e($teks) {
    return htmlspecialchars((string)$teks, ENT_QUOTES, "UTF-8");
}

// Eksperimen 3: ubah angka menjadi format Rupiah (150000 -> Rp150.000)
function formatRupiah($angka) {
    return "Rp" . number_format($angka, 0, ",", ".");
}

// Eksperimen 1: rata-rata dari tiga komponen nilai
function hitungRataRata($tugas, $uts, $uas) {
    return ($tugas + $uts + $uas) / 3;
}

// ===================== PEMROSESAN FORM POST (MINI PROJECT) =====================
$data = null;
$error = [];
$nama = $nim = $prodi = $email = $semesterInput = "";
$tugasInput = $utsInput = $uasInput = $biayaInput = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama = trim($_POST["nama"] ?? "");
    $nim = trim($_POST["nim"] ?? "");
    $prodi = trim($_POST["prodi"] ?? "");
    $semesterInput = trim($_POST["semester"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $tugasInput = trim($_POST["tugas"] ?? "");
    $utsInput = trim($_POST["uts"] ?? "");
    $uasInput = trim($_POST["uas"] ?? "");
    $biayaInput = trim($_POST["biaya"] ?? "");

    if ($nama === "") $error[] = "Nama wajib diisi.";

    // Eksperimen 4: validasi NIM
    if ($nim === "") {
        $error[] = "NIM wajib diisi.";
    } elseif (!ctype_digit($nim)) {
        $error[] = "NIM hanya boleh berisi angka.";
    } elseif (strlen($nim) !== PANJANG_NIM) {
        $error[] = "NIM harus tepat " . PANJANG_NIM . " digit (yang kamu isi: " . strlen($nim) . " digit).";
    }

    if ($prodi === "") $error[] = "Program studi wajib diisi.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error[] = "Format email tidak valid.";
    }
    if (!ctype_digit($semesterInput) ||
        (int)$semesterInput < 1 || (int)$semesterInput > 14) {
        $error[] = "Semester harus berupa angka 1-14.";
    }

    // Validasi nilai (0-100) untuk Eksperimen 1
    foreach (["Nilai tugas" => $tugasInput, "Nilai UTS" => $utsInput, "Nilai UAS" => $uasInput] as $label => $v) {
        if (!is_numeric($v) || (float)$v < 0 || (float)$v > 100) {
            $error[] = "$label harus berupa angka 0-100.";
        }
    }

    // Validasi biaya untuk Eksperimen 3
    if (!is_numeric($biayaInput) || (float)$biayaInput < 0) {
        $error[] = "Biaya semester harus berupa angka tidak negatif.";
    }

    if (!$error) {
        $data = compact("nama", "nim", "prodi", "email");
        $data["semester"] = (int)$semesterInput;
        $data["tugas"] = (float)$tugasInput;
        $data["uts"] = (float)$utsInput;
        $data["uas"] = (float)$uasInput;
        $data["rata"] = hitungRataRata($data["tugas"], $data["uts"], $data["uas"]);
        $data["biaya"] = (float)$biayaInput;
    }
}

// ===================== PEMROSESAN PENCARIAN GET (EKSPERIMEN 2) =====================
$sudahCari = isset($_GET["kata"]);
$kata = trim($_GET["kata"] ?? "");
$hasilCari = [];
if ($sudahCari && $kata !== "") {
    foreach ($daftarMahasiswa as $m) {
        if (stripos($m, $kata) !== false) {
            $hasilCari[] = $m;
        }
    }
}
?>
<!-- ===================== TAMPILAN HTML ===================== -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Mini Project - Formulir Data Mahasiswa</title>
</head>
<body>
    <h1>Formulir Data Mahasiswa</h1>
    <p>Waktu server saat halaman dibuat: <strong><?= date("H:i:s") ?></strong></p>

    <!-- ========== FORM INPUT DATA (POST) ========== -->
    <h2>Input Data</h2>

    <?php if ($error): ?>
        <div style="color:red">
            <p>Terdapat kesalahan:</p>
            <ul>
                <?php foreach ($error as $pesan): ?>
                    <li><?= e($pesan) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="mini_project.php">
        <p><label>Nama <input name="nama" value="<?= e($nama) ?>"></label></p>
        <p><label>NIM (angka, <?= PANJANG_NIM ?> digit) <input name="nim" value="<?= e($nim) ?>"></label></p>
        <p><label>Program Studi <input name="prodi" value="<?= e($prodi) ?>"></label></p>
        <p><label>Semester <input name="semester" value="<?= e($semesterInput) ?>"></label></p>
        <p><label>Email <input name="email" value="<?= e($email) ?>"></label></p>
        <p><label>Nilai Tugas <input name="tugas" value="<?= e($tugasInput) ?>"></label></p>
        <p><label>Nilai UTS <input name="uts" value="<?= e($utsInput) ?>"></label></p>
        <p><label>Nilai UAS <input name="uas" value="<?= e($uasInput) ?>"></label></p>
        <p><label>Biaya Semester (Rp) <input name="biaya" value="<?= e($biayaInput) ?>"></label></p>

        <!-- Kirim: data dikirim ke server, PHP memproses -->
        <button type="submit">Kirim</button>
        <!-- Reset: hanya di browser, tidak ada permintaan ke server (Eksperimen 5) -->
        <button type="reset">Reset</button>
    </form>

    <?php if ($data): ?>
        <h2>Data Diterima</h2>
        <table border="1" cellpadding="6" cellspacing="0">
            <tr><td>Nama</td><td><?= e($data["nama"]) ?></td></tr>
            <tr><td>NIM</td><td><?= e($data["nim"]) ?></td></tr>
            <tr><td>Program Studi</td><td><?= e($data["prodi"]) ?></td></tr>
            <tr><td>Semester</td><td><?= $data["semester"] ?></td></tr>
            <tr><td>Email</td><td><?= e($data["email"]) ?></td></tr>
            <tr><td>Nilai Tugas / UTS / UAS</td>
                <td><?= $data["tugas"] ?> / <?= $data["uts"] ?> / <?= $data["uas"] ?></td></tr>
            <tr><td>Nilai Rata-rata</td><td><?= number_format($data["rata"], 2) ?></td></tr>
            <tr><td>Biaya Semester</td><td><?= formatRupiah($data["biaya"]) ?></td></tr>
        </table>
    <?php endif; ?>

    <hr>

    <!-- ========== PENCARIAN NAMA (GET) - EKSPERIMEN 2 ========== -->
    <h2>Cari Nama Mahasiswa</h2>
    <form method="GET" action="mini_project.php">
        <label for="kata">Kata kunci:</label>
        <input id="kata" name="kata" type="text" value="<?= e($kata) ?>">
        <button type="submit">Cari</button>
    </form>

    <?php if ($sudahCari): ?>
        <?php if ($kata === ""): ?>
            <p>Kata kunci tidak boleh kosong.</p>
        <?php elseif (count($hasilCari) === 0): ?>
            <p>Tidak ada nama yang cocok dengan "<?= e($kata) ?>".</p>
        <?php else: ?>
            <p>Ditemukan <?= count($hasilCari) ?> nama:</p>
            <ol>
                <?php foreach ($hasilCari as $m): ?>
                    <li><?= e($m) ?></li>
                <?php endforeach; ?>
            </ol>
        <?php endif; ?>
    <?php endif; ?>
    <p>Data yang tersedia: <?= e(implode(", ", $daftarMahasiswa)) ?></p>

    <hr>

    
</body>
</html>
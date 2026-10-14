<?php
require 'koneksi.php';

$kode = $nama = $brand = $kategori = $jenis = $harga = $stok = $deskripsi = '';
$pesan = '';

function h($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

if (isset($_POST['simpan'])) {
    $kode = trim($_POST['kode_scooter'] ?? '');
    $nama = trim($_POST['nama_scooter'] ?? '');
    $brand = trim($_POST['merek_scooter'] ?? '');
    $kategori = trim($_POST['tipe_scooter'] ?? '');
    $jenis = trim($_POST['jenis_mesin'] ?? '');
    $harga = trim($_POST['harga_scooter'] ?? '');
    $stok = trim($_POST['stok_scooter'] ?? '');
    $deskripsi = trim($_POST['deskripsi_scooter'] ?? '');

    if (
        $kode === '' ||
        $nama === '' ||
        $brand === '' ||
        $kategori === '' ||
        $jenis === '' ||
        $deskripsi === ''
    ) {
        $pesan = 'Semua kolom wajib diisi.';
    } elseif (
        !is_numeric($harga) ||
        $harga <= 0 ||
        $harga > 9999999999
    ) {
        $pesan = 'Harga harus berupa angka positif tanpa Rp atau titik.';
    } elseif (
        filter_var($stok, FILTER_VALIDATE_INT) === false ||
        $stok < 0
    ) {
        $pesan = 'Stok harus berupa bilangan bulat nol atau lebih.';
    } else {
        $stmt = mysqli_prepare(
            $conn,
            'SELECT id FROM scooter WHERE kode_scooter = ?'
        );

        mysqli_stmt_bind_param($stmt, 's', $kode);
        mysqli_stmt_execute($stmt);

        $cek = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($cek) > 0) {
            $pesan = 'Kode scooter sudah digunakan.';
        } else {
            $stmt = mysqli_prepare(
                $conn,
                'INSERT INTO scooter (
                    kode_scooter,
                    nama_scooter,
                    merek_scooter,
                    tipe_scooter,
                    jenis_mesin,
                    harga_scooter,
                    stok_scooter,
                    deskripsi_scooter
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
            );

            mysqli_stmt_bind_param(
                $stmt,
                'sssssdis',
                $kode,
                $nama,
                $brand,
                $kategori,
                $jenis,
                $harga,
                $stok,
                $deskripsi
            );

            if (mysqli_stmt_execute($stmt)) {
                header('Location: index.php?pesan=1');
                exit;
            }

            $pesan = 'Scooter gagal disimpan. Periksa kembali data.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Scooter — ScootHub</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header class="topbar">
        <a class="brandmark" href="index.php">
            scoot<span>hub.</span>
        </a>

        <nav class="navlinks">
            <a href="index.php">Katalog</a>
            <a href="tambah.php">Tambah Scooter</a>
        </nav>
    </header>

    <main class="wrap">
        <p class="eyebrow">Scooter management</p>
        <h1 class="page-title">Tambah scooter</h1>
        <p class="meta">
            Isi detail scooter yang ingin dimasukkan ke katalog.
        </p>

        <section class="panel">
            <?php if ($pesan !== ''): ?>
                <div class="error">
                    <?= h($pesan) ?>
                </div>
            <?php endif; ?>

            <form method="post">
                <div class="form-grid">
                    <div>
                        <label for="kode">Kode scooter</label>
                        <input
                            id="kode"
                            name="kode_scooter"
                            maxlength="20"
                            required
                            value="<?= h($kode) ?>"
                            placeholder="SCT-004"
                        >
                    </div>

                    <div>
                        <label for="nama">Nama scooter</label>
                        <input
                            id="nama"
                            name="nama_scooter"
                            maxlength="100"
                            required
                            value="<?= h($nama) ?>"
                        >
                    </div>

                    <div>
                        <label for="brand">Merek</label>
                        <input
                            id="brand"
                            name="merek_scooter"
                            maxlength="50"
                            required
                            value="<?= h($brand) ?>"
                        >
                    </div>

                    <div>
                        <label for="kategori">Tipe scooter</label>
                        <select
                            id="kategori"
                            name="tipe_scooter"
                            required
                        >
                            <option value="">Pilih tipe scooter</option>

                            <?php foreach (['Matic', 'Retro', 'Modern', 'Premium', 'Sporty', 'Lainnya'] as $opt): ?>
                                <option
                                    value="<?= h($opt) ?>"
                                    <?= $kategori === $opt ? 'selected' : '' ?>
                                >
                                    <?= h($opt) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label for="jenis">Jenis mesin</label>
                        <select
                            id="jenis"
                            name="jenis_mesin"
                            required
                        >
                            <option value="">Pilih jenis mesin</option>

                            <?php foreach (['110 cc', '125 cc', '125 cc Hybrid', '150 cc', '160 cc', 'Listrik'] as $opt): ?>
                                <option
                                    value="<?= h($opt) ?>"
                                    <?= $jenis === $opt ? 'selected' : '' ?>
                                >
                                    <?= h($opt) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label for="harga">Harga (angka saja)</label>
                        <input
                            id="harga"
                            name="harga_scooter"
                            type="number"
                            min="1"
                            step="1"
                            required
                            value="<?= h($harga) ?>"
                            placeholder="89000"
                        >
                    </div>

                    <div>
                        <label for="stok">Stok</label>
                        <input
                            id="stok"
                            name="stok_scooter"
                            type="number"
                            min="0"
                            step="1"
                            required
                            value="<?= h($stok) ?>"
                            placeholder="20"
                        >
                    </div>

                    <div class="full">
                        <label for="deskripsi">Deskripsi scooter</label>
                        <textarea
                            id="deskripsi"
                            name="deskripsi_scooter"
                            required
                        ><?= h($deskripsi) ?></textarea>
                    </div>
                </div>

                <div class="actions">
                    <button class="btn" name="simpan" type="submit">
                        Simpan scooter
                    </button>

                    <a class="btn secondary" href="index.php">
                        Batal
                    </a>
                </div>
            </form>
        </section>
    </main>

    <footer class="footer">
        ScootHub · Praktikum PAW Modul 2
    </footer>
</body>

</html>
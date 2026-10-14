<?php
require 'koneksi.php';

$cari = trim($_GET['cari'] ?? '');
$kata = mysqli_real_escape_string($conn, $cari);

$sql = "
    SELECT *
    FROM scooter
    WHERE nama_scooter LIKE '%$kata%'
        OR merek_scooter LIKE '%$kata%'
        OR tipe_scooter LIKE '%$kata%'
    ORDER BY id DESC
";

$hasil = mysqli_query($conn, $sql);

function h($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function rupiah($value)
{
    return 'Rp ' . number_format((float) $value, 0, ',', '.');
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ScootHub — Katalog Scooter</title>
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
        <section class="hero">
            <p class="eyebrow">Your ride, your style</p>

            <h1>
                Temukan scooter,<br>
                mulai berkendara.
            </h1>

            <p>
                Kelola katalog scooter dalam satu tempat.
                Cari kendaraan, cek stok, dan perbarui informasi
                scooter dengan mudah.
            </p>
        </section>

        <?php if (isset($_GET['pesan'])): ?>
            <div class="notice">
                Perubahan data scooter berhasil disimpan.
            </div>
        <?php endif; ?>

        <div class="toolbar">
            <div>
                <p class="eyebrow">Scooter collection</p>
                <h2>Katalog scooter</h2>
            </div>

            <form class="search" method="get">
                <input
                    type="search"
                    name="cari"
                    placeholder="Cari nama, merek, tipe..."
                    value="<?= h($cari) ?>"
                >

                <button class="btn" type="submit">
                    Cari
                </button>

                <?php if ($cari !== ''): ?>
                    <a class="btn secondary" href="index.php">
                        Reset
                    </a>
                <?php endif; ?>
            </form>
        </div>

        <p class="meta">
            Jumlah hasil: <?= mysqli_num_rows($hasil) ?> scooter
        </p>

        <?php if (mysqli_num_rows($hasil) === 0): ?>
            <div class="empty">
                <h3>Scooter belum ditemukan</h3>

                <p>
                    Coba kata kunci lain atau tambahkan scooter baru.
                </p>

                <a class="btn" href="tambah.php">
                    + Tambah Scooter
                </a>
            </div>
        <?php else: ?>
            <div class="cards">
                <?php while ($scooter = mysqli_fetch_assoc($hasil)): ?>
                    <article class="product-card">
                        <div class="product-art" aria-hidden="true">
                            
                        </div>

                        <span class="pill">
                            <?= h($scooter['tipe_scooter']) ?>
                        </span>

                        <h3>
                            <?= h($scooter['nama_scooter']) ?>
                        </h3>

                        <p class="meta">
                            <?= h($scooter['merek_scooter']) ?>
                            ·
                            <?= h($scooter['jenis_mesin']) ?>
                        </p>

                        <p class="price">
                            <?= rupiah($scooter['harga_scooter']) ?>
                        </p>

                        <p class="stock">
                            Stok tersedia:
                            <?= (int) $scooter['stok_scooter'] ?>
                        </p>

                        <div class="card-actions">
                            <a href="detail.php?id=<?= (int) $scooter['id'] ?>">
                                Lihat detail
                            </a>

                            <a href="edit.php?id=<?= (int) $scooter['id'] ?>">
                                Edit
                            </a>

                            <a href="hapus.php?id=<?= (int) $scooter['id'] ?>">
                                Hapus
                            </a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </main>

    <footer class="footer">
        ScootHub · Praktikum PAW Modul 2 · PHP & MySQL
    </footer>
</body>

</html>
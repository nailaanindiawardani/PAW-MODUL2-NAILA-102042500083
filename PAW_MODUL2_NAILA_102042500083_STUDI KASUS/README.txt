PROJECT PRAKTIKUM PAW MODUL 2 — TEMA SCOOTER
Nama aplikasi: ScootHub

FILE PROJECT
- database.sql : membuat database paw_modul2_scooter, tabel scooter, dan 3 data awal.
- koneksi.php  : koneksi PHP ke MySQL/MariaDB.
- style.css    : tampilan responsif bertema oranye, putih, dan abu-abu.
- index.php    : daftar scooter dan pencarian (READ).
- tambah.php   : form tambah scooter (CREATE) dengan validasi.
- detail.php   : informasi lengkap satu scooter.
- edit.php     : form ubah scooter (UPDATE) dengan validasi.
- hapus.php    : konfirmasi dan hapus scooter (DELETE).

CARA MENJALANKAN (LARAGON)
1. Ekstrak folder project ke C:\laragon\www\scooter_paw
2. Jalankan Start All di Laragon.
3. Buka http://localhost/phpmyadmin
4. Pilih tab Import dan import file database.sql.
5. Pastikan konfigurasi di koneksi.php cocok dengan MySQL lokal. Default: host 127.0.0.1, user root, password kosong.
6. Buka http://localhost/scooter_paw/index.php

CARA MENJALANKAN (XAMPP)
1. Ekstrak folder project ke htdocs/scooter_paw.
2. Jalankan Apache dan MySQL.
3. Import database.sql melalui phpMyAdmin.
4. Buka http://localhost/scooter_paw/index.php

CATATAN
- Data scooter awal merupakan data contoh untuk latihan. Harga adalah ilustrasi dan perlu diperbarui jika dipakai sebagai informasi jual-beli.
- Jika nama folder diubah, URL localhost juga perlu disesuaikan.

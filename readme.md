# Inventory Management System

UJK: Membangun Arsitektur Aplikasi, Database, dan Autentikasi.

## Identitas Mahasiswa
- **Nama:** Otto Santoso Putro
- **NIM:** 22010326
- **Prodi:** S1 Teknik Informatika
- **Semester:** 8
- **Tema Kasus:** Manajemen Inventaris Barang

---

##  Fitur Utama
1. **Autentikasi :**
   - Sistem Login menggunakan enkripsi password
   - Sistem Registrasi untuk pendaftaran akun baru.
2. **Manajemen Sesi :**
   - Proteksi halaman Dashboard; tidak dapat diakses tanpa login.
   - Fitur Logout untuk menghapus sesi pengguna.
3. **Fitur CRUD (Create, Read, Update, Delete):**
   - **Tampil Data:** Menampilkan inventaris.
   - **Tambah & Edit:** Menggunakan **Bootstrap Modals** untuk kinerja yang lebih cepat.
   - **Hapus:** Fitur hapus data dengan konfirmasi keamanan.

---

##  TechStack
- **Bahasa Pemrograman:** PHP Native
- **Database:** MySQL
- **UI Framework:** Bootstrap 5
- **Server:** Laragon

---

## Cara Instalasi & Penggunaan

1. **Clone Repository:**
   Letakkan folder project ini di direktori `C:\laragon\www\` atau `C:\xampp\htdocs\`.

2. **Import Database:**
   - Jalankan MySQL di Laragon/XAMPP.
   - Buka phpMyAdmin (`localhost/phpmyadmin`).
   - Buat database baru dengan nama `tugas_kuliah`.
   - Import file `inventory.sql` yang ada di project ini.

3. **Konfigurasi Koneksi:**
   Sesuaikan pengaturan database di file `config/koneksi.php` jika diperlukan (default: username `root` & password kosong).

4. **Menjalankan Aplikasi:**
   - Akses di browser: `http://localhost/CRUD` atau `http://CRUD.test`
   - Gunakan fitur **Daftar Sekarang** untuk membuat akun baru

---
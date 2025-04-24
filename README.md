# RESTful API - Tes Evaluasi Kemampuan Teknis PT Rimba Ananta Vikasa Indonesia

## Deskripsi Proyek
Proyek ini merupakan sebuah API berbasis **RESTful** yang menyediakan fitur **CRUD (Create, Read, Update, Delete)** untuk entitas **User**. API ini dibangun menggunakan **Laravel** sebagai framework PHP, dan mencakup berbagai fitur dasar untuk mengelola data pengguna, seperti membuat pengguna baru, memperbarui informasi pengguna, menghapus pengguna, serta mengambil data pengguna.

## Fitur Utama
- **Create (POST /api/users)**: Menambahkan pengguna baru ke dalam database.
- **Read (GET /api/users/{id})**: Mengambil data pengguna berdasarkan ID.
- **Update (PUT /api/users/{id})**: Memperbarui data pengguna berdasarkan ID.
- **Delete (DELETE /api/users/{id})**: Menghapus pengguna berdasarkan ID.
- **Validasi**: Validasi data pengguna menggunakan **Laravel Request** dan **FormRequest**.
- **Swagger Documentation**: Dokumentasi API menggunakan **Swagger** untuk memudahkan pemahaman endpoint yang tersedia.

## Teknologi yang Digunakan
- **Laravel**: Framework PHP untuk membangun backend API.
- **MySQL**: Database relasional yang digunakan untuk menyimpan data pengguna.
- **Swagger**: Untuk menyediakan dokumentasi interaktif API.
- **PHP**: Bahasa pemrograman yang digunakan untuk mengembangkan API.
- **Composer**: Manajer dependensi PHP.

## Instruksi Instalasi dan Cara Menjalankan Aplikasi Secara Lokal

### Persyaratan Sistem
Pastikan Anda memiliki perangkat lunak berikut di sistem Anda:
- **PHP** versi 8.0 atau lebih tinggi
- **Composer** untuk mengelola dependensi PHP
- **MySQL/MariaDB** untuk database
- **Laravel** sebagai framework backend

### Langkah-langkah Instalasi

1. **Clone repositori**
   Pertama, clone repositori ini ke mesin lokal Anda menggunakan perintah Git berikut:

   ```bash
   git clone https://github.com/username/repository.git
   cd repository

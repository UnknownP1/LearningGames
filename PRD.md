# Product Requirements Document (PRD)

## 1. Judul Proyek
LearningGames

## 2. Ringkasan Proyek
LearningGames adalah aplikasi web edukasi interaktif yang dirancang untuk membantu anak-anak belajar sambil bermain. Aplikasi ini menghadirkan pembelajaran dalam beberapa kategori utama, yaitu warna, hewan, bangunan, dan bentuk. Setiap kategori memiliki halaman pembelajaran dan halaman kuis untuk menguji pemahaman pengguna.

Tujuan utama dari proyek ini adalah membuat pengalaman belajar yang menyenangkan, visual, dan mudah diakses melalui browser. Dengan pendekatan yang ringan dan interaktif, pengguna dapat belajar melalui tampilan visual, tombol aksi, dan suara (text-to-speech) yang mendukung proses pemahaman.

## 3. Latar Belakang
Banyak media pembelajaran anak masih bersifat pasif dan kurang interaktif. Dengan perkembangan teknologi web, terdapat peluang untuk menciptakan produk edukasi yang lebih menarik, terutama untuk anak-anak usia sekolah dasar.

LearningGames mencoba menjawab kebutuhan tersebut dengan menghadirkan pembelajaran yang:
- mudah dipahami
- menarik secara visual
- interaktif dan game-like
- sesuai untuk penggunaan di perangkat browser
- dapat diakses secara cepat tanpa kompleksitas aplikasi native

## 4. Problem Statement
Anak-anak sering kesulitan untuk fokus saat belajar materi dasar seperti warna, bentuk, dan pengenalan objek umum. Materi yang disampaikan secara konvensional sering tidak memicu rasa ingin tahu dan keterlibatan aktif.

LearningGames bertujuan untuk mengubah pengalaman belajar menjadi sesuatu yang lebih menyenangkan, memanfaatkan elemen visual, suara, dan kuis singkat untuk memperkuat pemahaman.

## 5. Target Pengguna
### 5.1 Pengguna utama
- Anak-anak usia 5–12 tahun
- Siswa dasar yang sedang belajar konsep dasar

### 5.2 Pengguna pendukung
- Orang tua
- Guru
- Pengajar rumah belajar

## 6. Tujuan Produk
### Tujuan bisnis
- Menyediakan platform edukasi web yang ringan dan mudah diakses
- Meningkatkan minat belajar anak melalui pengalaman yang menyenangkan
- Menjadi basis produk edukasi yang dapat dikembangkan ke kategori lain

### Tujuan pengguna
- Belajar konsep dasar dengan cara yang lebih interaktif
- Memahami materi melalui visual dan suara
- Mengukur pemahaman melalui kuis singkat

## 7. Scope Produk
### Fitur inti
1. Halaman utama (home) yang berisi menu pembelajaran
2. Modul pembelajaran warna
3. Modul pembelajaran hewan
4. Modul pembelajaran bangunan
5. Modul pembelajaran bentuk
6. Kuis interaktif untuk setiap kategori
7. Skor hasil kuis
8. Fasilitas text-to-speech untuk membacakan nama objek/warna
9. Autentikasi pengguna dasar
10. Halaman profil dan dashboard pengguna

### Fitur non-inti
- Pengelolaan data pengguna tidak kompleks
- Tidak ada sistem admin untuk konten edukasi
- Tidak ada multiplayer atau leaderboard

## 8. User Journey
### 8.1 Alur belajar warna
1. Pengguna membuka halaman utama
2. Memilih kategori “Mengenal Warna”
3. Melihat daftar warna utama dengan tampilan visual
4. Mengklik warna tertentu untuk melihat informasi dan efek UI
5. Sistem membacakan nama warna via suara
6. Pengguna masuk ke halaman kuis warna
7. Menjawab pertanyaan pilihan ganda
8. Melihat skor akhir dan dapat mencoba ulang

### 8.2 Alur belajar modul lain
Proses serupa berlaku untuk kategori hewan, bangunan, dan bentuk. Setiap kategori memiliki konteks pembelajaran dan kuis masing-masing.

## 9. Functional Requirements
### 9.1 Halaman utama
- Menampilkan menu pembelajaran dalam bentuk kartu atau tombol
- Setiap kategori memiliki ikon dan deskripsi singkat
- Navigasi ke modul belajar masing-masing

### 9.2 Halaman pembelajaran
- Menampilkan daftar item edukasi per kategori
- Memberi tampilan yang jelas dan mudah dibaca
- Mampu menunjukkan visual yang sesuai dengan topik
- Menyediakan suara yang membacakan judul atau label item

### 9.3 Halaman kuis
- Menampilkan pertanyaan satu per satu
- Menyediakan opsi jawaban pilihan ganda
- Menentukan jawaban benar atau salah
- Menghitung skor total
- Menampilkan hasil akhir setelah semua soal selesai
- Memberi opsi ulang kuis

### 9.4 Autentikasi dan profil
- Pengguna bisa masuk ke aplikasi
- Halaman profil tersedia untuk update data pengguna
- Dashboard hanya dapat diakses oleh pengguna terautentikasi

## 10. Non-Functional Requirements
### 10.1 Kinerja
- Aplikasi harus cepat dimuat di browser
- Navigasi antar halaman harus responsif

### 10.2 UX/UI
- Tampilan harus berwarna cerah, ramah anak, dan mudah dibaca
- UI harus responsif di desktop maupun perangkat mobile

### 10.3 Aksesibilitas
- Mendukung penggunaan keyboard dan interaksi yang sederhana
- Menyediakan teks yang jelas serta elemen yang besar dan mudah diklik
- Menggunakan text-to-speech untuk memperkuat pemahaman

### 10.4 Keamanan
- Menggunakan sistem autentikasi bawaan Laravel
- Mengamankan route yang bersifat pengguna terautentikasi

## 11. Arsitektur Teknis
### Stack teknologi
- PHP 8.3
- Laravel 13
- Inertia.js
- Vue 3
- Tailwind CSS
- Vite

### Struktur aplikasi
- Backend berbasis Laravel untuk routing dan autentikasi
- Frontend berbasis Vue yang di-render melalui Inertia
- Data pembelajaran sebagian besar didefinisikan di sisi frontend sebagai array data statis
- CSS custom digunakan untuk memperkuat tampilan edukasi

### Route utama
- / : halaman utama
- /warna : pembelajaran warna
- /warna/quiz : kuis warna
- /hewan : pembelajaran hewan
- /hewan/quiz : kuis hewan
- /bangunan : pembelajaran bangunan
- /bangunan/quiz : kuis bangunan
- /bentuk : pembelajaran bentuk
- /bentuk/quiz : kuis bentuk
- /dashboard : dashboard pengguna
- /profile : profil pengguna

## 12. Data dan Model Domain
Saat ini aplikasi tidak memiliki model bisnis yang kompleks untuk topik edukasi. Data pembelajaran utama bersifat statis dan didefinisikan langsung dalam komponen frontend. Namun, sistem autentikasi Laravel tetap menyediakan user model dan database bawaan untuk kebutuhan login, register, dan profile.

## 13. KPI dan Keberhasilan
Keberhasilan produk dapat diukur dengan:
- jumlah modul yang dapat dipelajari pengguna
- tingkat interaksi pengguna pada setiap halaman belajar
- jumlah pengguna yang mengikuti kuis sampai selesai
- waktu rata-rata pengguna pada halaman edukasi
- tingkat repeat usage untuk materi yang sama

## 14. Risiko dan Kendala
- Fitur text-to-speech bergantung pada dukungan browser
- Konten saat ini masih terbatas pada kategori dasar
- Belum ada sistem leaderboard atau progres belajar yang terintegrasi
- Aplikasi belum memiliki admin panel untuk mengelola konten secara dinamis

## 15. Roadmap
### MVP (versi saat ini)
- halaman utama
- 4 kategori pembelajaran
- kuis interaktif
- suara pembacaan nama
- autentikasi dasar

### Versi berikutnya
- progres belajar per pengguna
- leaderboard dan pencapaian
- kategori baru (angka, alfabet, hewan liar, kendaraan, dll.)
- konten yang dapat dikelola oleh admin
- pengalaman belajar dengan animasi yang lebih kaya

## 16. Kesimpulan
LearningGames adalah produk edukasi web yang menggabungkan pembelajaran dasar dengan pengalaman bermain. Dengan pendekatan yang interaktif, visual, dan aksesibel, aplikasi ini siap menjadi platform belajar ringan yang dapat dikembangkan lebih lanjut menjadi solusi edukasi yang lebih lengkap.

## 17. Catatan Implementasi Saat Ini
Proyek ini sudah memiliki fondasi yang kuat sebagai aplikasi Laravel + Inertia + Vue, dengan struktur route yang jelas dan fokus pada edukasi interaktif. Aplikasi ini cocok untuk dikembangkan lebih lanjut sebagai portal pembelajaran untuk anak-anak dengan konten yang semakin kaya dan lebih personal.

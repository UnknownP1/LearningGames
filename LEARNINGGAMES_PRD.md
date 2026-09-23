# LearningGames: PRD dan Handoff Konteks untuk DeepSeek

> Dokumen ini dibuat pada 2026-09-23 berdasarkan isi repository yang sedang aktif. Dokumen ini adalah gabungan Product Requirements Document (PRD), technical brief, dan progress report. Gunakan fakta pada bagian "Status Saat Ini" sebagai sumber kebenaran sebelum mengusulkan perubahan.

## Cara Menggunakan Dokumen Ini

Salin seluruh dokumen ini ke DeepSeek Chat. Tambahkan pertanyaan atau tugas spesifik setelah bagian "Tugas untuk AI". Jangan mengirim file `.env`, credential, password, token, atau folder `vendor`, `node_modules`, dan `public/build` kecuali memang diperlukan untuk diagnosis tertentu.

## Instruksi untuk DeepSeek

Kamu bertindak sebagai senior product engineer yang membantu melanjutkan proyek LearningGames. Baca seluruh konteks ini sebelum menjawab.

Aturan kerja:

1. Bedakan fakta yang sudah ada dari rekomendasi baru. Jangan menganggap fitur sudah ada hanya karena tercantum sebagai target.
2. Pertahankan Laravel, Inertia.js, Vue 3, dan struktur folder yang sudah digunakan kecuali ada alasan teknis kuat.
3. Gunakan bahasa Indonesia untuk copy UI karena target pengguna adalah anak-anak Indonesia.
4. Untuk perubahan backend PHP, gunakan pola Laravel yang sudah ada dan tambahkan test yang relevan.
5. Untuk perubahan UI, periksa desktop dan mobile serta pertahankan aksesibilitas dasar: tombol keyboard-accessible, label, feedback yang jelas, dan ukuran interaksi yang sesuai anak.
6. Jangan menambahkan dependensi atau mengubah arsitektur tanpa menjelaskan alasan dan dampaknya.
7. Sebelum mengedit, jelaskan file yang akan disentuh dan hipotesis masalahnya. Setelah mengedit, jalankan validasi yang paling sempit dan laporkan hasilnya.
8. Jika ada informasi yang belum tersedia, tandai sebagai asumsi atau pertanyaan terbuka. Jangan mengarang data produk.

## 1. Ringkasan Produk

**Nama:** LearningGames

**Jenis produk:** Aplikasi web edukasi anak berbasis permainan.

**Bahasa utama:** Bahasa Indonesia.

**Tujuan:** Membantu anak mengenali warna, hewan, bangunan, dan bentuk melalui interaksi visual sederhana, suara Bahasa Indonesia, lalu kuis pilihan ganda.

**Pengguna utama:** Anak-anak usia dini atau usia sekolah awal.

**Pengguna pendukung yang tersirat:** Orang tua, guru, atau pendamping yang ingin melihat anak belajar dan berlatih.

**Nilai utama:** Belajar singkat, visual, menyenangkan, dan dapat langsung beralih dari materi ke kuis.

**Status produk:** Prototype/MVP frontend yang sudah memiliki alur belajar dan kuis lokal. Autentikasi Laravel tersedia sebagai scaffold, tetapi belum terhubung dengan progres belajar.

## 2. Sasaran Produk

### Sasaran saat ini

- Anak dapat memilih kategori pembelajaran dari halaman utama.
- Anak dapat memilih item pembelajaran dan melihat item aktif.
- Anak dapat mendengar nama item dalam Bahasa Indonesia melalui Web Speech API.
- Anak dapat mengulang atau menghentikan suara melalui tombol speaker.
- Anak dapat mengerjakan kuis lima soal dengan empat pilihan jawaban.
- Anak mendapat feedback benar/salah dan skor akhir maksimal 100.

### Sasaran pengembangan berikutnya

- Menyamakan jumlah materi dan cakupan soal dalam setiap kategori.
- Membuat hasil dan progres dapat disimpan untuk pengguna yang login.
- Mengubah dashboard dari scaffold menjadi ringkasan kemajuan belajar.
- Memperluas konten, aset, feedback, dan aksesibilitas tanpa membuat UI terlalu rumit.
- Menambahkan coverage test untuk perilaku kuis dan fitur progres.

## 3. Alur Pengguna Saat Ini

1. Pengguna membuka `/`.
2. Halaman Home menampilkan empat menu: Warna, Hewan, Bangunan, Bentuk.
3. Pengguna memilih satu kategori.
4. Halaman belajar menampilkan item default dan daftar kartu item.
5. Pengguna memilih kartu. Item aktif berubah, display dianimasikan, pesan singkat muncul, dan nama item dibacakan dalam Bahasa Indonesia.
6. Pengguna dapat menekan speaker untuk mengulang atau menghentikan suara.
7. Pengguna menekan tombol lanjut ke kuis.
8. Kuis menampilkan satu soal, empat opsi, nomor soal, dan feedback setelah pilihan dibuat.
9. Jawaban benar menambah 20 poin. Jawaban salah tidak menambah poin.
10. Setelah lima soal, pengguna melihat skor dari 100 dan jumlah jawaban benar.
11. Pengguna dapat kembali ke Home atau kembali ke halaman pembelajaran.

Autentikasi adalah alur terpisah: register, login, verifikasi email, reset password, profile, dan dashboard tersedia dari Laravel Breeze. Belum ada hubungan antara akun dan hasil belajar.

## 4. Fitur yang Sudah Ada

### Halaman Home

- Route: `GET /`
- Inertia page: `resources/js/Pages/Home.vue`
- Empat tombol kategori:
  - `Mengenal Warna` -> `/warna`
  - `Mengenal Hewan` -> `/hewan`
  - `Mengenal Bangunan` -> `/bangunan`
  - `Mengenal Bentuk` -> `/bentuk`
- Copy utama: `Belajar & Bermain` dan `Yuk belajar sambil bermain!`

### Pembelajaran warna

- Route: `/warna`
- Page: `resources/js/Pages/Learn.vue`
- Materi: Merah, Biru, Kuning, Hijau, Ungu, Pink.
- Setiap item memiliki nama dan nilai warna hex.
- Menggunakan `ColorCard.vue` dan `ColorDisplay.vue`.
- Menggunakan animasi Web Animations API dan text-to-speech `id-ID`.
- Kuis: `/warna/quiz`, page `Quiz.vue`.

### Pembelajaran hewan

- Route: `/hewan`
- Page: `resources/js/Pages/Animals.vue`
- Materi: Kucing, Anjing, Kelinci, Sapi, Ayam, Gajah.
- Item direpresentasikan dengan emoji.
- Menggunakan `AnimalCard.vue` dan `AnimalDisplay.vue`.
- Kuis: `/hewan/quiz`, page `AnimalQuiz.vue`.

### Pembelajaran bangunan

- Route: `/bangunan`
- Page: `resources/js/Pages/Building.vue`
- Materi: Rumah Sakit, Kantor Polisi, Kantor Pemadam Kebakaran, Sekolah, Perpustakaan, Bank.
- Sebagian item memakai emoji dan sebagian memakai gambar raster.
- Aset yang sudah ada: `public/images/PoliceStation.png`, `FireStation.png`, `Library.png`.
- Menggunakan `BuildingCard.vue` dan `BuildingDisplay.vue`.
- Kuis: `/bangunan/quiz`, page `BuildingQuiz.vue`.

### Pembelajaran bentuk

- Route: `/bentuk`
- Page: `resources/js/Pages/Shapes.vue`
- Materi: Lingkaran, Persegi, Segitiga, Persegi Panjang, Bintang, Hati.
- Item direpresentasikan dengan emoji.
- Menggunakan `ShapeDisplay.vue` dan import `ShapeCard.vue`.
- Kuis: `/bentuk/quiz`, page `ShapesQuiz.vue`.

### Mekanisme kuis

- Semua kuis berjalan sepenuhnya di browser.
- State menggunakan Vue `ref`.
- Semua kuis memiliki lima soal dan empat opsi per soal.
- Skor jawaban benar: 20 poin.
- Skor maksimum: 100.
- Feedback: benar atau belum tepat.
- Soal berpindah setelah pengguna memilih jawaban dan menekan tombol berikutnya.
- Hasil tidak disimpan ke database, session, localStorage, atau akun pengguna.

### Autentikasi dan profil

- Dibangun dengan Laravel Breeze dan Inertia Vue.
- Route auth berada di `routes/auth.php`.
- Controller auth berada di `app/Http/Controllers/Auth/`.
- Profile controller: `app/Http/Controllers/ProfileController.php`.
- Halaman auth berada di `resources/js/Pages/Auth/`.
- Halaman profile berada di `resources/js/Pages/Profile/`.
- `/dashboard` membutuhkan middleware `auth` dan `verified`.
- User model: `app/Models/User.php`.

## 5. Route yang Terdaftar

Route utama berada di `routes/web.php`:

| Method | URL | Inertia page / controller | Nama route | Akses |
|---|---|---|---|---|
| GET | `/` | `Home` | `home` | Publik |
| GET | `/warna` | `Learn` | `colors.learn` | Publik |
| GET | `/warna/quiz` | `Quiz` | `colors.quiz` | Publik |
| GET | `/hewan` | `Animals` | `animals.learn` | Publik |
| GET | `/hewan/quiz` | `AnimalQuiz` | `animals.quiz` | Publik |
| GET | `/bangunan` | `Building` | `building.learn` | Publik |
| GET | `/bangunan/quiz` | `BuildingQuiz` | `building.quiz` | Publik |
| GET | `/bentuk` | `Shapes` | `Shapes.learn` | Publik |
| GET | `/bentuk/quiz` | `ShapesQuiz` | `Shapes.quiz` | Publik |
| GET | `/dashboard` | `Dashboard` | `dashboard` | Auth + email verified |
| GET | `/profile` | `ProfileController@edit` | `profile.edit` | Auth |
| PATCH | `/profile` | `ProfileController@update` | `profile.update` | Auth |
| DELETE | `/profile` | `ProfileController@destroy` | `profile.destroy` | Auth |

Route auth tambahan didefinisikan di `routes/auth.php`: login, register, logout, forgot/reset password, password confirmation, password update, dan verifikasi email.

## 6. Struktur Teknis

### Stack

- PHP `^8.3`.
- Laravel `^13.17`.
- Inertia Laravel `^2.0`.
- Vue `^3.4.0`.
- `@inertiajs/vue3` `^2.0.0`.
- Vite `^8.0.0`.
- Tailwind CSS `^3.2.1` dan plugin forms.
- Laravel Breeze `^2.4` untuk auth.
- Laravel Sanctum `^4.0`.
- Ziggy `^2.0`.
- PHPUnit `^12.5.12`.
- Laravel Pint `^1.27`.
- Database lokal yang digunakan oleh `.env` adalah MySQL dengan database `learning_games`; `.env.example` memakai SQLite.

### Entry point dan bundling

- Entry JS: `resources/js/app.js`.
- Entry Vite: `resources/js/app.js` di `vite.config.js`.
- Root Blade: `resources/views/app.blade.php`.
- Page resolver Inertia memuat `resources/js/Pages/**/*.vue`.
- Ziggy didaftarkan di app Vue.

### Komponen

Komponen umum di `resources/js/Components/`: `ApplicationLogo`, `Checkbox`, `DangerButton`, `Dropdown`, `DropdownLink`, `InputError`, `InputLabel`, `Modal`, `NavLink`, `PrimaryButton`, `ResponsiveNavLink`, `SecondaryButton`, `TextInput`.

Komponen domain:

- `resources/js/Components/Animals/AnimalCard.vue`
- `resources/js/Components/Animals/AnimalDisplay.vue`
- `resources/js/Components/Buildings/BuildingCard.vue`
- `resources/js/Components/Buildings/BuildingDisplay.vue`
- `resources/js/Components/Colors/ColorCard.vue`
- `resources/js/Components/Colors/ColorDisplay.vue`
- `resources/js/Components/Shapes/Shapecard.vue`
- `resources/js/Components/Shapes/ShapeDisplay.vue`

Layout: `AuthenticatedLayout.vue` dan `GuestLayout.vue` di `resources/js/Layouts/`.

### CSS

`resources/css/app.css` mengimpor stylesheet untuk home, tiap halaman belajar, dan tiap tipe kuis. File domainnya adalah:

- `home.css`
- `color-learning.css`
- `animal-learning.css`
- `building-learning.css`
- `shape-learning.css`
- `quiz-color.css`
- `animal-quiz.css`
- `quiz-building.css`
- `quiz-shape.css`

Auth, dashboard, dan profile terutama menggunakan utility Tailwind.

### Database

Migrasi saat ini mencakup users, sessions, password reset tokens, cache, jobs, batches, dan failed jobs. Belum ada tabel untuk materi, soal, hasil kuis, progres, achievement, atau profil anak.

Seeder membuat user:

- Nama: `Test User`
- Email: `test@example.com`

Jangan menyalin password atau nilai secret dari `.env` ke chat.

## 7. Status Progres Terverifikasi

### Berhasil

- `php artisan migrate --seed` terakhir selesai dengan exit code 0.
- `npm install` terakhir selesai dengan exit code 0.
- `npm run build` pada 2026-09-23 berhasil.
- Vite mentransformasi 803 modules dan menghasilkan manifest/build assets.
- Commit terakhir: `8c57539 perubahan Quiz building Pt2`.

### Perubahan lokal

- `package-lock.json` sedang modified menurut `git status --short`.
- Perubahan lokal tersebut tidak boleh dihapus tanpa pemeriksaan lebih lanjut.

### Test

- `php artisan test --compact` menemukan 25 test.
- 2 test berhasil dan 23 test error.
- Error berasal dari `could not find driver` untuk koneksi SQLite in-memory pada environment PHP saat ini, bukan bukti langsung bahwa seluruh logika aplikasi gagal.
- Driver SQLite/PDO SQLite perlu tersedia atau konfigurasi test perlu diarahkan ke database test yang sesuai sebelum suite dapat menjadi sinyal valid.

### Perintah lokal

```powershell
composer install
npm install
php artisan migrate --seed
npm run build
php artisan serve
```

Untuk development frontend, jalankan `npm run dev` pada terminal terpisah. Jangan membagikan isi `.env`.

## 8. Gap dan Risiko yang Diketahui

Ini adalah masalah nyata yang sudah terlihat dari kode, bukan backlog yang sudah dikerjakan:

1. Setiap halaman belajar memiliki 6 item, tetapi setiap kuis hanya memiliki 5 soal.
   - Warna tidak menguji Pink.
   - Hewan tidak menguji Sapi.
   - Bangunan tidak menguji Bank.
   - Bentuk tidak menguji Persegi Panjang.
2. `Shapes.vue` mengimpor `ShapeCard.vue`, sedangkan file yang ada bernama `Shapecard.vue`. Ini berisiko pada filesystem case-sensitive walaupun dapat berjalan di Windows.
3. `resources/css/app.css` mengimpor `./quiz-color` tanpa suffix `.css`, tidak konsisten dengan import CSS lain.
4. `ShapesQuiz.vue` tidak menonaktifkan tombol jawaban setelah pilihan dibuat seperti kuis lain.
5. Beberapa file memiliki fungsi restart quiz, tetapi hasil akhir yang terlihat tidak menawarkan tombol restart.
6. Materi dan soal diduplikasi di banyak page Vue.
7. Hasil kuis dan progres tidak persisten.
8. Dashboard masih menampilkan pesan scaffold `You're logged in!`.
9. Gambar bangunan baru tersedia untuk Kantor Polisi, Kantor Pemadam Kebakaran, dan Perpustakaan; item lain memakai emoji fallback.
10. Penamaan route bentuk memakai `Shapes.learn` dan `Shapes.quiz`, berbeda gaya dengan route kategori lain yang lowercase.
11. `Welcome.vue` masih merupakan halaman default Laravel dan bukan halaman utama yang digunakan oleh `/`.

## 9. Backlog Prioritas yang Disarankan

### P0: Stabilitas dan konsistensi

- Perbaiki import `ShapeCard.vue` atau samakan nama file agar aman di Linux/CI.
- Perbaiki import `quiz-color.css`.
- Pastikan semua kuis mengunci pilihan setelah jawaban dipilih.
- Putuskan secara eksplisit apakah kuis harus 5 soal atau mencakup seluruh 6 materi; sesuaikan skor dan progress indicator.
- Tambahkan restart button pada hasil kuis bila memang menjadi bagian dari pengalaman yang diinginkan.
- Siapkan driver SQLite untuk test environment dan jalankan ulang suite.

### P1: Produk pembelajaran

- Pindahkan data kategori dan soal ke struktur data bersama agar tidak diduplikasi.
- Tambahkan audio fallback atau kontrol yang jelas jika browser tidak mendukung Speech Synthesis.
- Tambahkan gambar untuk seluruh bangunan atau tetapkan kebijakan visual yang konsisten.
- Tambahkan indikator kemajuan belajar yang mudah dipahami anak.
- Audit responsive layout, keyboard navigation, focus state, contrast, dan alt text.

### P2: Akun dan progres

- Rancang tabel `learning_categories`, `learning_items`, `quizzes`, `quiz_questions`, `quiz_attempts`, dan/atau model yang lebih sederhana sesuai kebutuhan.
- Simpan attempt: user, kategori, skor, jumlah benar, waktu mulai/selesai.
- Tampilkan ringkasan progres di dashboard.
- Pisahkan data anak dan akun pendamping jika diperlukan; jangan mengasumsikan model privasi sebelum ada keputusan produk.

### P3: Pengembangan konten

- Tambah kategori secara data-driven.
- Tambah tingkat kesulitan.
- Tambah variasi soal dan randomisasi yang tetap dapat diuji.
- Pertimbangkan badge atau reward hanya setelah kebutuhan inti progres stabil.

## 10. Acceptance Criteria MVP Saat Ini

- Home dapat dibuka dan menavigasi ke empat kategori.
- Setiap kategori memiliki halaman belajar dengan item yang dapat dipilih.
- Nama item ditampilkan dalam Bahasa Indonesia.
- Speaker mengucapkan nama item saat didukung browser dan tidak menyebabkan error saat API tidak tersedia.
- Setiap kuis menampilkan progress, empat opsi, feedback, dan hasil.
- Jawaban yang sudah dikirim tidak dapat diubah pada soal yang sama.
- Skor maksimum dan jumlah jawaban benar konsisten dengan jumlah soal.
- Build produksi berhasil.
- Test backend dapat berjalan tanpa error environment.
- Tidak ada credential atau secret yang masuk ke repository atau dokumen handoff.

## 11. Pertanyaan Produk yang Belum Diputuskan

- Target usia anak yang tepat berapa?
- Apakah anak menggunakan akun sendiri, atau orang tua/guru yang login?
- Apakah seluruh 6 item per kategori wajib muncul di kuis?
- Apakah konten harus dapat diubah tanpa deploy, sehingga perlu admin/CMS?
- Apakah skor hanya untuk satu sesi atau harus disimpan sebagai riwayat?
- Apakah aplikasi harus mendukung offline/PWA?
- Apakah emoji cukup untuk materi awal, atau semua item memerlukan ilustrasi/gambar asli?
- Apakah suara anak, pilihan bahasa, atau kontrol orang tua diperlukan?
- Apakah target deployment menggunakan MySQL seperti `.env` lokal atau SQLite/layanan lain?

## 12. Format Respons yang Diharapkan dari DeepSeek

Saat diberi tugas baru pada proyek ini, jawab dengan urutan:

1. Pemahaman masalah dan fakta kode yang relevan.
2. File atau modul yang akan diperiksa/diubah.
3. Rencana perubahan kecil yang dapat diuji.
4. Implementasi atau patch.
5. Perintah validasi dan hasilnya.
6. Risiko, asumsi, dan pekerjaan lanjutan yang benar-benar masih tersisa.

## 13. Tugas untuk AI

Tugas saya untukmu adalah:

`[TULIS TUGAS SPESIFIK DI SINI. Contoh: "Perbaiki semua gap P0, tambahkan test yang relevan, lalu laporkan file yang berubah dan hasil validasinya."]`

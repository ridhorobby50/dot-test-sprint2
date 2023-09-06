# Dot Test Sprint 2

Aplikasi ini adalah lanjutan Dot Test Sprint 1. (https://github.com/ridhorobby50/dot-test-sprint1)
Pastikan anda memiliki database yang ada dari Sprint 1
## Instalasi
- Copy isi dari .env.example dan buatlah file .env. Pastekan isi dari .env.example ke file .env yang baru dibuat
- Ubah Detail pada env dari DB_HOST sampai DB_PASSWORD sesuai dengan database yang digunakan di sprint 1
- Jalankan perintah php artisan jwt:secret untuk membuat jwt secret yang akan diletakkan di .env
- Jalankan perintah php artisan migrate untuk membuat table users
- Jalankan perintah php artisan db:seed untuk mengisi table users
- Jika sudah semua maka anda bisa menjalankan aplikasi dengan menjalankan perintah php artisan serve
- Ada 3 endpoint yang bisa diakses, yakni :
    1. api/v1/login
    2. api/v1/provinces
    3. api/v1/cities

- api/v1/provinces dan api/v1/cities secara default akan mengambil data dari database, namun jika ditambahkan param query origins=1, maka akan mengambil data langsung dari rajaOngkir. Struktur data pada response akan terlihat berbeda untuk menunjukkan perbedaan antara data rajaongkir dan data yang berasal dari database
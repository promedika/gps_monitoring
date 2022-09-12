<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Tentang Aplikasi Absensi Marketing

Aplikasi Absensi Marketing digunakan untuk Mencatat Kehadiran dengan cara upload gambar yang sudah terdapat lokasi gps pada gambar tersebut.

## Cara Install Aplikasi Absensi Marketing

- Download atau clone dari repository git.
- Setting dan sesuaikan file .env yg digunakan.
- Buka command line dan pindah ke directory root absensi marketing.
- Jalankan "composer install"
- Buat folder public di dalam folder storage/app/
- Buat folder posts, clock_in_img, dan clock_out_img di dalam folder storage/app/public/
- Jalankan "php artisan storage:link"
- Setting database
- Setting .env
- Jalankan "php artisan key:generate"
- Jalankan "php artisan migrate"
- Jalakan "php artisan db:seed --class=AdminUserSeeder"
- Jalankan "php artisan serve"
- Buka aplikasi absensi marketing pada browser
- Selamat, aplikasi berhasil dijalankan

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

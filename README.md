SISTEM ABSENSI QR CODE
1. STACK
   A. WEB BASED
       - **LARAVEL 10.10**
       - **PHP 8.1**
   B. Database
       - **MySQL 5.0 / 10.2.40-MariaDB**
   C. Mobile Apps
       - **Flutter framework  3.16.5**
       - **Dart v. 3.2.3**
2. Cara Installasi
   A. Web Apps (**Manual Installation**)
       - Download Source ini
       - Copy semua file ke root directory ex: C:\Xampp\htdocs\namafolder
       - buat database dengan nama **absensisiswa**
       - Restore Database yang ada di folder **database/database** ke database yang sudah dibuat, atau bisa menggunakan artisan seeder dengan mengetikan perintah di document root dengan perintah **php artisan migrate**
       - Akses dengan menggunakan localhost/namafolder
   B. Web Apps (**Github Installation**)
       - Clone source ini dengan mengetikan perintah **git clone https://github.com/adji142/absensisiwa-barcodeautoreload.git**
       - buat database dengan nama **absensisiswa**
       - Restore Database yang ada di folder **database/database** ke database yang sudah dibuat, atau bisa menggunakan artisan seeder dengan mengetikan perintah di document root dengan perintah **php artisan migrate**
   C. Mobile Apps
       - Download semua file yang dibutuhkan seperti flutter framework, dart, editor
       - setelah semua terinstall lakukan instalasi package dengan mengetikan perintah **flutter pub get**
       - Start dan debuging

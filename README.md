# REST API Pengiriman Email PHP Native 

## Pendahuluan

API ini menyediakan endpoint untuk mengirimkan email secara programatik menggunakan :

- library PHPMailer
- library JWT
- library phpdotenv
- Cron Job 
- MYSQL

API ini dirancang dengan **PHP 8.2 Native** untuk bisa berjalan dengan authentification serta autorization demi keamanan endpoint, serta dilengkapi dengan dokumentasi yang jelas.

## Prasyarat

- PHP 8.2
- MYSQL Server 
- Composer
- **Server Email** : Akun email yang mendukung SMTP (misalnya Gmail) dengan konfigurasi SMTP yang benar.
- **Alat** : Postman
- **JWT** : Secret Token yang disepekati

## Instalasi

1. Clone repository:
```bash
  git clone https://github.com/your-username/your-repo.git
```
2. Composer :
```bash
composer install
```
3. SQL :

Run SQL Script di file [script.sql](./script.sql) 

4. Cron Job 

- [Setup Cron Job in Windows using task scheduler](https://www.youtube.com/watch?v=74LrUOja3iw)
- masukan url file [cron.php](./cron.php) kedalam cron job 

5. .env
- copy dan paste file .env_example dan rename menjadi .env
- lalu isikan credential untuk database MYSQL, SMTP Email, dan JWT Token

6. Run Server 
```bash
php -S localhost:8000
```

## API Reference

referensi [API](./API%20Lavtech%20Code%20Challage.postman_collection.json) bisa di import via postman






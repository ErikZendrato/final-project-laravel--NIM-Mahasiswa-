# Final Project Aplikasi Berbasis Laravel - Dokumentasi API

## Identitas Mahasiswa

- **Nama:** Laurensius Frederik Zendrato
- **NIM:** 2415354079
- **Kelas/Rombel:** 4C TRPL
- **Tanggal Praktikum:** 25 Mei 2026

---

## Teknologi & Tools yang Digunakan

- **Sistem Operasi:** Windows 11
- **Bahasa Pemrograman:** PHP (Laravel Framework)
- **Database:** MySQL / phpMyAdmin
- **Tools Pengujian API:** Thunder Client / Postman
- **Code Editor & Version Control:** VS Code & Git

---

## Langkah-Langkah Pengujian Endpoint

1. Pastikan *local server* database (MySQL via phpMyAdmin/XAMPP/Laragon) sudah aktif.
2. Jalankan perintah `php artisan serve` pada terminal VS Code untuk mengaktifkan server lokal Laravel.
3. Buka ekstensi **Thunder Client** di VS Code.
4. Masukkan URL endpoint (sesuaikan domain lokal/port, misalnya: `http://localhost:8000` atau dengan tambahan *prefix* `/api` jika diatur di `api.php`).
5. Pilih HTTP Method yang sesuai, isi *Request Body* (jika bertipe POST/PUT/PATCH), lalu klik **Send**.
6. Ambil screenshot hasil *Response Body* beserta *HTTP Status Code*-nya untuk dokumentasi di bawah ini.

---

## Dokumentasi Hasil Pengujian (Screenshot)



### Modul Customer

#### 1. Get Single Customer (`GET /customers/{id}`)
> ![Get Single Customer](SS/1.png)

#### 2. Create Customer (`POST /customers`)
> ![Create Customer](SS/2.png)

#### 3. Update Customer (`PUT /customers/{id}`)
> ![Update Customer](SS/3.png)

#### 4. Delete Customer (`DELETE /customers/{id}`)
> ![Delete Customer](SS/4.png)


---

### Modul Service

#### 5. Get Single Service (`GET /services/{id}`)
> ![Get Single Service](SS/5.png)

#### 6. Create Service (`POST /services`)
> ![Create Service](SS/6.png)

#### 7. Update Service (`PUT /services/{id}`)
> ![Update Service](SS/7.png)

#### 8. Delete Service (`DELETE /services/{id}`)
> ![Delete Service](SS/8.png)

---

### Modul Subscription

#### 9. Get All Subscriptions (`GET /subscriptions`)
> ![Get All Subscriptions](SS/9.png)

#### 10. Get Single Subscription (`GET /subscriptions/{id}`)
> ![Get Single Subscription](SS/10.png)

#### 11. Create Subscription (`POST /subscriptions`)
> ![Create Subscription](SS/11.png)

#### 12. Change Subscription Status (`PATCH /subscriptions/{id}/change-status`)
> ![Change Subscription Status](SS/12.png)
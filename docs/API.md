# Dokumentasi API — Absensi Digital

Base URL lokal: `http://127.0.0.1:8000/api`
Emulator Android: `http://10.0.2.2:8000/api` · HP fisik: `http://IP-KOMPUTER:8000/api` (jalankan `php artisan serve --host=0.0.0.0`).

Semua request wajib memakai header `Accept: application/json`.
Endpoint bertanda 🔒 butuh header `Authorization: Bearer <token>` (token didapat dari login).

> Prinsip: **client mengirim data, server yang memutuskan.** Identitas siswa tidak dikirim dari aplikasi, tetapi dibaca server dari token login.

---

## POST `/login`
Login akun **siswa**. Akun admin ditolak (403).

Request
```json
{ "email": "siswa@absensi.test", "password": "password" }
```
Response 200
```json
{
  "message": "Login berhasil",
  "token": "1|xxxxxxxxxxxxxxxx",
  "user": { "id": 2, "name": "Siswa Demo", "email": "siswa@absensi.test", "role": "siswa" }
}
```
| Status | Penyebab |
|---|---|
| 401 | Email atau password salah |
| 403 | Akun bukan siswa |
| 422 | Email/password kosong atau format salah |

## GET `/me` 🔒
Profil user dan data siswa (NIS, kelas).

Response 200
```json
{
  "user": { "id": 2, "name": "Siswa Demo", "email": "siswa@absensi.test", "role": "siswa" },
  "student": {
    "id": 1, "nis": "123456789", "full_name": "Siswa Demo",
    "class": { "id": 1, "class_name": "XII RPL 1", "major": "RPL" }
  }
}
```
`student` bernilai `null` bila akun belum terhubung ke data siswa. Tanpa token → 401.

## POST `/logout` 🔒
Menghapus token yang sedang dipakai. Response 200: `{ "message": "Logout berhasil" }`.

## POST `/attendance/scan` 🔒
Memvalidasi QR token dan lokasi GPS siswa (Haversine). **Belum menyimpan absensi.**

Request
```json
{ "qr_token": "TOKEN_DARI_QR", "latitude": -6.123456, "longitude": 108.123456 }
```
Response 200 (valid)
```json
{
  "success": true,
  "message": "QR dan lokasi valid.",
  "data": {
    "student":  { "id": 1, "nis": "123456789", "name": "Siswa Demo" },
    "qr":       { "token_id": 1, "date": "2026-10-23T00:00:00.000000Z", "valid_until": "..." },
    "location": { "name": "Gerbang Utama", "code": "GERBANG", "latitude": "-6.1234560", "longitude": "108.1234560", "radius": 50 },
    "gps":      { "latitude": -6.123456, "longitude": 108.123456, "distance": 18.5 }
  }
}
```
Response 422 (di luar radius)
```json
{
  "success": false,
  "message": "Anda berada di luar radius lokasi absensi.",
  "data": { "distance": 125.0, "radius": 50, "location": "Gerbang Utama" }
}
```

| Status | `message` | Penyebab |
|---|---|---|
| 401 | Unauthenticated. | Tanpa token / token salah |
| 422 | The latitude field must be between -90 and 90. (dll.) | Koordinat atau `qr_token` tidak valid |
| 422 | Akun belum terhubung dengan data siswa. | `students.user_id` kosong |
| 422 | QR Code tidak valid atau sudah kedaluwarsa. | Token palsu / nonaktif / bukan hari ini / expired |
| 422 | Lokasi QR tidak aktif. | `qr_locations.is_active = 0` |
| 422 | Koordinat lokasi QR belum diatur oleh admin. | Lat/long lokasi kosong |
| 422 | Anda berada di luar radius lokasi absensi. | `jarak > radius` |

Jarak tepat sama dengan radius dianggap **valid** (`jarak > radius` yang ditolak).

---

## Matriks pengujian (Pertemuan 8)
| No | QR | GPS | Hasil |
|---|---|---|---|
| 1 | Benar | Dalam radius | VALID |
| 2 | Benar | Di luar radius | Ditolak |
| 3 | Salah | Dalam radius | Ditolak |
| 4 | Salah | Di luar radius | Ditolak |
| 5 | Expired | Dalam radius | Ditolak |
| 6 | Nonaktif | Dalam radius | Ditolak |
| 7 | Benar | Koordinat tidak valid (200, 500) | Ditolak |
| 8 | Benar | Tepat di batas radius | VALID |

Semua kasus sudah disiapkan di `docs/postman/absensi-digital.postman_collection.json`.

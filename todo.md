# Todo List — Perbaikan Fitur Job Role

## Database
- [x] Migration: tambah kolom `department`, `level`, `status` ke tabel `job_roles`
- [x] Update `JobroleSeeder` dengan data lengkap
- [x] Update `JobroleFactory` untuk testing

## Model & Service
- [x] Tambah `department`, `level`, `status` ke `$fillable` di `Jobrole.php`
- [x] Update `createJobrole()` di service agar simpan semua field
- [x] Update `updateJobrole()` di service agar update semua field (tidak hanya `role`)

## Controller
- [x] Tambah method `index()` — ambil data real dari DB
- [x] Tambah method `edit()` — ambil data real dari DB
- [x] Tambah method `update()` — validasi + simpan department, level, status
- [x] Update `store()` — validasi + simpan department, level, status
- [x] Update `show()` — ambil data real dari DB (hapus dummy)
- [x] Update `destroy()` — tambah redirect untuk web request

## Routes
- [x] Ubah route GET `/job-roles` → arahkan ke `JobroleController@index`
- [x] Tambah route PUT `/job-roles/{id}` → `JobroleController@update`
- [x] Tambah nama route `jobrole.destroy` pada route DELETE

## Views
### Edit (`edit.blade.php`)
- [x] Ubah `action="#"` → `route('jobrole.update', $id)`
- [x] Ubah `name="name"` → `name="role"`
- [x] Tambah dropdown Departemen, Level, Status dengan selected value
- [x] Hapus field Departement (deskripsi) yang tidak ada di DB

### Index (`index.blade.php`)
- [x] Hapus data dummy hardcoded
- [x] Pakai variabel `$jobroles` dari controller
- [x] Ubah akses array `$role['...']` → object `$role->...`

### Detail (`detail.blade.php`)
- [x] Akses `$jobrole->role` (bukan `$jobrole->name`)
- [x] Tombol Edit arahkan ke `route('jobrole.edit')`

### Layout (`app.blade.php`)
- [x] Tambah modal konfirmasi hapus (ikuti pola modal logout)
- [x] Tambah fungsi JS `openDeleteModal()` dan `closeDeleteModal()`

## Hapus
- [x] Ganti `<a href="#">` dengan button panggil modal
- [x] Modal konfirmasi dengan method DELETE
- [x] Redirect + flash message setelah hapus

## Git
- [x] Commit: `fix: perbaiki fitur job role - edit, department/level/status, modal hapus`
- [x] Push ke branch `fix/adityananto-jobrole`

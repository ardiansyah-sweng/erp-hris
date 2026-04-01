# ERP-HRIS
Modul Manajemen SDM Aplikasi ERP

# Tautan Google Sheet
https://docs.google.com/spreadsheets/d/1DqY_ybKibNQ15xTntpKzz1D4TmLLcau9_5C6BadfCV4/edit?usp=sharing 

## Entitas/Set Relasi
- **Employees**. Employee adalah pegawai/karyawan di perusahaan.
  - Atribut
    - id (Primary Key)      - Unique identifier
    - name (string)         - Nama lengkap karyawan
    - email (string)        - Email pribadi/kontak utama
    - phone_number (string) - Nomor telepon karyawan
    - place_of_birth (string) - Tempat lahir karyawan
    - date_of_birth (date)  - Tanggal Lahir karyawan
    - address (string)      - Alamat tinggal karyawan
    - id_number (string)    - Nomor KTP karyawan
    - age (integer, default 0) - hasil perhitungan tanggal sekarang dengan date_of_birth 

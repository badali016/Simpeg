```mermaid
erDiagram
  PEGAWAI {
    int id
    string nip
    string nik
    string nama
    date tgl_lahir
    string tempat_lahir
    string gender
    string status_pernikahan
    string gol_darah
    string alamat
    string kontak
    string email
    string status_kerja       
    string jenis_kontrak      
    date tgl_mulai
    date tgl_selesai
    date tgl_akhir_probation
    int unit_id
    int jabatan_id
    int grade_id
    int atasan_id
  }

  UNIT {
    int id
    string kode
    string nama
    int parent_id
  }

  JABATAN {
    int id
    string kode
    string nama
    string jenis_jabatan     
  }

  GRADE {
    int id
    string kode
    int step
    string golongan
  }

  TUNJANGAN_MELEKAT {
    int id
    string nama
    string kode
    decimal nilai
    string golongan_min
    string golongan_max
  }

  KELUARGA {
    int id
    int pegawai_id
    string hubungan          
    string nama
    date tgl_lahir
    string status_tanggungan
  }

  KEPESERTAAN {
    int id
    int pegawai_id
    string jenis             
    string nomor
    date tgl_daftar
    string status
  }

  KREDENSIAL {
    int id
    int pegawai_id
    string jenis            
    string nomor
    string penerbit
    date tgl_terbit
    date tgl_berlaku
    date tgl_kadaluarsa
    boolean terverifikasi
  }

  PENDIDIKAN {
    int id
    int pegawai_id
    string jenjang
    string institusi
    string program_studi
    date tahun_lulus
  }

  PELATIHAN {
    int id
    int pegawai_id
    string nama
    string penyelenggara
    date tgl_mulai
    date tgl_selesai
    int jam_cpd
    boolean bersertifikat
  }

  PENGALAMAN_KERJA {
    int id
    int pegawai_id
    string organisasi
    string jabatan
    date tgl_mulai
    date tgl_selesai
  }

  MUTASI {
    int id
    int pegawai_id
    int unit_asal_id
    int unit_tujuan_id
    date tgl_mutasi
    string jenis_mutasi      
  }

  PENGHARGAAN {
    int id
    int pegawai_id
    string nama
    date tgl_diberikan
    string keterangan
  }

  SANKSI {
    int id
    int pegawai_id
    string tingkat
    date tgl_mulai
    date tgl_selesai
    string alasan
  }


  GEOFENCE {
    int id
    string nama
    string jenis_lokasi      
    decimal lat
    decimal lng
    int radius_meter
    time jam_mulai_aktif
    time jam_selesai_aktif
  }

  SHIFT {
    int id
    string kode
    string nama
    time jam_mulai
    time jam_selesai
    int durasi_menit
    int toleransi_terlambat
    int grace_period
  }

  JADWAL_SHIFT {
    int id
    int pegawai_id
    int shift_id
    int unit_id
    date tanggal
    string sumber          
  }

  PRESENSI {
    int id
    int pegawai_id
    int jadwal_shift_id
    int geofence_id
    datetime waktu_masuk
    datetime waktu_keluar
    decimal lat
    decimal lng
    decimal akurasi
    boolean mock_location_terdeteksi
    string jenis_device     
    string status_hadir    
    string selfie_path
  }

  KOREKSI_PRESENSI {
    int id
    int presensi_id
    int pemohon_id
    int approver_id
    string jenis_perubahan 
    datetime waktu_diakui
    string alasan
    string lampiran_path
    string status           
  }

  LEMBUR {
    int id
    int pegawai_id
    int presensi_id
    datetime jam_mulai
    datetime jam_selesai
    decimal jam_lembur
    int approver_id
    string status
    string alasan
  }

  CUTI_IZIN {
    int id
    int pegawai_id
    string jenis            
    date tgl_mulai
    date tgl_selesai
    int jumlah_hari
    int approver_id
    string status          
    string alasan
    string lampiran_path
  }

  %% ========= PKP (KENAIKAN PANGKAT) & KINERJA =========

  PKP {
    int id
    int pegawai_id
    string jenis_pangkat
    date tgl_pengajuan
    string status           
    string catatan
  }

  PKP_ITEM {
    int id
    int pkp_id
    string kategori        
    string nama
    decimal nilai
    boolean lengkap
  }

  PKP_REVIEW {
    int id
    int pkp_id
    int reviewer_id
    string tahap           
    date tgl_review
    string keputusan
    string catatan
  }

  KINERJA {
    int id
    int pegawai_id
    string periode        
    string jenis           
    decimal nilai_akhir
    string rekomendasi
  }

  KINERJA_TARGET {
    int id
    int kinerja_id
    string indikator
    decimal bobot
    decimal target
    decimal realisasi
  }

  

  DOKUMEN {
    int id
    int pegawai_id
    int unit_id
    string kategori         
    string nomor
    string judul
    string penerbit
    date tgl_terbit
    date tgl_berlaku
    date tgl_kadaluarsa
    string sensitivitas    
    string path_file
    string hash_file
    int versi_aktif_id
  }

  DOKUMEN_VERSI {
    int id
    int dokumen_id
    int versi
    string path_file
    string hash_file
    date tgl_upload
    int uploader_id
  }

  %% ========= USER, ROLE, AUDIT =========

  USER {
    int id
    int pegawai_id
    string username
    string email
    string password_hash
    boolean is_active
    string sso_provider     
  }

  ROLE {
    int id
    string nama
    string deskripsi
  }

  USER_ROLE {
    int id
    int user_id
    int role_id
  }

  AUDIT_LOG {
    int id
    int user_id
    string aksi
    string entitas
    int entitas_id
    json perubahan
    datetime waktu
    string ip_address
  }



  UNIT ||--o{ UNIT : "parent_child"
  UNIT ||--o{ PEGAWAI : "memiliki banyak pegawai"
  JABATAN ||--o{ PEGAWAI : "jabatan pegawai"
  GRADE ||--o{ PEGAWAI : "grade pegawai"
  TUNJANGAN_MELEKAT ||--o{ GRADE : "referensi"

  PEGAWAI ||--o{ KELUARGA : "tanggungan"
  PEGAWAI ||--o{ KEPESERTAAN : "kepesertaan"
  PEGAWAI ||--o{ KREDENSIAL : "kredensial"
  PEGAWAI ||--o{ PENDIDIKAN : "riwayat pendidikan"
  PEGAWAI ||--o{ PELATIHAN : "riwayat pelatihan"
  PEGAWAI ||--o{ PENGALAMAN_KERJA : "pengalaman kerja"
  PEGAWAI ||--o{ MUTASI : "mutasi/promosi"
  PEGAWAI ||--o{ PENGHARGAAN : "penghargaan"
  PEGAWAI ||--o{ SANKSI : "sanksi"

  PEGAWAI ||--o{ JADWAL_SHIFT : "jadwal kerja"
  SHIFT ||--o{ JADWAL_SHIFT : "dipakai di jadwal"
  UNIT ||--o{ JADWAL_SHIFT : "jadwal per unit"

  PEGAWAI ||--o{ PRESENSI : "presensi"
  JADWAL_SHIFT ||--o{ PRESENSI : "realisasi"
  GEOFENCE ||--o{ PRESENSI : "lokasi absen"

  PRESENSI ||--o{ KOREKSI_PRESENSI : "koreksi"
  PEGAWAI ||--o{ KOREKSI_PRESENSI : "pemohon"
  PEGAWAI ||--o{ LEMBUR : "pengaju lembur"
  PRESENSI ||--o{ LEMBUR : "berdasarkan presensi"

  PEGAWAI ||--o{ CUTI_IZIN : "pengajuan cuti/izin"

  PEGAWAI ||--o{ PKP : "pengajuan PKP"
  PKP ||--o{ PKP_ITEM : "komponen penilaian"
  PKP ||--o{ PKP_REVIEW : "review berjenjang"
  PEGAWAI ||--o{ KINERJA : "rekap kinerja"
  KINERJA ||--o{ KINERJA_TARGET : "target detail"

  PEGAWAI ||--o{ DOKUMEN : "dokumen personal"
  UNIT ||--o{ DOKUMEN : "dokumen unit"
  DOKUMEN ||--o{ DOKUMEN_VERSI : "versi"

  PEGAWAI ||--o{ USER : "akun sistem"
  USER ||--o{ USER_ROLE : "roles"
  ROLE ||--o{ USER_ROLE : "users"
  USER ||--o{ AUDIT_LOG : "aktivitas"
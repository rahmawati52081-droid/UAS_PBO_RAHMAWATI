<?php

// ==========================================================================
// 1. SUBCLASS: MAHASISWA MANDIRI
// ==========================================================================
class MahasiswaMandiri extends Mahasiswa {
    private $golonganUKT;
    private $namaWali;

    public function __construct($id, $nama, $nim, $semester, $ukt, $golonganUKT, $namaWali) {
        parent::__construct($id, $nama, $nim, $semester, $ukt);
        $this->golonganUKT = $golonganUKT;
        $this->namaWali = $namaWali;
    }

    /**
     * OVERRIDE: Logika Bisnis Mandiri
     * Tarif UKT Nominal + Biaya Operasional Kemahasiswaan (Flat Rp 100.000)
     */
    public function hitungTagihanSemester() {
        $biayaOperasional = 100000;
        return $this->tarif_ukt_nominal + $biayaOperasional;
    }

    public function tampilkanSpesifikasiAkademik() {
        echo "Mahasiswa Mandiri - Nama Wali: {$this->namaWali}, Golongan: {$this->golonganUKT}\n";
    }

    public function getQuerySelectAllMandiri() {
        return "SELECT id_mahasiswa, nama_mahasiswa, nim, semester, tarif_ukt_nominal, golongan_ukt, nama_wali 
                FROM tabel_mahasiswa WHERE jenis_pembayaran = 'mandiri';";
    }
}

// ==========================================================================
// 2. SUBCLASS: MAHASISWA BIDIKMISI
// ==========================================================================
class MahasiswaBidikmisi extends Mahasiswa {
    private $nomorKipKuliah;
    private $danaSukuSubsidi;

    public function __construct($id, $nama, $nim, $semester, $ukt, $nomorKipKuliah, $danaSukuSubsidi) {
        parent::__construct($id, $nama, $nim, $semester, $ukt);
        $this->nomorKipKuliah = $nomorKipKuliah;
        $this->danaSukuSubsidi = $danaSukuSubsidi;
    }

    /**
     * OVERRIDE: Logika Bisnis Bidikmisi
     * Digratiskan penuh (0 Rupiah) karena ditanggung negara lewat KIP-Kuliah
     */
    public function hitungTagihanSemester() {
        return 0;
    }

    public function tampilkanSpesifikasiAkademik() {
        echo "Mahasiswa Bidikmisi - No KIP: {$this->nomorKipKuliah}, Dana Saku: Rp " . number_format($this->danaSukuSubsidi, 0, ',', '.') . "\n";
    }

    public function getQuerySelectAllBidikmisi() {
        return "SELECT id_mahasiswa, nama_mahasiswa, nim, semester, nomor_kip_kuliah, dana_saku_subsidi 
                FROM tabel_mahasiswa WHERE jenis_pembayaran = 'bidikmisi';";
    }
}

// ==========================================================================
// 3. SUBCLASS: MAHASISWA PRESTASI
// ==========================================================================
class MahasiswaPrestasi extends Mahasiswa {
    private $namaInstansiBeasiswa;
    private $minimalIpkSyarat;

    public function __construct($id, $nama, $nim, $semester, $ukt, $namaInstansiBeasiswa, $minimalIpkSyarat) {
        parent::__construct($id, $nama, $nim, $semester, $ukt);
        $this->namaInstansiBeasiswa = $namaInstansiBeasiswa;
        $this->minimalIpkSyarat = $minimalIpkSyarat;
    }

    /**
     * OVERRIDE: Logika Bisnis Prestasi
     * Potongan 75%, sehingga mahasiswa hanya membayar 25% (0.25) dari tarif asli
     */
    public function hitungTagihanSemester() {
        return $this->tarif_ukt_nominal * 0.25;
    }

    public function tampilkanSpesifikasiAkademik() {
        echo "Mahasiswa Prestasi - Beasiswa: {$this->namaInstansiBeasiswa}, Syarat Minimal IPK: {$this->minimalIpkSyarat}\n";
    }

    public function getQuerySelectAllPrestasi() {
        return "SELECT id_mahasiswa, nama_mahasiswa, nim, semester, tarif_ukt_nominal, nama_instansi_beasiswa, minimal_ipk_syarat 
                FROM tabel_mahasiswa WHERE jenis_pembayaran = 'prestasi';";
    }
}
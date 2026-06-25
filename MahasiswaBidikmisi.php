<?php

// ==========================================================================
// 2. SUBCLASS: MAHASISWA BIDIKMISI
// ==========================================================================
class MahasiswaBidikmisi extends Mahasiswa {
    // Properti tambahan spesifik
    private $nomorKipKuliah;
    private $danaSukuSubsidi; // (Typo dari danaSakuSubsidi disesuaikan dengan instruksi)

    public function __construct($id, $nama, $nim, $semester, $ukt, $nomorKipKuliah, $danaSukuSubsidi) {
        parent::__construct($id, $nama, $nim, $semester, $ukt);
        $this->nomorKipKuliah = $nomorKipKuliah;
        $this->danaSukuSubsidi = $danaSukuSubsidi;
    }

    // Implementasi metode abstrak dari induk
    public function hitungTagihanSemester() {
        // Mahasiswa Bidikmisi biasanya gratis UKT (0 Rupiah) karena ditanggung pemerintah
        return 0;
    }

    public function tampilkanSpesifikasiAkademik() {
        echo "Mahasiswa Bidikmisi - No KIP: {$this->nomorKipKuliah}, Dana Saku Subsidi: Rp " . number_format($this->danaSukuSubsidi, 0, ',', '.') . "\n";
    }

    // Method berisi Query SELECT-WHERE untuk mengambil semua data Mahasiswa Bidikmisi
    public function getQuerySelectAllBidikmisi() {
        $sql = "SELECT id_mahasiswa, nama_mahasiswa, nim, semester, nomor_kip_kuliah, dana_saku_subsidi 
                FROM tabel_mahasiswa 
                WHERE jenis_pembayaran = 'bidikmisi';";
        return $sql;
    }
}
?>
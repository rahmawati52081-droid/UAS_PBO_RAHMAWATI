<?php

abstract class Mahasiswa {
    // Properti Terenkapsulasi (Protected)
    protected $id_mahasiswa;
    protected $nama_mahasiswa;
    protected $nim;
    protected $semester;
    protected $tarif_ukt_nominal;

    // Constructor untuk inisialisasi data awal
    public function __construct($id, $nama, $nim, $semester, $ukt) {
        $this->id_mahasiswa = $id;
        $this->nama_mahasiswa = $nama;
        $this->nim = $nim;
        $this->semester = $semester;
        $this->tarif_ukt_nominal = $ukt;
    }

    // Metode Abstrak (Wajib di-override/diimplementasikan oleh kelas anak)
    abstract public function hitungTagihanSemester();
    abstract public function tampilkanSpesifikasiAkademik();
}
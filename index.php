<?php
// ==========================================================================
// 1. DEFINISI CLASS & SUBCLASS (PROPERTI SET PUBLIC)
// ==========================================================================

abstract class Mahasiswa {
    // Diubah menjadi PUBLIC agar bisa diakses langsung di View tanpa getter
    public $id_mahasiswa;
    public $nama_mahasiswa;
    public $nim;
    public $semester;
    public $tarif_ukt_nominal;

    public function __construct($id, $nama, $nim, $semester, $ukt) {
        $this->id_mahasiswa = $id;
        $this->nama_mahasiswa = $nama;
        $this->nim = $nim;
        $this->semester = $semester;
        $this->tarif_ukt_nominal = $ukt;
    }

    abstract public function hitungTagihanSemester();
    abstract public function tampilkanSpesifikasiAkademik();
}

class MahasiswaMandiri extends Mahasiswa {
    public $golonganUKT;
    public $namaWali;

    public function __construct($id, $nama, $nim, $semester, $ukt, $golonganUKT, $namaWali) {
        parent::__construct($id, $nama, $nim, $semester, $ukt);
        $this->golonganUKT = $golonganUKT;
        $this->namaWali = $namaWali;
    }

    public function hitungTagihanSemester() {
        return $this->tarif_ukt_nominal + 100000; // + Biaya Operasional Flat
    }

    public function tampilkanSpesifikasiAkademik() {
        echo "Mandiri - Wali: {$this->namaWali}, Golongan: {$this->golonganUKT}";
    }

    public function getQuerySelectAllMandiri() {
        return "SELECT * FROM tabel_mahasiswa WHERE jenis_pembayaran = 'mandiri';";
    }
}

class MahasiswaBidikmisi extends Mahasiswa {
    public $nomorKipKuliah;
    public $danaSukuSubsidi;

    public function __construct($id, $nama, $nim, $semester, $ukt, $nomorKipKuliah, $danaSukuSubsidi) {
        parent::__construct($id, $nama, $nim, $semester, $ukt);
        $this->nomorKipKuliah = $nomorKipKuliah;
        $this->danaSukuSubsidi = $danaSukuSubsidi;
    }

    public function hitungTagihanSemester() {
        return 0; // Digratiskan penuh
    }

    public function tampilkanSpesifikasiAkademik() {
        echo "Bidikmisi - KIP: {$this->nomorKipKuliah}";
    }

    // DISINI PERBAIKANNYA: Diubah menjadi SELECT * agar tarif_ukt_nominal ikut terbawa
    public function getQuerySelectAllBidikmisi() {
        return "SELECT * FROM tabel_mahasiswa WHERE jenis_pembayaran = 'bidikmisi';";
    }
}

class MahasiswaPrestasi extends Mahasiswa {
    public $namaInstansiBeasiswa;
    public $minimalIpkSyarat;

    public function __construct($id, $nama, $nim, $semester, $ukt, $namaInstansiBeasiswa, $minimalIpkSyarat) {
        parent::__construct($id, $nama, $nim, $semester, $ukt);
        $this->namaInstansiBeasiswa = $namaInstansiBeasiswa;
        $this->minimalIpkSyarat = $minimalIpkSyarat;
    }

    public function hitungTagihanSemester() {
        return $this->tarif_ukt_nominal * 0.25; // Cukup bayar 25%
    }

    public function tampilkanSpesifikasiAkademik() {
        echo "Prestasi - Beasiswa: {$this->namaInstansiBeasiswa}";
    }

    // DISINI PERBAIKANNYA: Diubah menjadi SELECT * agar tarif_ukt_nominal ikut terbawa
    public function getQuerySelectAllPrestasi() {
        return "SELECT * FROM tabel_mahasiswa WHERE jenis_pembayaran = 'prestasi';";
    }
}


// ==========================================================================
// 2. KONEKSI DAN PROSES DATABASE INTO OBJECT ARRAY
// ==========================================================================

$host     = "localhost";
$username = "root";
$password = "";
$database = "db_uas_pbo_ti1d_rahmawati";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$daftarMandiri   = [];
$daftarBidikmisi = [];
$daftarPrestasi  = [];

// Fetch Mandiri
$mhsMandiriDummy = new MahasiswaMandiri(null, '', '', 0, 0, '', '');
$resultMandiri = $conn->query($mhsMandiriDummy->getQuerySelectAllMandiri());
if ($resultMandiri && $resultMandiri->num_rows > 0) {
    while($row = $resultMandiri->fetch_assoc()) {
        $daftarMandiri[] = new MahasiswaMandiri(
            $row['id_mahasiswa'], $row['nama_mahasiswa'], $row['nim'], 
            $row['semester'], $row['tarif_ukt_nominal'], $row['golongan_ukt'], $row['nama_wali']
        );
    }
}

// Fetch Bidikmisi
$mhsBidikmisiDummy = new MahasiswaBidikmisi(null, '', '', 0, 0, '', 0);
$resultBidikmisi = $conn->query($mhsBidikmisiDummy->getQuerySelectAllBidikmisi());
if ($resultBidikmisi && $resultBidikmisi->num_rows > 0) {
    while($row = $resultBidikmisi->fetch_assoc()) {
        $daftarBidikmisi[] = new MahasiswaBidikmisi(
            $row['id_mahasiswa'], $row['nama_mahasiswa'], $row['nim'], 
            $row['semester'], $row['tarif_ukt_nominal'], $row['nomor_kip_kuliah'], $row['dana_saku_subsidi']
        );
    }
}

// Fetch Prestasi
$mhsPrestasiDummy = new MahasiswaPrestasi(null, '', '', 0, 0, '', 0);
$resultPrestasi = $conn->query($mhsPrestasiDummy->getQuerySelectAllPrestasi());
if ($resultPrestasi && $resultPrestasi->num_rows > 0) {
    while($row = $resultPrestasi->fetch_assoc()) {
        $daftarPrestasi[] = new MahasiswaPrestasi(
            $row['id_mahasiswa'], $row['nama_mahasiswa'], $row['nim'], 
            $row['semester'], $row['tarif_ukt_nominal'], $row['nama_instansi_beasiswa'], $row['minimal_ipk_syarat']
        );
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Registrasi Pembayaran UKT</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans text-gray-900">

    <div class="max-w-7xl mx-auto px-4 py-8">
        <header class="mb-10 text-center">
            <h1 class="text-3xl font-extrabold text-indigo-900 tracking-tight">SISTEM REGISTRASI PEMBAYARAN KULIAH</h1>
            <p class="text-sm text-gray-500 mt-2">Data Terkelompok Berdasarkan Kategori Skema Pembiayaan (OOP Public Property)</p>
        </header>

        <section class="mb-12 bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-orange-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white uppercase tracking-wider">Mahasiswa Jalur Mandiri</h2>
            </div>
            <div class="p-6 overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700 text-xs uppercase font-semibold">
                            <th class="px-4 py-3">ID</th>
                            <th class="px-4 py-3">NIM</th>
                            <th class="px-4 py-3">Nama Mahasiswa</th>
                            <th class="px-4 py-3 text-center">Semester</th>
                            <th class="px-4 py-3">Golongan UKT</th>
                            <th class="px-4 py-3">Nama Wali</th>
                            <th class="px-4 py-3 text-right">Tarif Pokok</th>
                            <th class="px-4 py-3 text-right bg-orange-50 text-orange-700 font-bold">Total Tagihan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm">
                        <?php if(empty($daftarMandiri)): ?>
                            <tr><td colspan="8" class="text-center py-4 text-gray-500">Tidak ada data.</td></tr>
                        <?php else: ?>
                            <?php foreach($daftarMandiri as $mhs): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-gray-500"><?= $mhs->id_mahasiswa; ?></td>
                                    <td class="px-4 py-3 font-medium"><?= $mhs->nim; ?></td>
                                    <td class="px-4 py-3"><?= $mhs->nama_mahasiswa; ?></td>
                                    <td class="px-4 py-3 text-center"><?= $mhs->semester; ?></td>
                                    <td class="px-4 py-3"><span class="px-2 py-0.5 bg-orange-100 text-orange-800 rounded text-xs"><?= $mhs->golonganUKT; ?></span></td>
                                    <td class="px-4 py-3 text-gray-600"><?= $mhs->namaWali; ?></td>
                                    <td class="px-4 py-3 text-right">Rp <?= number_format($mhs->tarif_ukt_nominal, 0, ',', '.'); ?></td>
                                    <td class="px-4 py-3 text-right font-bold bg-orange-50 text-orange-700">Rp <?= number_format($mhs->hitungTagihanSemester(), 0, ',', '.'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="mb-12 bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-emerald-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white uppercase tracking-wider">Mahasiswa Jalur Bidikmisi / KIP-K</h2>
            </div>
            <div class="p-6 overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700 text-xs uppercase font-semibold">
                            <th class="px-4 py-3">ID</th>
                            <th class="px-4 py-3">NIM</th>
                            <th class="px-4 py-3">Nama Mahasiswa</th>
                            <th class="px-4 py-3 text-center">Semester</th>
                            <th class="px-4 py-3">No. KIP Kuliah</th>
                            <th class="px-4 py-3 text-right">Dana Saku</th>
                            <th class="px-4 py-3 text-right bg-emerald-50 text-emerald-700 font-bold">Total Tagihan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm">
                        <?php if(empty($daftarBidikmisi)): ?>
                            <tr><td colspan="7" class="text-center py-4 text-gray-500">Tidak ada data.</td></tr>
                        <?php else: ?>
                            <?php foreach($daftarBidikmisi as $mhs): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-gray-500"><?= $mhs->id_mahasiswa; ?></td>
                                    <td class="px-4 py-3 font-medium"><?= $mhs->nim; ?></td>
                                    <td class="px-4 py-3"><?= $mhs->nama_mahasiswa; ?></td>
                                    <td class="px-4 py-3 text-center"><?= $mhs->semester; ?></td>
                                    <td class="px-4 py-3 text-gray-600"><?= $mhs->nomorKipKuliah; ?></td>
                                    <td class="px-4 py-3 text-right text-emerald-600 font-medium">Rp <?= number_format($mhs->danaSukuSubsidi, 0, ',', '.'); ?></td>
                                    <td class="px-4 py-3 text-right font-bold bg-emerald-50 text-emerald-700">
                                        <span class="text-xs uppercase bg-emerald-200 text-emerald-800 px-2 py-1 rounded font-bold">Gratis (Rp 0)</span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-blue-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white uppercase tracking-wider">Mahasiswa Jalur Prestasi</h2>
            </div>
            <div class="p-6 overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700 text-xs uppercase font-semibold">
                            <th class="px-4 py-3">ID</th>
                            <th class="px-4 py-3">NIM</th>
                            <th class="px-4 py-3">Nama Mahasiswa</th>
                            <th class="px-4 py-3 text-center">Semester</th>
                            <th class="px-4 py-3">Instansi Beasiswa</th>
                            <th class="px-4 py-3 text-center">Min IPK</th>
                            <th class="px-4 py-3 text-right">Tarif Asli</th>
                            <th class="px-4 py-3 text-right bg-blue-50 text-blue-700 font-bold">Tagihan (Diskon 75%)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm">
                        <?php if(empty($daftarPrestasi)): ?>
                            <tr><td colspan="8" class="text-center py-4 text-gray-500">Tidak ada data.</td></tr>
                        <?php else: ?>
                            <?php foreach($daftarPrestasi as $mhs): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-gray-500"><?= $mhs->id_mahasiswa; ?></td>
                                    <td class="px-4 py-3 font-medium"><?= $mhs->nim; ?></td>
                                    <td class="px-4 py-3"><?= $mhs->nama_mahasiswa; ?></td>
                                    <td class="px-4 py-3 text-center"><?= $mhs->semester; ?></td>
                                    <td class="px-4 py-3 text-gray-600"><?= $mhs->namaInstansiBeasiswa; ?></td>
                                    <td class="px-4 py-3 text-center"><span class="bg-blue-100 text-blue-800 px-2 py-0.5 rounded font-bold text-xs"><?= $mhs->minimalIpkSyarat; ?></span></td>
                                    <td class="px-4 py-3 text-right text-gray-400 line-through">Rp <?= number_format($mhs->tarif_ukt_nominal, 0, ',', '.'); ?></td>
                                    <td class="px-4 py-3 text-right font-bold bg-blue-50 text-blue-700">Rp <?= number_format($mhs->hitungTagihanSemester(), 0, ',', '.'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>

</body>
</html>
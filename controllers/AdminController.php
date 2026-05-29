<?php
class AdminController {
    private $authModel;
    private $kamarModel;
    private $pembayaranModel;
    private $laporanModel;

    public function __construct($authModel, $kamarModel, $pembayaranModel, $laporanModel) {
        $this->authModel = $authModel;
        $this->kamarModel = $kamarModel;
        $this->pembayaranModel = $pembayaranModel;
        $this->laporanModel = $laporanModel;
    }

    public function checkSession() {
        if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
            header("Location: index.php");
            exit();
        }
        if (isset($_SESSION['terakhir_aktif']) && (time() - $_SESSION['terakhir_aktif'] > 900)) {
            session_unset();
            session_destroy();
            header("Location: index.php?pesan=timeout");
            exit();
        }
        $_SESSION['terakhir_aktif'] = time();
    }

    public function index() {
        $this->checkSession();
        $hal_aktif = isset($_GET['hal']) ? $_GET['hal'] : 'dashboard';
        $pesan_aksi = "";
        $kamar_edit = null;

        if (isset($_GET['aksi']) && isset($_GET['id'])) {
            $aksi = $_GET['aksi'];
            $id   = $_GET['id'];

            if ($aksi == 'terima') {
                $this->pembayaranModel->updateStatus((int)$id, 'diterima');
                header("Location: index.php?page=admin&hal=pembayaran");
                exit();
            } elseif ($aksi == 'tolak') {
                $this->pembayaranModel->updateStatus((int)$id, 'ditolak');
                header("Location: index.php?page=admin&hal=pembayaran");
                exit();
            } elseif ($aksi == 'hapus_laporan') {
                $this->laporanModel->hapusLaporan((int)$id);
                header("Location: index.php?page=admin&hal=laporan");
                exit();
            } elseif ($aksi == 'proses_laporan') {
                $this->laporanModel->updateStatusLaporan((int)$id, 'Diproses');
                header("Location: index.php?page=admin&hal=laporan");
                exit();
            } elseif ($aksi == 'selesai_laporan') {
                $this->laporanModel->updateStatusLaporan((int)$id, 'Selesai');
                header("Location: index.php?page=admin&hal=laporan");
                exit();
            } elseif ($aksi == 'hapus_kamar') {
                $this->kamarModel->hapusKamar($id);
                header("Location: index.php?page=admin&hal=kamar");
                exit();
            } elseif ($aksi == 'edit_kamar') {
                $kamar_edit = $this->kamarModel->getKamarByNo($id);
                $hal_aktif = 'kamar';
            }
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['tambah_kamar'])) {
                $no_kamar = $_POST['no_kamar'];
                $tipe     = $_POST['tipe'];
                $harga    = $_POST['harga'];
                $status   = $_POST['status'];
                $this->kamarModel->tambahKamar($no_kamar, $tipe, $harga, $status);
                header("Location: index.php?page=admin&hal=kamar");
                exit();
            }

            if (isset($_POST['ubah_kamar'])) {
                $no_kamar_lama = $_POST['no_kamar_lama'];
                $no_kamar_baru = $_POST['no_kamar'];
                $tipe          = $_POST['tipe'];
                $harga         = $_POST['harga'];
                $status        = $_POST['status'];
                $this->kamarModel->ubahKamar($no_kamar_lama, $no_kamar_baru, $tipe, $harga, $status);
                header("Location: index.php?page=admin&hal=kamar");
                exit();
            }

            if (isset($_POST['simpan_profil'])) {
                $nama  = $_POST['nama'];
                $email = $_POST['email'];
                $hp    = $_POST['hp'];
                $id    = $_SESSION['id'];
                $this->authModel->updateProfil($id, $nama, $email, $hp);
                $_SESSION['nama']  = $nama;
                $_SESSION['email'] = $email;
                $_SESSION['hp']    = $hp;
                $pesan_aksi = "✅ Profil berhasil disimpan!";
                $hal_aktif = 'profil';
            }
        }

        $total_kamar     = $this->kamarModel->getTotalKamar();
        $kamar_terisi    = $this->kamarModel->getKamarTerisi();
        $tunggakan       = $this->pembayaranModel->getTunggakanCount();
        $data_kamar      = $this->kamarModel->getAllKamar();
        
        $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : "";
        $data_penghuni   = $this->authModel->getPenghuni($keyword);
        $data_pembayaran = $this->pembayaranModel->getPembayaranMenunggu();
        $data_laporan    = $this->laporanModel->getAllLaporan();

        include 'views/admin.php';
    }
}
?>

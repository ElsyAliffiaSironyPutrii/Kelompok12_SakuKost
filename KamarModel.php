<?php
class KamarModel {
    private $db;

    public function __construct($koneksi) {
        $this->db = $koneksi;
    }

    public function getTotalKamar() {
        return mysqli_fetch_assoc(mysqli_query($this->db, "SELECT COUNT(*) as total FROM kamar"))['total'];
    }

    public function getKamarTerisi() {
        return mysqli_fetch_assoc(mysqli_query($this->db, "SELECT COUNT(*) as total FROM kamar WHERE status='terisi'"))['total'];
    }

    public function getAllKamar() {
        return mysqli_query($this->db, "SELECT * FROM kamar ORDER BY no_kamar");
    }

    public function getKamarTersedia() {
        return mysqli_query($this->db, "SELECT no_kamar FROM kamar WHERE status='tersedia' ORDER BY no_kamar");
    }

    public function getKamarByNo($no_kamar) {
        $no_kamar = mysqli_real_escape_string($this->db, $no_kamar);
        return mysqli_fetch_assoc(mysqli_query($this->db, "SELECT * FROM kamar WHERE no_kamar='$no_kamar'"));
    }

    public function tambahKamar($no_kamar, $tipe, $harga, $status) {
        $no_kamar = mysqli_real_escape_string($this->db, strip_tags(trim($no_kamar)));
        $tipe     = mysqli_real_escape_string($this->db, strip_tags(trim($tipe)));
        $harga    = (int)$harga;
        $status   = mysqli_real_escape_string($this->db, strip_tags(trim($status)));
        return mysqli_query($this->db, "INSERT INTO kamar (no_kamar, tipe, harga, status) VALUES ('$no_kamar', '$tipe', $harga, '$status')");
    }

    public function ubahKamar($no_kamar_lama, $no_kamar_baru, $tipe, $harga, $status) {
        $no_kamar_lama = mysqli_real_escape_string($this->db, $no_kamar_lama);
        $no_kamar_baru = mysqli_real_escape_string($this->db, strip_tags(trim($no_kamar_baru)));
        $tipe          = mysqli_real_escape_string($this->db, strip_tags(trim($tipe)));
        $harga         = (int)$harga;
        $status        = mysqli_real_escape_string($this->db, strip_tags(trim($status)));
        return mysqli_query($this->db, "UPDATE kamar SET no_kamar='$no_kamar_baru', tipe='$tipe', harga=$harga, status='$status' WHERE no_kamar='$no_kamar_lama'");
    }

    public function hapusKamar($no_kamar) {
        $no_kamar = mysqli_real_escape_string($this->db, $no_kamar);
        return mysqli_query($this->db, "DELETE FROM kamar WHERE no_kamar='$no_kamar'");
    }

    public function updateStatus($no_kamar, $status) {
        $no_kamar = mysqli_real_escape_string($this->db, $no_kamar);
        $status = mysqli_real_escape_string($this->db, $status);
        return mysqli_query($this->db, "UPDATE kamar SET status='$status' WHERE no_kamar='$no_kamar'");
    }
}
?>
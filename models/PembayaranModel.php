<?php
class PembayaranModel {
    private $db;

    public function __construct($koneksi) {
        $this->db = $koneksi;
    }

    public function getTunggakanCount() {
        return mysqli_fetch_assoc(mysqli_query($this->db, "SELECT COUNT(*) as total FROM pembayaran WHERE status='menunggu'"))['total'];
    }

    public function getPembayaranMenunggu() {
        return mysqli_query($this->db, "SELECT p.*, u.nama, u.kamar FROM pembayaran p JOIN users u ON p.user_id = u.id WHERE p.status = 'menunggu' ORDER BY p.tanggal DESC");
    }

    public function updateStatus($id, $status) {
        $id = (int)$id;
        return mysqli_query($this->db, "UPDATE pembayaran SET status='$status' WHERE id=$id");
    }

    public function getRiwayatUser($user_id) {
        $user_id = (int)$user_id;
        return mysqli_query($this->db, "SELECT * FROM pembayaran WHERE user_id=$user_id ORDER BY tanggal DESC");
    }

    public function tambahPembayaran($user_id, $bulan, $jumlah, $catatan) {
        $user_id = (int)$user_id;
        $bulan   = mysqli_real_escape_string($this->db, strip_tags(trim($bulan)));
        $jumlah  = (int)$jumlah;
        $catatan = mysqli_real_escape_string($this->db, strip_tags(trim($catatan)));
        return mysqli_query($this->db, "INSERT INTO pembayaran (user_id, bulan, jumlah, catatan, status) VALUES ($user_id, '$bulan', $jumlah, '$catatan', 'menunggu')");
    }
}
?>

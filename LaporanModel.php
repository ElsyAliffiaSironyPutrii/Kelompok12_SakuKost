<?php
class LaporanModel {
    private $db;

    public function __construct($koneksi) {
        $this->db = $koneksi;
    }

    public function getAllLaporan() {
        return mysqli_query($this->db, "SELECT l.*, u.nama, u.kamar FROM laporan l JOIN users u ON l.user_id = u.id ORDER BY l.tanggal DESC");
    }

    public function getLaporanById($id) {
        $id = (int)$id;
        return mysqli_fetch_assoc(mysqli_query($this->db, "SELECT l.*, u.nama, u.kamar FROM laporan l JOIN users u ON l.user_id = u.id WHERE l.id=$id"));
    }

    public function hapusLaporan($id) {
        $id = (int)$id;
        return mysqli_query($this->db, "DELETE FROM laporan WHERE id=$id");
    }

    public function getRiwayatUser($user_id) {
        $user_id = (int)$user_id;
        return mysqli_query($this->db, "SELECT * FROM laporan WHERE user_id=$user_id ORDER BY tanggal DESC");
    }

    public function tambahLaporan($user_id, $fasilitas, $lokasi, $deskripsi) {
        $user_id   = (int)$user_id;
        $fasilitas = mysqli_real_escape_string($this->db, strip_tags(trim($fasilitas)));
        $lokasi    = mysqli_real_escape_string($this->db, strip_tags(trim($lokasi)));
        $deskripsi = mysqli_real_escape_string($this->db, strip_tags(trim($deskripsi)));
        return mysqli_query($this->db, "INSERT INTO laporan (user_id, fasilitas, lokasi, deskripsi, status_laporan) VALUES ($user_id, '$fasilitas', '$lokasi', '$deskripsi', 'Pending')");
    }

    public function ubahLaporanUser($id, $fasilitas, $lokasi, $deskripsi) {
        $id        = (int)$id;
        $fasilitas = mysqli_real_escape_string($this->db, strip_tags(trim($fasilitas)));
        $lokasi    = mysqli_real_escape_string($this->db, strip_tags(trim($lokasi)));
        $deskripsi = mysqli_real_escape_string($this->db, strip_tags(trim($deskripsi)));
        return mysqli_query($this->db, "UPDATE laporan SET fasilitas='$fasilitas', lokasi='$lokasi', deskripsi='$deskripsi' WHERE id=$id");
    }

    public function updateStatusLaporan($id, $status) {
        $id     = (int)$id;
        $status = mysqli_real_escape_string($this->db, $status);
        return mysqli_query($this->db, "UPDATE laporan SET status_laporan='$status' WHERE id=$id");
    }
}
?>
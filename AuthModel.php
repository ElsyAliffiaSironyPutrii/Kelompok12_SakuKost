<?php
class AuthModel {
    private $db;

    public function __construct($koneksi) {
        $this->db = $koneksi;
    }

    public function login($username) {
        $username = mysqli_real_escape_string($this->db, strip_tags(trim($username)));
        $result = mysqli_query($this->db, "SELECT * FROM users WHERE username='$username'");
        return mysqli_fetch_assoc($result);
    }

    public function cekUsername($username) {
        $username = mysqli_real_escape_string($this->db, strip_tags(trim($username)));
        $cek = mysqli_query($this->db, "SELECT username FROM users WHERE username='$username'");
        return mysqli_num_rows($cek) > 0;
    }

    public function register($username, $password, $nama, $email, $hp, $kamar) {
        $username = mysqli_real_escape_string($this->db, strip_tags(trim($username)));
        $nama     = mysqli_real_escape_string($this->db, strip_tags(trim($nama)));
        $email    = mysqli_real_escape_string($this->db, strip_tags(trim($email)));
        $hp       = mysqli_real_escape_string($this->db, strip_tags(trim($hp)));
        $kamar    = mysqli_real_escape_string($this->db, strip_tags(trim($kamar)));
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (username, password, nama, email, hp, role, kamar) VALUES ('$username', '$password_hash', '$nama', '$email', '$hp', 'user', '$kamar')";
        return mysqli_query($this->db, $query);
    }

    public function updateProfil($id, $nama, $email, $hp) {
        $id    = (int)$id;
        $nama  = mysqli_real_escape_string($this->db, strip_tags(trim($nama)));
        $email = mysqli_real_escape_string($this->db, strip_tags(trim($email)));
        $hp    = mysqli_real_escape_string($this->db, strip_tags(trim($hp)));
        return mysqli_query($this->db, "UPDATE users SET nama='$nama', email='$email', hp='$hp' WHERE id=$id");
    }

    public function getUserById($id) {
        $id = (int)$id;
        $result = mysqli_query($this->db, "SELECT * FROM users WHERE id=$id");
        return mysqli_fetch_assoc($result);
    }

    public function getPenghuni($keyword = "") {
        if ($keyword != "") {
            $keyword = mysqli_real_escape_string($this->db, strip_tags(trim($keyword)));
            return mysqli_query($this->db, "
                SELECT u.id, u.nama, u.kamar,
                    CASE 
                        WHEN (SELECT COUNT(*) FROM pembayaran p WHERE p.user_id = u.id AND p.status = 'menunggu') > 0 
                        THEN 'menunggak' 
                        ELSE 'lunas' 
                    END as status_bayar
                FROM users u 
                WHERE u.role = 'user' AND u.kamar IS NOT NULL AND (u.nama LIKE '%$keyword%' OR u.kamar LIKE '%$keyword%')
                ORDER BY u.kamar
            ");
        } else {
            return mysqli_query($this->db, "
                SELECT u.id, u.nama, u.kamar,
                    CASE 
                        WHEN (SELECT COUNT(*) FROM pembayaran p WHERE p.user_id = u.id AND p.status = 'menunggu') > 0 
                        THEN 'menunggak' 
                        ELSE 'lunas' 
                    END as status_bayar
                FROM users u 
                WHERE u.role = 'user' AND u.kamar IS NOT NULL
                ORDER BY u.kamar
            ");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SakuKost - Daftar</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h2>📝 Registrasi Penyewa</h2>
            <p>Silakan isi berkas data diri Anda</p>
        </div>
        <?php if ($error): ?>
            <div class="alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <?php if ($sukses): ?>
            <div class="alert-success"><?= $sukses ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" required autocomplete="off">
            </div>
            <div class="form-group">
                <label>Nomor HP Aktif</label>
                <input type="text" name="hp" required autocomplete="off">
            </div>
            <div class="form-group">
                <label>Alamat Email</label>
                <input type="email" name="email" required autocomplete="off">
            </div>
            <div class="form-group">
                <label>Pilih Nomor Kamar</label>
                <select name="kamar" required>
                    <option value="">-- Pilih Kamar Tersedia --</option>
                    <?php while ($k = mysqli_fetch_assoc($kamar_tersedia)): ?>
                        <option value="<?= $k['no_kamar'] ?>">Kamar <?= $k['no_kamar'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Username Baru</label>
                <input type="text" name="username" required autocomplete="off">
            </div>
            <div class="form-group">
                <label>Password Akun</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn-block">Daftar Sekarang</button>
        </form>
        <div class="auth-footer">
            Sudah terdaftar sebagai penghuni? <a href="index.php">Masuk Di Sini</a>
        </div>
    </div>
</div>
</body>
</html>
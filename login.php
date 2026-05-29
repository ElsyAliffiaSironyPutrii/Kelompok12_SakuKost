<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SakuKost - Masuk</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h2>🏠 SakuKost</h2>
            <p>Sistem Pengelolaan Rumah Kost Digital</p>
        </div>
        <?php if ($error): ?>
            <div class="alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'timeout'): ?>
            <div class="alert-danger">Sesi Anda telah berakhir karena tidak ada aktivitas.</div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required autocomplete="off">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn-block">Masuk Ke Akun</button>
        </form>
        <div class="auth-footer">
            Belum punya akun penyewa? <a href="index.php?page=register">Daftar Sekarang</a>
        </div>
    </div>
</div>
</body>
</html>
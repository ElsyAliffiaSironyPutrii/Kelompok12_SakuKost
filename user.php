<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SakuKost - Penghuni</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="main-layout">
    <nav class="sidebar">
        <div class="sidebar-header">
            <div class="logo-icon">🏠</div>
            <h3>SakuKost</h3>
            <p>Panel Penghuni</p>
        </div>
        <div class="sidebar-user">
            <div class="avatar">U</div>
            <div class="info">
                <div class="nama"><?= htmlspecialchars($_SESSION['nama']) ?></div>
                <div class="role">Kamar <?= htmlspecialchars($_SESSION['kamar']) ?></div>
            </div>
        </div>
        <ul>
            <li class="<?= $hal_aktif == 'dashboard' ? 'aktif' : '' ?>"><a href="index.php?page=user&hal=dashboard"><span class="icon">📊</span> Info Kamar</a></li>
            <li class="<?= $hal_aktif == 'pembayaran' ? 'aktif' : '' ?>"><a href="index.php?page=user&hal=pembayaran"><span class="icon">💰</span> Pembayaran</a></li>
            <li class="<?= $hal_aktif == 'laporan' ? 'aktif' : '' ?>"><a href="index.php?page=user&hal=laporan"><span class="icon">🔧</span> Lapor Kerusakan</a></li>
            <div class="sidebar-divider"></div>
            <li class="<?= $hal_aktif == 'profil' ? 'aktif' : '' ?>"><a href="index.php?page=user&hal=profil"><span class="icon">👤</span> Profil Saya</a></li>
            <li class="logout-item"><a href="logout.php"><span class="icon">🚪</span> Keluar</a></li>
        </ul>
    </nav>
    <main class="content">
        <?php if ($pesan_aksi): ?><div class="notif-box"><?= $pesan_aksi ?></div><?php endif; ?>

        <?php if ($hal_aktif == 'dashboard'): ?>
        <div class="page-header"><div><h1>🚪 Informasi Kamar</h1><p>Detail hunian Anda</p></div></div>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">🔑</div>
                <div class="stat-info"><h4>Nomor Kamar</h4><p><?= htmlspecialchars($kamar_info['no_kamar']) ?></p></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">🛏️</div>
                <div class="stat-info"><h4>Tipe Kamar</h4><p><?= htmlspecialchars($kamar_info['tipe']) ?></p></div>
            </div>
            <div class="stat-card hijau">
                <div class="stat-icon">💵</div>
                <div class="stat-info"><h4>Biaya Bulanan</h4><p>Rp <?= number_format($kamar_info['harga'], 0, ',', '.') ?></p></div>
            </div>
        </div>

        <?php elseif ($hal_aktif == 'pembayaran'): ?>
        <div class="page-header"><div><h1>💰 Riwayat & Tagihan</h1></div></div>
        <div style="display: flex; gap: 30px; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 300px;">
                <h3>Form Pembayaran Bulanan</h3><br>
                <form method="POST" action="index.php?page=user&hal=pembayaran" class="form-container" style="max-width: 100%;">
                    <input type="hidden" name="kirim_pembayaran" value="1">
                    <label>Untuk Bulan</label>
                    <select name="bulan" required>
                        <option value="Januari 2026">Januari 2026</option>
                        <option value="Februari 2026">Februari 2026</option>
                        <option value="Maret 2026">Maret 2026</option>
                        <option value="April 2026">April 2026</option>
                        <option value="Mei 2026">Mei 2026</option>
                        <option value="Juni 2026">Juni 2026</option>
                    </select>
                    <label>Jumlah Transfer (Rp)</label>
                    <input type="number" name="jumlah" value="<?= $kamar_info['harga'] ?>" required>
                    <label>Catatan</label>
                    <textarea name="catatan" rows="3" placeholder="Keterangan transfer"></textarea>
                    <button type="submit" class="btn-simpan" style="background:#3498db;">Kirim Bukti Bayar</button>
                </form>
            </div>
            <div style="flex: 1.5; min-width: 350px;">
                <h3>Log Transaksi</h3><br>
                <div class="table-container">
                    <table>
                        <tr><th>Bulan</th><th>Jumlah</th><th>Status</th></tr>
                        <?php while ($p = mysqli_fetch_assoc($riwayat_pembayaran)): ?>
                        <tr>
                            <td><?= htmlspecialchars($p['bulan']) ?></td>
                            <td>Rp <?= number_format($p['jumlah'], 0, ',', '.') ?></td>
                            <td>
                                <?php if ($p['status'] == 'menunggu'): ?><span style="color:#f39c12;">⏳ Proses</span>
                                <?php elseif ($p['status'] == 'diterima'): ?><span style="color:#2ecc71;">✅ Diterima</span>
                                <?php else: ?><span style="color:#e74c3c;">❌ Ditolak</span><?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </table>
                </div>
            </div>
        </div>

        <?php elseif ($hal_aktif == 'laporan'): ?>
        <div class="page-header"><div><h1>🔧 Modul Keluhan Fasilitas (CRUD Modul 2 - User Side)</h1><p>Laporkan kendala, lihat status, ubah data laporan, atau batalkan aduan</p></div></div>
        <div style="display: flex; gap: 30px; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 300px;">
                <h3><?= $laporan_edit ? '✏️ Ubah Keluhan Anda' : '📝 Buat Keluhan Baru' ?></h3><br>
                <form method="POST" action="index.php?page=user&hal=laporan" class="form-container" style="max-width: 100%;">
                    <?php if ($laporan_edit): ?>
                        <input type="hidden" name="ubah_laporan" value="1">
                        <input type="hidden" name="id_laporan" value="<?= $laporan_edit['id'] ?>">
                    <?php else: ?>
                        <input type="hidden" name="kirim_laporan" value="1">
                    <?php endif; ?>
                    <label>Nama Fasilitas</label>
                    <input type="text" name="fasilitas" value="<?= $laporan_edit ? htmlspecialchars($laporan_edit['fasilitas']) : '' ?>" required>
                    <label>Lokasi</label>
                    <input type="text" name="lokasi" value="<?= $laporan_edit ? htmlspecialchars($laporan_edit['lokasi']) : '' ?>" required>
                    <label>Deskripsi Kerusakan</label>
                    <textarea name="deskripsi" rows="4" required><?= $laporan_edit ? htmlspecialchars($laporan_edit['deskripsi']) : '' ?></textarea>
                    <button type="submit" class="btn-simpan" style="background:#e67e22; margin-top:10px;"><?= $laporan_edit ? 'Simpan Perubahan' : 'Kirim Aduan' ?></button>
                    <?php if ($laporan_edit): ?>
                        <a href="index.php?page=user&hal=laporan" style="display:block; text-align:center; margin-top:10px; color:#e74c3c; text-decoration:none;">Batal</a>
                    <?php endif; ?>
                </form>
            </div>
            <div style="flex: 1.5; min-width: 350px;">
                <h3>Daftar Pengaduan Anda</h3><br>
                <div class="table-container">
                    <table>
                        <tr><th>Fasilitas</th><th>Deskripsi</th><th>Status Keluhan</th><th>Aksi</th></tr>
                        <?php while ($l = mysqli_fetch_assoc($riwayat_laporan)): ?>
                        <tr>
                            <td><?= htmlspecialchars($l['fasilitas']) ?></td>
                            <td><?= htmlspecialchars($l['deskripsi']) ?></td>
                            <td>
                                <?php if ($l['status_laporan'] == 'Pending'): ?><span style="color:#e74c3c;">⏳ Pending</span>
                                <?php elseif ($l['status_laporan'] == 'Diproses'): ?><span style="color:#3498db;">⚙️ Diproses</span>
                                <?php else: ?><span style="color:#2ecc71;">✅ Selesai</span><?php endif; ?>
                            </td>
                            <td>
                                <?php if ($l['status_laporan'] == 'Pending'): ?>
                                    <a href="index.php?page=user&hal=laporan&aksi=edit_laporan&id=<?= $l['id'] ?>" style="color:#3498db; text-decoration:none; margin-right:10px;">✏️ Edit</a>
                                    <a href="index.php?page=user&hal=laporan&aksi=hapus_laporan&id=<?= $l['id'] ?>" class="btn-deny" style="background:none; border:none; padding:0; color:#e74c3c;">🗑️ Tarik</a>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </table>
                </div>
            </div>
        </div>

        <?php elseif ($hal_aktif == 'profil'): ?>
        <div class="page-header"><div><h1>👤 Pengaturan Akun</h1></div></div>
        <form method="POST" action="index.php?page=user&hal=profil">
            <input type="hidden" name="simpan_profil" value="1">
            <div class="form-container">
                <label>Nama Lengkap</label><input type="text" name="nama" value="<?= htmlspecialchars($user_info['nama']) ?>" required>
                <label>Email</label><input type="email" name="email" value="<?= htmlspecialchars($user_info['email']) ?>" required>
                <label>Nomor HP</label><input type="text" name="hp" value="<?= htmlspecialchars($user_info['hp']) ?>" required>
                <button type="submit" class="btn-simpan">💾 Simpan Perubahan</button>
            </div>
        </form>
        <?php endif; ?>
    </main>
</div>
<script src="script.js"></script>
</body>
</html>
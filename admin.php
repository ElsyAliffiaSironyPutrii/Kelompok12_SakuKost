<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SakuKost - Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="main-layout">
    <nav class="sidebar">
        <div class="sidebar-header">
            <div class="logo-icon">🏠</div>
            <h3>SakuKost</h3>
            <p>Panel Admin</p>
        </div>
        <div class="sidebar-user">
            <div class="avatar">A</div>
            <div class="info">
                <div class="nama"><?= htmlspecialchars($_SESSION['nama']) ?></div>
                <div class="role">Pemilik Kost</div>
            </div>
        </div>
        <ul>
            <li class="<?= $hal_aktif == 'dashboard' ? 'aktif' : '' ?>"><a href="index.php?page=admin&hal=dashboard"><span class="icon">📊</span> Dashboard</a></li>
            <li class="<?= $hal_aktif == 'kamar' ? 'aktif' : '' ?>"><a href="index.php?page=admin&hal=kamar"><span class="icon">🚪</span> Data Kamar</a></li>
            <li class="<?= $hal_aktif == 'penghuni' ? 'aktif' : '' ?>"><a href="index.php?page=admin&hal=penghuni"><span class="icon">👥</span> Data Penghuni</a></li>
            <li class="<?= $hal_aktif == 'pembayaran' ? 'aktif' : '' ?>"><a href="index.php?page=admin&hal=pembayaran"><span class="icon">💰</span> Konfirmasi Bayar</a></li>
            <li class="<?= $hal_aktif == 'laporan' ? 'aktif' : '' ?>"><a href="index.php?page=admin&hal=laporan"><span class="icon">🔧</span> Laporan Fasilitas</a></li>
            <div class="sidebar-divider"></div>
            <li class="<?= $hal_aktif == 'profil' ? 'aktif' : '' ?>"><a href="index.php?page=admin&hal=profil"><span class="icon">👤</span> Profil Saya</a></li>
            <li class="logout-item"><a href="logout.php"><span class="icon">🚪</span> Keluar</a></li>
        </ul>
    </nav>
    <main class="content">
        <?php if ($hal_aktif == 'dashboard'): ?>
        <div class="page-header">
            <div>
                <h1>📊 Dashboard Pemilik</h1>
                <p>Selamat datang kembali, <?= htmlspecialchars($_SESSION['nama']) ?>!</p>
            </div>
        </div>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">🚪</div>
                <div class="stat-info"><h4>Total Kamar</h4><p><?= $total_kamar ?></p></div>
            </div>
            <div class="stat-card hijau">
                <div class="stat-icon">✅</div>
                <div class="stat-info"><h4>Kamar Terisi</h4><p><?= $kamar_terisi ?></p></div>
            </div>
            <div class="stat-card merah">
                <div class="stat-icon">⏳</div>
                <div class="stat-info"><h4>Menunggu Konfirmasi</h4><p><?= $tunggakan ?> Bayar</p></div>
            </div>
        </div>

        <?php elseif ($hal_aktif == 'kamar'): ?>
        <div class="page-header"><div><h1>🚪 Kelola Kamar (CRUD Modul 1)</h1><p>Tambah, Lihat, Update, dan Hapus Kamar Kost</p></div></div>
        <div style="display: flex; gap: 30px; flex-wrap: wrap; margin-top: 20px;">
            <div style="flex: 1; min-width: 280px;">
                <h3><?= $kamar_edit ? '📝 Form Edit Kamar' : '➕ Tambah Kamar Baru' ?></h3><br>
                <form method="POST" action="index.php?page=admin&hal=kamar" class="form-container" style="max-width: 100%;">
                    <?php if ($kamar_edit): ?>
                        <input type="hidden" name="ubah_kamar" value="1">
                        <input type="hidden" name="no_kamar_lama" value="<?= htmlspecialchars($kamar_edit['no_kamar']) ?>">
                    <?php else: ?>
                        <input type="hidden" name="tambah_kamar" value="1">
                    <?php endif; ?>
                    <label>Nomor Kamar</label>
                    <input type="text" name="no_kamar" value="<?= $kamar_edit ? htmlspecialchars($kamar_edit['no_kamar']) : '' ?>" required>
                    <label>Tipe Kamar</label>
                    <input type="text" name="tipe" placeholder="Contoh: Eksklusif, Standar" value="<?= $kamar_edit ? htmlspecialchars($kamar_edit['tipe']) : '' ?>" required>
                    <label>Harga Bulanan (Rp)</label>
                    <input type="number" name="harga" value="<?= $kamar_edit ? htmlspecialchars($kamar_edit['harga']) : '' ?>" required>
                    <label>Status Hunian</label>
                    <select name="status" required>
                        <option value="tersedia" <?= $kamar_edit && $kamar_edit['status'] == 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
                        <option value="terisi" <?= $kamar_edit && $kamar_edit['status'] == 'terisi' ? 'selected' : '' ?>>Terisi</option>
                    </select>
                    <button type="submit" class="btn-simpan" style="background:#2ecc71; margin-top:10px;"><?= $kamar_edit ? 'Simpan Perubahan' : 'Tambah Kamar' ?></button>
                    <?php if ($kamar_edit): ?>
                        <a href="index.php?page=admin&hal=kamar" style="display:block; text-align:center; margin-top:10px; color:#e74c3c; text-decoration:none;">Batal Edit</a>
                    <?php endif; ?>
                </form>
            </div>
            <div style="flex: 2; min-width: 400px;">
                <h3>Daftar Seluruh Kamar</h3><br>
                <div class="table-container">
                    <table>
                        <tr><th>No Kamar</th><th>Tipe</th><th>Harga</th><th>Status</th><th>Aksi</th></tr>
                        <?php while ($k = mysqli_fetch_assoc($data_kamar)): ?>
                        <tr>
                            <td><?= htmlspecialchars($k['no_kamar']) ?></td>
                            <td><?= htmlspecialchars($k['tipe']) ?></td>
                            <td>Rp <?= number_format($k['harga'], 0, ',', '.') ?></td>
                            <td><span class="<?= $k['status'] == 'terisi' ? 'status-terisi' : 'status-tersedia' ?>"><?= ucfirst($k['status']) ?></span></td>
                            <td>
                                <a href="index.php?page=admin&aksi=edit_kamar&id=<?= $k['no_kamar'] ?>" style="color:#3498db; text-decoration:none; margin-right:10px;">✏️ Edit</a>
                                <a href="index.php?page=admin&aksi=hapus_kamar&id=<?= $k['no_kamar'] ?>" class="btn-deny" style="color:#e74c3c; text-decoration:none; background:none; padding:0;">🗑️ Hapus</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </table>
                </div>
            </div>
        </div>

        <?php elseif ($hal_aktif == 'penghuni'): ?>
        <div class="page-header"><div><h1>👥 Data Penghuni</h1><p>Daftar semua penyewa kost aktif</p></div></div>
        <div style="margin-bottom: 20px;">
            <form method="POST" action="index.php?page=admin&hal=penghuni" style="display: flex; gap: 10px;">
                <input type="text" name="keyword" placeholder="Cari nama atau nomor kamar..." value="<?= htmlspecialchars($keyword) ?>" style="padding: 8px 12px; border: 1px solid #ccc; border-radius: 4px; width: 250px;">
                <button type="submit" style="padding: 8px 15px; background: #3498db; color: white; border: none; border-radius: 4px; cursor: pointer;">🔍 Cari</button>
            </form>
        </div>
        <div class="table-container">
            <table>
                <tr><th>Nama Penghuni</th><th>No Kamar</th><th>Status Pembayaran</th></tr>
                <?php while ($p = mysqli_fetch_assoc($data_penghuni)): ?>
                <tr>
                    <td><?= htmlspecialchars($p['nama']) ?></td>
                    <td><?= htmlspecialchars($p['kamar']) ?></td>
                    <td><span class="<?= $p['status_bayar'] == 'lunas' ? 'status-ok' : 'status-no' ?>"><?= $p['status_bayar'] == 'lunas' ? '✅ Lunas' : '❌ Menunggak' ?></span></td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>

        <?php elseif ($hal_aktif == 'pembayaran'): ?>
        <div class="page-header"><div><h1>💰 Konfirmasi Pembayaran</h1><p>Periksa bukti transaksi iuran</p></div></div>
        <div class="table-container">
            <table>
                <tr><th>Nama</th><th>Kamar</th><th>Bulan</th><th>Jumlah</th><th>Catatan</th><th>Aksi</th></tr>
                <?php $ada = false; while ($p = mysqli_fetch_assoc($data_pembayaran)): $ada = true; ?>
                <tr>
                    <td><?= htmlspecialchars($p['nama']) ?></td>
                    <td><?= htmlspecialchars($p['kamar']) ?></td>
                    <td><?= htmlspecialchars($p['bulan']) ?></td>
                    <td>Rp <?= number_format($p['jumlah'], 0, ',', '.') ?></td>
                    <td><?= htmlspecialchars($p['catatan']) ?: '-' ?></td>
                    <td>
                        <a href="index.php?page=admin&aksi=terima&id=<?= $p['id'] ?>" class="btn-acc">✅ Terima</a>
                        <a href="index.php?page=admin&aksi=tolak&id=<?= $p['id'] ?>" class="btn-deny">❌ Tolak</a>
                    </td>
                </tr>
                <?php endwhile; if (!$ada): ?>
                <tr><td colspan="6" style="text-align:center; color:#888; padding:25px;">Tidak ada antrean pembayaran.</td></tr>
                <?php endif; ?>
            </table>
        </div>

        <?php elseif ($hal_aktif == 'laporan'): ?>
        <div class="page-header"><div><h1>🔧 Laporan Keluhan Fasilitas (CRUD Modul 2)</h1><p>Melihat, Memproses status, dan Menghapus Pengaduan</p></div></div>
        <div class="table-container">
            <table>
                <tr><th>Pengirim</th><th>Kamar</th><th>Fasilitas</th><th>Lokasi</th><th>Deskripsi</th><th>Status</th><th>Aksi</th></tr>
                <?php $ada = false; while ($l = mysqli_fetch_assoc($data_laporan)): $ada = true; ?>
                <tr>
                    <td><?= htmlspecialchars($l['nama']) ?></td>
                    <td><?= htmlspecialchars($l['kamar']) ?></td>
                    <td><?= htmlspecialchars($l['fasilitas']) ?></td>
                    <td><?= htmlspecialchars($l['lokasi']) ?></td>
                    <td><?= htmlspecialchars($l['deskripsi']) ?></td>
                    <td>
                        <?php if ($l['status_laporan'] == 'Pending'): ?><span style="color:#e74c3c; font-weight:bold;">⏳ Pending</span>
                        <?php elseif ($l['status_laporan'] == 'Diproses'): ?><span style="color:#3498db; font-weight:bold;">⚙️ Diproses</span>
                        <?php else: ?><span style="color:#2ecc71; font-weight:bold;">✅ Selesai</span><?php endif; ?>
                    </td>
                    <td>
                        <?php if ($l['status_laporan'] == 'Pending'): ?>
                            <a href="index.php?page=admin&aksi=proses_laporan&id=<?= $l['id'] ?>" style="color:#3498db; text-decoration:none; margin-right:10px;">⚙️ Proses</a>
                        <?php endif; ?>
                        <?php if ($l['status_laporan'] == 'Diproses'): ?>
                            <a href="index.php?page=admin&aksi=selesai_laporan&id=<?= $l['id'] ?>" style="color:#2ecc71; text-decoration:none; margin-right:10px;">✅ Selesai</a>
                        <?php endif; ?>
                        <a href="index.php?page=admin&aksi=hapus_laporan&id=<?= $l['id'] ?>" class="btn-deny" style="background:none; border:none; padding:0; color:#e74c3c;">🗑️ Hapus</a>
                    </td>
                </tr>
                <?php endwhile; if (!$ada): ?>
                <tr><td colspan="7" style="text-align:center; color:#888; padding:25px;">Belum ada laporan keluhan masuk.</td></tr>
                <?php endif; ?>
            </table>
        </div>

        <?php elseif ($hal_aktif == 'profil'): ?>
        <div class="page-header"><div><h1>👤 Profil Saya</h1></div></div>
        <?php if ($pesan_aksi): ?><div class="notif-box"><?= $pesan_aksi ?></div><?php endif; ?>
        <form method="POST" action="index.php?page=admin&hal=profil">
            <input type="hidden" name="simpan_profil" value="1">
            <div class="form-container">
                <label>Nama Lengkap</label><input type="text" name="nama" value="<?= htmlspecialchars($_SESSION['nama']) ?>" required>
                <label>Email</label><input type="email" name="email" value="<?= htmlspecialchars($_SESSION['email']) ?>">
                <label>Nomor HP</label><input type="text" name="hp" value="<?= htmlspecialchars($_SESSION['hp']) ?>">
                <button type="submit" class="btn-simpan">💾 Simpan Perubahan</button>
            </div>
        </form>
        <?php endif; ?>
    </main>
</div>
<script src="script.js"></script>
</body>
</html>
<?php
session_start();
if (!isset($_SESSION['login'])) { 
    header("Location: auth/login.php"); 
    exit; 
}
require 'config/koneksi.php';
$query = mysqli_query($conn, "SELECT * FROM barang");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <i class="fa-solid fa-cube fa-lg me-2"></i>INVENTORY MANAGEMENT SYSTEM
            </a>
            <div class="d-flex align-items-center">
                <div class="user-profile me-3">
                    <i class="fa-solid fa-user-circle text-primary me-2"></i>
                    <span class="small fw-bold"><?= htmlspecialchars($_SESSION['user']); ?></span>
                </div>
                <a href="auth/logout.php" class="btn btn-outline-danger btn-sm rounded-3" onclick="return confirm('Keluar dari sistem?')">
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row mb-5 align-items-center">
            <div class="col">
                <h2 class="fw-800 mb-1">Daftar Inventaris</h2>
            </div>
            <div class="col-auto">
                <button class="btn btn-primary shadow" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    <i class="fa-solid fa-plus-circle me-2"></i>Baru
                </button>
            </div>
        </div>

        <div class="card-table mt-4">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Produk</th>
                            <th>Status Stok</th>
                            <th>Harga Satuan</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i = 1; 
                        if(mysqli_num_rows($query) > 0):
                            while($row = mysqli_fetch_assoc($query)) : 
                        ?>
                        <tr>
                            <td class="text-muted fw-bold"><?= $i++; ?></td>
                            <td>
                                <span class="fw-bold d-block"><?= $row['nama_barang']; ?></span>
                                <span class="text-muted" style="font-size: 0.7rem;">ID: #00<?= $row['id']; ?></span>
                            </td>
                            <td><span class="badge-stok"><?= $row['stok']; ?> Unit</span></td>
                            <td class="fw-bold text-dark">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                            <td class="text-end">
                                <button class="btn-action text-warning me-2" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row['id']; ?>">
                                    <i class="fa-solid fa-pen-nib"></i>
                                </button>
                                <button class="btn-action text-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $row['id']; ?>">
                                    <i class="fa-solid fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>

                        <div class="modal fade" id="modalEdit<?= $row['id']; ?>" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="process/edit.php" method="POST">
                                        <div class="modal-header">
                                            <h5 class="fw-bold">Edit Informasi</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                            <div class="mb-3">
                                                <label class="form-label">Nama Barang</label>
                                                <input type="text" name="nama_barang" class="form-control" value="<?= $row['nama_barang']; ?>" required>
                                            </div>
                                            <div class="row">
                                                <div class="col-6 mb-3">
                                                    <label class="form-label">Stok</label>
                                                    <input type="number" name="stok" class="form-control" value="<?= $row['stok']; ?>" required>
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <label class="form-label">Harga</label>
                                                    <input type="number" name="harga" class="form-control" value="<?= $row['harga']; ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" name="update" class="btn btn-primary">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="modalHapus<?= $row['id']; ?>" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                <div class="modal-content text-center p-3">
                                    <div class="modal-body">
                                        <div class="text-danger mb-3">
                                            <i class="fa-solid fa-triangle-exclamation fa-4x"></i>
                                        </div>
                                        <h5 class="fw-bold">Konfirmasi Hapus</h5>
                                        <p class="small text-muted">Hapus <strong><?= $row['nama_barang']; ?></strong>?<br> Ini tidak dapat dibatalkan.</p>
                                        <div class="d-grid gap-2 mt-4">
                                            <a href="process/hapus.php?id=<?= $row['id']; ?>" class="btn btn-danger py-2 rounded-3">Hapus Sekarang</a>
                                            <button class="btn btn-light py-2 rounded-3" data-bs-dismiss="modal">Batal</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php 
                            endwhile; 
                        else:
                        ?>
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="opacity-25 mb-3">
                                    <i class="fa-solid fa-box-open fa-5x"></i>
                                </div>
                                <h6 class="fw-bold text-muted">Belum ada barang terdaftar</h6>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalTambah" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="process/tambah.php" method="POST">
                    <div class="modal-header">
                        <h5 class="fw-bold">Registrasi Barang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control" placeholder="Masukkan Nama Barang" required>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label">Stok Awal</label>
                                <input type="number" name="stok" class="form-control" placeholder="0" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">Harga Jual</label>
                                <input type="number" name="harga" class="form-control" placeholder="0" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="submit" class="btn btn-primary">Simpan Barang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
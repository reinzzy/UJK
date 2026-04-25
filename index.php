<?php
session_start();
if (!isset($_SESSION['login'])) { 
    header("Location: auth/login.php"); 
    exit; 
}
require 'config/koneksi.php';

$query = mysqli_query($conn, "SELECT barang.*, kategori.nama_kategori 
                              FROM barang 
                              LEFT JOIN kategori ON barang.id_kategori = kategori.id");

$data_barang = [];
while ($row = mysqli_fetch_assoc($query)) {
    $data_barang[] = $row;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Inventory</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="brand">Inventory System</div>
        <div class="user-box">
            <span><?= htmlspecialchars($_SESSION['user']); ?></span>
            <a href="auth/logout.php" class="btn btn-sm btn-light ms-3">Logout</a>
        </div>
    </div>
</nav>

<div class="container main-content">

    <!-- HEADER -->
    <div class="section-header">
        <div>
            <h3>Inventaris Barang</h3>
            <p>Manajemen stok dan data produk</p>
        </div>

        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
            Tambah Barang
        </button>
    </div>

    <!-- TABLE -->
    <div class="table-wrapper">
        <table class="table table-modern">
            <thead>
                <tr>
                    <th style="width:60px;">No</th>
                    <th>Produk</th>
                    <th>Kategori</th>
                    <th class="text-end">Stok</th>
                    <th class="text-end">Harga</th>
                    <th style="width:120px;"></th>
                </tr>
            </thead>
            <tbody>
            <?php if(count($data_barang) > 0): ?>
                <?php $i=1; foreach($data_barang as $row): ?>
                <tr>
                    <td class="text-muted"><?= $i++; ?></td>

                    <td>
                        <div class="item-name"><?= htmlspecialchars($row['nama_barang']); ?></div>
                        <div class="item-id">ID: <?= $row['id']; ?></div>
                    </td>

                    <td>
                        <span class="badge-soft">
                            <?= $row['nama_kategori'] ?? 'N/A'; ?>
                        </span>
                    </td>

                    <td class="text-end"><?= $row['stok']; ?></td>

                    <td class="text-end price">
                        Rp <?= number_format($row['harga'],0,',','.'); ?>
                    </td>

                    <td class="text-end">
                        <button class="action-link" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row['id']; ?>">
                            Edit
                        </button>
                        <a href="process/hapus.php?id=<?= $row['id']; ?>" class="action-link danger ms-2" onclick="return confirm('Hapus data?')">
                            Hapus
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">Belum ada data</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<!-- MODAL EDIT -->
<?php foreach($data_barang as $row): ?>
<div class="modal fade" id="modalEdit<?= $row['id']; ?>">
    <div class="modal-dialog">
        <form action="process/edit.php" method="POST" class="modal-content">
            <div class="modal-header">
                <h6>Edit Barang</h6>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" name="id" value="<?= $row['id']; ?>">

                <div class="mb-3">
                    <label>Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control" value="<?= htmlspecialchars($row['nama_barang']); ?>">
                </div>

                <div class="mb-3">
                    <label>Kategori</label>
                    <select name="id_kategori" class="form-select">
                        <?php
                        $kat = mysqli_query($conn, "SELECT * FROM kategori");
                        while($k = mysqli_fetch_assoc($kat)):
                        ?>
                        <option value="<?= $k['id']; ?>" <?= $k['id']==$row['id_kategori']?'selected':'' ?>>
                            <?= $k['nama_kategori']; ?>
                        </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="row">
                    <div class="col">
                        <label>Stok</label>
                        <input type="number" name="stok" class="form-control" value="<?= $row['stok']; ?>">
                    </div>
                    <div class="col">
                        <label>Harga</label>
                        <input type="number" name="harga" class="form-control" value="<?= $row['harga']; ?>">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
<?php endforeach; ?>

<!-- MODAL TAMBAH -->
<div class="modal fade" id="modalTambah">
    <div class="modal-dialog">
        <form action="process/tambah.php" method="POST" class="modal-content">
            <div class="modal-header">
                <h6>Tambah Barang</h6>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="text" name="nama_barang" class="form-control mb-3" placeholder="Nama barang">

                <select name="id_kategori" class="form-select mb-3">
                    <option value="">Pilih kategori</option>
                    <?php
                    $kat = mysqli_query($conn, "SELECT * FROM kategori");
                    while($k = mysqli_fetch_assoc($kat)):
                    ?>
                    <option value="<?= $k['id']; ?>"><?= $k['nama_kategori']; ?></option>
                    <?php endwhile; ?>
                </select>

                <div class="row">
                    <div class="col">
                        <input type="number" name="stok" class="form-control" placeholder="Stok">
                    </div>
                    <div class="col">
                        <input type="number" name="harga" class="form-control" placeholder="Harga">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
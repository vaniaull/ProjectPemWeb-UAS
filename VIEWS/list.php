<?php

include "../config.php";

// pagination
$limit = 10; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

//ambil data 
$total_result = mysql_query($conn, "SELECT COUNT(*) AS total FROM blog");
$total = mysqli_fetch_assoc($total_result)['total'];
$total_pages = ceil($total / $limit);

//ambil data perlimit
$data_result = mysql_query($conn, "SELECT * FROM blog LIMIT $start, $limit");
?>

<h2>Daftar Blog</h2>
<a href="from_create.php">+ Tambah Blog</a>

<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>No</th>
        <th>Judul</th>
        <th>Isi</th>
        <th>Aksi</th>
    </tr>
    <?php while($b = mysqli_fetch_assoc($data)) : ?>
    </tr>
        <td><?= $b['id']; ?></td>
        <td><?= htmlspecialchars($b['name']) ?></td>
        <td><?= htmlspecialchars($b['title']) ?></td>
        
        <td>
            <a href="from_edit.php?id=<?= $b['id']; ?>">edit</a> |
            <a href="../proses/delete.php?id=<?= $b['id']; ?>" onclick="return confirm('Hapus?');">Hapus</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<!-- Navigasi Halaman -->
 <div style="margin-top: 20px;">
    <?php if ($page > 1): ?>
        <a href="?page=<?= $page - 1 ?>"> Prev</a>
        <?php endif; ?>

    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?page=<?= $i ?>" <?= ($i == $page) ? 'font-weight: bold;"' : '' ?>">
        <?= $i ?>
        </a>
    <?php endfor; ?>

    <?php if ($page < $total_pages): ?>
        <a href="?page=<?= $page + 1 ?>">Next</a>
    <?php endif; ?>
</div>
<h2>Tambah Berita</h2>
<a href="list.php"> Kembali ke Daftar Berita</a>

<form action="../procces/create.php" method="POST"style="margin-top: 20px; max-width: 600px;">

    <label for="title"><strong>Judul</strong></label><br>
    <input type="text" name="title" placeholder="Judul buku"required style="width:100%; padding:8px;"><br><br>
    <label for="thumbnail" placeholder="Masukkan URL atau base64 gambar" rows="3" sytle="width:100%; padding:8px;"></textarea><br><br>

    <label><strong>Isi Konten:</strong></label><br>
    <textarea name="content[]" placeholder="paragraf 1" rows="4" style="width:100% padding:8px;"></textarea><br><br>
    
    <label><strong>
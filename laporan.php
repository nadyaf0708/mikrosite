<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan PKL</title>
  <link rel="stylesheet" href="assets/style.css">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #f0f5ff, #ffffff);
      margin: 0;
      display: flex;
    }

    /* ===== Sidebar ===== */
    .sidebar {
      width: 250px;
      height: 100vh;
      background: linear-gradient(180deg, #7caffcff, #0056b3);
      color: white;
      position: fixed;
      top: 0;
      left: 0;
      display: flex;
      flex-direction: column;
      padding: 20px;
      box-shadow: 2px 0 8px rgba(0,0,0,0.1);
    }

    .sidebar h2 {
      text-align: center;
      margin-bottom: 30px;
      font-size: 22px;
    }

    .sidebar a {
      color: white;
      text-decoration: none;
      padding: 12px 15px;
      margin: 6px 0;
      border-radius: 8px;
      display: block;
      transition: 0.3s;
    }

    .sidebar a:hover,
    .sidebar a.active {
      background: rgba(255,255,255,0.2);
    }

    /* ===== Main Content ===== */
    .main-content {
      margin-left: 250px;
      padding: 40px;
      width: calc(100% - 250px);
    }

    h1 {
      color: #0047b3;
      text-align: center;
      font-size: 28px;
      margin-bottom: 20px;
    }

    .form-card {
      background: linear-gradient(135deg, #e0f0ff, #ffffff);
      border: 1px solid #cddffb;
      padding: 20px;
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.08);
      margin-bottom: 25px;
      max-width: 700px;
      margin-left: auto;
      margin-right: auto;
    }

    .form-card h2 {
      text-align: center;
      color: #007bff;
      margin-bottom: 15px;
    }

    label {
      display: block;
      margin-top: 10px;
      color: #333;
      font-weight: 500;
    }

    input[type="text"], input[type="date"], textarea, input[type="file"] {
      width: 100%;
      padding: 10px;
      border-radius: 8px;
      border: 1px solid #ccc;
      margin-top: 5px;
    }

    textarea {
      resize: vertical;
      height: 80px;
    }

    .form-btn {
      background: linear-gradient(90deg, #007bff, #0062cc);
      color: white;
      border: none;
      border-radius: 8px;
      padding: 10px;
      font-size: 16px;
      cursor: pointer;
      width: 100%;
      margin-top: 15px;
      transition: 0.3s;
    }

    .form-btn:hover {
      background: linear-gradient(90deg, #0056b3, #004095);
    }

    .success-msg, .error-msg {
      padding: 10px;
      border-radius: 8px;
      text-align: center;
      margin-top: 15px;
    }

    .success-msg {
      background-color: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
    }

    .error-msg {
      background-color: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      border-radius: 10px;
      overflow: hidden;
    }

    th {
      background: #007bff;
      color: white;
      padding: 12px;
    }

    td {
      background: #fdfdfd;
      padding: 10px;
      text-align: center;
    }

    tr:nth-child(even) td {
      background: #f4f8ff;
    }

    footer {
      text-align: center;
      padding: 15px;
      margin-top: 40px;
      color: #666;
      font-size: 14px;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h2>📘 Mikrosite PKL</h2>
    <a href="index.php">🏠 Beranda</a>
    <a href="presensi.php">🧾 Presensi</a>
    <a href="agenda.php">🗓️ Agenda</a>
    <a href="laporan.php" class="active">📝 Laporan</a>
    <a href="foto.php">📸 Foto Kegiatan</a>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <h1>Laporan Kegiatan PKL</h1>

    <div class="form-card">
      <h2>Tambah Laporan</h2>
      <form method="POST" enctype="multipart/form-data">
        <label>Tanggal</label>
        <input type="date" name="tanggal" required>

        <label>Judul Laporan</label>
        <input type="text" name="judul" placeholder="Contoh: Laporan Mingguan 1" required>

        <label>Deskripsi</label>
        <textarea name="deskripsi" placeholder="Tuliskan ringkasan kegiatan yang dilakukan..." required></textarea>

        <label>Upload File (PDF/DOCX)</label>
        <input type="file" name="file_laporan" accept=".pdf,.doc,.docx" required>

        <button class="form-btn" type="submit" name="simpan">💾 Simpan Laporan</button>
      </form>

      <?php
      if (isset($_POST['simpan'])) {
        $tanggal = $_POST['tanggal'];
        $judul = $_POST['judul'];
        $deskripsi = $_POST['deskripsi'];

        $nama_file = $_FILES['file_laporan']['name'];
        $tmp = $_FILES['file_laporan']['tmp_name'];
        $folder = "uploads/laporan/";

        if (!file_exists($folder)) {
          mkdir($folder, 0777, true);
        }

        $path = $folder . basename($nama_file);

        if (move_uploaded_file($tmp, $path)) {
          $q = "INSERT INTO laporan (tanggal, judul, deskripsi, file) VALUES ('$tanggal','$judul','$deskripsi','$nama_file')";
          if (mysqli_query($koneksi, $q)) {
            echo "<p class='success-msg'>✅ Laporan berhasil disimpan!</p>";
          } else {
            echo "<p class='error-msg'>❌ Gagal menyimpan ke database.</p>";
          }
        } else {
          echo "<p class='error-msg'>⚠️ Upload file gagal.</p>";
        }
      }
      ?>
    </div>

    <h2>🗂️ Daftar Laporan</h2>
    <?php
    $data = mysqli_query($koneksi, "SELECT * FROM laporan ORDER BY tanggal DESC");
    if (mysqli_num_rows($data) > 0) {
      echo "<table><tr><th>No</th><th>Tanggal</th><th>Judul</th><th>Deskripsi</th><th>File</th></tr>";
      $no = 1;
      while ($row = mysqli_fetch_assoc($data)) {
        echo "<tr>
                <td>$no</td>
                <td>".date('d-m-Y', strtotime($row['tanggal']))."</td>
                <td>{$row['judul']}</td>
                <td>{$row['deskripsi']}</td>
                <td><a href='uploads/laporan/{$row['file']}' target='_blank'>📂 Lihat File</a></td>
              </tr>";
        $no++;
      }
      echo "</table>";
    } else {
      echo "<p style='text-align:center;color:#777;'>Belum ada laporan yang diunggah.</p>";
    }
    ?>

    <footer>
      &copy; 2025 Mikrosite PKL | Laporan Kegiatan
    </footer>
  </div>

</body>
</html>

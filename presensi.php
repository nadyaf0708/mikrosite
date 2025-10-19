<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Presensi PKL</title>
  <link rel="stylesheet" href="assets/style.css">
  <style>
    /* ====== Layout Dasar dengan Sidebar ====== */
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f4f7fa;
      display: flex;
    }

    /* ====== Sidebar ====== */
    .sidebar {
      width: 240px;
      background: linear-gradient(180deg, #7caffcff, #0047b3);
      color: white;
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      display: flex;
      flex-direction: column;
      box-shadow: 2px 0 10px rgba(0,0,0,0.2);
    }

    .sidebar h2 {
      text-align: center;
      padding: 25px 10px;
      border-bottom: 1px solid rgba(255,255,255,0.2);
      font-size: 20px;
    }

    .sidebar a {
      text-decoration: none;
      color: white;
      padding: 15px 25px;
      display: block;
      font-weight: 500;
      transition: 0.3s;
    }

    .sidebar a:hover, .sidebar a.active {
      background: rgba(255,255,255,0.2);
      border-left: 5px solid #fff;
      padding-left: 20px;
    }

    /* ====== Main Content ====== */
    .main-content {
      margin-left: 240px;
      padding: 40px 30px;
      flex: 1;
    }

    h1, h2 {
      color: rgba(14, 13, 13, 1);
      text-align: center;
    }

    /* ====== Card Form ====== */
    .form-card {
      background: linear-gradient(135deg, #e6f0ff, #ffffff);
      border: 1px solid #cddffb;
      padding: 25px;
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.08);
      margin: 30px auto;
      max-width: 700px;
      text-align: left;
    }

    label {
      display: block;
      margin-top: 10px;
      font-weight: 600;
    }

    input, select {
      width: 100%;
      padding: 10px;
      margin-top: 6px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 15px;
    }

    .form-btn {
      background: linear-gradient(90deg, #007bff, #0056d1);
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
      background: linear-gradient(90deg, #0056d1, #003c99);
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

    /* ====== Tabel ====== */
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 25px;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    th {
      background: #007bff;
      color: white;
      padding: 12px;
      text-align: center;
    }

    td {
      background: #fff;
      padding: 10px;
      text-align: center;
    }

    tr:nth-child(even) td {
      background: #f5f8ff;
    }

    footer {
      text-align: center;
      margin-top: 40px;
      color: #666;
    }
  </style>
</head>
<body>

<!-- ====== Sidebar ====== -->
<div class="sidebar">
  <h2>📋 Mikrosite PKL</h2>
  <a href="index.php">🏠 Dashboard</a>
  <a href="presensi.php" class="active">🧾 Presensi</a>
  <a href="agenda.php">🗓️ Agenda</a>
  <a href="laporan.php">📝 Laporan</a>
  <a href="foto.php">📸 Foto</a>
</div>

<!-- ====== Main Content ====== -->
<div class="main-content">
  <h1>Presensi Siswa PKL</h1>

  <div class="form-card">
    <h2>Form Presensi</h2>
    <form method="POST">
      <label>Nama Lengkap</label>
      <input type="text" name="nama" placeholder="Masukkan nama lengkap..." required>

      <label>Tanggal</label>
      <input type="date" name="tanggal" required>

      <label>Keterangan</label>
      <select name="keterangan" required>
        <option value="">-- Pilih Keterangan --</option>
        <option value="Hadir">Hadir</option>
        <option value="Izin">Izin</option>
        <option value="Sakit">Sakit</option>
        <option value="Alpha">Alpha</option>
      </select>

      <button class="form-btn" type="submit" name="simpan">💾 Simpan Presensi</button>
    </form>

    <?php
    if (isset($_POST['simpan'])) {
      $nama = $_POST['nama'];
      $tanggal = $_POST['tanggal'];
      $ket = $_POST['keterangan'];

      $q = "INSERT INTO presensi (nama, tanggal, keterangan) VALUES ('$nama','$tanggal','$ket')";
      if (mysqli_query($koneksi, $q)) {
        echo "<p class='success-msg'>✅ Data presensi berhasil disimpan!</p>";
      } else {
        echo "<p class='error-msg'>❌ Gagal menyimpan data. Coba lagi!</p>";
      }
    }
    ?>
  </div>

  <h2>📊 Data Presensi</h2>
  <?php
  $data = mysqli_query($koneksi, "SELECT * FROM presensi ORDER BY tanggal DESC");
  if (mysqli_num_rows($data) > 0) {
    echo "<table><tr><th>No</th><th>Nama</th><th>Tanggal</th><th>Keterangan</th></tr>";
    $no = 1;
    while ($row = mysqli_fetch_assoc($data)) {
      echo "<tr>
              <td>$no</td>
              <td>{$row['nama']}</td>
              <td>".date('d-m-Y', strtotime($row['tanggal']))."</td>
              <td>{$row['keterangan']}</td>
            </tr>";
      $no++;
    }
    echo "</table>";
  } else {
    echo "<p style='text-align:center;color:#777;'>Belum ada data presensi.</p>";
  }
  ?>

  <footer>
    <p>&copy; 2025 Mikrosite PKL | Presensi Siswa</p>
  </footer>
</div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Data</title>
    <link href="../css/tambah.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    <!-- NAVBAR -->
<nav class="navbar navbar-expand-md navbar-dark bg-primary">
    <div class="container-fluid mx-auto">
        <a class="navbar-brand" href="#">
            <img src="../images/Logo_alamanah.png" alt="Logo" width="50" height="50" class="d-inline-block align-text-center">
            SMA AL-AMANAH CIWIDEY
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarNav" aria-controls="navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Offcanvas -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="navbarNav" aria-labelledby="navbarNavLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="navbarNavLabel">Menu</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body" style="color: black;">
                <div class="navbar-nav ms-auto">
                    <a class="nav-link active text-end" aria-current="page" href="menuutama.php">Dashboard</a>
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle text-end" href="#" role="button" id="kelolaDataDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Kelola Data
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="kelolaDataDropdown">
                            <li><a class="dropdown-item" href="lihatdata.php">Lihat Data</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
<!-- End NAVBAR -->

<!-- Konten Utama -->
<div class="container">
    <h2 class="mt-4 mb-4">Tambah Data Siswa</h2>
    <form id="addDataForm" action="#" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nis">NIS:</label>
            <input type="text" class="form-control" id="nis" name="nis" required>
        </div>
        <div class="form-group">
            <label for="nama">Nama:</label>
            <input type="text" class="form-control" id="nama" name="nama" required>
        </div>
        <div class="form-group">
            <label for="tanggal">Tanggal:</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
        </div>
        <div class="form-group mt-3">
            <label for="url_image">Gambar:</label>
            <input type="file" class="form-control-file" id="url_image" name="url_image" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<!-- End Konten Utama -->

<!-- FOOTER -->
<footer class="footer mt-5 text-center-footer">
    <!-- Konten footer -->
    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto ">
                <p style="color: black;">&copy; 21552011107_HILMAN MUTAQIN_TIF RP 221PB_UASWEB1</p>
                <a href="https://sttbandung.ac.id/">SEKOLAH TINGGI TEKNOLOGI BANDUNG</a>
            </div>
        </div>
    </div>
</footer>

<!-- END FOOTER -->


    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> <!-- Add this line -->
    <script>
    document.getElementById('addDataForm').addEventListener('submit', function(event) {
        event.preventDefault();

        var formData = new FormData();
        formData.append('nis', document.getElementById('nis').value);
        formData.append('nama', document.getElementById('nama').value);
        formData.append('tanggal', document.getElementById('tanggal').value);
        formData.append('url_image', document.getElementById('url_image').files[0]);

        axios.post('https://web1hilmanmutaqin.000webhostapp.com/API/tambahsiswa.php', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function(response) {
                alert('Data berhasil ditambahkan!');
                // Bersihkan semua field
                document.getElementById('nis').value = '';
                document.getElementById('nama').value = '';
                document.getElementById('tanggal').value = '';
                document.getElementById('url_image').value = '';
            })
            .catch(function(error) {
                alert('Gagal menambahkan data: ' + error.response.data);
            });
    });
</script>

</body>
</html>

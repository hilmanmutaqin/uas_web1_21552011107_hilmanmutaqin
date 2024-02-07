<?php
include('check_session.php');

// Ambil ID dari $_POST
$id = isset($_POST['id']) ? $_POST['id'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data</title>
    <link href="../css/editdata.css" rel="stylesheet">
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
                                Edit Data
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
    <div class="container mt-5">
        <h2 class="mb-4">Edit Data Siswa</h2>

        <form id="editStudentForm">
            <div class="form-group">
                <label for="nis">NIS:</label>
                <input type="text" class="form-control" id="nis" name="nis" required>
            </div>

            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>

            <div class="form-grou mt-3">
                <label for="url_image">Image:</label>
                <input type="file" class="form-control-file" id="url_image" name="url_image" accept="image/*">
            </div>

            <button type="button" class="btn btn-primary" onclick="editStudent()">Edit Student Data</button>
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

    <!-- Include Axios library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.4/axios.min.js"></script>

    <script>
        function getData() {
            const studentId = "<?php echo $id; ?>";

            var formData = new FormData();
            formData.append('id', studentId);

            axios.post('https://web1hilmanmutaqin.000webhostapp.com/API/selectdata.php', formData)
                .then(function (response) {
                    document.getElementById('nis').value = response.data.nis;
                    document.getElementById('nama').value = response.data.nama;
                })
                .catch(function (error) {
                    console.error(error);
                    alert('Error fetching student data.');
                });
        }

        window.onload = getData;

        function editStudent() {
            const studentId = "<?php echo $id; ?>";
            const nis = document.getElementById("nis").value;
            const nama = document.getElementById("nama").value;
            const imageUrlInput = document.getElementById("url_image");
            const url_image = imageUrlInput.files[0];

            var formData = new FormData();
            formData.append("id", studentId);
            formData.append("nis", nis);
            formData.append("nama", nama);

            if (imageUrlInput.files.length > 0) {
                formData.append("url_image", url_image);
            }

            axios.post('https://web1hilmanmutaqin.000webhostapp.com/API/update_siswa.php', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            })
                .then(function (response) {
                    console.log(response.data);
                    alert(response.data); 
                    window.location.href = 'lihatdata.php'; 
                })
                .catch(function (error) {
                    console.error(error);
                    alert('Error editing student data.');
                });
        }
    </script>
</body>
</html>

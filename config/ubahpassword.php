<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Password</title>
    <link href="../css/ubahpassword.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-md navbar-dark bg-primary">
        <div class="container-fluid mx-auto">
            <a class="navbar-brand" href="#">
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
                        <a class="nav-link text-end" href="ubahpassword.php">Ubah Password</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- End NAVBAR -->

    <!-- Konten Utama -->
    <div class="container mt-5">
        <h2>Selamat datang <span id="loggedInUserName"></span></h2>

        <!-- Formulir Ubah Password -->
        <form id="changePasswordForm">
            <div class="mb-3">
                <label for="currentPassword" class="form-label">Password Saat Ini</label>
                <input type="password" class="form-control" id="currentPassword" name="currentPassword" required>
            </div>
            <div class="mb-3">
                <label for="newPassword" class="form-label">Password Baru</label>
                <input type="password" class="form-control" id="newPassword" name="newPassword" required>
            </div>
            <button type="submit" class="btn btn-primary">Ubah Password</button>
        </form>
        <!-- End Formulir Ubah Password -->
    </div>
    <!-- End Konten Utama -->
    
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


    <!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    // Script untuk menampilkan nama pengguna yang login
    var loggedInUserName = localStorage.getItem('nama');
    document.getElementById('loggedInUserName').innerText = loggedInUserName;


    function clearFormFields() {
        document.getElementById('currentPassword').value = '';
        document.getElementById('newPassword').value = '';
    }

    // Fungsi untuk mengubah password
    function changePassword(currentPassword, newPassword) {
        // Mendapatkan session_token dari localStorage
        const sessionToken = localStorage.getItem('session_token');
        
        // Objek data yang akan dikirimkan ke server
        const formData = new FormData();
        formData.append('username', loggedInUserName); 
        formData.append('currentPassword', currentPassword);
        formData.append('newPassword', newPassword);
        formData.append('session_token', sessionToken);

  
        axios.post('https://web1hilmanmutaqin.000webhostapp.com/API/proses_ubah_password.php', formData)
            .then(response => {
                if (response.data.status === 'success') {
                    alert('Password berhasil diubah');
                    clearFormFields(); 
                } else {
                  
                    alert('Gagal mengubah password: ' + response.data.message);
                }
            })
            .catch(error => {
                // Tangani kesalahan jika panggilan gagal
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengubah password');
            });
    }

    // Event listener untuk submit form
    document.getElementById('changePasswordForm').addEventListener('submit', function(event) {
        event.preventDefault(); 
        const currentPassword = document.getElementById('currentPassword').value;
        const newPassword = document.getElementById('newPassword').value;
        changePassword(currentPassword, newPassword); 
    });
</script>

</body>
</html>

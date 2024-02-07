<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Utama - SMA AL-AMANAH CIWIDEY</title>
    <link rel="stylesheet" href="../css/utama.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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
                        <a class="nav-link active text-end" aria-current="page" href="#">Dashboard</a>
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle text-end" href="#" role="button" id="kelolaDataDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                Kelola Data
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="kelolaDataDropdown">
                                <li><a class="dropdown-item" href="lihatdata.php">Lihat Data</a></li>
                                <li><a class="dropdown-item" href="tambahdata.php">Tambah Data</a></li> <!-- Tambahkan opsi untuk memanggil form tambahsiswa.php -->
                            </ul>
                        </div>
                        <a class="nav-link text-end" href="ubahpassword.php">Ubah Password</a>
                        <a class="nav-link text-end" href="#" onclick="Logout()">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- End NAVBAR -->

    <!-- Konten Utama -->
    <div class="container mt-5">
        <h2 id="welcomeMessage">Selamat datang</h2>
        <!-- kurva -->
        <div class="chart-container">
            <canvas id="myChart" style="max-width: 600px; max-height: 400px;"></canvas>
        </div>
        <!-- pilihan Unduh -->
        <div class="mt-3">
            <select id="tahunSelect">
                <option value="2019">2019</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
            </select>
            <button class="btn btn-primary" onclick="unduhPDF()">Unduh PDF</button>
            <button class="btn btn-primary" onclick="unduhExcel()">Unduh Excel</button>
        </div>
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

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- pdfmake -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>

    <script>
        document.getElementById('welcomeMessage').innerText = 'Selamat datang ' + localStorage.getItem('nama');

        function Logout() {
            // Mendapatkan session_token dari localStorage
            const sessionToken = localStorage.getItem('session_token');

            // Hapus nama dan session_token dari localStorage setelah logout
            localStorage.removeItem('nama');
            localStorage.removeItem('session_token');

            // Buat objek FormData
            const formData = new FormData();
            formData.append('session_token', sessionToken);

            // Konfigurasi axios untuk logout
            axios.post('https://web1hilmanmutaqin.000webhostapp.com/config/logout.php', formData)
                .then(response => {
                    console.log(response);
                    // Handle respons dari server
                    if (response.data.status === 'success') {

                        window.location.href = '../index.html';
                    } else {
                        // Jika logout gagal, tampilkan pesan kesalahan
                        alert('Logout Failed. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error during logout:', error);
                    alert('An error occurred during logout. Please try again later.');
                });
        }

        // Data dummy 
        const data = {
            labels: ["2019", "2020", "2021", "2022", "2023", "2024"],
            datasets: [{
                label: 'Jumlah Pengguna',
                data: [500, 700, 900, 1200, 1500, 1800],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };

        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'line',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Fungsi untuk mengunduh PDF
        function unduhPDF() {
            const canvas = document.getElementById('myChart');
            const imgData = canvas.toDataURL('image/png');
            const selectedYear = document.getElementById('tahunSelect').value;

            const docDefinition = {
                content: [{
                        text: 'Laporan Tahun ' + selectedYear,
                        style: 'header'
                    },
                    {
                        image: imgData,
                        width: 500
                    },
                ],
                styles: {
                    header: {
                        fontSize: 18,
                        bold: true,
                        margin: [0, 0, 0, 10],
                    },
                },
            };

            pdfMake.createPdf(docDefinition).download('laporan_' + selectedYear + '_pdf.pdf');
        }

        // Fungsi untuk mengunduh Excel
        function unduhExcel() {
            const data = myChart.data;
            const labels = data.labels;
            const datasets = data.datasets[0].data;

            const ws = XLSX.utils.aoa_to_sheet([
                ["Tahun", "Jumlah Pengguna"]
            ]);
            for (let i = 0; i < labels.length; i++) {
                XLSX.utils.sheet_add_aoa(ws, [
                    [labels[i], datasets[i]]
                ], {
                    origin: -1
                });
            }
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Grafik Pengguna");
            XLSX.writeFile(wb, "grafik_pengguna.xlsx");
        }
    </script>
</body>

</html>
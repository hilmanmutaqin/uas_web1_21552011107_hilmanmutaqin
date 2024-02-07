<?php
include('check_session.php')
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
    <link href="../css/lihatdata.css" rel="stylesheet">
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
                                <li><a class="dropdown-item text-dark" href="tambahdata.php">Tambah Data</a></li>
                            
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
        <h2 class="mb-4">Data Siswa</h2>
        <table id="newsTable" class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

  <!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Axios JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- DataTables JavaScript -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            var table = $('#newsTable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": function (data, callback, settings) {
                    axios.get('https://web1hilmanmutaqin.000webhostapp.com/API/datasiswa.php', {
                        params: {
                            key: data.search.value
                        }
                    })
                        .then(function (response) {
                            response.data.forEach(function (row, index) {
                                row.no = index + 1;
                            });

                            callback({
                                draw: data.draw,
                                recordsTotal: response.data.length,
                                recordsFiltered: response.data.length,
                                data: response.data
                            });
                        })
                        .catch(function (error) {
                            console.error(error);
                            alert('Error fetching data.');
                        });
                },
                "columns": [
                    { "data": "no" },
                    { "data": "nis" },
                    { "data": "nama" },
                    {
                        "data": "img",
                        "render": function (data, type, row) {
                            return '<img src="' + data + '" alt="Image" style="max-width: 100px; max-height: 100px;">';
                        }
                    },
                    {
                        "data": null,
                        "render": function (data, type, row) {
                            return '<button class="btn btn-danger btn-sm" onclick="deleteNews(' + row.id + ')">Delete</button>' +
                                '<form action="editdata.php" method="post">' +
                                '<input type="hidden" name="id" value="' + row.id + '">' +
                                '<button type="submit" class="btn btn-primary btn-sm">Edit</button>' +
                                '</form>';
                        }
                    }
                ]
            });
        });

        function deleteNews(id) {
            var formData = new FormData();
            formData.append('idnews', id);

            if (confirm("Apakah anda yakin ingin menghapus data siswa?")) {
                axios.post('https://web1hilmanmutaqin.000webhostapp.com/API/deletesiswa.php', formData)
                    .then(function (response) {
                        alert(response.data);
                        $('#newsTable').DataTable().ajax.reload();
                    })
                    .catch(function (error) {
                        console.error(error);
                        alert('Error deleting news.');
                    });
            }
        }
    </script>
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
</body>
</html>

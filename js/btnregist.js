document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("registerButton").addEventListener("click", function (event) {
        // Prevent the default form submission
        event.preventDefault();

        // Ambil nilai dari formulir
        var fullName = document.getElementById("inputName").value;
        var email = document.getElementById("inputEmail").value;
        var password = document.getElementById("inputPassword").value;

        // Validasi password sebelum mengirim ke server
        if (validatePassword(password)) {
            // Buat objek XMLHttpRequest
            var xhr = new XMLHttpRequest();

            // Tetapkan metode dan URL tujuan
            xhr.open("POST", "register.php", true);

            // Tetapkan tipe konten untuk POST
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            // Tangani respon dari server
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        // Parse respon JSON dari PHP
                        var response = JSON.parse(xhr.responseText);

                        // Tampilkan pesan dari server
                        alert(response.message);

                        // Jika pendaftaran berhasil, lakukan sesuatu (contoh: redirect)
                        if (response.success) {
                            window.location.href = "register.php";
                        }
                    } else {
                        // Tampilkan notifikasi popup untuk kesalahan
                        alert("Terjadi kesalahan. Silakan coba lagi.");
                    }
                }
            };

            // Kirim data ke server
            xhr.send("inputName=" + fullName + "&inputEmail=" + email + "&inputPassword=" + password);
        } else {
            // Tampilkan notifikasi popup jika validasi password tidak berhasil
            alert("Password tidak valid. Pastikan password memiliki panjang minimal, setidaknya satu simbol, dan setidaknya satu angka.");
        }
    });
});

// Validasi password
function validatePassword(password) {
    // Contoh validasi: minimal 8 karakter, setidaknya satu simbol, dan setidaknya satu angka
    var symbolRegex = /[!@#$%^&*(),.?":{}|<>]/; // Simbol yang diizinkan
    var numberRegex = /\d/; // Setidaknya satu angka

    return password.length >= 8 && symbolRegex.test(password) && numberRegex.test(password);
}

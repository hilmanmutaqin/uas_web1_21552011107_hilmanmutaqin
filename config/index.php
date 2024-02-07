<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
  async function checkSession() {
    try {
      // Get session_token
      const sessionToken = localStorage.getItem('session_token');

      if (!sessionToken) {
        window.location.href = 'login.html';
        return;
      }

      const formData = new FormData();
      formData.append('session_token', sessionToken);

      const response = await axios.post('https://web1hilmanmutaqin.000webhostapp.com/config/session.php', formData);

      if (response.data.status === 'success') {
        const name = response.data.hasil.name || 'Default Name';
        localStorage.setItem('nama', name);
        window.location.href = 'https://web1hilmanmutaqin.000webhostapp.com/config/menuutama.php';
      } else {
        window.location.href = '../login.html';
      }
    } catch (error) {
      console.error('Error during login:', error);
    }
  }

  checkSession();
</script>

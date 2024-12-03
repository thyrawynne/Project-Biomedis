function handleLogin(event) {
    event.preventDefault(); // Mencegah reload halaman
  
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
  
    if (username && password) {
      window.location.href = "index.html"; // Redirect ke halaman index
    } else {
      alert("Please fill in both fields.");
    }
  }
  
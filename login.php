<?php
session_start();
include 'koneksi.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $password = md5($_POST['password']);

  $query = "SELECT * FROM user WHERE username='$username' AND password='$password'";
  $result = mysqli_query($koneksi, $query);

  if (mysqli_num_rows($result) === 1) {
    $_SESSION['login'] = true;
    header("Location: index.php");
    exit;
  } else {
    $error = "Username atau password salah!";
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login SPK Apotek</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="min-height: 100vh;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <h4 class="text-center mb-4">Login SPK Apotek</h4>
            <?php if (!empty($error)) : ?>
              <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            <form method="POST">
              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" required autofocus>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
              </div>
              <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
          </div>
        </div>
        <p class="text-center mt-3 text-muted small">© <?= date('Y') ?> SPK Apotek</p>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
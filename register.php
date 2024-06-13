register.php
<?php

if (isset($_SESSION['logged_in_user']) && $_SESSION['logged_in_user']) {
  header('Location: index.php');
  exit;
}

$loginSuccessful = false;
$loginError = "";


if (isset($_POST['submit'])) {
  
  if ($_POST['submit'] === 'register') {
    
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['password'] = $_POST['password']; 
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING); 
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING); 

    // Gönderilen kimlik bilgilerinin saklanan (simüle edilen) kimlik bilgileriyle eşleşip eşleşmediğini kontrol
    if ($username === $_SESSION['username'] && $password === $_SESSION['password']) {
      $loginSuccessful = true;
      // Kullanıcıyı “Kişisel Muhasebe” sayfasına yönlendir
      $_SESSION['logged_in_user'] = true;
      header('Location: index.php'); //Gerekirse yönlendirme yolunu ayarlama
      exit;
    } else {
      $loginError = "Invalid username or password.";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş & Kayıt </title>
    <link rel="stylesheet" href="styl.css">
</head>

<body style="background-image: url('./Muhasebe.jpg');">
    
   

    <header>
        <h2 class="logo">Kişisel Muhasebe Sistemi</h2>
        <nav class="navigation">
            <?php
              // Oturum açma düğmesini koşullu olarak görüntüle
              if (!$loginSuccessful && !isset($_SESSION['username'])) {
                echo '<button class="btnLogin-popup">Login</button>';
              } else {
                echo '<button class="btnLogin-popup">Logout</button>';
              }
            ?>
         </nav>
    </header>

    <div class="wrapper">
         <span class="icon-close"><ion-icon name="close"></ion-icon></span>

        <div class="form-box login"> <?php if (!$loginSuccessful) : ?>
            <h2>Login</h2>
            <form action="" method="post">
                <input type="hidden" name="submit" value="login">
                <div class="input-box">
                    <span class="icon"><ion-icon name="mail"></ion-icon></span>
                    <input type="email" name="username" required>
                    <label>Email (Username)</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="lock"></ion-icon></span>
                    <input type="password" name="password" required>
                    <label>Şifre</label>
                </div>
                <?php
                  // Oturum açma başarısız olursa hata mesajını görüntüle
                  if ($loginError) {
                    echo "<p class='error'>$loginError</p>";
                  }
                ?>
                <div class="remember-forgot">
                    <label><input type="checkbox"> Hatırla beni</label>
                    <a href="#">Şifrenizi mi unuttunuz?</a>
                </div>
                <button type="submit" class="btn">Login</button>
                <div class="login-register">
                    <p>    Hesab mı yok?<a href="#" class="register-link">  Kayıt Olun</a></p>
                </div>
            </form>
            <?php endif; ?>
        </div>

        <div class="form-box register"> <?php if (!$loginSuccessful) : ?>
            <h2>Kayıt İşlemleri</h2>
            <form action="" method="post">
                <input type="hidden" name="submit" value="register">
                <div class="input-box">
                    <span class="icon"><ion-icon name="person"></ion-icon></span>
                    <input type="text" name="username" required>
                    <label>Username</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="mail"></ion-icon></span>
                    <input type="email" name="email" required>
                    <label>Email</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="lock"></ion-icon></span>
                    <input type="password" name="password" required>
                    <label>Şifre</label>
                </div>
                <div class="remember-forgot">
                    <label><input type="checkbox"> Şartlar ve koşulları kabul ediyorum</label>
                  
                </div>
                <button type="submit" class="btn">Kayıt</button>
                <div class="login-register">
                    <p> Zaten bir hesabınız var mı?<a href="#" class="login-link"> Login</a></p>
                </div>
            </form>
        </div>

        <?php endif; ?>

    </div>

    
        <script src="script.js"></script>
        <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>

    </body>

</html>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box;}

input[type=text], select, textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  margin-top: 6px;
  margin-bottom: 16px;
  resize: vertical;
}

input[type=submit], button {
  background-color: #04AA6D;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  margin-right: 10px;
}

input[type=submit]:hover, button:hover {
  background-color: #45a049;
}

.container {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}
</style>
</head>
<body style="background-image: url('./Muhasebe.jpg');">

<h3>Yorum yap</h3>

<div class="container">
  <form id="yorumForm" action="yorum.php" method="post">
    <label for="fname">İsim Soyisim</label>
    <input type="text" id="fname" name="isim" placeholder="İsim Soyisim giriniz..">

    <label for="lname">Telefon numarası</label>
    <input type="text" id="lname" name="tel" placeholder="Telefon numaranızı giriniz..">

    
    <label for="lname">Email</label>
    <input type="text" id="lname" name="mail" placeholder="Email giriniz..">
    <label for="lname">Konu</label>
    <input type="text" id="lname" name="konu" placeholder="Konu giriniz..">
    <label for="subject">Mesaj</label>
    <textarea id="subject" name="mesaj" placeholder="Yorum yazınız .." style="height:200px"></textarea>
    <input type="submit" value="Submit">
    <button type="button" onclick="goBack()">Geri dön</button>
  </form>
</div>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formdan gelen verileri al
    $isim = $_POST['isim'];
    $tel = $_POST['tel'];
    $mail = $_POST['mail'];
    $konu = $_POST['konu'];
    $mesaj = $_POST['mesaj'];

  echo "<div style='background-color: #f4f4f4; padding: 20px; border-radius: 5px;'>";
    echo "<h2 style='color: #333;'>Yorum için teşekkür ederim!</h2>";
 echo "<p style='color: #666;'>$isim, değerli yorumunuz için teşekkür ederim. Geri dönüş yapmak için sabırsızlanıyorum.</p>";
    echo "</div>";
}
?>
<script>
    function goBack() {
       window.history.back();
    }
</script>
</body>
</html>

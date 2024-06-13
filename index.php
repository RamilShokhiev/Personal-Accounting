<?php
session_start();

// Kullanıcının oturum açıp açmadığını kontrol (oturum açma mantığı)
if (!isset($_SESSION['logged_in_user']) || !$_SESSION['logged_in_user']) {
  // Kullanıcı oturum açmamış, kayıt formunu görüntüle
  include 'register.php';
} else {
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kişisel Muhasebe</title>
    <link rel="stylesheet" type="text/css" href="style.css" />

</head>
<body style="background-image: url('./Muhasebe.jpg');">
    <div class="container">
        <h1>Gelirlerin ve Giderlerin Hesaplayıcı</h1>
        <h2>Gelirler</h2>
        <form id="income-form" method="post">
            <select name="income_category">
                <option value="">Kategori Seçin</option>
                <option value=" Maaş"> Maaş </option>
                <option value=" Faiz Geliri"> Faiz Geliri </option>
                <option value=" Kira Geliri"> Kira Geliri </option>
                <option value=" Diğer"> Diğer </option>
            </select>
            <input type="text" name="income_name" placeholder="Gelirin ismi" required />
            <input type="number" name="income_amount" placeholder="Gelirin miktari" required min=0 />
            <input type="date" name="income_date" required />
            <button type="submit" name="add_income">
                Geliri ekle
            </button>
        </form>
         <div class="income-table">
            <table>
                <thead>
                    <tr>
                        <th>Kategori</th>
                        <th>Gelirin ismi</th>
                        <th>Gelir miktar</th>
                        <th>Tarih</th>
                        <th>Sil</th>
                    </tr>
                </thead>
                <tbody>
                    <?php include 'incomes.php'; ?>
                </tbody>
            </table>
            <div class="total-amount">
                <strong>Toplam:</strong>
                ₺<span><?php echo calculate_total_incomes(); ?></span>
            </div>
        </div>
        <h2>Giderler</h2>
        <form id="expense-form" method="post">
            <select name="expense_category">
                <option value="">Kategori Seçin</option>
                <option value=" Faturalar"> Faturalar </option>
                <option value=" Yiyecek"> Yiyecek </option>
                <option value=" Ulaşım"> Ulaşım </option>
                <option value=" Eğlence"> Eğlence </option>
                <option value=" Diğer"> Diğer </option>
            </select>
            <input type="text" name="expense_name" placeholder="Giderin ismi" required />
            <input type="number" name="expense_amount" placeholder="Giderin miktari" required min=0/>
            <input type="date" name="expense_date" required />
            <button type="submit" name="add_expense">
                Gideri ekle
            </button>
        </form>
        <div class="expense-table">
            <table>
                <thead>
                    <tr>
                        <th>Kategori</th>
                        <th>Giderin ismi</th>
                        <th>Giderin miktari</th>
                        <th>Tarih</th>
                        <th>Sil</th>
                    </tr>
                </thead>
                <tbody>
                    <?php include 'expenses.php'; ?>
                </tbody>
            </table>
            <div class="total-amount">
                <strong>Toplam:</strong>
                ₺<span><?php echo calculate_total_expenses(); ?></span>
            </div>
        </div>
        <div class="analysis-section">
            <h2>Gelirlerin ve Giderlerin Analizi</h2>
            <form action="analysis.php" method="post">
                <label for="start_date">Başlangıç tarihi:</label>
                <input type="date" id="start_date" name="start_date" required />
                <label for="end_date">Bitiş tarihi:</label>
                <input type="date" id="end_date" name="end_date" required />
                <button type="submit" name="analyze">Analiz et</button>
            </form>
        </div>
    </div>
</body>
</html>
<?php
}
  
?>
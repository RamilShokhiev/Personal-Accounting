<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gelirlerin ve Giderlerin Analizi</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body style="background-image: url('./Muhasebe.jpg');">
    <div class="container">
        <h1>Gelirlerin ve Giderlerin Analizi</h1>

        <div class="analysis-section">
            <form action="analysis.php" method="post">
                <label for="start_date">Başlangıç tarihi:</label>
                <input type="date" id="start_date" name="start_date" required />
                <label for="end_date">Bitiş tarihi:</label>
                <input type="date" id="end_date" name="end_date" required />
                <button type="submit" name="analyze">Analiz et</button>
            </form>
            <?php
            if (isset($_POST['analyze'])) {
                $startDate = $_POST['start_date'];
                $endDate = $_POST['end_date'];

                // Seçilen dönem için gelir ve giderleri analiz etme fonksiyonu
                function analyzeData($startDate, $endDate) {
                    $totalIncome = 0;
                    $totalExpense = 0;

                    // Oturumda gelir verisi olup olmadığını kontrol etme
                    if (isset($_SESSION['incomes'])) {
                        echo "<h2>Gelirler $startDate tarihinden  $endDate tarihine kadar:</h2>";
                        echo "<ul>";
                        foreach ($_SESSION['incomes'] as $income) {
                            if ($income['date'] >= $startDate && $income['date'] <= $endDate) {
                                $totalIncome += $income['amount'];
                                echo "<li>{$income['category']} - {$income['name']}: {$income['amount']} ₺ ({$income['date']})</li>";
                            }
                        }
                        echo "</ul>";
                    } else {
                        echo "<p>Seçilen süre boyunca gelir yok.</p>";
                    }

                    // Oturumda gider verisi olup olmadığını kontrol etme
                    if (isset($_SESSION['expenses'])) {
                        echo "<h2>Giderler $startDate tarihinden  $endDate tarihine kadar:</h2>";
                        echo "<ul>";
                        foreach ($_SESSION['expenses'] as $expense) {
                            if ($expense['date'] >= $startDate && $expense['date'] <= $endDate) {
                                $totalExpense += $expense['amount'];
                                echo "<li>{$expense['category']} - {$expense['name']}: {$expense['amount']} ₺ ({$expense['date']})</li>";
                            }
                        }
                        echo "</ul>";
                    } else {
                        echo "<p>Seçilen zaman dilimi için harcama yok.</p>";
                    }

                    // Harcamalardan sonra kalan tutarı hesaplama
                    $remainingAmount = $totalIncome - $totalExpense;

                    // Analiz sonuçlarını görüntüleme
                    echo "<p><strong><h2>$startDate ile $endDate arasındaki dönem için analiz sonuçları:</h2></strong></p>";
                    echo "<p>Toplam gelirirler: ₺" . number_format($totalIncome, 2) . "</p>";
                    echo "<p>Toplam tüketim: ₺" . number_format($totalExpense, 2) . "</p>";
                    echo "<p>Toplam kalan: ₺" . number_format($remainingAmount, 2) . "</p>";

                    // Emeklilik tasarrufları veya yatırımları için kullanılabilir fon olup olmadığını kontrol etme
                    if ($remainingAmount > 0) {
                        // Emeklilik tasarrufları ve yatırımları için ayrılan kısmı hesaplama
                        $retirementPortion = $totalIncome * 0.15; // Emeklilik için %15
                        $investmentPortion = ($totalIncome - $retirementPortion) * 0.15; // Yatırımlar için %15

                        
                        echo "<p>Emeklilik için ayrılan miktar: ₺" . number_format($retirementPortion, 2) . "</p>";
                        echo "<p>Yatırımlar için ayrılan miktar: ₺" . number_format($investmentPortion, 2) . "</p>";
                    } else {
                        echo "<p>Yeterli fon mevcut değil.</p>";
                    }
                }

                // Gelir ve giderleri analiz etmek için fonksiyonu çağırma
                analyzeData($startDate, $endDate);
            }
            ?>

            <button onclick="goBack()">Geri dön</button>
            <button onclick="location.href='yorum.php'" class="button yorum-button">Yorum Yap</button>


        </div>
    </div>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
    
</body>
</html>

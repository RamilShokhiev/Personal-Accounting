
<?php 


// Gelir dizisini oturumdan başlatma
$incomes = $_SESSION['incomes'] ?? [];

// Gelirleri tablo biçiminde oluşturma işlevi
function renderIncomes() {
    global $incomes;

    // Gelirleri tarihe göre sıralama
    usort($incomes, function($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    });

    ob_start();
    foreach ($incomes as $index => $income) { 
        $category = $income['category'] ?? ''; ?>
        <tr>
        <td><?php echo $category; ?></td>
            <td><?php echo isset($income['name']) ? $income['name'] : ''; ?></td>
            <td>₺<?php echo isset($income['amount']) ? $income['amount'] : ''; ?></td>
            <td><?php echo isset($income['date']) ? $income['date'] : ''; ?></td>
            <td class="delete-btn" data-type="income" data-id="<?php echo $index; ?>">
                <form method="post">
                    <input type="hidden" name="delete_income" value="true">
                    <input type="hidden" name="income_index" value="<?php echo $index; ?>">
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
    <?php }
    $rendered = ob_get_clean();
    return $rendered;
}

// Gelir ekleme işlevi
function addIncome() {
    global $incomes;

    if (isset($_POST['add_income'])) {
        // Formdan gelir adını ve tutarını alma
        $incomeCategory = $_POST['income_category'];
        $incomeName = $_POST['income_name'];
        $incomeAmount = floatval($_POST['income_amount']);
        $incomeDate = $_POST['income_date'];

        // Girişleri doğrulayın
        if ($incomeCategory === "" || $incomeName === "" || $incomeAmount === 0 || $incomeDate === "") {
            echo '<script>alert("Please enter valid income details.");</script>';
            return;
        }

        // Yeni gelir nesnesi oluşturma
        $income = [
            'category' => $incomeCategory,
            'name' => $incomeName,
            'amount' => $incomeAmount,
            'date' => $incomeDate,
        ];

        // Gelirler dizisine gelir ekleme
        $incomes[] = $income;

        // Gelirleri oturuma kaydetme
        $_SESSION['incomes'] = $incomes;
    }
}

// Gelir silme işlevi
function deleteIncome() {
    global $incomes;

    if (isset($_POST['delete_income'])) {
        // data-id özniteliğinden gelir endeksi alma
        $incomeIndex = $_POST['income_index'];

        // Geliri gelirler dizisinden çıkarma
        unset($incomes[$incomeIndex]);


        $_SESSION['incomes'] = $incomes;
    }
}

// Toplam gelirleri hesaplama fonksiyonu
function calculate_total_incomes() {
    global $incomes;

    $totalAmount = 0;
    foreach ($incomes as $income) {
        $totalAmount += isset($income['amount']) ? $income['amount'] : 0;
    }
    return number_format($totalAmount, 2);
}

// Gelir ekleme ve silme
addIncome();
deleteIncome();


echo renderIncomes();
?>
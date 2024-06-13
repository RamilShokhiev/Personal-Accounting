
<?php 

// Gider dizisini oturumdan başlatması
$expenses = $_SESSION['expenses'] ?? [];


// Giderleri tablo biçiminde oluşturma işlevi
function renderExpenses() {
    global $expenses;

    usort($expenses, function($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    });

    // Gider listesini temizleme
    ob_start();
    foreach ($expenses as $index => $expense) { 
        $category = $expense['category'] ?? '';?>
        <tr>
        <td><?php echo $category; ?></td>
            <td><?php echo $expense['name']; ?></td>
            <td>₺<?php echo $expense['amount']; ?></td>
            <td><?php echo $expense['date']; ?></td>
            <td class="delete-btn" data-type="expense" data-id="<?php echo $index; ?>">
                <form method="post">
                    <input type="hidden" name="delete_expense" value="true">
                    <input type="hidden" name="expense_index" value="<?php echo $index; ?>">
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
    <?php }
    $rendered = ob_get_clean();
    return $rendered;
}

// Gider ekleme işlevi
function addExpense() {
    global $expenses;

    if (isset($_POST['add_expense'])) {
        // Formdan gider adını ve tutarını alma
        $expenseCategory = $_POST['expense_category'];
        $expenseName = $_POST['expense_name'];
        $expenseAmount = floatval($_POST['expense_amount']);
        $expenseDate = $_POST['expense_date'];

        // Girişleri doğrulama
        if ($expenseCategory === "" || $expenseName === "" || $expenseAmount === 0 || $expenseDate === "") {
            echo '<script>alert("Please enter valid expense details.");</script>';
            return;
        }
        // Yeni gider nesnesi oluşturma
        $expense = [
            'category' => $expenseCategory,
            'name' => $expenseName,
            'amount' => $expenseAmount,
            'date' => $expenseDate,
        ];
   // Giderleri giderler dizisine ekleme
        $expenses[] = $expense;

        // Harcamaları oturuma kaydetme
        $_SESSION['expenses'] = $expenses;
    }
}

// Gider silme işlevi
function deleteExpense() {
    global $expenses;

    if (isset($_POST['delete_expense'])) {
        // data-id özniteliğinden gider dizini alma
        $expenseIndex = $_POST['expense_index'];

        // Gider dizisinden gideri kaldırma
        unset($expenses[$expenseIndex]);

        
        $_SESSION['expenses'] = $expenses;
    }
}

// Toplam giderleri hesaplama fonksiyonu
function calculate_total_expenses() {
    global $expenses;

    $totalAmount = 0;
    foreach ($expenses as $expense) {
        $totalAmount += $expense['amount'];
    }
    return number_format($totalAmount, 2);
}

// Gider ekleme ve silme
addExpense();
deleteExpense();


echo renderExpenses();
?>
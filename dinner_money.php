<?php
// start of my code, once again all mine 
session_start();

// check if its actually a parent
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'parent') {
   header("Location: index.php");
   exit();
}

// connecting to db
require_once 'db_connect.php';

// get child and dinner account info
$dinner_query = $conn->prepare("
   SELECT 
       p.pupil_id,
       da.account_id,
       da.balance,
       da.meal_preference,
       da.free_school_meals
   FROM pupil_parent pp
   JOIN pupil p ON pp.pupil_id = p.pupil_id
   JOIN dinner_account da ON p.pupil_id = da.pupil_id
   WHERE pp.parent_id = ?
");
$dinner_query->bind_param("i", $_SESSION['user_id']);
$dinner_query->execute();
$dinner_info = $dinner_query->get_result()->fetch_assoc();

// handle payment submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['payment_amount'])) {
    $payment_amount = floatval($_POST['payment_amount']);
    
    // start transaction for safety
    $conn->begin_transaction();
    
    try {
        // update balance
        $update_query = $conn->prepare("
            UPDATE dinner_account 
            SET balance = balance + ? 
            WHERE account_id = ?
        ");
        $update_query->bind_param("di", $payment_amount, $dinner_info['account_id']);
        $update_query->execute();
        
        // record payment
        $payment_record = $conn->prepare("
            INSERT INTO dinner_payment 
            (account_id, payment_date, amount, payment_method, term)
            VALUES (?, CURDATE(), ?, 'Cash', CONCAT(YEAR(CURDATE()), ' Term'))
        ");
        $payment_record->bind_param("id", $dinner_info['account_id'], $payment_amount);
        $payment_record->execute();
        
        // commit changes
        $conn->commit();
        
        // refresh dinner info
        $dinner_query->execute();
        $dinner_info = $dinner_query->get_result()->fetch_assoc();
        
        $success_message = "Payment successful!";
    } catch (Exception $e) {
        $conn->rollback();
        $error_message = "Error processing payment: " . $e->getMessage();
    }
}
?>
<!--my html code for the page, quite standard-->
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Dinner Money</title>
   <link rel="stylesheet" href="styles/dashboard.css">
</head>
<body>
   <div class="container">
       <h1>Dinner Money Account</h1>      
       <div class="dashboard">
           <h2>Dinner Money Account</h2>
           <div class="information">
               <p><strong>Current Balance:</strong> £<?php echo number_format($dinner_info['balance'], 2); ?></p>
               <p><strong>Meal Preference:</strong> <?php echo htmlspecialchars($dinner_info['meal_preference']); ?></p>
               <p><strong>Free School Meals:</strong> <?php echo $dinner_info['free_school_meals'] ? 'Yes' : 'No'; ?></p>
           </div>
       </div>
       <div class="dashboard">
           <h2>Add Dinner Money</h2>
           <?php if (isset($success_message)): ?>
               <div class="success-message"><?php echo $success_message; ?></div>
           <?php endif; ?>
           <?php if (isset($error_message)): ?>
               <div class="error-message"><?php echo $error_message; ?></div>
           <?php endif; ?>
           <form method="post" action="">
               <div class="field">
                   <label for="payment_amount">Payment Amount (£)</label>
                   <input type="number" id="payment_amount" name="payment_amount" 
                          min="0" step="0.01" required 
                          placeholder="Enter amount to add">
               </div>
               <button type="submit" class="btn">Add Funds</button>
           </form>
           <p class="payment-note">
               <strong>Note:</strong> pay cash to the school office to add funds to your account.
           </p>
       </div>    
       <a href="logout.php" class="logout-btn">Logout</a>
       <a href="parent_dashboard.php" class="btn" style="margin-top: 20px;">Back to Dashboard</a>
   </div>
</body>
</html>

<?php
$dinner_query->close();
$conn->close();
?>
<?php
// library page for parents to view books that their child may want to borrow from library
session_start();
// check if its a parent
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'parent') {
   header("Location: index.php");
   exit();
}
// db connection
require_once 'db_connect.php';
// get childs details
$child_query = $conn->prepare("
   SELECT pupil_id 
   FROM pupil_parent 
   WHERE parent_id = ?
");
$child_query->bind_param("i", $_SESSION['user_id']);
$child_query->execute();
$child_info = $child_query->get_result()->fetch_assoc();
$pupil_id = $child_info['pupil_id'];
// handle book borrowing
if (isset($_GET['borrow']) && !empty($_GET['borrow'])) {
    $book_id = intval($_GET['borrow']);
    
    // check if book is available and add it to loans
    $borrow_query = $conn->prepare("
        INSERT INTO library_loan (pupil_id, book_id, borrow_date, due_date)
        SELECT ?, book_id, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 14 DAY)
        FROM library_book 
        WHERE book_id = ? AND available = 1
    ");
    $borrow_query->bind_param("ii", $pupil_id, $book_id);
    $borrow_query->execute();
    
    // update book availability 
    $conn->query("
        UPDATE library_book 
        SET available = 0 
        WHERE book_id = $book_id
    ");
    
    header("Location: library_books.php");
    exit();
}
// handles book return
if (isset($_GET['return']) && !empty($_GET['return'])) {
    $loan_id = intval($_GET['return']);
    
    // return book and make it available again
    $conn->query("
        UPDATE library_loan 
        SET return_date = CURDATE() 
        WHERE loan_id = $loan_id AND pupil_id = $pupil_id
    ");
    
    $conn->query("
        UPDATE library_book lb
        JOIN library_loan ll ON lb.book_id = ll.book_id
        SET lb.available = 1
        WHERE ll.loan_id = $loan_id
    ");
    
    header("Location: library_books.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library Books</title>
    <link rel="stylesheet" href="styles/dashboard.css">
</head>
<body>
    <div class="container">
        <h1>Library Books</h1>       
        <div class="dashboard">
            <h2>Books u can borrow</h2>
            <?php 
            // get all books
            $books_query = $conn->query("
                SELECT lb.*, 
                (SELECT loan_id FROM library_loan 
                 WHERE book_id = lb.book_id 
                 AND pupil_id = $pupil_id 
                 AND return_date IS NULL) as my_loan
                FROM library_book lb
                ORDER BY lb.title
            ");         
            while ($book = $books_query->fetch_assoc()) {
                echo "<div>";
                echo htmlspecialchars($book['title']) . " by " . htmlspecialchars($book['author']);
                
                if ($book['available']) {
                    echo " - Available ";
                    echo "<a href='library_books.php?borrow={$book['book_id']}'>Borrow</a>";
                } elseif ($book['my_loan']) {
                    echo " - U have dis book ";
                } else {
                    echo " - Not available";
                }
                
                echo "</div>";
            }
            ?>
        </div>       
        <div class="dashboard">
            <h2>Your Current Books</h2>
            <?php 
            // get current loans
            $loans_query = $conn->query("
                SELECT ll.loan_id, lb.title 
                FROM library_loan ll
                JOIN library_book lb ON ll.book_id = lb.book_id
                WHERE ll.pupil_id = $pupil_id 
                AND ll.return_date IS NULL
            ");         
            while ($loan = $loans_query->fetch_assoc()) {
                echo "<div>";
                echo htmlspecialchars($loan['title']);
                echo " <a href='library_books.php?return={$loan['loan_id']}'>Return</a>";
                echo "</div>";
            }
            ?>
        </div>      
        <a href="parent_dashboard.php" class="btn">Back to Dashboard</a>
    </div>
</body>
</html>
<?php
$conn->close();
?>
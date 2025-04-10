<?php
// start of my code, once again all mine. i used help from the uni slides but i dont think i need to ref this
session_start();

// check if its actually a parent
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'parent') {
   header("Location: index.php");
   exit();
}

// connecting to db
require_once 'db_connect.php';

//sql statement to retrieve information
$child_query = $conn->prepare("
   SELECT 
       p.pupil_id,
       p.first_name AS child_first_name,
       p.last_name AS child_last_name,
       p.date_of_birth,
       p.gender,
       p.medical_info,
       c.class_name,
       c.year_group,
       da.balance AS dinner_balance
   FROM pupil_parent pp
   JOIN pupil p ON pp.pupil_id = p.pupil_id
   JOIN classes c ON p.class_id = c.class_id
   JOIN dinner_account da ON p.pupil_id = da.pupil_id
   WHERE pp.parent_id = ?
");
$child_query->bind_param("i", $_SESSION['user_id']);
$child_query->execute();
$child_info = $child_query->get_result()->fetch_assoc();

//turns result into array
$attendance_query = $conn->prepare("
   SELECT 
       attendance_date, 
       GROUP_CONCAT(CONCAT(session, ': ', status, ' - ', notes) SEPARATOR '; ') AS session_details
   FROM attendance 
   WHERE pupil_id = ?
   GROUP BY attendance_date
   ORDER BY attendance_date DESC 
   LIMIT 5
");
$attendance_query->bind_param("i", $child_info['pupil_id']);
$attendance_query->execute();
$attendance_result = $attendance_query->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Parent Dashboard</title>
   <link rel="stylesheet" href="styles/dashboard.css">
</head>
<body>
   <div class="container">
       <h1>Parent Dashboard</h1>
       
       <div class="dashboard">
           <h2>Your Child's Details</h2> <!--shows the childs details-->
           <div class="information"> <!--htmlspecialchars is good as if someone tries to hack the site, their dangerous characters are changed into plain text-->
               <p><strong>Name:</strong> <?php echo htmlspecialchars($child_info['child_first_name'] . ' ' . $child_info['child_last_name']); ?></p>
               <p><strong>Class:</strong> <?php echo htmlspecialchars($child_info['class_name']); ?></p>
               <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($child_info['date_of_birth']); ?></p>
               <p><strong>Gender:</strong> <?php echo htmlspecialchars($child_info['gender']); ?></p>
               <p><strong>Dinner Money Balance:</strong> £<?php echo number_format($child_info['dinner_balance'], 2); ?></p>
               <?php if (!empty($child_info['medical_info'])): ?>
                   <p class="medical-info"><strong>Medical Notes:</strong> <?php echo htmlspecialchars($child_info['medical_info']); ?></p>
               <?php endif; ?>
           </div>
       </div>

       <div class="dashboard">
           <h2>Attendance Record</h2>
           <table>
               <thead>
                   <tr>
                       <th>Date</th>
                       <th>Session Details</th>
                   </tr>
               </thead>
               <tbody>
                   <?php while ($attendance = $attendance_result->fetch_assoc()): ?>
                       <tr>
                           <td><?php echo htmlspecialchars($attendance['attendance_date']); ?></td>
                           <td><?php echo htmlspecialchars($attendance['session_details']); ?></td>
                       </tr>
                   <?php endwhile; ?>
               </tbody>
           </table>
       </div>
        
       <div class="dashboard">
           <h2>Quick Actions</h2>
           <div class="action-buttons">
               <a href="library_books.php" class="btn">Library books</a>
               <a href="dinner_money.php" class="btn">Manage Dinner Money</a>
               <a href="#" class="btn">Contact teacher</a>
           </div>
       </div>
       
       <a href="logout.php" class="logout-btn">Logout</a>
   </div>
</body>
</html>

<?php
$child_query->close();
$attendance_query->close();
$conn->close();
?>
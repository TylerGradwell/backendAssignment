<?php
//this is my code for marking attendance, all my code
session_start();
// check if its a teacher - redirect if not logged in as teacher
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
   header("Location: index.php");
   exit();
}
// connect to database
require_once 'db_connect.php';
// retrieve the class ID for the current teacher
$teacher_query = $conn->prepare("SELECT class_id FROM teacher WHERE teacher_id = ?");
$teacher_query->bind_param("i", $_SESSION['user_id']);
$teacher_query->execute();
$teacher_data = $teacher_query->get_result()->fetch_assoc();
$class_id = $teacher_data['class_id'];
// fetch all students in this teacher's class, sorted alphabetically
$students_query = $conn->prepare("
   SELECT pupil_id, first_name, last_name 
   FROM pupil 
   WHERE class_id = ? 
   ORDER BY last_name, first_name
");
$students_query->bind_param("i", $class_id);
$students_query->execute();
$students_result = $students_query->get_result();
// process attendance submission when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['mark_attendance'])) {
   $date = $_POST['date'];
   $session = $_POST['session'];
   $success = true;
   // iterate through each student's attendance status
   foreach ($_POST['status'] as $pupil_id => $status) {
       // check if attendance record already exists for this student
       $check_query = $conn->prepare("
           SELECT attendance_id 
           FROM attendance 
           WHERE pupil_id = ? AND attendance_date = ? AND session = ?
       ");
       $check_query->bind_param("iss", $pupil_id, $date, $session);
       $check_query->execute();
       $check_result = $check_query->get_result();
       
       $notes = $_POST['notes'][$pupil_id];
       
       if ($check_result->num_rows > 0) {
           // update existing attendance record if found
           $attendance_id = $check_result->fetch_assoc()['attendance_id'];
           $update_query = $conn->prepare("
               UPDATE attendance 
               SET status = ?, notes = ? 
               WHERE attendance_id = ?
           ");
           $update_query->bind_param("ssi", $status, $notes, $attendance_id);
           if (!$update_query->execute()) {
               $success = false;
           }
       } else {
           // create new attendance record if no existing record
           $insert_query = $conn->prepare("
               INSERT INTO attendance (pupil_id, attendance_date, session, status, notes) 
               VALUES (?, ?, ?, ?, ?)
           ");
           $insert_query->bind_param("issss", $pupil_id, $date, $session, $status, $notes);
           if (!$insert_query->execute()) {
               $success = false;
           }
       }
   }
   // set appropriate message based on database operation result
   if ($success) {
       $success_message = "Attendance has been recorded successfully.";
   } else {
       $error_message = "There was a problem recording attendance.";
   }
}
// get current date for default form input
$today = date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Mark Attendance</title>
   <link rel="stylesheet" href="styles/dashboard.css">
   <style>
       .student-row {
           margin-bottom: 15px;
           padding-bottom: 15px;
           border-bottom: 1px solid #eee;
       }
       .student-name {
           font-weight: bold;
           margin-bottom: 5px;
       }
       /* layout for radio buttons */
       .status-options {
           display: flex;
           gap: 15px;
           margin-bottom: 10px;
       }
       .notes-field {
           width: 100%;
           padding: 8px;
           border: 1px solid #ddd;
           border-radius: 4px;
       }
       .success-message {
           background-color: #d4edda;
           color: #155724;
           padding: 10px;
           border-radius: 4px;
           margin-bottom: 15px;
       }
       .error-message {
           background-color: #f8d7da;
           color: #721c24;
           padding: 10px;
           border-radius: 4px;
           margin-bottom: 15px;
       }
   </style>
</head>
<body>
   <div class="container">
       <h1>Mark Attendance</h1>    
       <!-- success message when attendance is recorded-->
       <?php if (isset($success_message)): ?>
           <div class="success-message"><?php echo $success_message; ?></div>
       <?php endif; ?>  
       <!-- displays error message if something goes wrong-->
       <?php if (isset($error_message)): ?>
           <div class="error-message"><?php echo $error_message; ?></div>
       <?php endif; ?>
     
       <div class="dashboard">
           <h2>My Class Attendance</h2>
           <form method="post" action="">
               <!-- date selection -->
               <div style="margin-bottom: 20px;">
                   <label for="date"><strong>Date:</strong></label>
                   <input type="date" id="date" name="date" value="<?php echo $today; ?>" required style="margin: 0 10px;">
                   
                   <label for="session"><strong>Session:</strong></label>
                   <select id="session" name="session" required style="margin: 0 10px;">
                       <option value="Morning">Morning</option>
                       <option value="Afternoon">Afternoon</option>
                   </select>
               </div>
               
               <!-- checks if student is in class -->
               <?php if ($students_result->num_rows > 0): ?>
                   <!-- this iterates throug the students in the class -->
                   <?php while ($student = $students_result->fetch_assoc()): ?>
                       <div class="student-row">
                           <!-- displaying the students name -->
                           <div class="student-name">
                               <?php echo htmlspecialchars($student['last_name'] . ', ' . $student['first_name']); ?>
                           </div>                          
                           <!-- attendance status buttons-->
                           <div class="status-options">
                               <label>
                                   <input type="radio" name="status[<?php echo $student['pupil_id']; ?>]" value="Present" checked> 
                                   Present
                               </label>
                               <label>
                                   <input type="radio" name="status[<?php echo $student['pupil_id']; ?>]" value="Absent"> 
                                   Absent
                               </label>
                               <label>
                                   <input type="radio" name="status[<?php echo $student['pupil_id']; ?>]" value="Late"> 
                                   Late
                               </label>
                           </div>                          
                           <!-- notes input -->
                           <div>
                               <input type="text" name="notes[<?php echo $student['pupil_id']; ?>]" 
                                      placeholder="Notes (optional)" class="notes-field">
                           </div>
                       </div>
                   <?php endwhile; ?>                  
                   <button type="submit" name="mark_attendance" class="btn" style="margin-top: 15px;">
                       Submit Attendance
                   </button>
               <?php else: ?>
                   <p>No students found in your class.</p>
               <?php endif; ?>
           </form>
       </div>
       <a href="teacher_dashboard.php" class="btn" style="margin-top: 20px;">Back to Dashboard</a>
   </div>
</body>
</html>
<?php
// closes database connections
$teacher_query->close();
$students_query->close();
$conn->close();
?>
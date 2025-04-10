<?php
// this page lets teachers view all the students in the school
// it gets the student details if an id is passed and shows them at the top
session_start();
// check if its a teacher
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
   header("Location: index.php");
   exit();
}
// db connection
require_once 'db_connect.php';
// get teacher's class id
$teacher_query = $conn->prepare("SELECT class_id FROM teacher WHERE teacher_id = ?");
$teacher_query->bind_param("i", $_SESSION['user_id']);
$teacher_query->execute();
$teacher_info = $teacher_query->get_result()->fetch_assoc();
$class_id = $teacher_info['class_id'];
// get all classes
$class_query = "SELECT class_id, class_name, year_group FROM classes ORDER BY year_group, class_name";
$classes_result = $conn->query($class_query);
// if a student id is provided, get that student's details
if (isset($_GET['id'])) {
   $student_id = $_GET['id'];
   // get student details
   $student_query = $conn->prepare("
       SELECT p.*, c.class_name, c.year_group
       FROM pupil p
       JOIN classes c ON p.class_id = c.class_id
       WHERE p.pupil_id = ?
   ");
   $student_query->bind_param("i", $student_id);
   $student_query->execute();
   $student_info = $student_query->get_result()->fetch_assoc();
   // get parent information for this student
   $parent_query = $conn->prepare("
       SELECT pg.*
       FROM parent_guardian pg
       JOIN pupil_parent pp ON pg.parent_id = pp.parent_id
       WHERE pp.pupil_id = ?
   ");
   $parent_query->bind_param("i", $student_id);
   $parent_query->execute();
   $parents_result = $parent_query->get_result();
   // get attendance for this student
   $attendance_query = $conn->prepare("
       SELECT attendance_date, session, status, notes
       FROM attendance
       WHERE pupil_id = ?
       ORDER BY attendance_date DESC, session
       LIMIT 5
   ");
   $attendance_query->bind_param("i", $student_id);
   $attendance_query->execute();
   $attendance_result = $attendance_query->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>View Students</title>
   <link rel="stylesheet" href="styles/dashboard.css">
   <style>
       .my-class {
           background-color: #e6f7ff;
       }
       .section-header {
           background-color: #0a2c5c;
           color: white;
           padding: 8px;
           font-weight: bold;
           margin-top: 20px;
       }
       .action-margin {
           margin-top: 20px;
       }
   </style>
</head>
<body>
   <div class="container">
       <h1>School Students Directory</h1>
       
       <?php 
       // viewing a specfic student will show them at the top of page
       if (isset($_GET['id']) && isset($student_info)): 
       ?>
           <div class="dashboard">
               <h2>Student Details</h2>
               <div class="information">
                   <p><strong>Name:</strong> <?php echo htmlspecialchars($student_info['first_name'] . ' ' . $student_info['last_name']); ?></p>
                   <p><strong>Class:</strong> <?php echo htmlspecialchars($student_info['class_name']); ?></p>
                   <p><strong>Year Group:</strong> <?php echo htmlspecialchars($student_info['year_group']); ?></p>
                   <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($student_info['date_of_birth']); ?></p>
                   <p><strong>Gender:</strong> <?php echo htmlspecialchars($student_info['gender']); ?></p>
                   <p><strong>Address:</strong> <?php echo htmlspecialchars($student_info['address']); ?></p>
                   <p><strong>Postcode:</strong> <?php echo htmlspecialchars($student_info['postcode']); ?></p>
                   <p><strong>Enrollment Date:</strong> <?php echo htmlspecialchars($student_info['enrollment_date']); ?></p>
                   
                   <?php if (!empty($student_info['medical_info'])): ?>
                       <p class="medical-info"><strong>Medical Information:</strong> <?php echo htmlspecialchars($student_info['medical_info']); ?></p>
                   <?php endif; ?>
               </div>
           </div>     
           <div class="dashboard">
               <h2>Parents/Guardians</h2>
               <?php if ($parents_result->num_rows > 0): ?>
                   <table>
                       <thead>
                           <tr>
                               <th>Name</th>
                               <th>Relationship</th>
                               <th>Contact</th>
                               <th>Primary</th>
                           </tr>
                       </thead>
                       <tbody>
                           <?php while ($parent = $parents_result->fetch_assoc()): ?>
                               <tr>
                                   <td><?php echo htmlspecialchars($parent['first_name'] . ' ' . $parent['last_name']); ?></td>
                                   <td><?php echo htmlspecialchars($parent['relationship_to_pupil']); ?></td>
                                   <td>
                                       <p>Email: <?php echo htmlspecialchars($parent['email']); ?></p>
                                       <p>Phone: <?php echo htmlspecialchars($parent['phone_number']); ?></p>
                                   </td>
                                   <td><?php echo $parent['primary_contact'] ? 'Yes' : 'No'; ?></td>
                               </tr>
                           <?php endwhile; ?>
                       </tbody>
                   </table>
               <?php else: ?>
                   <p>No parent information found.</p>
               <?php endif; ?>
           </div>       
           <div class="dashboard">
               <h2>Recent Attendance</h2>
               <?php if ($attendance_result->num_rows > 0): ?>
                   <table>
                       <thead>
                           <tr>
                               <th>Date</th>
                               <th>Session</th>
                               <th>Status</th>
                               <th>Notes</th>
                           </tr>
                       </thead>
                       <tbody>
                           <?php while ($attendance = $attendance_result->fetch_assoc()): ?>
                               <tr>
                                   <td><?php echo htmlspecialchars($attendance['attendance_date']); ?></td>
                                   <td><?php echo htmlspecialchars($attendance['session']); ?></td>
                                   <td><?php echo htmlspecialchars($attendance['status']); ?></td>
                                   <td><?php echo htmlspecialchars($attendance['notes']); ?></td>
                               </tr>
                           <?php endwhile; ?>
                       </tbody>
                   </table>
               <?php else: ?>
                   <p>No attendance records found.</p>
               <?php endif; ?>
           </div>   
           <div class="action-margin">
               <a href="mark_attendance.php?id=<?php echo $student_id; ?>" class="btn">Mark Attendance</a>
               <a href="view_students.php" class="btn">Close Details</a>
           </div>
       <?php endif; ?>
       <div class="dashboard">
           <h2>All Students by Class</h2> 
           <?php if ($classes_result->num_rows > 0): ?>
               <?php while ($class = $classes_result->fetch_assoc()): ?>
                   <div class="section-header">
                       <?php echo htmlspecialchars($class['class_name']); ?>
                       <?php if ($class['class_id'] == $class_id): ?> (Your Class) <?php endif; ?>
                   </div>  
                   <table>
                       <thead>
                           <tr>
                               <th>Name</th>
                               <th>Date of Birth</th>
                               <th>Gender</th>
                               <th>Action</th>
                           </tr>
                       </thead>
                       <tbody>
                           <?php 
                           // get students for this class
                           $students_query = $conn->prepare("
                               SELECT pupil_id, first_name, last_name, date_of_birth, gender
                               FROM pupil
                               WHERE class_id = ?
                               ORDER BY last_name, first_name
                           ");
                           $students_query->bind_param("i", $class['class_id']);
                           $students_query->execute();
                           $students_result = $students_query->get_result();
                           if ($students_result->num_rows > 0):
                               while ($student = $students_result->fetch_assoc()):
                           ?>
                               <tr class="<?php echo ($class['class_id'] == $class_id) ? 'my-class' : ''; ?>">
                                   <td><?php echo htmlspecialchars($student['last_name'] . ', ' . $student['first_name']); ?></td>
                                   <td><?php echo htmlspecialchars($student['date_of_birth']); ?></td>
                                   <td><?php echo htmlspecialchars($student['gender']); ?></td>
                                   <td><a href="view_students.php?id=<?php echo $student['pupil_id']; ?>" class="btn btn-small">View Details</a></td>
                               </tr>
                           <?php 
                               endwhile;
                           else:
                           ?>
                               <tr>
                                   <td colspan="4">No students in this class</td>
                               </tr>
                           <?php endif; ?>
                       </tbody>
                   </table>
               <?php endwhile; ?>
           <?php else: ?>
               <p>No classes found.</p>
           <?php endif; ?>
       </div> 
       <a href="teacher_dashboard.php" class="btn action-margin">Back to Dashboard</a>
   </div>
</body>
</html>

<?php
$teacher_query->close();
if (isset($_GET['id'])) {
   $student_query->close();
   $parent_query->close();
   $attendance_query->close();
}
$conn->close();
?>
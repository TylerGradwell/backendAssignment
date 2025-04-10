
<?php
/*this is all my code yet again */
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start(); //begins session
require_once 'db_connect.php'; //includes db connection file

function clean_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
} /*this function removes whitespace e.g when a user accdintally adds extra space when typing 
prevents a cross scripting attack and removes backslashes*/

function authenticate_user($conn, $email, $password, $role) {
    
    $tables = [
        'teacher' => ['user_table' => 'teacher_user', 'main_table' => 'teacher', 'id_column' => 'teacher_id'],
        'parent' => ['user_table' => 'parent_user', 'main_table' => 'parent_guardian', 'id_column' => 'parent_id']
    ];

    // validates the user role and sets error messge if its wrong
    if (!isset($tables[$role])) {
        $_SESSION['login_error'] = "Invalid user role.";
        return false;
    }

    $table_info = $tables[$role];

    // does an sql statement to find if user is on the system
    $stmt = $conn->prepare("SELECT * FROM {$table_info['user_table']} WHERE (username = ? OR email = ?)");
    $stmt->bind_param("ss", $email, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Checks if the user exists
    if ($result->num_rows !== 1) {
        $_SESSION['login_error'] = "No user found with these credentials.";
        return false;
    }

    $user = $result->fetch_assoc();

    // checks if the password matches
    if ($password !== $user['password_hash']) {
        $_SESSION['login_error'] = "Invalid email/username or password.";
        return false;
    }

    // gets the rest of the user details from the user table
    $user_stmt = $conn->prepare("SELECT * FROM {$table_info['main_table']} WHERE {$table_info['id_column']} = ?");
    $user_stmt->bind_param("i", $user[$table_info['id_column']]);
    $user_stmt->execute();
    $user_details = $user_stmt->get_result()->fetch_assoc();

    // stores details in session 
    $_SESSION['user_id'] = $user[$table_info['id_column']];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['role'] = $role;

    // stores login times in db
    $update_stmt = $conn->prepare("UPDATE {$table_info['user_table']} SET last_login = NOW() WHERE user_id = ?");
    $update_stmt->bind_param("i", $user['user_id']);
    $update_stmt->execute();

    return true;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = clean_input($_POST['email']);
    $password = $_POST['password'];
    $role = clean_input($_POST['role']);

    if (authenticate_user($conn, $email, $password, $role)) {
       
        if ($role == 'teacher') {
            header("Location: teacher_dashboard.php");
        } else {
            header("Location: parent_dashboard.php");
        }
        exit();
    } else {
        
        header("Location: index.php");
        exit();
    }
} else {
    
    header("Location: index.php");
    exit();
}
//end of my code 
?>

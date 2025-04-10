<!--All my code below for making the main webpage people see when they enter the site.
its quite basic in its design, but includes hyperlinks at the top that can be used for future upgrades
Mainly is here just so it isn't just a login page, I at least wanted some decor-->
<?php
session_start();
$login_error = '';
if (isset($_SESSION['login_error'])) {
    $login_error = $_SESSION['login_error'];
    
    unset($_SESSION['login_error']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="Viewport" content="width=device-width, initial scale=1.0">
    <meta name="description" content="Tech website">
    <title>St Alphonsus Primary School</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <header>
        <nav class="navigation">
            <div class="container">
                <a href="#" class="navbar-brand">
                    <img src="Images/logo.png" alt="School Logo">
                    St Alphonsus Primary School
                </a>
                <div class="navbar-headers">
                    <a href="#">Home</a>
                    <a href="#">Apply</a>
                    <a href="#">Uniform</a>
                    <a href="#">Visit us</a>
                    <a href="#">Photos</a>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <div class="login-contaainer">
            <h1>Login</h1>
            <p class="text">Access your account below</p>
            <?php if (!empty($login_error)): ?>
                <div class="error-message"><?php echo $login_error; ?></div>
            <?php endif; ?>
            <div class="tabs">
                <div class="tab active" id="teacher-tab">Teacher</div>
                <div class="tab" id="parent-tab">Parent</div>
            </div>
            
            <div class="form active" id="teacher-form">
                <form action="login.php" method="post">
                    <input type="hidden" name="role" value="teacher">
                    <div class="field">
                        <label for="t-email">Email Address</label>
                        <input type="email" id="t-email" name="email" required>
                    </div>
                    <div class="field">
                        <label for="t-pass">Password</label>
                        <input type="password" id="t-pass" name="password" required>
                    </div>
                    <button type="submit" class="btn">Login</button>
                    <a href="#" class="link">Forgot Password?</a>
                </form>
            </div>
            
            <div class="form" id="parent-form">
                <form action="login.php" method="post">
                    <input type="hidden" name="role" value="parent">
                    <div class="field">
                        <label for="p-email">Email Address</label>
                        <input type="email" id="p-email" name="email" required>
                    </div>
                    <div class="field">
                        <label for="p-pass">Password</label>
                        <input type="password" id="p-pass" name="password" required>
                    </div>
                    <button type="submit" class="btn">Login</button>
                    <a href="#" class="link">Forgot Password?</a>
                </form>
            </div>
        </div>
    
        <script>
            // js implemented to tab switch. I used id's to make this process easy
            document.addEventListener('DOMContentLoaded', function() {
                const teacherTab = document.getElementById('teacher-tab');
                const parentTab = document.getElementById('parent-tab');
                const teacherForm = document.getElementById('teacher-form');
                const parentForm = document.getElementById('parent-form');
                
                teacherTab.addEventListener('click', function() {
                    teacherTab.classList.add('active');
                    parentTab.classList.remove('active');
                    teacherForm.classList.add('active');
                    parentForm.classList.remove('active');
                });
                
                parentTab.addEventListener('click', function() {
                    parentTab.classList.add('active');
                    teacherTab.classList.remove('active');
                    parentForm.classList.add('active');
                    teacherForm.classList.remove('active');
                });
            });
        </script>
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-links">
                    <div class="footer-section">
                        <h4>Quick links</h4>
                        <ul>
                            <li><a href="#">Home</a></li>
                            <li><a href="#">Apply</a></li>
                            <li><a href="#">Uniform</a></li>
                            <li><a href="#">Visit us</a></li>
                            <li><a href="#">Photos</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>2025 St Alphonsus Primary School. All rights reserved.</p>
                <div class="footer-legal">
                    <a href="#">Privacy policy</a>
                    <a href="#">Terms of service</a>
                </div>
            </div>
        </div>
    </footer>
    <script src="scripts/login-validation.js"></script>
    <!--end of html code-->
</body>
</html>

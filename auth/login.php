<?php
include '../config/DB.php';
include '../config/Session.php';
Session::init();

// Initialize an error variable
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $query = "SELECT * FROM users WHERE email='$email' AND password='$password' ORDER BY users.id";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $value = $result->fetch_assoc();

        Session::set("login",true);
        Session::set("email", $value['email']);
        Session::set("name", $value['first_name']);
        header("Location: /admin/index.php");
    } else {
        $errorMessage = "Credentials do not match. Please try again.";
    }
}
?>

<html>
<head>
    <link rel="icon" href="../favicon.ico" type="image/x-icon"> <!-- Favicon-->
    <!-- project css file -->
    <link rel="stylesheet" href="../assets/css/ebazar.style.min.css">
</head>
<body>
    <div id="ebazar-layout" class="theme-blue">
        <!-- main body area -->
        <div class="main p-2 py-3 p-xl-5">
            <!-- Body: Body -->
            <div class="body d-flex p-0 p-xl-5">
                <div class="container-xxl">
                    <div class="row g-0">
                        <div class="col-lg-6 d-none d-lg-flex justify-content-center align-items-center rounded-lg auth-h100">
                            <div style="max-width: 25rem;">
                                <div class="text-center mb-5">
                                    <i class="bi bi-bag-check-fill text-primary" style="font-size: 90px;"></i>
                                </div>
                                <div class="mb-5">
                                    <h2 class="color-900 text-center">A few clicks is all it takes.</h2>
                                </div>
                                <div class="">
                                    <img src="../assets/images/login-img.svg" alt="login-img">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 d-flex justify-content-center align-items-center border-0 rounded-lg auth-h100">
                            <div class="w-100 p-3 p-md-5 card border-0 shadow-sm" style="max-width: 32rem;">
                                <!-- Display error message if exists -->
                                <?php if ($errorMessage != ''): ?>
                                    <div class="alert alert-danger text-center mb-4">
                                        <?php echo $errorMessage; ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Form -->
                                <form action="" method="POST" class="row g-1 p-3 p-md-4">
                                    <div class="col-12 text-center mb-5">
                                        <h1>Sign in</h1>
                                        <span>Free access to our dashboard.</span>
                                    </div>
                                    <div class="col-12 text-center mb-4">
                                        <a class="btn btn-lg btn-light btn-block" href="#">
                                            <span class="d-flex justify-content-center align-items-center">
                                                <img class="avatar xs me-2" src="../assets/images/google.svg" alt="Image Description">
                                                Sign in with Google
                                            </span>
                                        </a>
                                        <span class="dividers text-muted mt-4">OR</span>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-2">
                                            <label class="form-label">Email address</label>
                                            <input type="email" name="email" class="form-control form-control-lg" placeholder="name@example.com">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-2">
                                            <div class="form-label">
                                                <span class="d-flex justify-content-between align-items-center">
                                                    Password
                                                    <a class="text-secondary" href="auth-password-reset.html">Forgot Password?</a>
                                                </span>
                                            </div>
                                            <input type="password" name="password" class="form-control form-control-lg" placeholder="***************">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Remember me
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12 text-center mt-4">
                                        <button type="submit" class="btn btn-lg btn-block btn-light lift text-uppercase" alt="signin">SIGN IN</button>
                                    </div>
                                    <div class="col-12 text-center mt-4">
                                        <span>Don't have an account yet? <a href="register.php" class="text-secondary">Sign up here</a></span>
                                    </div>
                                </form>
                                <!-- End Form -->
                            </div>
                        </div>
                    </div> <!-- End Row -->
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery Core Js -->
    <script src="../assets/bundles/libscripts.bundle.js"></script>
</body>
</html>

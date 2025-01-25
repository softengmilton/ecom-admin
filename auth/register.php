<?php
include '../config/DB.php';
include '../config/Session.php';

?> 
<!doctype html>
<html class="no-js" lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>::eBazar:: Signup </title>
    <link rel="icon" href="../favicon.ico" type="image/x-icon"> <!-- Favicon-->

    <!-- project css file  -->
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
                                    <i class="bi bi-bag-check-fill  text-primary" style="font-size: 90px;"></i>
                                </div>
                                <div class="mb-5">
                                    <h2 class="color-900 text-center">A few clicks is all it takes.</h2>
                                </div>
                                <!-- Image block -->
                                <div class="">
                                    <img src="../assets/images/login-img.svg" alt="login-img">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 d-flex justify-content-center align-items-center border-0 rounded-lg auth-h100">
                            <div class="w-100 p-3 p-md-5 card border-0 shadow-sm" style="max-width: 32rem;">
                            <?php
                                // Assuming a database connection has already been established in $conn

                                if ($_SERVER['REQUEST_METHOD'] == "POST") {
                                    // Retrieve form data
                                    $first_name = $_POST['first_name'];
                                    $last_name = $_POST['last_name'];
                                    $email = $_POST['email'];
                                    $password = $_POST['password'];
                                    $confirm_password = $_POST['confirm_password'];
                                    $terms_accepted = isset($_POST['terms_accepted']) ? 1 : 0;

                                    // Password validation (check if passwords match)
                                    if ($password !== $confirm_password) {
                                        echo "<script>alert('Passwords do not match.')</script>";
                                    } else {
                                        $query = "INSERT INTO users (first_name, last_name, email, password, terms_accepted) VALUES ('$first_name', '$last_name', '$email', '$password', '$terms_accepted')";
                                        $stmt = $conn->prepare($query);

                                        if ($stmt) {
                                            // Execute the query
                                            if ($stmt->execute()) {
                                                echo "<script>alert('Account created successfully!'); window.location.href = 'login.php';</script>";
                                            } else {
                                                echo "<script>alert('Something went wrong: " . $stmt->error . "')</script>";
                                            }
                                            // Close statement
                                            $stmt->close();
                                        } else {
                                            echo "<script>alert('Something went wrong: " . $conn->error . "')</script>";
                                        }
                                    }
                                }

                                $conn->close();
                                ?>

                                <!-- Form -->
                                <form class="row g-1 p-3 p-md-4" method="POST" action="">
                                    <div class="col-12 text-center mb-5">
                                        <h1>Create your account</h1>
                                        <span>Free access to our dashboard.</span>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-2">
                                            <label class="form-label">First Name</label>
                                            <input type="text" name="first_name" class="form-control form-control-lg" placeholder="John" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-2">
                                            <label class="form-label">Last Name</label>
                                            <input type="text" name="last_name" class="form-control form-control-lg" placeholder="Parker" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-2">
                                            <label class="form-label">Email address</label>
                                            <input type="email" name="email" class="form-control form-control-lg" placeholder="name@example.com" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-2">
                                            <label class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control form-control-lg" placeholder="8+ characters required" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-2">
                                            <label class="form-label">Confirm Password</label>
                                            <input type="password" name="confirm_password" class="form-control form-control-lg" placeholder="8+ characters required" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="terms_accepted" value="1" id="flexCheckDefault" required>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                I accept the <a href="#" title="Terms and Conditions" class="text-secondary">Terms and Conditions</a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12 text-center mt-4">
                                        <button type="submit" class="btn btn-lg btn-block btn-light lift text-uppercase">SIGN UP</button>
                                    </div>
                                    <div class="col-12 text-center mt-4">
                                        <span>Already have an account? <a href="login.php" title="Sign in" class="text-secondary">Sign in here</a></span>
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
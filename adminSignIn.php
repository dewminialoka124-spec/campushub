<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>CampusHub | Admin Login</title>
    <link rel="icon" href="resource/icon/education.png" type="image/png" />
    <link rel="stylesheet" href="assets/css/bootstrap.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
</head>

<body class="main-body">

    <div class="container-fluid d-flex justify-content-center align-items-center min-vh-100 py-5">
        <div class="row align-content-center w-100" style="max-width: 520px;">

            <!--Header-->
            <div class="col-12 text-center mb-4">
                <div class="d-inline-block bg-white p-3 rounded-circle shadow-sm mb-3" style="border: 1px solid #f6e2e7;">
                    <img src="resource/icon/education.png" alt="CampusHub Icon" style="height: 52px; width: auto;">
                </div>
                <h1 class="title01 mb-1">CampusHub Admin Portal</h1>
                <p class="text-muted fs-6">Sign in with your administrator credentials</p>
            </div>

            <!--Content-->
            <div class="col-12">
                <div class="row justify-content-center">

                    <!--Admin SignIn Box Only-->
                    <div class="col-12" id="adminSignInBox">
                        <div class="soft-card p-4 p-md-5">
                            <div class="row g-3">

                                <div class="col-12 text-center mb-2">
                                    <h2 class="title02 mb-1">Administrator Sign In</h2>
                                    <p class="text-muted small">Secure access for event managers & site admins</p>
                                    <hr class="mt-2 mb-3" style="color: #f8bbd0;">
                                </div>

                                <?php
                                $admin_email = "";
                                $admin_password = "";

                                if (isset($_COOKIE["admin_email"])) {
                                    $admin_email = $_COOKIE["admin_email"];
                                }

                                if (isset($_COOKIE["admin_password"])) {
                                    $admin_password = $_COOKIE["admin_password"];
                                }
                                ?>

                                <div class="col-12">
                                    <label class="form-label">Admin Email</label>
                                    <input type="email" class="form-control" placeholder="ex: admin@campushub.lk" id="adminEmail" value="<?php echo $admin_email; ?>">
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control" placeholder="ex: ••••••••" id="adminPassword" value="<?php echo $admin_password; ?>">
                                </div>

                                <div class="col-12">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="adminRememberMe">
                                        <label class="form-check-label fw-semibold text-secondary" for="adminRememberMe">Remember Me</label>
                                    </div>
                                </div>

                                <div class="col-12 d-grid mt-4">
                                    <button class="btn btn-pink py-2 fw-bold" onclick="adminSignIn();">Sign In as Admin</button>
                                </div>

                                <div class="col-12 text-center mt-3">
                                    <a href="index.php" class="nav-link-soft text-decoration-none">&larr; Back to Student Login</a>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!--Back to Home-->
            <div class="col-12 text-center mt-4">
                <a href="home.php" class="nav-link-soft">Continue to Home as Guest</a>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/js/bootstrap.bundle.js"></script>
    <script src="assets/js/script.js"></script>
</body>

</html>

<?php
include "config/connection.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>CampusHub | Student Sign In & Sign Up</title>
    <link rel="icon" href="resource/icon/education.png" type="image/png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
</head>

<body class="main-body">

    <div class="container-fluid d-flex justify-content-center align-items-center min-vh-100 py-5">
        <div class="row align-content-center w-100" style="max-width: 840px;">

            <!--Header-->
            <div class="col-12 text-center mb-4">
                <div class="d-inline-block bg-white p-3 rounded-circle shadow-sm mb-3 border">
                    <img src="resource/icon/education.png" alt="CampusHub Icon" style="height: 54px; width: auto;">
                </div>
                <h1 class="title01 mb-2">Hi, Welcome to CampusHub</h1>
                <p class="text-muted fs-6">Register for student events, workshops and campus activities</p>
            </div>

            <!--Content-->
            <div class="col-12">
                <div class="row justify-content-center">

                    <!--SignUp Box-->
                    <div class="col-12 col-lg-9" id="signUpBox">
                        <div class="soft-card p-4 p-md-5">
                            <div class="row g-3">

                                <div class="col-12 text-center mb-2">
                                    <h2 class="title02 mb-1">Create A Student Account</h2>
                                    <p class="text-muted small">Join CampusHub to register for exciting campus events</p>
                                </div>

                                <div class="col-12 d-none" id="msgdiv">
                                    <div class="alert alert-danger rounded-3" role="alert" id="msg"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label"><i class="bi bi-person me-1 text-primary"></i>First Name</label>
                                    <input type="text" class="form-control" placeholder="ex: Dewmini" id="fname">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><i class="bi bi-person me-1 text-primary"></i>Last Name</label>
                                    <input type="text" class="form-control" placeholder="ex: Aloka" id="lname">
                                </div>
                                <div class="col-12">
                                    <label class="form-label"><i class="bi bi-envelope me-1 text-primary"></i>Email Address</label>
                                    <input type="email" class="form-control" placeholder="ex: dewmini@student.lk" id="email">
                                </div>
                                <div class="col-12">
                                    <label class="form-label"><i class="bi bi-key me-1 text-primary"></i>Password</label>
                                    <input type="password" class="form-control" placeholder="ex: ••••••••" id="password">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><i class="bi bi-phone me-1 text-primary"></i>Mobile Number</label>
                                    <input type="text" class="form-control" placeholder="ex: 0777653426" id="mobile">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><i class="bi bi-gender-ambiguous me-1 text-primary"></i>Gender</label>
                                    <select class="form-select" id="gender">
                                        <option value="0">Select Gender</option>
                                        <option value="1">Female</option>
                                        <option value="2">Male</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label"><i class="bi bi-building me-1 text-primary"></i>Institution</label>
                                    <select class="form-select" id="institution">
                                        <option value="0">Select Institution</option>
                                        <?php
                                        $insitutation_rs = Database::search("SELECT * FROM `insitutation`");
                                        $insitutation_num = $insitutation_rs->num_rows;

                                        for ($i = 0; $i < $insitutation_num; $i++) {

                                            $insitutation_data = $insitutation_rs->fetch_assoc();
                                            ?>
                                            <option value="<?php echo $insitutation_data["id"]; ?>"><?php echo $insitutation_data["name"]; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-12 row g-2 mt-4">
                                    <div class="col-12 col-sm-6 d-grid">
                                        <button class="btn btn-pink py-2" onclick="signUp()"><i class="bi bi-person-plus me-1"></i> Sign Up</button>
                                    </div>
                                    <div class="col-12 col-sm-6 d-grid">
                                        <button class="btn btn-soft-outline py-2" onclick="changeView()"><i class="bi bi-box-arrow-in-right me-1"></i> Log In Instead</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!--SignIn Box-->
                    <div class="col-12 col-lg-7 d-none" id="signInBox">
                        <div class="soft-card p-4 p-md-5">
                            <div class="row g-3">

                                <div class="col-12 text-center mb-2">
                                    <h2 class="title02 mb-1">Student Sign In</h2>
                                    <p class="text-muted small">Enter your credentials to access your student account</p>
                                </div>

                                <?php
                                $email = "";
                                $password = "";

                                if (isset($_COOKIE["email"])) {
                                    $email = $_COOKIE["email"];
                                }

                                if (isset($_COOKIE["password"])) {
                                    $password = $_COOKIE["password"];
                                }
                                ?>

                                <div class="col-12">
                                    <label class="form-label"><i class="bi bi-envelope me-1 text-primary"></i>Email Address</label>
                                    <input type="email" class="form-control" placeholder="ex: dewmini@student.lk" id="email2" value="<?php echo $email; ?>">
                                </div>

                                <div class="col-12">
                                    <label class="form-label"><i class="bi bi-lock me-1 text-primary"></i>Password</label>
                                    <input type="password" class="form-control" placeholder="ex: ••••••••" id="password2" value="<?php echo $password; ?>">
                                </div>

                                <div class="col-6 d-flex align-items-center">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="rememberMe">
                                        <label class="form-check-label fw-semibold text-secondary" for="rememberMe">Remember Me</label>
                                    </div>
                                </div>
                                <div class="col-6 text-end">
                                    <a href="#" class="nav-link-soft p-0" onclick="forgotPassword();" style="font-size: 13px;">Forgot Password?</a>
                                </div>

                                <div class="col-12 row g-2 mt-4">
                                    <div class="col-12 col-sm-6 d-grid">
                                        <button class="btn btn-pink py-2" onclick="signIn();"><i class="bi bi-box-arrow-in-right me-1"></i> Sign In</button>
                                    </div>
                                    <div class="col-12 col-sm-6 d-grid">
                                        <button class="btn btn-soft-outline py-2" onclick="changeView();"><i class="bi bi-person-plus me-1"></i> Register Account</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!--Guest & Admin Quick Links-->
            <div class="col-12 text-center mt-4">
                <a href="home.php" class="nav-link-soft me-2 py-1"><i class="bi bi-eye me-1"></i>Continue as a guest & view events</a>
                <span class="text-muted">|</span>
                <a href="adminSignIn.php" class="nav-link-soft ms-2 py-1" style="color: var(--primary-indigo); font-weight: 700;"><i class="bi bi-shield-lock me-1"></i>Admin Login Portal</a>
            </div>

        </div>
    </div>

    <!-- Retype Forget Password Modal -->
    <div class="modal fade" tabindex="-1" id="fpmodal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 24px;">

                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title title03"><i class="bi bi-shield-exclamation text-primary me-2"></i>Reset Your Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body py-4">
                    <div class="row g-3">

                        <div class="col-6">
                            <label class="form-label">New Password</label>
                            <div>
                                <input type="password" class="form-control" id="np">
                                <button class="btn btn-outline-secondary btn-sm mt-2 rounded-pill px-3" id="npb" type="button" onclick="showpassword1();">Show</button>
                            </div>
                        </div>

                        <div class="col-6">
                            <label class="form-label">Re-Type Password</label>
                            <div>
                                <input type="password" class="form-control" id="rnp">
                                <button class="btn btn-outline-secondary btn-sm mt-2 rounded-pill px-3" id="rnpb" type="button" onclick="showpassword2();">Show</button>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Verification Code</label>
                            <input type="text" class="form-control" id="vcode" placeholder="Enter code sent to your email">
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-pink px-4" onclick="resetPassword();">Save Changes</button>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/js/bootstrap.bundle.js"></script>
    <script src="assets/js/script.js"></script>
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CampusHub</title>
    <link rel="icon" href="resource/icon/education.png" type="image/png" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.css" />
    <link rel="stylesheet" href="assets/css/style.css" />

</head>

<body>

    <?php
    session_start();
    $currentPage = basename($_SERVER['PHP_SELF']);
    ?>

    <div class="container-fluid top-bar">
        <div class="container">
            <div class="row align-items-center py-2">

                <div class="col-12 col-lg-3 text-center text-lg-start d-flex align-items-center justify-content-center justify-content-lg-start mb-2 mb-lg-0">
                    <img src="resource/icon/education.png" alt="CampusHub Logo" style="height: 34px;" class="me-2">
                    <a href="home.php" class="logo-text">CampusHub</a>
                </div>

                <div class="col-12 col-lg-6 text-center mb-2 mb-lg-0">
                    <a href="home.php" class="nav-link-soft <?php echo ($currentPage == 'home.php' || $currentPage == 'eventView.php') ? 'active' : ''; ?>"><i class="bi bi-calendar-event me-1"></i>Events</a>
                    <a href="announcements.php" class="nav-link-soft <?php echo ($currentPage == 'announcements.php') ? 'active' : ''; ?>"><i class="bi bi-megaphone me-1"></i>Announcements</a>
                    <a href="gallery.php" class="nav-link-soft <?php echo ($currentPage == 'gallery.php') ? 'active' : ''; ?>"><i class="bi bi-images me-1"></i>Gallery</a>
                    <a href="contact.php" class="nav-link-soft <?php echo ($currentPage == 'contact.php') ? 'active' : ''; ?>"><i class="bi bi-envelope me-1"></i>Contact</a>
                </div>

                <div class="col-12 col-lg-3 text-center text-lg-end">

                    <?php
                    if (isset($_SESSION["u"])) {
                        $data = $_SESSION["u"];
                    ?>

                        <div class="dropdown d-inline-block">
                            <button class="btn btn-yellow dropdown-toggle px-4 shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle me-1"></i> Hi, <?php echo $data["fname"]; ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2 p-2" style="border-radius: 16px;">
                                <li><a class="dropdown-item py-2 fw-semibold rounded-3" href="profile.php"><i class="bi bi-person me-2"></i>My Profile</a></li>
                                <?php
                                if ($data["role"] == "admin") {
                                ?>
                                    <li><a class="dropdown-item py-2 fw-semibold rounded-3 text-danger" href="adminPanel.php"><i class="bi bi-speedometer2 me-2"></i>Admin Panel</a></li>
                                <?php
                                } else {
                                ?>
                                    <li><a class="dropdown-item py-2 fw-semibold rounded-3" href="myRegistrations.php"><i class="bi bi-ticket-perforated me-2"></i>My Registrations</a></li>
                                <?php
                                }
                                ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item py-2 fw-semibold rounded-3 text-secondary" href="#" onclick="signOut();"><i class="bi bi-box-arrow-right me-2"></i>Sign Out</a></li>
                            </ul>
                        </div>

                    <?php
                    } else {
                    ?>
                        <a href="index.php" class="btn btn-pink px-4 shadow-sm"><i class="bi bi-box-arrow-in-right me-1"></i> Sign In / Register</a>
                    <?php
                    }
                    ?>

                </div>

            </div>
        </div>
    </div>

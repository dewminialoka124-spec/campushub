    <footer class="footer-soft mt-auto">
        <div class="container">
            <div class="row g-4 pb-4">

                <!-- Brand Col -->
                <div class="col-12 col-lg-4 text-center text-lg-start">
                    <div class="d-flex align-items-center justify-content-center justify-content-lg-start mb-3">
                        <img src="resource/icon/education.png" alt="CampusHub Logo" style="height: 38px;" class="me-2">
                        <span class="logo-text fs-3">CampusHub</span>
                    </div>
                    <p class="text-secondary leading-relaxed mb-4" style="max-width: 340px;">
                        CampusHub brings together student workshops, sports tournaments, hackathons and club activities into one seamless, modern portal.
                    </p>
                    <div class="d-flex gap-2 justify-content-center justify-content-lg-start">
                        <a href="#" class="btn btn-sm btn-light border rounded-circle p-2 d-flex align-items-center justify-content-center text-primary" style="width: 38px; height: 38px;" title="Facebook"><i class="bi bi-facebook fs-6"></i></a>
                        <a href="#" class="btn btn-sm btn-light border rounded-circle p-2 d-flex align-items-center justify-content-center text-danger" style="width: 38px; height: 38px;" title="Instagram"><i class="bi bi-instagram fs-6"></i></a>
                        <a href="#" class="btn btn-sm btn-light border rounded-circle p-2 d-flex align-items-center justify-content-center text-info" style="width: 38px; height: 38px;" title="Twitter"><i class="bi bi-twitter-x fs-6"></i></a>
                        <a href="#" class="btn btn-sm btn-light border rounded-circle p-2 d-flex align-items-center justify-content-center text-primary" style="width: 38px; height: 38px;" title="LinkedIn"><i class="bi bi-linkedin fs-6"></i></a>
                        <a href="#" class="btn btn-sm btn-light border rounded-circle p-2 d-flex align-items-center justify-content-center text-danger" style="width: 38px; height: 38px;" title="YouTube"><i class="bi bi-youtube fs-6"></i></a>
                    </div>
                </div>

                <!-- Navigation Links -->
                <div class="col-6 col-md-3 col-lg-2 text-start">
                    <h5 class="title03 mb-3">Explore</h5>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><a href="home.php" class="text-decoration-none text-secondary hover-primary"><i class="bi bi-chevron-right small me-1 text-primary"></i> Events</a></li>
                        <li class="mb-2"><a href="announcements.php" class="text-decoration-none text-secondary hover-primary"><i class="bi bi-chevron-right small me-1 text-primary"></i> Notices</a></li>
                        <li class="mb-2"><a href="gallery.php" class="text-decoration-none text-secondary hover-primary"><i class="bi bi-chevron-right small me-1 text-primary"></i> Gallery</a></li>
                        <li class="mb-0"><a href="contact.php" class="text-decoration-none text-secondary hover-primary"><i class="bi bi-chevron-right small me-1 text-primary"></i> Contact</a></li>
                    </ul>
                </div>

                <!-- Student Portal Links -->
                <div class="col-6 col-md-3 col-lg-2 text-start">
                    <h5 class="title03 mb-3">Portal</h5>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><a href="index.php" class="text-decoration-none text-secondary hover-primary"><i class="bi bi-chevron-right small me-1 text-primary"></i> Sign In</a></li>
                        <li class="mb-2"><a href="profile.php" class="text-decoration-none text-secondary hover-primary"><i class="bi bi-chevron-right small me-1 text-primary"></i> My Profile</a></li>
                        <li class="mb-2"><a href="myRegistrations.php" class="text-decoration-none text-secondary hover-primary"><i class="bi bi-chevron-right small me-1 text-primary"></i> Registrations</a></li>
                        <li class="mb-0"><a href="adminSignIn.php" class="text-decoration-none text-secondary hover-primary"><i class="bi bi-chevron-right small me-1 text-primary"></i> Admin Login</a></li>
                    </ul>
                </div>

                <!-- Contact & Office -->
                <div class="col-12 col-md-6 col-lg-4 text-center text-md-start">
                    <h5 class="title03 mb-3">CampusHub Support</h5>
                    <div class="bg-white p-3 rounded-4 border shadow-sm">
                        <div class="d-flex align-items-start mb-2">
                            <i class="bi bi-geo-alt-fill text-danger fs-5 me-2 mt-1"></i>
                            <span class="text-secondary small">Student Services Division, No 45, Campus Road, Colombo 07</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-envelope-fill text-primary fs-5 me-2"></i>
                            <span class="text-secondary small">info@campushub.lk</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-telephone-fill text-success fs-5 me-2"></i>
                            <span class="text-secondary small">011 2 345 678 (Mon - Fri, 9 AM - 5 PM)</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Sub Footer -->
            <div class="pt-3 border-top d-flex flex-column flex-md-row justify-content-between align-items-center text-muted small">
                <p class="mb-2 mb-md-0">
                    <?php
                    $year = date("Y");
                    echo "&copy; " . $year . " <b>CampusHub</b>. All rights reserved.";
                    ?>
                </p>
                <div class="d-flex gap-3">
                    <span class="text-muted"><i class="bi bi-heart-fill text-danger me-1"></i> Made for Students</span>
                    <span>|</span>
                    <a href="#" class="text-secondary text-decoration-none">Privacy Policy</a>
                    <span>|</span>
                    <a href="#" class="text-secondary text-decoration-none">Terms of Service</a>
                </div>
            </div>

        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/js/bootstrap.bundle.js"></script>
    <script src="assets/js/script.js"></script>

</body>

</html>

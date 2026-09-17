<?php
include "config/connection.php";
include "includes/header.php";

// Error handling : only admins can open this page
if (!isset($_SESSION["u"])) {
    echo "<div class='container py-5'><div class='alert alert-danger rounded-4 p-4 text-center'>Please <a href='index.php' class='fw-bold'>sign in</a> first.</div></div>";
    include "includes/footer.php";
    exit();
}

$u = $_SESSION["u"];

if ($u["role"] != "admin") {
    echo "<div class='container py-5'><div class='alert alert-danger rounded-4 p-4 text-center'>You do not have permission to view the admin panel.</div></div>";
    include "includes/footer.php";
    exit();
}

// Dashboard counts (SELECT operations)
$eventCount = Database::search("SELECT COUNT(*) AS `total` FROM `event` ")->fetch_assoc();
$userCount = Database::search("SELECT COUNT(*) AS `total` FROM `user` WHERE `role`='student' ")->fetch_assoc();
$regCount = Database::search("SELECT COUNT(*) AS `total` FROM `registration` WHERE `status`='registered' ")->fetch_assoc();
$msgCount = Database::search("SELECT COUNT(*) AS `total` FROM `contact_message` WHERE `status`='new' ")->fetch_assoc();
?>

<div class="container py-4">
    <div class="row g-4">

        <div class="col-12 text-center text-lg-start mb-2">
            <h1 class="title01 mb-1">Admin Dashboard</h1>
            <p class="text-muted fs-6">Manage events, announcements, registrations and system stats</p>
        </div>

        <div class="col-6 col-lg-3">
            <div class="soft-card text-center p-4 h-100">
                <div class="display-5 fw-bold text-danger mb-1"><?php echo $eventCount["total"]; ?></div>
                <p class="text-muted fw-bold mb-0 text-uppercase small">Total Events</p>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="soft-card text-center p-4 h-100">
                <div class="display-5 fw-bold text-primary mb-1"><?php echo $userCount["total"]; ?></div>
                <p class="text-muted fw-bold mb-0 text-uppercase small">Registered Students</p>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="soft-card text-center p-4 h-100">
                <div class="display-5 fw-bold text-success mb-1"><?php echo $regCount["total"]; ?></div>
                <p class="text-muted fw-bold mb-0 text-uppercase small">Event Registrations</p>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="soft-card text-center p-4 h-100">
                <div class="display-5 fw-bold text-warning mb-1"><?php echo $msgCount["total"]; ?></div>
                <p class="text-muted fw-bold mb-0 text-uppercase small">New Messages</p>
            </div>
        </div>

        <div class="col-12">
            <div class="soft-card p-4">
                <h2 class="title02 mb-3">Quick Actions & Management</h2>
                <div class="row g-3 justify-content-center">
                    <div class="col-12 col-sm-6 col-lg-3 d-grid">
                        <a href="addEvent.php" class="btn btn-pink py-2">Add New Event</a>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3 d-grid">
                        <a href="addAnnouncements.php" class="btn btn-pink py-2">Add Announcement</a>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3 d-grid">
                        <a href="manageEvents.php" class="btn btn-yellow py-2">Manage Events</a>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3 d-grid">
                        <a href="manageRegistrations.php" class="btn btn-yellow py-2">Registrations</a>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3 d-grid">
                        <a href="manageUsers.php" class="btn btn-soft-outline py-2">Manage Students</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Latest contact messages -->
        <div class="col-12">
            <div class="soft-card p-4">
                <h2 class="title02 mb-3">Latest Contact Messages</h2>
                <div class="table-responsive">
                    <table class="table table-soft align-middle">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $msgs = Database::search("SELECT * FROM `contact_message` ORDER BY `sent_date` DESC LIMIT 5 ");

                            if ($msgs->num_rows == 0) {
                            ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">No messages received yet.</td>
                                </tr>
                                <?php
                            } else {
                                while ($m = $msgs->fetch_assoc()) {
                                ?>
                                    <tr>
                                        <td class="fw-bold text-dark"><?php echo $m["name"]; ?></td>
                                        <td><?php echo $m["email"]; ?></td>
                                        <td><span class="pill-pink"><?php echo $m["subject"]; ?></span></td>
                                        <td><?php echo $m["message"]; ?></td>
                                        <td><?php echo date("d M Y", strtotime($m["sent_date"])); ?></td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<?php
include "includes/footer.php";
?>

<?php
include "config/connection.php";
include "includes/header.php";

// Error handling : id must be sent through the URL
if (!isset($_GET["id"])) {
    echo "<div class='container py-5'><div class='alert alert-danger rounded-4 shadow-sm p-4 text-center'>Invalid event. Please go back to the events page.</div></div>";
    include "includes/footer.php";
    exit();
}

$id = $_GET["id"];

$rs = Database::search("SELECT * FROM `event` WHERE `id`='" . $id . "' ");

if ($rs->num_rows != 1) {
    echo "<div class='container py-5'><div class='alert alert-danger rounded-4 shadow-sm p-4 text-center'>Event not found.</div></div>";
    include "includes/footer.php";
    exit();
}

$e = $rs->fetch_assoc();

// Count registrations
$rc = Database::search("SELECT COUNT(*) AS `total` FROM `registration` 
WHERE `event_id`='" . $id . "' AND `status`='registered' ");
$count = $rc->fetch_assoc();

$image = "resource/event_images/default.jpg";
if (!empty($e["image"])) {
    $image = "resource/event_images/" . $e["image"];
}

$availableSeats = ($e["max_capacity"] - $count["total"]);

// Logged user details are used to fill the form
$fullName = "";
$email = "";
$mobile = "";
$userId = "";

if (isset($_SESSION["u"])) {
    $u = $_SESSION["u"];
    $userId = $u["id"];
    $fullName = $u["fname"] . " " . $u["lname"];
    $email = $u["email"];
    $mobile = $u["mobile"];
}
?>

<div class="container py-4">
    
    <div class="mb-4">
        <a href="home.php" class="btn btn-soft-outline btn-sm px-3"><i class="bi bi-arrow-left me-1"></i> Back to Events List</a>
    </div>

    <div class="row g-4">

        <div class="col-12 col-lg-7">
            <div class="soft-card p-4">
                <div class="position-relative overflow-hidden rounded-4 mb-4 shadow-sm">
                    <img src="<?php echo $image; ?>" class="w-100" style="max-height: 400px; object-fit: cover;" alt="<?php echo $e["title"]; ?>">
                    <div class="position-absolute top-0 start-0 p-3">
                        <span class="pill shadow-sm fs-6 px-3 py-1"><i class="bi bi-tag-fill me-1"></i><?php echo $e["category"]; ?></span>
                    </div>
                </div>

                <h1 class="title02 mb-3"><?php echo $e["title"]; ?></h1>

                <p class="text-secondary leading-relaxed fs-6 mb-4"><?php echo nl2br($e["description"]); ?></p>

                <div class="row g-3 p-3 bg-white rounded-4 border mb-4 shadow-sm">
                    <div class="col-12 col-md-4">
                        <span class="text-muted d-block small fw-bold text-uppercase"><i class="bi bi-calendar3 text-primary me-1"></i>Date & Time</span>
                        <span class="fw-semibold text-dark"><?php echo date("d M Y - h:i A", strtotime($e["event_date"])); ?></span>
                    </div>
                    <div class="col-12 col-md-4">
                        <span class="text-muted d-block small fw-bold text-uppercase"><i class="bi bi-geo-alt-fill text-danger me-1"></i>Venue</span>
                        <span class="fw-semibold text-dark"><?php echo $e["location"]; ?></span>
                    </div>
                    <div class="col-12 col-md-4">
                        <span class="text-muted d-block small fw-bold text-uppercase"><i class="bi bi-person-lines-fill text-info me-1"></i>Available Seats</span>
                        <span class="fw-bold <?php echo ($availableSeats <= 0) ? 'text-danger' : 'text-success'; ?>">
                            <?php echo $availableSeats > 0 ? $availableSeats . " Left" : "Fully Booked"; ?>
                        </span>
                    </div>
                </div>

                <!-- Multimedia : audio briefing for the event -->
                <div class="p-3 rounded-4 border bg-white shadow-sm">
                    <h3 class="title03 mb-2"><i class="bi bi-volume-up-fill text-primary me-2"></i>Audio Briefing</h3>
                    <audio controls class="w-100">
                        <source src="resource/media/event_briefing.mp3" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-5">
            <div class="soft-card p-4">
                <h2 class="title02 mb-3"><i class="bi bi-ticket-detailed text-primary me-2"></i>Register For Event</h2>

                <?php
                if (!isset($_SESSION["u"])) {
                ?>
                    <div class="alert alert-warning rounded-4 p-4 text-center border-0 shadow-sm" style="background: linear-gradient(135deg, #fef3c7, #fef08a);">
                        <p class="mb-2 font-semibold text-amber-900"><i class="bi bi-lock-fill me-1"></i> Ready to join this event?</p>
                        <p class="small text-muted mb-3">Please sign in with your student account to complete your event registration.</p>
                        <a href="index.php" class="btn btn-pink w-100"><i class="bi bi-box-arrow-in-right me-1"></i> Sign In to Register</a>
                    </div>
                <?php
                } else {
                ?>

                    <div class="row g-3">

                        <div class="col-12 d-none" id="msgdiv2">
                            <div class="alert alert-danger rounded-3" role="alert" id="msg2"></div>
                        </div>

                        <input type="hidden" id="eventId" value="<?php echo $e["id"]; ?>">
                        <input type="hidden" id="userId" value="<?php echo $userId; ?>">

                        <div class="col-12">
                            <label class="form-label"><i class="bi bi-person me-1 text-primary"></i>Full Name</label>
                            <input type="text" class="form-control" id="rfullname" value="<?php echo $fullName; ?>">
                        </div>

                        <div class="col-12">
                            <label class="form-label"><i class="bi bi-envelope me-1 text-primary"></i>Email Address</label>
                            <input type="email" class="form-control" id="remail" value="<?php echo $email; ?>">
                        </div>

                        <div class="col-12">
                            <label class="form-label"><i class="bi bi-phone me-1 text-primary"></i>Mobile Number</label>
                            <input type="text" class="form-control" id="rmobile" value="<?php echo $mobile; ?>">
                        </div>

                        <div class="col-12">
                            <label class="form-label"><i class="bi bi-chat-left-text me-1 text-primary"></i>Note to Organiser (Optional)</label>
                            <textarea class="form-control" id="rnote" rows="3" placeholder="Any special requirements or questions..."></textarea>
                        </div>

                        <div class="col-12 d-grid mt-4">
                            <?php if ($availableSeats <= 0) { ?>
                                <button class="btn btn-secondary py-2 fw-bold" disabled><i class="bi bi-slash-circle me-1"></i> Event Fully Booked</button>
                            <?php } else { ?>
                                <button class="btn btn-pink py-2 fw-bold" onclick="registerEvent();"><i class="bi bi-check-circle me-1"></i> Confirm Registration</button>
                            <?php } ?>
                        </div>

                    </div>

                <?php
                }
                ?>
            </div>
        </div>

    </div>
</div>

<?php
include "includes/footer.php";
?>

<?php
include "config/connection.php";
include "includes/header.php";

if (!isset($_SESSION["u"]) || $_SESSION["u"]["role"] != "admin") {
    echo "<div class='container py-5'><div class='alert alert-danger rounded-4 p-4 text-center'>Admins only.</div></div>";
    include "includes/footer.php";
    exit(); 
}
?>

<div class="container py-4">
    <div class="row g-4">

        <div class="col-12 text-center text-lg-start mb-2">
            <h1 class="title01 mb-1">Add New Announcement</h1>
            <p class="text-muted fs-6">Post a news update or announcement for all students</p>
        </div>

        <div class="col-12 col-lg-8">
            <div class="soft-card p-4">

                <div class="row g-3">

                    <?php
                    if (isset($_GET["msg"])) {
                        $alertType = isset($_GET["t"]) ? $_GET["t"] : 'info';
                    ?>
                        <div class="col-12">
                            <div class="alert alert-<?php echo $alertType; ?> rounded-3 mb-3"><?php echo $_GET["msg"]; ?></div>
                        </div>
                    <?php
                    }
                    ?>

                    <div class="col-12">
                        <label class="form-label">Announcement Title</label>
                        <input type="text" id="title" class="form-control" placeholder="ex: Important Notice on Workshop Registration">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea id="description" class="form-control" rows="4" placeholder="Enter full announcement message..."></textarea>
                    </div>

                    <div class="col-12 col-lg-6">
                        <label class="form-label">Published Date & Time</label>
                        <input type="datetime-local" id="event_date" class="form-control">
                    </div>

                    <div class="col-12 col-lg-5 d-grid mt-4">
                        <button type="button" class="btn btn-pink py-2 fw-bold" onclick="addAnnouncement();">Publish Announcement</button>
                    </div>

                </div>

            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="assets/js/script.js"></script>

<?php
include "includes/footer.php";
?>

<?php
include "config/connection.php";
include "includes/header.php";

if (!isset($_SESSION["u"]) || $_SESSION["u"]["role"] != "admin") {
    echo "<div class='container py-5'><div class='alert alert-danger rounded-4 p-4 text-center'>Admins only.</div></div>";
    include "includes/footer.php";
    exit();
}

// Error handling : id must come through the URL
if (!isset($_GET["id"])) {
    echo "<div class='container py-5'><div class='alert alert-danger rounded-4 p-4 text-center'>Invalid event.</div></div>";
    include "includes/footer.php";
    exit();
}

$id = $_GET["id"];

$rs = Database::search("SELECT * FROM `event` WHERE `id`='" . $id . "' ");

if ($rs->num_rows != 1) {
    echo "<div class='container py-5'><div class='alert alert-danger rounded-4 p-4 text-center'>Event not found.</div></div>";
    include "includes/footer.php";
    exit();
}

$e = $rs->fetch_assoc();
?>

<div class="container py-4">
    <div class="row g-4">

        <div class="col-12 text-center text-lg-start mb-2">
            <h1 class="title01 mb-1">Update Event</h1>
            <p class="text-muted fs-6">Edit details for event #<?php echo $e["id"]; ?></p>
        </div>

        <div class="col-12 col-lg-8">
            <div class="soft-card p-4">
                <div class="row g-3">

                    <!-- parameter passing with a hidden field -->
                    <input type="hidden" id="event_id" value="<?php echo $e["id"]; ?>">

                    <div class="col-12">
                        <label class="form-label">Event Title</label>
                        <input type="text" id="title" class="form-control" value="<?php echo $e["title"]; ?>">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea id="description" class="form-control" rows="4"><?php echo $e["description"]; ?></textarea>
                    </div>

                    <div class="col-12 col-lg-6">
                        <label class="form-label">Category</label>
                        <select id="category" class="form-select">
                            <?php
                            $categories = array("Technology", "Design", "Sports", "Club Activity", "Competition", "Soft Skills");

                            foreach ($categories as $c) {
                            ?>
                                <option value="<?php echo $c; ?>" <?php if ($e["category"] == $c) {
                                                                        echo "selected";
                                                                    } ?>><?php echo $c; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-12 col-lg-6">
                        <label class="form-label">Venue</label>
                        <input type="text" id="location" class="form-control" value="<?php echo $e["location"]; ?>">
                    </div>

                    <div class="col-12 col-lg-6">
                        <label class="form-label">Date & Time</label>
                        <input type="datetime-local" id="event_date" class="form-control" value="<?php echo date("Y-m-d\TH:i", strtotime($e["event_date"])); ?>">
                    </div>

                    <div class="col-12 col-lg-6">
                        <label class="form-label">Maximum Capacity</label>
                        <input type="number" id="capacity" class="form-control" value="<?php echo $e["max_capacity"]; ?>">
                    </div>

                    <div class="col-12 col-lg-6">
                        <label class="form-label">Status</label>
                        <select id="status" class="form-select">
                            <option value="published" <?php if ($e["status"] == "published") {
                                                            echo "selected";
                                                        } ?>>Published</option>
                            <option value="draft" <?php if ($e["status"] == "draft") {
                                                        echo "selected";
                                                    } ?>>Draft</option>
                            <option value="archived" <?php if ($e["status"] == "archived") {
                                                            echo "selected";
                                                        } ?>>Archived</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Change Event Cover Image (Optional)</label>
                        <input type="file" id="eventimage" class="form-control" accept="image/*">
                    </div>

                    <div class="col-12 col-lg-5 d-grid mt-4">
                        <button type="button" class="btn btn-pink py-2 fw-bold" onclick="updateEvent();">Update Event</button>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<?php
include "includes/footer.php";
?>

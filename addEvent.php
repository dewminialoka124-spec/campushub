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
            <h1 class="title01 mb-1">Add New Event</h1>
            <p class="text-muted fs-6">Fill in the details to publish a new campus event or workshop</p>
        </div>

        <div class="col-12 col-lg-8">
            <div class="soft-card p-4">
                <div class="row g-3">

                    <div class="col-12">
                        <label class="form-label">Event Title</label>
                        <input type="text" id="title" class="form-control" placeholder="ex: Web Development Workshop">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea id="description" class="form-control" rows="4" placeholder="Provide event details, schedule, agenda..."></textarea>
                    </div>

                    <div class="col-12 col-lg-6">
                        <label class="form-label">Category</label>
                        <select id="category" class="form-select">
                            <option value="Technology">Technology</option>
                            <option value="Design">Design</option>
                            <option value="Sports">Sports</option>
                            <option value="Club Activity">Club Activity</option>
                            <option value="Competition">Competition</option>
                            <option value="Soft Skills">Soft Skills</option>
                        </select>
                    </div>

                    <div class="col-12 col-lg-6">
                        <label class="form-label">Venue</label>
                        <input type="text" id="location" class="form-control" placeholder="ex: Main Auditorium">
                    </div>

                    <div class="col-12 col-lg-6">
                        <label class="form-label">Date & Time</label>
                        <input type="datetime-local" id="event_date" class="form-control">
                    </div>

                    <div class="col-12 col-lg-6">
                        <label class="form-label">Maximum Capacity</label>
                        <input type="number" id="capacity" class="form-control" placeholder="ex: 50">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Event Cover Image (jpg / png)</label>
                        <input type="file" id="eventimage" class="form-control" accept="image/*">
                    </div>

                    <div class="col-12 col-lg-5 d-grid mt-4">
                        <button type="button" class="btn btn-pink py-2 fw-bold" onclick="addEvent();">Publish Event</button>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<?php
include "includes/footer.php";
?>

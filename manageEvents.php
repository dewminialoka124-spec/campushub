<?php
include "config/connection.php";
include "includes/header.php";

if (!isset($_SESSION["u"]) || $_SESSION["u"]["role"] != "admin") {
    echo "<div class='container py-5'><div class='alert alert-danger rounded-4 p-4 text-center'>Admins only.</div></div>";
    include "includes/footer.php";
    exit();
}

$events = Database::search("SELECT * FROM `event` ORDER BY `event_date` DESC ");
?>

<div class="container py-4">
    <div class="row g-4">

        <div class="col-12 d-flex flex-column flex-md-row justify-content-between align-items-md-center">
            <div>
                <h1 class="title01 mb-1">Manage Events</h1>
                <p class="text-muted fs-6 mb-0">Create, edit, and publish campus activities</p>
            </div>
            <a href="addEvent.php" class="btn btn-pink px-4 py-2 mt-3 mt-md-0 shadow-sm">+ Add New Event</a>
        </div>

        <div class="col-12">
            <div class="soft-card p-4">

                <?php
                if (isset($_GET["msg"])) {
                    $alertType = isset($_GET["t"]) ? $_GET["t"] : 'info';
                ?>
                    <div class="alert alert-<?php echo $alertType; ?> rounded-3 mb-3"><?php echo $_GET["msg"]; ?></div>
                <?php
                }
                ?>

                <div class="table-responsive">
                    <table class="table table-soft align-middle">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Date</th>
                                <th>Venue</th>
                                <th>Capacity</th>
                                <th>Registered</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($events->num_rows == 0) {
                            ?>
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">No events created yet.</td>
                                </tr>
                                <?php
                            } else {
                                while ($e = $events->fetch_assoc()) {

                                    $rc = Database::search("SELECT COUNT(*) AS `total` FROM `registration` 
                                WHERE `event_id`='" . $e["id"] . "' AND `status`='registered' ");
                                    $c = $rc->fetch_assoc();
                                    $statusClass = ($e["status"] == "published") ? "pill-success" : "pill-pink";
                                ?>
                                    <tr>
                                        <td class="fw-bold text-dark"><?php echo $e["title"]; ?></td>
                                        <td><span class="pill"><?php echo $e["category"]; ?></span></td>
                                        <td><?php echo date("d M Y - h:i A", strtotime($e["event_date"])); ?></td>
                                        <td><?php echo $e["location"]; ?></td>
                                        <td class="fw-semibold"><?php echo $e["max_capacity"]; ?></td>
                                        <td class="fw-bold text-primary"><?php echo $c["total"]; ?></td>
                                        <td><span class="<?php echo $statusClass; ?>"><?php echo $e["status"]; ?></span></td>
                                        <td>
                                            <a href="updateEvent.php?id=<?php echo $e["id"]; ?>" class="btn btn-yellow btn-sm me-1">Update</a>
                                            <button class="btn btn-soft-outline btn-sm" onclick="deleteEvent('<?php echo $e["id"]; ?>');">Delete</button>
                                        </td>
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

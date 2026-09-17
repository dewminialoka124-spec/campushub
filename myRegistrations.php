<?php
include "config/connection.php";
include "includes/header.php";

// Error handling : page is only for logged users
if (!isset($_SESSION["u"])) {
    echo "<div class='container py-5'><div class='alert alert-danger rounded-4 p-4 text-center'>Please <a href='index.php' class='fw-bold'>sign in</a> to view your registrations.</div></div>";
    include "includes/footer.php";
    exit();
}

$u = $_SESSION["u"];

$rs = Database::search("SELECT `registration`.*, `event`.`title`, `event`.`event_date`, `event`.`location` 
FROM `registration` INNER JOIN `event` ON `registration`.`event_id`=`event`.`id` 
WHERE `registration`.`user_id`='" . $u["id"] . "' 
ORDER BY `registration`.`registered_date` DESC ");
?>

<div class="container py-4">
    <div class="row g-4">
        <div class="col-12 text-center text-lg-start mb-2">
            <h1 class="title01 mb-1">My Event Registrations</h1>
            <p class="text-muted fs-6">Manage all events you have registered for</p>
        </div>

        <div class="col-12">
            <div class="soft-card p-4">

                <?php
                if ($rs->num_rows == 0) {
                ?>
                    <div class="text-center py-5">
                        <img src="resource/icon/education.png" alt="No Registrations" style="height: 48px; opacity: 0.5;" class="mb-3">
                        <p class="fs-5 text-muted mb-3">You have not registered for any event yet.</p>
                        <a href="home.php" class="btn btn-pink px-4">Browse Campus Events</a>
                    </div>
                <?php
                } else {
                ?>
                    <div class="table-responsive">
                        <table class="table table-soft align-middle">
                            <thead>
                                <tr>
                                    <th>Event</th>
                                    <th>Date</th>
                                    <th>Venue</th>
                                    <th>Registered On</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($r = $rs->fetch_assoc()) {
                                    $statusClass = ($r["status"] == "registered") ? "pill-success" : "pill-danger";
                                ?>
                                    <tr>
                                        <td class="fw-bold text-dark"><?php echo $r["title"]; ?></td>
                                        <td><i class="bi bi-clock me-1 text-muted"></i><?php echo date("d M Y - h:i A", strtotime($r["event_date"])); ?></td>
                                        <td><i class="bi bi-geo-alt me-1 text-muted"></i><?php echo $r["location"]; ?></td>
                                        <td><?php echo date("d M Y", strtotime($r["registered_date"])); ?></td>
                                        <td><span class="<?php echo $statusClass; ?>"><?php echo $r["status"]; ?></span></td>
                                        <td>
                                            <?php
                                            if ($r["status"] == "registered") {
                                            ?>
                                                <button class="btn btn-soft-outline btn-sm px-3" onclick="cancelRegistration('<?php echo $r["id"]; ?>');">Cancel</button>
                                            <?php
                                            } else {
                                                echo "<span class='text-muted'>-</span>";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
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

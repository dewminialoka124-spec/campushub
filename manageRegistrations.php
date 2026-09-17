<?php
include "config/connection.php";
include "includes/header.php";

if (!isset($_SESSION["u"]) || $_SESSION["u"]["role"] != "admin") {
    echo "<div class='container py-5'><div class='alert alert-danger rounded-4 p-4 text-center'>Admins only.</div></div>";
    include "includes/footer.php";
    exit();
}

// Filter by event (parameter passing with GET)
$eventId = "";

if (isset($_GET["e"])) {
    $eventId = $_GET["e"];
}

$query = "SELECT `registration`.*, `event`.`title` FROM `registration` 
INNER JOIN `event` ON `registration`.`event_id`=`event`.`id` ";

if (!empty($eventId)) {
    $query = $query . " WHERE `registration`.`event_id`='" . $eventId . "' ";
}

$query = $query . " ORDER BY `registration`.`registered_date` DESC ";

$regs = Database::search($query);
?>

<div class="container py-4">
    <div class="row g-4">

        <div class="col-12 text-center text-lg-start mb-2">
            <h1 class="title01 mb-1">Event Registrations</h1>
            <p class="text-muted fs-6">View and manage student registrations & attendance records</p>
        </div>

        <div class="col-12">
            <div class="soft-card p-4">

                <form method="GET" action="manageRegistrations.php">
                    <div class="row g-3 align-items-end mb-4 bg-white p-3 rounded-4 border">
                        <div class="col-12 col-lg-5">
                            <label class="form-label">Filter By Event</label>
                            <select name="e" class="form-select">
                                <option value="">All Events</option>
                                <?php
                                $ev = Database::search("SELECT * FROM `event` ORDER BY `title` ASC ");
                                while ($e = $ev->fetch_assoc()) {
                                ?>
                                    <option value="<?php echo $e["id"]; ?>" <?php if ($eventId == $e["id"]) {
                                                                                echo "selected";
                                                                            } ?>><?php echo $e["title"]; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-12 col-lg-2 d-grid">
                            <button type="submit" class="btn btn-pink py-2">Filter</button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-soft align-middle">
                        <thead>
                            <tr>
                                <th>Event</th>
                                <th>Student</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Registered On</th>
                                <th>Status</th>
                                <th>Attendance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($regs->num_rows == 0) {
                            ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">No registrations found.</td>
                                </tr>
                                <?php
                            } else {
                                while ($r = $regs->fetch_assoc()) {
                                    $statusClass = ($r["status"] == "attended") ? "pill-success" : (($r["status"] == "registered") ? "pill-pink" : "pill-danger");
                                ?>
                                    <tr>
                                        <td class="fw-bold text-dark"><?php echo $r["title"]; ?></td>
                                        <td class="fw-semibold"><?php echo $r["full_name"]; ?></td>
                                        <td><?php echo $r["email"]; ?></td>
                                        <td><?php echo $r["mobile"]; ?></td>
                                        <td><?php echo date("d M Y", strtotime($r["registered_date"])); ?></td>
                                        <td><span class="<?php echo $statusClass; ?>"><?php echo $r["status"]; ?></span></td>
                                        <td>
                                            <?php
                                            if ($r["status"] == "attended") {
                                                echo "<span class='badge bg-success-subtle text-success px-3 py-2 rounded-pill'>Attended</span>";
                                            } elseif ($r["status"] == "registered") {
                                            ?>
                                                <button class="btn btn-yellow btn-sm px-3" onclick="markAttendance('<?php echo $r["id"]; ?>');">Mark Attended</button>
                                            <?php
                                            } else {
                                                echo "<span class='text-muted'>-</span>";
                                            }
                                            ?>
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

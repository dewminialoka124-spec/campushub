<?php
include "config/connection.php";
include "includes/header.php";

if (!isset($_SESSION["u"]) || $_SESSION["u"]["role"] != "admin") {
    echo "<div class='container py-5'><div class='alert alert-danger rounded-4 p-4 text-center'>Admins only.</div></div>";
    include "includes/footer.php";
    exit();
}

$students = Database::search("SELECT `user`.*, `insitutation`.`name` AS `institution_name`
    FROM `user`
    LEFT JOIN `insitutation` ON `user`.`insitutation_id`=`insitutation`.`id`
    WHERE `user`.`role`='student'
    ORDER BY `user`.`joined_date` DESC ");
?>

<div class="container py-4">
    <div class="row g-4">

        <div class="col-12 text-center text-lg-start mb-2">
            <h1 class="title01 mb-1">Manage Students</h1>
            <p class="text-muted fs-6">View student accounts and activate or deactivate access</p>
        </div>

        <div class="col-12">
            <div class="soft-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="title02 mb-0">Registered Students</h2>
                    <span class="pill"><?php echo $students->num_rows; ?> Students</span>
                </div>

                <div class="table-responsive">
                    <table class="table table-soft align-middle">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Institution</th>
                                <th>Joined On</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($students->num_rows == 0) {
                            ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">No students registered yet.</td>
                                </tr>
                                <?php
                            } else {
                                while ($student = $students->fetch_assoc()) {
                                    $isActive = $student["status"] == 1;
                                    $statusClass = $isActive ? "pill-success" : "pill-danger";
                                    $statusText = $isActive ? "Active" : "Inactive";
                                    $institution = !empty($student["institution_name"]) ? $student["institution_name"] : "No Institution Assigned";
                                ?>
                                    <tr>
                                        <td class="fw-bold text-dark"><?php echo $student["fname"] . " " . $student["lname"]; ?></td>
                                        <td><?php echo $student["email"]; ?></td>
                                        <td><?php echo $student["mobile"]; ?></td>
                                        <td><?php echo $institution; ?></td>
                                        <td><?php echo date("d M Y", strtotime($student["joined_date"])); ?></td>
                                        <td><span class="<?php echo $statusClass; ?>"><?php echo $statusText; ?></span></td>
                                        <td>
                                            <button type="button" class="btn <?php echo $isActive ? "btn-soft-outline" : "btn-yellow"; ?> btn-sm" onclick="changeUserStatus('<?php echo $student["id"]; ?>');">
                                                <?php echo $isActive ? "Deactivate" : "Activate"; ?>
                                            </button>
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

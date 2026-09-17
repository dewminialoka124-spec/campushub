<?php
include "config/connection.php";
include "includes/header.php";

if (!isset($_SESSION["u"])) {
    echo "<div class='container py-5'><div class='alert alert-danger rounded-4 p-4 text-center'>Please <a href='index.php' class='fw-bold'>sign in</a> to view your profile.</div></div>";
    include "includes/footer.php";
    exit();
}

$u = $_SESSION["u"];

// Always read the latest data from the database
$rs = Database::search("SELECT * FROM `user` WHERE `id`='" . $u["id"] . "' ");
$d = $rs->fetch_assoc();

// Get the institution name of the user
$institution_name = "No Institution Assigned";

$myins_rs = Database::search("SELECT * FROM `insitutation` WHERE `id`='" . $d["insitutation_id"] . "' ");
$myins_num = $myins_rs->num_rows;

if ($myins_num == 1) {
    $myins_data = $myins_rs->fetch_assoc();
    $institution_name = $myins_data["name"];
}

$img = "resource/profile_images/defult.png";
if (!empty($d["profile_pic"])) {
    $img = "resource/profile_images/" . $d["profile_pic"];
}
?>

<div class="container py-4">
    <div class="row g-4">

        <div class="col-12 text-center text-lg-start mb-2">
            <h1 class="title01 mb-1">My Account Profile</h1>
            <p class="text-muted fs-6">View and update your personal student information</p>
        </div>

        <div class="col-12 col-lg-4">
            <div class="soft-card text-center p-4">
                <div class="position-relative d-inline-block mb-3">
                    <img src="<?php echo $img; ?>" class="profile-img" id="img" alt="Profile picture">
                </div>
                <h2 class="title03 mb-1"><?php echo $d["fname"] . " " . $d["lname"]; ?></h2>
                <p class="text-muted small mb-2"><?php echo $institution_name; ?></p>
                <span class="pill-pink shadow-sm mb-3"><?php echo strtoupper($d["role"]); ?></span>
                <p class="text-secondary small border-top pt-3 mt-2 mb-0">Member since <?php echo date("d M Y", strtotime($d["joined_date"])); ?></p>
            </div>
        </div>

        <div class="col-12 col-lg-8">
            <div class="soft-card p-4">
                <h3 class="title02 mb-3">Update Personal Details</h3>

                <div class="row g-3">

                    <div class="col-12 col-md-6">
                        <label class="form-label">First Name</label>
                        <input type="text" id="fname" class="form-control" value="<?php echo $d["fname"]; ?>">
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">Last Name</label>
                        <input type="text" id="lname" class="form-control" value="<?php echo $d["lname"]; ?>">
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">Email Address (Locked)</label>
                        <input type="email" class="form-control bg-light" value="<?php echo $d["email"]; ?>" disabled>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">Mobile Number</label>
                        <input type="text" id="mobile" class="form-control" value="<?php echo $d["mobile"]; ?>">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Institution</label>
                        <select class="form-select" id="institution">
                            <option value="0">Select Institution</option>
                            <?php
                            $insitutation_rs = Database::search("SELECT * FROM `insitutation`");
                            $insitutation_num = $insitutation_rs->num_rows;

                            for ($x = 0; $x < $insitutation_num; $x++) {

                                $insitutation_data = $insitutation_rs->fetch_assoc();

                                if ($d["insitutation_id"] == $insitutation_data["id"]) {
                                    ?>
                                    <option value="<?php echo $insitutation_data["id"]; ?>" selected><?php echo $insitutation_data["name"]; ?></option>
                                    <?php
                                } else {
                                    ?>
                                    <option value="<?php echo $insitutation_data["id"]; ?>"><?php echo $insitutation_data["name"]; ?></option>
                                    <?php
                                }
                            }
                            ?>

                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label">About Me</label>
                        <textarea id="bio" class="form-control" rows="3" placeholder="Tell us about yourself..."><?php echo $d["bio"] ?? ''; ?></textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Profile Picture (jpg / png, max 2MB)</label>
                        <input type="file" id="profileimage" class="form-control" accept="image/*" onchange="changeProfileImg();">
                    </div>

                    <div class="col-12 col-lg-5 d-grid mt-4">
                        <button type="button" class="btn btn-pink py-2 fw-bold" onclick="updateProfile();">Save Changes</button>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<?php
include "includes/footer.php";
?>

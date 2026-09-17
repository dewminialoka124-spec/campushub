<?php
include "config/connection.php";
include "includes/header.php";

$media = Database::search("SELECT `media`.*, `user`.`fname`, `user`.`lname`, `event`.`title` 
FROM `media` INNER JOIN `user` ON `media`.`user_id`=`user`.`id` 
LEFT JOIN `event` ON `media`.`event_id`=`event`.`id` 
ORDER BY `media`.`uploaded_date` DESC ");
?>

<div class="container py-4">
    <div class="row g-4">

        <div class="col-12 text-center text-lg-start mb-2">
            <h1 class="title01 mb-1">Activity Gallery</h1>
            <p class="text-muted fs-6">Photographs uploaded by students from past events and campus activities.</p>
        </div>

        <!-- Upload box -->
        <div class="col-12">
            <div class="soft-card p-4">
                <h3 class="title03 mb-3">Upload A Photo</h3>

                <?php
                if (!isset($_SESSION["u"])) {
                ?>
                    <div class="alert alert-warning rounded-4 mb-0 p-3">
                        <i class="bi bi-info-circle me-1"></i> Please <a href="index.php" class="fw-bold">sign in</a> to share your photos with the campus community.
                    </div>
                <?php
                } else {
                ?>
                    <div class="row g-3 align-items-end">

                        <div class="col-12 col-lg-4">
                            <label class="form-label">Select Event</label>
                            <select id="gallery_event" class="form-select">
                                <option value="">General</option>
                                <?php
                                $ev = Database::search("SELECT * FROM `event` ORDER BY `title` ASC ");
                                while ($e = $ev->fetch_assoc()) {
                                ?>
                                    <option value="<?php echo $e["id"]; ?>"><?php echo $e["title"]; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-12 col-lg-4">
                            <label class="form-label">Caption</label>
                            <input type="text" id="gallery_caption" class="form-control" placeholder="ex: Day 1 of the workshop">
                        </div>

                        <div class="col-12 col-lg-3">
                            <label class="form-label">Photo (jpg / png)</label>
                            <input type="file" id="gallery_mediafile" class="form-control" accept="image/*">
                        </div>

                        <div class="col-12 col-lg-1 d-grid">
                            <button type="button" class="btn btn-pink py-2" onclick="uploadMedia();">Upload</button>
                        </div>

                    </div>
                <?php
                }
                ?>
            </div>
        </div>

        <!-- Gallery items -->
        <div class="col-12">
            <h2 class="title02 mb-3">Recent Uploads</h2>
            <div class="row g-4">
                <?php
                if ($media->num_rows == 0) {
                ?>
                    <div class="col-12">
                        <div class="soft-card text-center py-5">
                            <img src="resource/icon/education.png" alt="No Photos" style="height: 48px; opacity: 0.5;" class="mb-3">
                            <p class="fs-5 text-muted mb-0">No photos uploaded yet. Be the first to upload!</p>
                        </div>
                    </div>
                <?php
                } else {
                    while ($m = $media->fetch_assoc()) {
                        $eventTitle = empty($m["title"]) ? "General" : $m["title"];
                ?>
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="soft-card p-3 h-100 d-flex flex-column">
                                <div class="overflow-hidden rounded-3 mb-2" style="height: 180px;">
                                    <img src="<?php echo $m["file_path"]; ?>" class="gallery-img" style="height: 100%;" alt="<?php echo $m["caption"]; ?>">
                                </div>
                                <h4 class="fw-bold fs-6 text-dark mb-1 mt-1"><?php echo $m["caption"]; ?></h4>
                                <span class="pill-pink align-self-start mb-2"><?php echo $eventTitle; ?></span>
                                <div class="text-muted small mt-auto pt-2 border-top">
                                    By <span class="fw-semibold text-secondary"><?php echo $m["fname"] . " " . $m["lname"]; ?></span>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>

    </div>
</div>

<?php
include "includes/footer.php";
?>

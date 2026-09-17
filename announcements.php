<?php
include "config/connection.php";
include "includes/header.php";
?>

<div class="container py-4">
    <div class="row g-4">

        <div class="col-12 text-center text-lg-start mb-2">
            <h1 class="title01 mb-1">Campus Announcements</h1>
            <p class="text-muted fs-6">Stay updated with the latest news, notices, and updates</p>
        </div>

        <div class="col-12 d-flex flex-wrap gap-2 mb-2">
            <a href="xml/exportAnnouncements.php" target="_blank" class="btn btn-outline-secondary btn-sm px-3">
                <i class="bi bi-file-earmark-code me-1"></i> View XML Feed
            </a>
            <a href="xml/exportAnnouncements.php?download=1" class="btn btn-outline-secondary btn-sm px-3">
                <i class="bi bi-download me-1"></i> Download XML
            </a>
        </div>

        <?php
        $announcemet_rs = Database::search("SELECT * FROM `announcement` ORDER BY `published_at` DESC");
        $announcemet_num = $announcemet_rs->num_rows;

        if ($announcemet_num == 0) {
        ?>
            <div class="col-12">
                <div class="soft-card text-center py-5">
                    <img src="resource/icon/education.png" alt="No Announcements" style="height: 48px; opacity: 0.5;" class="mb-3">
                    <p class="fs-5 text-muted mb-0">No announcements posted yet.</p>
                </div>
            </div>
        <?php
        } else {
            for ($i = 0; $i < $announcemet_num; $i++) {
                $announcemet_data = $announcemet_rs->fetch_assoc();
        ?>
                <div class="col-12 col-lg-6">
                    <div class="soft-card h-100 p-4">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="pill-pink shadow-sm"><?php echo $announcemet_data["title"]; ?></span>
                            <span class="badge bg-light text-secondary rounded-pill px-3 py-2 border">
                                <i class="bi bi-clock me-1"></i> <?php echo date("d M Y", strtotime($announcemet_data["published_at"])); ?>
                            </span>
                        </div>
                        <p class="text-secondary leading-relaxed fs-6 mt-3 mb-3"><?php echo nl2br($announcemet_data["description"]); ?></p>
                        <div class="text-muted small border-top pt-2 mt-auto">
                            <b>Published On:</b> <?php echo date("d M Y - h:i A", strtotime($announcemet_data["published_at"])); ?>
                        </div>
                    </div>
                </div>
        <?php
            }
        }
        ?>

    </div>
</div>

<?php
include "includes/footer.php";
?>

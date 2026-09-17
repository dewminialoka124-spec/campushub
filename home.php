<?php
include "config/connection.php";
include "includes/header.php";

// Search values coming from the form (parameter passing with GET)
$search = "";
$category = "";

if (isset($_GET["s"])) {
    $search = $_GET["s"];
}

if (isset($_GET["c"])) {
    $category = $_GET["c"];
}

// Build the SELECT query with the search parameters
$query = "SELECT * FROM `event` WHERE `status`='published' ";

if (!empty($search)) {
    $query = $query . " AND (`title` LIKE '%" . $search . "%' OR `location` LIKE '%" . $search . "%') ";
}

if (!empty($category)) {
    $query = $query . " AND `category`='" . $category . "' ";
}

$query = $query . " ORDER BY `event_date` ASC ";

$events = Database::search($query);
?>

<div class="container py-4">

    <!-- Hero section -->
    <div class="row hero-box align-items-center mb-5">
        <div class="col-12 col-lg-7">
            <span class="pill mb-3 shadow-sm"><i class="bi bi-stars me-1"></i> Welcome to CampusHub</span>
            <h1 class="title01 mb-3">Find Your Next Campus Experience</h1>
            <p class="fs-6 text-secondary leading-relaxed mb-4">
                CampusHub brings together workshops, competitions, sports events and club activities
                from every institution. Create an account, register online and keep all your
                activities in one place.
            </p>
            <div class="d-flex flex-wrap gap-2">
                <a href="#events-section" class="btn btn-pink px-4 py-2 shadow-sm"><i class="bi bi-compass me-1"></i> Explore Events</a>
                <a href="announcements.php" class="btn btn-yellow px-4 py-2 shadow-sm"><i class="bi bi-megaphone me-1"></i> Announcements</a>
            </div>
        </div>

        <div class="col-12 col-lg-5 mt-4 mt-lg-0">
            <!-- Multimedia : promotional video -->
            <div class="overflow-hidden rounded-4 shadow-lg border border-white">
                <video class="w-100 d-block" autoplay muted playsinline controls poster="resource/promo.jpg" style="border-radius: 20px;">
                    <source src="resource/73007-545277076.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </div>

    <!-- Search form -->
    <div class="row mb-5" id="events-section">
        <div class="col-12">
            <div class="soft-card p-4">
                <form method="GET" action="home.php">
                    <div class="row g-3 align-items-end">

                        <div class="col-12 col-lg-6">
                            <label class="form-label"><i class="bi bi-search me-1 text-primary"></i>Search Events</label>
                            <input type="text" name="s" class="form-control" placeholder="Search by title or venue name..." value="<?php echo htmlspecialchars($search); ?>">
                        </div>

                        <div class="col-12 col-lg-4">
                            <label class="form-label"><i class="bi bi-funnel me-1 text-primary"></i>Category Filter</label>
                            <select name="c" class="form-select">
                                <option value="">All Categories</option>
                                <?php
                                $categories = Database::search("SELECT DISTINCT `category` FROM `event` ");
                                while ($cd = $categories->fetch_assoc()) {
                                ?>
                                    <option value="<?php echo $cd["category"]; ?>" <?php if ($category == $cd["category"]) {
                                                                                        echo "selected";
                                                                                    } ?>>
                                        <?php echo $cd["category"]; ?>
                                    </option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-12 col-lg-2 d-grid">
                            <button type="submit" class="btn btn-pink py-2"><i class="bi bi-search me-1"></i> Search</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Event list -->
    <div class="row g-4 mb-5">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="title02 m-0">Upcoming Campus Events</h2>
                <p class="text-muted small m-0 mt-1">Register before seats run out</p>
            </div>
            <span class="pill-pink shadow-sm"><?php echo $events->num_rows; ?> Events Available</span>
        </div>

        <?php
        if ($events->num_rows == 0) {
        ?>
            <div class="col-12">
                <div class="soft-card text-center py-5">
                    <img src="resource/icon/education.png" alt="No events" style="height: 52px; opacity: 0.4;" class="mb-3">
                    <h3 class="title03 text-muted">No Events Match Your Search</h3>
                    <p class="text-muted small mb-0">Try searching for a different title or resetting your category filter.</p>
                </div>
            </div>
        <?php
        } else {
            while ($e = $events->fetch_assoc()) {
                // Count how many students registered
                $rc = Database::search("SELECT COUNT(*) AS `total` FROM `registration` 
                WHERE `event_id`='" . $e["id"] . "' AND `status`='registered' ");
                $count = $rc->fetch_assoc();

                $image = "resource/event_images/default.jpg";
                if (!empty($e["image"])) {
                    $image = "resource/event_images/" . $e["image"];
                }

                $maxCap = (int)$e["max_capacity"];
                $totalReg = (int)$count["total"];
                $percent = ($maxCap > 0) ? min(100, round(($totalReg / $maxCap) * 100)) : 0;
                $isFull = ($totalReg >= $maxCap);
        ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="event-card">
                        <div class="event-img-wrapper">
                            <img src="<?php echo $image; ?>" class="event-img" alt="<?php echo $e["title"]; ?>">
                            <div class="position-absolute top-0 start-0 p-3">
                                <span class="pill shadow-sm"><i class="bi bi-tag-fill me-1"></i><?php echo $e["category"]; ?></span>
                            </div>
                            <?php if ($isFull) { ?>
                                <div class="position-absolute top-0 end-0 p-3">
                                    <span class="pill-danger shadow-sm"><i class="bi bi-exclamation-circle-fill me-1"></i>FULL</span>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="card-body">
                            <h3 class="title03 mb-2"><?php echo $e["title"]; ?></h3>
                            <div class="text-secondary small mb-3">
                                <div class="mb-2">
                                    <i class="bi bi-calendar3 me-1 text-primary"></i> <b>Date:</b> <?php echo date("d M Y - h:i A", strtotime($e["event_date"])); ?>
                                </div>
                                <div class="mb-3">
                                    <i class="bi bi-geo-alt-fill me-1 text-danger"></i> <b>Venue:</b> <?php echo $e["location"]; ?>
                                </div>
                                
                                <div class="mb-1 d-flex justify-content-between text-muted small">
                                    <span><i class="bi bi-people-fill me-1 text-info"></i> Capacity</span>
                                    <span class="fw-bold <?php echo $isFull ? 'text-danger' : 'text-primary'; ?>"><?php echo $totalReg . " / " . $maxCap; ?> Seats</span>
                                </div>
                                <div class="progress" style="height: 6px; border-radius: 10px; background-color: #e2e8f0;">
                                    <div class="progress-bar <?php echo $isFull ? 'bg-danger' : 'bg-primary'; ?>" role="progressbar" style="width: <?php echo $percent; ?>%; border-radius: 10px;"></div>
                                </div>
                            </div>
                            <div class="mt-auto pt-2">
                                <a href="eventView.php?id=<?php echo $e["id"]; ?>" class="btn btn-pink w-100 shadow-sm"><i class="bi bi-ticket-perforated me-1"></i> View & Register</a>
                            </div>
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

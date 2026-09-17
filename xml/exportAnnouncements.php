<?php
include "../config/connection.php";
include "buildAnnouncementsXml.php";

$doc = buildAnnouncementsXml();

if (isset($_GET["download"])) {
    // Force a file download
    header("Content-Type: application/xml");
    header("Content-Disposition: attachment; filename=\"announcements.xml\"");
} else {
    // Show the raw XML in the browser
    header("Content-Type: text/xml");
}

echo $doc->saveXML();

?>

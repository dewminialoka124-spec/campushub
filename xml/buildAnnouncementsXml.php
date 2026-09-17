<?php

// Builds the announcements XML document from the database.
// The XML is assembled as a string (with a DOCTYPE pointing at
// announcements.dtd) and then parsed back into a DOMDocument, which is
// the most reliable way to get PHP's DTD validation working afterwards.
function buildAnnouncementsXml() {

    $rs = Database::search("SELECT * FROM `announcement` ORDER BY `published_at` DESC");

    $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    $xml .= "<!DOCTYPE announcements SYSTEM \"announcements.dtd\">\n";
    $xml .= "<announcements>\n";

    while ($row = $rs->fetch_assoc()) {
        $xml .= "  <announcement id=\"" . htmlspecialchars($row["a_id"]) . "\">\n";
        $xml .= "    <title>" . htmlspecialchars($row["title"]) . "</title>\n";
        $xml .= "    <description>" . htmlspecialchars($row["description"]) . "</description>\n";
        $xml .= "    <published_at>" . htmlspecialchars($row["published_at"]) . "</published_at>\n";
        $xml .= "  </announcement>\n";
    }

    $xml .= "</announcements>\n";

    $doc = new DOMDocument();
    $doc->preserveWhiteSpace = false;
    $doc->formatOutput = true;

    // Base path so the DOCTYPE's relative "announcements.dtd" resolves
    // to the copy sitting in this same xml/ folder.
    $doc->documentURI = "file://" . __DIR__ . "/announcements.xml";
    $doc->loadXML($xml);

    return $doc;
}

?>

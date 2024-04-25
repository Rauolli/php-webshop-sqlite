<?php
// Auswahl der Abteilungen
$db = new SQLite3('webshop.db');
if (!($res = $db->query("SELECT * FROM abteilung"))) {
    echo "Fehler bei der Abfrage.<br>";
    exit;
}
while ($dsatz = $res->fetchArray(SQLITE3_ASSOC)) {
    echo "<p class='button'><a href='index.php?abt=" . $dsatz['abteilung_id'] . "'>" . $dsatz['abteilung_name'] . "</a></p>";
}

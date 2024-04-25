<?php
// Session starten oder wieder aufnehmen
session_start();
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webshop</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h3>Wilkommen zum Webshop</h3>
        <p>Bitte wählen Sie eine Abteilung:</p>
        <?php
        // Datenbankverbindung
        if (extension_loaded('sqlite3')) {
            // echo "SQLite3-Treiber ist geladen.<br>";
            // $version = SQLite3::version();
            // echo "SQLite3-Version: " . $version['versionString'] . "<br>";
            $db = new SQLite3('webshop.db');
        } else {
            echo "<p class='error'>SQLite3-Treiber konnte nicht geladen werden.</p>";
        }
        $db = new SQLite3('webshop.db');
        include 'webshop.inc.php';

        // Artikel der Abteilungen
        if (isset($_GET['abt'])) {
            $abteilung_id = $_GET['abt'];
            $sql = "SELECT * FROM artikel WHERE abteilung_id = $abteilung_id";
            $res = $db->query($sql);

            // Tabellen-Überschrift
            echo "<form action='webshop_warenkorb.php' method='post'>";
            echo "<table>";
            echo "<tr>";
            echo "<th>Artikel</th>";
            echo "<th>Abteilung</th>";
            echo "<th>Artikel-Nr.</th>";
            echo "<th>Preis</th>";
            echo "<th>Anzahl</th>";
            echo "</tr>";

            while ($dsatz = $res->fetchArray(SQLITE3_ASSOC)) {
                $artikel_id = $dsatz['artikel_id'];
                echo "<tr>";
                echo "<td>" . $dsatz['artikel_name'] . "</td>";
                echo "<td>" . $dsatz['abteilung_id'] . "</td>";
                echo "<td>" . $dsatz['artikel_id'] . "</td>";
                echo "<td>" . number_format($dsatz['artikel_preis'], 2, ",", ".") . " €</td>";
                echo "<td><input type='text' name='anzahl[$artikel_id]' size='5'";
                if (isset($_SESSION['anzahl'][$artikel_id])) {
                    echo " value='" . $_SESSION['anzahl'][$artikel_id] . "'";
                } else {
                    echo " value='0'";
                }
                echo "></td>";
                echo "</tr>";
            }
            $db->close();
            echo "</table>";
            echo "<p class='button'><input type='submit' value='In den Warenkorb'></p>";
            echo "</form>";
        }

        ?>
    </div>
</body>

</html>
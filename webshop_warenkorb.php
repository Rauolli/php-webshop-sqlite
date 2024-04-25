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
        <h3>Webshop</h3>
        <?php
        $db = new SQLite3('webshop.db');
        include 'webshop.inc.php';
        ?>
        <br>
        <p>Ihr Warenkorb:</p>
        <table>
            <tr>
                <th>Artikel</th>
                <th>Abt.</th>
                <th>Art.-Nr.</th>
                <th>Einzelpreis</th>
                <th>Anzahl</th>
                <th>Gesamtpreis</th>
            </tr>
            <!-- Zum Test - danach entfernen -->
            <!-- </table> -->
            <?php
            // Übernahme von $_POST zu $_SESSION
            if (isset($_POST['anzahl'])) {
                foreach ($_POST['anzahl'] as $artikel_id => $anzahl) {
                    $_SESSION['anzahl'][$artikel_id] = intval($anzahl);
                }
            }
            // Ausgabe von $_SESSION
            $summe = 0;
            if (isset($_SESSION['anzahl'])) {
                foreach ($_SESSION['anzahl'] as $artikel_id => $anzahl) {
                    if (intval($anzahl) > 0) {
                        $sql = "SELECT * FROM artikel WHERE artikel_id = $artikel_id";
                        $res = $db->query($sql);
                        $dsatz = $res->fetchArray(SQLITE3_ASSOC);
                        $anzahl = $_SESSION['anzahl'][$artikel_id];
                        $gesamtpreis = $dsatz['artikel_preis'] * $anzahl;
                        $summe += $gesamtpreis;
                        echo "<tr>";
                        echo "<td>" . $dsatz['artikel_name'] . "</td>";
                        echo "<td>" . $dsatz['abteilung_id'] . "</td>";
                        echo "<td>" . $artikel_id . "</td>";
                        echo "<td>" . number_format($dsatz['artikel_preis'], 2, ",", ".") . " €</td>";
                        echo "<td>" . $anzahl . "</td>";
                        $summe += $anzahl * $dsatz['artikel_preis'];
                        echo "<td>" . number_format($gesamtpreis, 2, ",", ".") . " €</td>";
                        echo "</tr>";

                        // Testausgabe der Werte
                        // echo "<p>Artikel: " . $dsatz['artikel_name'] . "</p>";
                        // echo "<p>Abteilung: " . $dsatz['abteilung_id'] . "</p>";
                        // echo "<p>Artikel-Nr.: " . $dsatz['artikel_id'] . "</p>";
                        // echo "<p>Einzelpreis: " . number_format($dsatz['artikel_preis'], 2, ",", ".") . " €</p>";
                        // echo "<p>Anzahl: " . $anzahl . "</p>";
                        // echo "<p>Gesamtpreis: " . number_format($gesamtpreis, 2, ",", ".") . " €</p>";
                        // echo "<hr>";
                    }
                }
            }

            echo "<tr class='summe'>";
            echo "<td colspan='5'>Summe:</td>";
            echo "<td>" . number_format($summe, 2, ",", ".") . " €</td>";
            echo "</tr>";
            $db->close();
            ?>
            <!-- nach Test Kommentar entfernen -->
        </table>
    </div>
</body>

</html>
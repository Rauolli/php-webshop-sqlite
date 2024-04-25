<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    if (extension_loaded('sqlite3')) {
        echo "SQLite3-Treiber ist geladen.<br>";
        $version = SQLite3::version();
        echo "SQLite3-Version: " . $version['versionString'] . "<br>";
        $db = new SQLite3('sc_shop.db');
        // Tabelle Abteilung anlegen
        $sql = "CREATE TABLE abteilung (
            abteilung_id INTEGER PRIMARY KEY,
            abteilung_name TEXT
        )";
        $db->exec($sql);
        // Tabelle Abteilung füllen
        $sql = "INSERT INTO abteilung (abteilung_id, abteilung_name) VALUES
            (1, 'Computer und Hardware'),
            (2, 'TV, Video und DVD'),
            (3, 'Fotografie')";
        $db->exec($sql);

        // Tabelle Artikel anlegen
        $sql = "CREATE TABLE artikel (
            abteilung_id INTEGER,
            artikel_id INTEGER,
            artikel_name TEXT,
            artikel_preis REAL
        )";
        $db->exec($sql);
        // Tabelle Artikel füllen
        $db = new SQLite3('sc_shop.db');
        $sql = "INSERT INTO artikel (abteilung_id, artikel_id, artikel_name, artikel_preis) VALUES
            (1, 7609, 'Notebook', 395.9),
            (1, 7612, 'USB-Stick', 12.95),
            (1, 7632, 'Laserdrucker', 125.5),
            (1, 7678, 'NAS-Server', 280.15),
            (2, 4418, 'LED-Fernseher', 249),
            (2, 4422, 'Blu-Ray-Player', 49.95),
            (2, 4471, 'Sat-Antenne', 39.95),
            (2, 4475, 'Beamer', 179),
            (2, 4482, 'Heimkino', 489),
            (3, 6213, 'Digitalkamera', 89.95),
            (3, 6265, 'Action-Cam', 129.95),
            (3, 6267, 'Camcorder', 59.95)";
        $db->exec($sql);
        $db->close();
        echo "Datenbank sc_shop.db wurde angelegt.";
    } else {
        echo "SQLite3-Treiber ist nicht geladen.";
    }
    ?>
</body>

</html>
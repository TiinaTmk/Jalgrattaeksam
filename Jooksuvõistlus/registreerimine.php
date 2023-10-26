<?php
session_start();
require($_SERVER["DOCUMENT_ROOT"] . "/../config.php");
global $yhendus;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Registreerimine</title>
    <meta charset="utf-8">
    <meta name="description" content="This is a description">
    <link rel="stylesheet" href="styles.css" />
    <style>
        header.main-header {
            background-image: url('https://i.pinimg.com/736x/d4/0e/1e/d40e1eb37fdf0482d00ef3f193730993.jpg');
        }
        .table-container {
            display: flex;
            justify-content: center;
        }
    </style>
</head>

<body>
    <header class="main-header">
        <nav class="nav main-nav">
            <ul>
                <li><a href="index.php">REGISTREERIMINE</a></li>
                <li><a href="stardiprotokoll.php">STARDIPROTOKOLL</a></li>
                <li><a href="vaheajad.php">VAHEAJAD</a></li>
                <li><a href="lõpuprotokoll.php">LÕPUPROTOKOLL</a></li>
                <li><a href="autasustamine.php">AUTASUSTAMINE</a></li>
                <li><a href="adminn.php">ADMINN</a></li>
            </ul>
        </nav>
        <h1 class="run-name run-name-large">Registreerimine</h1>
        <div class="container">
        </div>
    </header>

<?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $eesnimi = $_POST["eesnimi"];
    $perekonnanimi = $_POST["perekonnanimi"];
    $sugu = $_POST["sugu"];
    $synniaeg = $_POST["synniaeg"];

    if (empty($perekonnanimi)) {
        echo "Perekonnanimi ei tohi olla tühi!";
    } else {
        $insert_query = $yhendus->prepare("INSERT INTO jooks (eesnimi, perekonnanimi, sugu, synniaeg) VALUES (?, ?, ?, ?)");
        $insert_query->bind_param("ssss", $eesnimi, $perekonnanimi, $sugu, $synniaeg);

        if ($insert_query->execute()) {
            $_SESSION["registrationSuccessful"] = true;
            echo "<strong>Registreerimine õnnestus, kohtume stardis!</strong>";
        } else {
            echo "Registreerimine ebaõnnestus: " . $insert_query->error;
        }

        $insert_query->close();
    }
}
?>
   
        <div class="form-style">
            <form method="POST" action="">
                <dl>
                    <label for="fname">Eesnimi:</label>
                    <input id="fname" type="text" name="eesnimi" placeholder="Eesnimi" required>
                    <br><br>

                    <label for "lname">Perekonnanimi:</label>
                    <input type="text" id="lname" name="perekonnanimi" placeholder="Perekonnanimi" required>
                    <br><br>

                    <label for="sugu">Sugu:</label>
                    <select id="sugu" name="sugu" required>
                        <option value="mees">Mees</option>
                        <option value="naine">Naine</option>
                    </select>
                    <br><br>

                    <label for="synniaeg">Sünniaeg:</label>
                    <input type="date" id="synniaeg" name="synniaeg" required>
                    <br><br>

                    <button class="button button1" type="submit" value="Submit">Edasta</button>
                </dl>
            </form>
        </div>
    
</div>

    <footer class="main-footer">
        <div class="container main-footer-container">
            <h3 class="run-name">Parim jooks 2024!</h3>
            <ul class="nav footer-nav">
            </ul>
        </div>
    </footer>
</body>

</html>

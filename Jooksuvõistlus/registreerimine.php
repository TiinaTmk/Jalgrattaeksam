<?php
require($_SERVER["DOCUMENT_ROOT"] . "/../config.php");
global $yhendus;

$registrationSuccessful = false;

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
            $registrationSuccessful = true;
        } else {
            echo "Registreerimine ebaõnnestus: " . $insert_query->error;
        }

        $insert_query->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registreeru</title>
    <style>
        body {
            background-image: url('https://cdn.pixabay.com/photo/2016/11/29/03/27/track-and-field-1867053_1280.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
        }
        .menu {
            background-color: #333;
            overflow: hidden;
        }
        .menu a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        .content-center {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-style {
            background-color: rgba(255, 255, 255, 0.7);
            padding: 20px;
            border-radius: 10px;
        }
        .button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 10px;
        }
        .form-style input[type="text"],
        .form-style select,
        .form-style input[type="date"] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
            border-radius: 5px;
        }
    </style>
</head>
<body>



<div class="content-center">
    <?php if ($registrationSuccessful) : ?>
        <h1 class="run-name run-name-large">Registreerimine õnnestus, kohtume stardis!</h1>
    <?php else : ?>
        <div class="form-style">
            <form method="POST" action="">
                <dl>
                    <h1 class="run-name run-name-large"><label for="fname">Eesnimi:</label>
                        <input id="fname" type="text" name="eesnimi" placeholder="Eesnimi" required>
                        <br><br>

                        <label for="lname">Perekonnanimi:</label>
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
    <?php endif; ?>

    
</div>
</body>
</html>

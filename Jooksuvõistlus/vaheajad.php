<?php
require($_SERVER["DOCUMENT_ROOT"] . "/../config.php");
global $yhendus;

if (isset($_GET['add_vaheaeg1'])) {
    $participant_id = $_GET['add_vaheaeg1'];
    $vaheaeg1_time = date('Y-m-d H:i:s');

    $update_command = $yhendus->prepare("UPDATE jooks SET vaheaeg1 = ? WHERE id = ?");
    $update_command->bind_param("si", $vaheaeg1_time, $participant_id);

    if ($update_command->execute()) {
        header('Location: ?page=vaheajad');
        exit();
    } else {
        echo "Vaheaeg1 lisamine nurjus: " . $update_command->error;
    }

    $update_command->close();
}

if (isset($_GET['add_vaheaeg2'])) {
    $participant_id = $_GET['add_vaheaeg2'];
    $vaheaeg2_time = date('Y-m-d H:i:s');

    $update_command = $yhendus->prepare("UPDATE jooks SET vaheaeg2 = ? WHERE id = ?");
    $update_command->bind_param("si", $vaheaeg2_time, $participant_id);

    if ($update_command->execute()) {
        header('Location: ?page=vaheajad');
        exit();
    } else {
        echo "Vaheaeg2 lisamine nurjus: " . $update_command->error;
    }

    $update_command->close();
}

$kask = $yhendus->prepare("SELECT id, eesnimi, perekonnanimi, sugu, synniaeg, start, vaheaeg1, vaheaeg2 FROM jooks WHERE start IS NOT NULL ORDER BY perekonnanimi");
$kask->execute();
$kask->bind_result($id, $eesnimi, $perekonnanimi, $sugu, $synniaeg, $start, $vaheaeg1, $vaheaeg2);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Vaheajad</title>
    <meta charset="utf-8">
    <meta name="description" content="See is a description">
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
        <h1 class="run-name run-name-large">Vaheajad</h1>
        <div class="container">
        </div>
    </header>

    <?php
    echo "<div class='table-container'>";
    echo "<table border='1'>";
    echo "<tr>
            <th>Number</th>
            <th>Perekonnanimi</th>
            <th>Eesnimi</th>
            <th>Sugu</th>
            <th>Sünniaeg</th>
            <th>Start</th>
            <th>Vaheaeg 1</th>
            <th>Lisa Vaheaeg1</th>
            <th>Vaheaeg 2</th>
            <th>Lisa Vaheaeg2</th>
        </tr>";

    $participantNumber = 1;

    while ($kask->fetch()) {
        $perekonnanimi = $perekonnanimi ?? "";
        $eesnimi = $eesnimi ?? "";
        $sugu = $sugu ?? "";
        $synniaeg = $synniaeg ?? "";
        $start = $start ?? "";
        $vaheaeg1 = $vaheaeg1 ?? "";
        $vaheaeg2 = $vaheaeg2 ?? "";

        echo "<tr>";
        echo "<td>" . $participantNumber . "</td>";
        echo "<td>" . htmlspecialchars($perekonnanimi) . "</td>";
        echo "<td>" . htmlspecialchars($eesnimi) . "</td>";
        echo "<td>" . htmlspecialchars($sugu) . "</td>";
        echo "<td>" . htmlspecialchars($synniaeg) . "</td>";
        echo "<td>" . htmlspecialchars($start) . "</td>";
        echo "<td>" . htmlspecialchars($vaheaeg1) . "</td>";
        echo '<td><a href="?add_vaheaeg1=' . $id . '" class="button-style">Lisa Vaheaeg1</a></td>';
        echo "<td>" . htmlspecialchars($vaheaeg2) . "</td>";
        echo '<td><a href="?add_vaheaeg2=' . $id . '" class="button-style">Lisa Vaheaeg2</a></td>';
        echo "</tr>";

        $participantNumber++;
    }

    echo "</table>";
    echo "</div>";

    $kask->close();
    ?>

    </section>
    <footer class="main-footer">
        <div class="container main-footer-container">
            <h3 class="run-name">Parim jooks 2024!</h3>
            <ul class="nav footer-nav">
            </ul>
        </div>
    </footer>
</body>

</html>

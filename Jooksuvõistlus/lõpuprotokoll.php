<?php
require($_SERVER["DOCUMENT_ROOT"] . "/../config.php");
global $yhendus;

if (isset($_GET['add_finish'])) {
    $participant_id = $_GET['add_finish'];
    $finish_time = date('Y-m-d H:i:s');

    $update_command = $yhendus->prepare("UPDATE jooks SET finish = ? WHERE id = ?");
    $update_command->bind_param("si", $finish_time, $participant_id);

    if ($update_command->execute()) {
        header('Location: ?page=lopuprotokoll');
        exit();
    } else {
        echo "Finišeerimine nurjus: " . $update_command->error;
    }

    $update_command->close();
}

$kask = $yhendus->prepare("SELECT id, eesnimi, perekonnanimi, sugu, synniaeg, start, vaheaeg1, vaheaeg2, finish FROM jooks WHERE vaheaeg1 IS NOT NULL AND vaheaeg2 IS NOT NULL ORDER BY perekonnanimi");
$kask->execute();
$kask->bind_result($id, $eesnimi, $perekonnanimi, $sugu, $synniaeg, $start, $vaheaeg1, $vaheaeg2, $finish);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Lõpuprotokoll</title>
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
        <h1 class="run-name run-name-large">Lõpuprotokoll</h1>
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
                <th>Vaheaeg 2</th>
                <th>Finiš</th>
                <th>Lisa finiš</th>
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
            $finish = $finish ?? "";
          

            echo "<tr>";
            echo "<td>" . $participantNumber . "</td>";
            echo "<td>" . htmlspecialchars($perekonnanimi) . "</td>";
            echo "<td>" . htmlspecialchars($eesnimi) . "</td>";
            echo "<td>" . htmlspecialchars($sugu) . "</td>";
            echo "<td>" . htmlspecialchars($synniaeg) . "</td>";
            echo "<td>" . htmlspecialchars($start) . "</td>";
            echo "<td>" . htmlspecialchars($vaheaeg1) . "</td>";
            echo "<td>" . htmlspecialchars($vaheaeg2) . "</td>";
            echo "<td>" . htmlspecialchars($finish) . "</td>";
            echo '<td><a href="?add_finish=' . $id . '" class="button-style">Finiš</a></td>';
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

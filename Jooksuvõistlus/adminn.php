<?php
require($_SERVER["DOCUMENT_ROOT"] . "/../config.php");
global $yhendus;

if (isset($_POST['delete_participant'])) {
    $participantId = $_POST['participant_id'];
    $delete_command = $yhendus->prepare("DELETE FROM jooks WHERE id = ?");
    $delete_command->bind_param("i", $participantId);

    if ($delete_command->execute()) {
        header('Location: ?page=adminn');
        exit();
    } else {
        echo "Kustutamine nurjus: " . $delete_command->error;
    }

    $delete_command->close();
}

$kask = $yhendus->prepare("SELECT id, eesnimi, perekonnanimi, sugu, synniaeg, start, finish, vaheaeg1, vaheaeg2 FROM jooks ORDER BY perekonnanimi");
$kask->execute();
$kask->bind_result($id, $eesnimi, $perekonnanimi, $sugu, $synniaeg, $start, $finish, $vaheaeg1, $vaheaeg2);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Adminn</title>
    <meta charset="utf-8">
    <meta name="description" content="See is a description">
    <link rel="stylesheet" href="styles.css" />
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
    <h1 class="run-name run-name-large">Adminn</h1>
    <div class="container">
    </div>
</header>

<section class "content-section container">
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
            <th>Finiš</th>
            <th>Vaheaeg1</th>
            <th>Vaheaeg2</th>
            <th>Kustuta</th>
          </tr>";

    $participantNumber = 1;

    while ($kask->fetch()) {
        $perekonnanimi = $perekonnanimi ?? "";
        $eesnimi = $eesnimi ?? "";
        $sugu = $sugu ?? "";
        $synniaeg = $synniaeg ?? "";
        $start = $start ?? "";
        $finish = $finish ?? "";
        $vaheaeg1 = $vaheaeg1 ?? "";
        $vaheaeg2 = $vaheaeg2 ?? "";

        echo "<tr>";
        echo "<td>" . $participantNumber . "</td>";
        echo "<td>" . htmlspecialchars($perekonnanimi) . "</td>";
        echo "<td>" . htmlspecialchars($eesnimi) . "</td>";
        echo "<td>" . htmlspecialchars($sugu) . "</td>";
        echo "<td>" . htmlspecialchars($synniaeg) . "</td>";
        echo "<td>" . htmlspecialchars($start) . "</td>";
        echo "<td>" . htmlspecialchars($finish) . "</td>";
        echo "<td>" . htmlspecialchars($vaheaeg1) . "</td>";
        echo "<td>" . htmlspecialchars($vaheaeg2) . "</td>";
        echo '<td>
                <form method="post" action="?page=adminn">
                    <input type="hidden" name="participant_id" value="' . $id . '">
                    <button class="delete-button" name="delete_participant" type="submit">Kustuta</button>
                </form>
              </td>';
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

<?php
require($_SERVER["DOCUMENT_ROOT"] . "/../config.php");
global $yhendus;

if (isset($_POST['start_time'])) {
    $currentTimestamp = date("Y-m-d H:i:s");
    $update_command = $yhendus->prepare("UPDATE jooks SET start = ?");
    $update_command->bind_param("s", $currentTimestamp);

    if ($update_command->execute()) {
        header('Location: ?page=stardiprotokoll');
        exit();
    } else {
        echo "Start time insertion failed: " . $update_command->error;
    }

    $update_command->close();
}

if (isset($_GET['kustuta'])) {
    $delete_id = $_GET['kustuta'];
    $delete_command = $yhendus->prepare("DELETE FROM jooks WHERE id = ?");
    $delete_command->bind_param("i", $delete_id);

    if ($delete_command->execute()) {
        header('Location: ?page=stardiprotokoll');
        exit();
    } else {
        echo "Kustutamine nurjus: " . $delete_command->error;
    }

    $delete_command->close();
}

$kask = $yhendus->prepare("SELECT id, eesnimi, perekonnanimi, sugu, synniaeg, start FROM jooks WHERE start IS NULL ORDER BY perekonnanimi");
$kask->execute();
$kask->bind_result($id, $eesnimi, $perekonnanimi, $sugu, $synniaeg, $start);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Stardiprotokoll</title>
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
    <h1 class="run-name run-name-large">Stardiprotokoll</h1>
    <div class="container">
    </div>
</header>

<div class="start-button">
    <form method="post" action="?page=stardiprotokoll">
        <button class="delete-button" type="submit" name="start_time">START</button>
    </form>
    <br>
</div>

<?php
if (!isset($_POST['start_time'])) { // Check if the "START" button was not clicked
    echo "<div class='table-container'>";
    echo "<table border='1'>";
    echo "<tr>
            <th>Number</th>
            <th>Perekonnanimi</th>
            <th>Eesnimi</th>
            <th>Sugu</th>
            <th>Sünniaeg</th>
            <th>Stardiaeg</th>
            <th>Kustuta</th>
          </tr>";

    $participantNumber = 1;

    while ($kask->fetch()) {
        $perekonnanimi = $perekonnanimi ?? "";
        $eesnimi = $eesnimi ?? "";
        $sugu = $sugu ?? "";
        $synniaeg = $synniaeg ?? "";
        $start = $start ?? "";

        echo "<tr>";
        echo "<td>" . $participantNumber . "</td>";
        echo "<td>" . htmlspecialchars($perekonnanimi) . "</td>";
        echo "<td>" . htmlspecialchars($eesnimi) . "</td>";
        echo "<td>" . htmlspecialchars($sugu) . "</td>";
        echo "<td>" . htmlspecialchars($synniaeg) . "</td>";
        echo '<td><input class="start-time" type="text" value="' . htmlspecialchars($start) . '" disabled></td>';
        echo '<td><button class="delete-button" onclick="deleteParticipant(' . $id . ')">Kustuta</button></td>';
        echo "</tr>";

        $participantNumber++;
    }

    echo "</table>";
    echo "</div";
    
    $kask->close();
}
?>

<footer class="main-footer">
    <div class="container main-footer-container">
        <h3 class="run-name">Parim jooks 2024!</h3>
        <ul class="nav footer-nav">
        </ul>
    </div>
</footer>
</body>

<script>
function deleteParticipant(participantId) {
    if (confirm("Are you sure you want to delete this participant?")) {
        window.location.href = '?page=stardiprotokoll&kustuta=' + participantId;
    }
}
</script>

</html>

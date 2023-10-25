<?php
require($_SERVER["DOCUMENT_ROOT"]."/../config.php");
global $yhendus;


$registrationSuccessful = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $eesnimi = $_POST["eesnimi"];
    $perekonnanimi = $_POST["perekonnanimi"];
    $sugu = $_POST["sugu"];
    $synniaeg = $_POST["synniaeg"];
    $koht = 0;

    if (empty($perekonnanimi)) {
        echo "Perekonnanimi ei tohi olla tühi!";
    } else {
        $insert_query = $yhendus->prepare("INSERT INTO jooks (eesnimi, perekonnanimi, sugu, synniaeg, koht) VALUES (?, ?, ?, ?, ?)");
        $insert_query->bind_param("ssssi", $eesnimi, $perekonnanimi, $sugu, $synniaeg, $koht);

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
<html lang="en">

<head>
  <title>Autasustamine</title>
  <meta charset="utf-8">
  <meta name="description" content="See on kirjeldus">
  <link rel="stylesheet" href="styles.css" />
  <style>
    header.main-header {
      background-image: url('https://i.pinimg.com/736x/d4/0e/1e/d40e1eb37fdf0482d00ef3f193730993.jpg');
    }
    .table-container {
      display: flex;
      justify-content: center;
      position: center;
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
    <h1 class="run-name run-name-large">Autasustamine</h1>
    <div class="container">
    </div>
  </header>

  <section class="content-section container">
  <h2 class="section-header">Esikolmik</h2>
  <div class="table-container">
  </section>
    <?php
    $best_times_query = $yhendus->prepare("SELECT id, eesnimi, perekonnanimi, sugu, synniaeg, start, vaheaeg1, vaheaeg2, finish, koht
                                           FROM jooks
                                           WHERE finish IS NOT NULL
                                           ORDER BY finish ASC
                                           LIMIT 3");
    $best_times_query->execute();
    $best_times_query->bind_result($id, $eesnimi, $perekonnanimi, $sugu, $synniaeg, $start, $vaheaeg1, $vaheaeg2, $finish, $koht);

    echo "<div class='table-container'>";
    echo "<table border='1'>";
    echo "<tr>
            <th>Koht</th>
            <th>Perekonnanimi</th>
            <th>Eesnimi</th>
            <th>Sugu</th>
            <th>Sünniaeg</th>
            <th>Stardiaeg</th>
            <th>Vaheaeg 1</th>
            <th>Vaheaeg 2</th>
            <th>Finišiaeg</th>
          </tr>";

    $participantNumber = 1;

    while ($best_times_query->fetch()) {
      echo "<tr>";
      echo "<td>" . $participantNumber . "</td>";
      echo "<td>" . ($perekonnanimi ? htmlspecialchars($perekonnanimi) : '') . "</td>";
      echo "<td>" . ($eesnimi ? htmlspecialchars($eesnimi) : '') . "</td>";
      echo "<td>" . ($sugu ? htmlspecialchars($sugu) : '') . "</td>";
      echo "<td>" . ($synniaeg ? htmlspecialchars($synniaeg) : '') . "</td>";
      echo "<td>" . ($start ? htmlspecialchars($start) : '') . "</td>";
      echo "<td>" . ($vaheaeg1 ? htmlspecialchars($vaheaeg1) : '') . "</td>";
      echo "<td>" . ($vaheaeg2 ? htmlspecialchars($vaheaeg2) : '') . "</td>";
      echo "<td>" . ($finish ? htmlspecialchars($finish) : '') . "</td>";
      echo "</tr>";

      $participantNumber++;
    }

    echo "</table>";
    echo "</div>";

    $best_times_query->close();
    

    
    $remaining_runners_query = $yhendus->prepare("SELECT id, eesnimi, perekonnanimi, sugu, synniaeg, start, vaheaeg1, vaheaeg2, finish, koht
                                                  FROM jooks
                                                  WHERE finish IS NOT NULL
                                                  ORDER BY finish ASC
                                                  LIMIT 3, 999"); // Skip the top 3, select the rest
    $remaining_runners_query->execute();
    $remaining_runners_query->bind_result($id, $eesnimi, $perekonnanimi, $sugu, $synniaeg, $start, $vaheaeg1, $vaheaeg2, $finish, $koht);

    
    echo '<h2 class="section-header">Järgmised tulemused</h2>';
    echo "<div class='table-container'>";
    echo "<table border='1'>";
    echo "<tr>
            <th>Koht</th>
            <th>Perekonnanimi</th>
            <th>Eesnimi</th>
            <th>Sugu</th>
            <th>Sünniaeg</th>
            <th>Stardiaeg</th>
            <th>Vaheaeg 1</th>
            <th>Vaheaeg 2</th>
            <th>Finišiaeg</th>
          </tr>";

    $participantNumber = 4;

    while ($remaining_runners_query->fetch()) {
      echo "<tr>";
      echo "<td>" . $participantNumber . "</td>";
      echo "<td>" . (!is_null($perekonnanimi) ? htmlspecialchars($perekonnanimi) : '') . "</td>";
      echo "<td>" . (!is_null($eesnimi) ? htmlspecialchars($eesnimi) : '') . "</td>";
      echo "<td>" . (!is_null($sugu) ? htmlspecialchars($sugu) : '') . "</td>";
      echo "<td>" . (!is_null($synniaeg) ? htmlspecialchars($synniaeg) : '') . "</td>";
      echo "<td>" . (!is_null($start) ? htmlspecialchars($start) : '') . "</td>";
      echo "<td>" . (!is_null($vaheaeg1) ? htmlspecialchars($vaheaeg1) : '') . "</td>";
      echo "<td>" . (!is_null($vaheaeg2) ? htmlspecialchars($vaheaeg2) : '') . "</td>";
      echo "<td>" . (!is_null($finish) ? htmlspecialchars($finish) : '') . "</td>";
      echo "</tr>";

      $participantNumber++;
    }

    echo "</table>";
    echo "</div>";

    $remaining_runners_query->close();

    if (isset($_GET['kustutasid'])) {
      $delete_id = $_GET['kustutasid'];

      $delete_command = $yhendus->prepare("DELETE FROM jooks WHERE id = ?");
      $delete_command->bind_param("i", $delete_id);

      if ($delete_command->execute()) {
        header('Location: ?page=autasustamine');
        exit();
      } else {
        echo "Kustutamine nurjus: " . $delete_command->error;
      }

      $delete_command->close();
    }

    $yhendus->close();
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
</body>
</html>


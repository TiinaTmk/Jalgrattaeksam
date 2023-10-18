<?php
require($_SERVER["DOCUMENT_ROOT"] . "/../config.php");
global $yhendus;


session_start();

if (isset($_REQUEST["uustops_id"])) {
    $kask = $yhendus->prepare("UPDATE kohviautomaat SET topsepakis = topsepakis - 1 WHERE id = ?");
    $kask->bind_param("i", $_REQUEST["uustops_id"]);
    $kask->execute();
    $kask->close();

    $_SESSION['page'] = $_REQUEST['page'];
    header("Location: $_SERVER[PHP_SELF]");
    exit();
}
?>

<!doctype html>
<html>
<head>
    <title>Kohviautomaat</title>
    <style>
        body {
            background-image: url('https://img.freepik.com/premium-photo/falling-coffee-beans-white-background-generative-ai_864588-4357.jpg?size=626&ext=jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
    </style>
</head>
<body>
<h1>Kohviautomaat</h1>
<table>
    <?php
    
    ob_start(); 

    $kask = $yhendus->prepare("SELECT id, jooginimi, topsepakis FROM kohviautomaat WHERE avalik = 1 AND topsepakis > 0");
    $kask->bind_result($id, $jooginimi, $topsepakis);
    $kask->execute();
    while ($kask->fetch()) {
        $jooginimi = htmlspecialchars($jooginimi);
        echo "<tr>
        <td>$jooginimi</td>
        <td>$topsepakis</td>
        <td>
            <a href='?uustops_id=$id'>Joo üks tops</a>
        </td>
    </tr>";
    }
    ob_end_flush(); 
    ?>
</table>
</body>
</html>



<?php


if (isset($_POST["uustops"])) {
    $uustops_id = $_POST["uustops_id"];
    $uustops = intval($_POST["uustops"]);

    if ($uustops > 0) {
        $kask = $yhendus->prepare("UPDATE kohviautomaat SET topsepakis = topsepakis + ? WHERE id = ?");
        $kask->bind_param("ii", $uustops, $uustops_id);
        $kask->execute();
        $kask->close();
header("Location: $_SERVER[PHP_SELF]");
        exit();
    }
}

if (isset($_POST["kustuta"])) {
    $kustutajoogiId = $_POST["kustuta"];
    
    $kask_delete = $yhendus->prepare("DELETE FROM kohviautomaat WHERE id = ?");
    $kask_delete->bind_param("i", $kustutajoogiId);
    
    if ($kask_delete->execute()) {
        $kask_delete->close();
header("Location: $_SERVER[PHP_SELF]");
        exit();
    } else {
        echo "Error executing the DELETE query: " . $kask_delete->error . "<br>";
    }
}

if (isset($_POST["uusjooginimi"])) {
    $uusjooginimi = $_POST["uusjooginimi"];
    $kask = $yhendus->prepare("INSERT INTO kohviautomaat (jooginimi, avalik, topsepakis) VALUES (?, 1, 0)");
    $kask->bind_param("s", $uusjooginimi);
    $kask->execute();
    $kask->close();
}
?>



<?php


if(isSet($_REQUEST["topsi_id"])){
    $punktid = isSet($_REQUEST["topsepakis"]) ? intval($_REQUEST["topsepakis"]) % 4 : 1;
    $kask=$yhendus->prepare("UPDATE kohviautomaat SET topsepakis=topsepakis+? WHERE id=?");
    $kask->bind_param("ii", $punktid, $_REQUEST["topsi_id"]);
    $kask->execute();
header("Location: $_SERVER[PHP_SELF]");
    $yhendus->close();
    exit();
}
?>
<!doctype html>
<html>
<head>
<title>Kohviautomaadi haldusleht</title>
</head>
<body>
<h1>Kohviautomaadi haldusleht</h1>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    Uue joogi nimi:
    <input type="text" name="uusjooginimi" required />
    <input type="submit" value="Lisa jook" />
    <br>
</form>
<br>

<table>
    <tr>
        <th>Jooginimi</th>
        <th>Topsepakis</th>
        <th>Lisa tops</th>
        
    </tr>



<?php
$kask=$yhendus->prepare("SELECT id, jooginimi, topsepakis FROM kohviautomaat WHERE avalik=1");
$kask->bind_result($id, $jooginimi, $topsepakis);
$kask->execute();
while($kask->fetch()){
$jooginimi=htmlspecialchars($jooginimi);
echo "<tr>
<td>$jooginimi</td>
<td>$topsepakis</td>
<td>
    <a href='?topsi_id=$id'>Lisa uus tops</a>
</td>
<td>
    <form action='" . $_SERVER['PHP_SELF'] . "' method='post'>
        <button type='submit' name='kustuta' value='$id'>Kustuta</button>
    </form>
</td>
</tr>";
}

?>
</table>
</body>
</html>
<?php
$yhendus->close();
?>

<?php
require($_SERVER["DOCUMENT_ROOT"]."/../config.php");
global $yhendus;




if(isSet($_REQUEST["uusleht"])){
    $kask=$yhendus->prepare("INSERT INTO jooks (eesnimi, perekonnanimi, start, finish, vaheaeg1, vaheaeg2, sugu, synniaeg) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $kask->bind_param("ssssssss", $_REQUEST["eesnimi"], $_REQUEST["perekonnanimi"],  $_REQUEST["start"],  $_REQUEST["finish"],  $_REQUEST["vaheaeg1"],  $_REQUEST["vaheaeg2"], $_REQUEST["sugu"],  $_REQUEST["synniaeg"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]?page=$_REQUEST[page]"); 

    $yhendus->close();
    exit();
}



if(isSet($_REQUEST["uusleht2"])){
    $kask=$yhendus->prepare("INSERT INTO jooks (eesnimi, perekonnanimi, start, finish, vaheaeg1, vaheaeg2, sugu, synniaeg) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $kask->bind_param("ssssssss", $_REQUEST["eesnimi"], $_REQUEST["perekonnanimi"],  $_REQUEST["start"],  $_REQUEST["finish"],  $_REQUEST["vaheaeg1"],  $_REQUEST["vaheaeg2"], $_REQUEST["sugu"],  $_REQUEST["synniaeg"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]"); 

    $yhendus->close();
    exit();
}


if(isSet($_REQUEST["kustutasid"])){
    $kask=$yhendus->prepare("DELETE FROM jooks WHERE id=?");
    $kask->bind_param("i", $_REQUEST["kustutasid"]);
    $kask->execute();
}

if(isSet($_REQUEST["kustutasid"])){
    $kask=$yhendus->prepare("DELETE FROM jooks WHERE id=?");
    $kask->bind_param("i", $_REQUEST["kustutasid"]);
    $kask->execute();
}



if(isset($_GET["page"])){
    $openPage = $_GET["page"].".php";
    if (file_exists($openPage)) {
        require($openPage);
    } else {
        require("error404.php");
    }
    
} else {
    require("default.php");
}

require("footer.php");





<?php
    $serverBaze = "localhost";
    $username = "root";
    $password = "";
    $bazaPodataka = "orbital_optics";

    try
    {
        $conn =  new PDO("mysql:host=$serverBaze;dbname=$bazaPodataka", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
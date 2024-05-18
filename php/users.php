<?php
    include_once("conn.php");
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if(isset($_SESSION['user']))
        {
            $result = $_SESSION['user'];

            header('Content-Type: application/json');

            echo json_encode($result);
        }
        else
        {
            $empty = json_decode("{}");

            echo json_encode($empty);
        }
    }
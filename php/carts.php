<?php
    include_once("conn.php");

    // GET REQUEST

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $user_id = (int)$_GET['user_id'];

        $queryString = "SELECT *
                        FROM `cart`
                        WHERE `cart`.`user_id` = $user_id
                        AND `cart`.`active` = 1;";

        $result = $conn->query($queryString);

        $result = $result->fetch();

        header('Content-Type: application/json');

        echo json_encode($result);
    }

    // POST REQUEST

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user_id = (int)$_POST['user_id'];

        $queryString = $conn->prepare("INSERT INTO `cart` (`user_id`)
                                              VALUE (:user_id);");

        $result = $queryString->execute(['user_id' => $user_id]);

        header('Content-Type: application/json');

        echo json_encode($result);
    }
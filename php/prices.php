<?php
    include_once("conn.php");

    // GET REQUEST

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $product_id = (int)$_GET['product_id'];

        $queryString = "SELECT *
                        FROM `price`
                        INNER JOIN 
                        (
                            SELECT MAX(`created_at`) AS `latest_created_at`
                            FROM `price`
                            WHERE `product_id` = $product_id
                        ) AS `latest_product_price` ON `price`.`created_at` = `latest_product_price`.`latest_created_at`
                        WHERE `price`.`product_id` = $product_id;";

        $result = $conn->query($queryString);

        $result = $result->fetch();

        header('Content-Type: application/json');

        echo json_encode($result);
    }
<?php
    include_once("conn.php");

    // GET REQUEST

    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        $user_id = (int)$_GET['user_id'];
        $local_storage = $_GET['local_storage_cart'];

        if (empty($local_storage))
        {
            $queryString = "SELECT DISTINCT
                                `cart`.`id` AS 'id',
                                `product`.id AS 'product_id',
                                `product`.`name` AS 'name',
                                `price`.id AS 'price_id',
                                `price`.`price` AS 'price',
                                `product`.`image_path` AS 'image',
                                COUNT(*) AS 'quantity'
                            FROM
                                `cart`
                                INNER JOIN `user` ON `cart`.`user_id` = `user`.`id`
                                INNER JOIN `cart_product` ON `cart`.`id` = `cart_product`.`cart_id`
                                INNER JOIN `price` ON `cart_product`.`price_id` = `price`.`id`
                                INNER JOIN `product` ON `price`.`product_id` = `product`.`id`
                            WHERE 
                                `cart`.`user_id` = $user_id
                            AND
                                `cart`.`active` = 1
                            GROUP BY
                                `product`.`name`,
                                `price`.`price`;";

            $result = $conn->query($queryString);

            $result = $result->fetchAll(PDO::FETCH_ASSOC);
        }
        else {
            $local_storage_list = [];

            foreach ($local_storage as $LSitem)
            {
                $product_id = (int)$LSitem['product_id'];

                $queryString = "SELECT DISTINCT
                                    `product`.id AS 'product_id',
                                    `product`.`name` AS 'name',
                                    `price`.id AS 'price_id',
                                    `price`.`price` AS 'price',
                                    `product`.`image_path` AS 'image'
                                FROM 
                                    `product`
                                    INNER JOIN `price` ON `product`.`id` = `price`.`product_id`
                                    INNER JOIN 
                                    (
                                        SELECT 
                                            `created_at` AS `latest_created_at`,
                                            `product_id`,
                                            `price`
                                        FROM 
                                            `price`
                                        WHERE 
                                            `product_id` = $product_id
                                        ORDER BY
                                            `created_at` DESC
                                        LIMIT
                                            1
                                    ) AS `latest_product_price` ON `price`.`created_at` = `latest_product_price`.`latest_created_at`
                                WHERE 
                                    `price`.`product_id` = $product_id
                                AND 
                                    `product`.`id` = $product_id;";

                $result = $conn->query($queryString);

                $result = $result->fetch(PDO::FETCH_ASSOC);

                array_push($local_storage_list, $result);

                $result = $local_storage_list;
            }
        }
        header('Content-Type: application/json');

        echo json_encode($result);
    }

    // POST REQUEST

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $cart_id = (int)$_POST['cart_id'];
        $product_price_id = (int)$_POST['product_price_id'];

        $queryString = $conn->prepare("INSERT INTO `cart_product` (`cart_id`, `price_id`)
                                             VALUES (:cart_id, :product_price_id);");

        $result = $queryString->execute(['cart_id' => $cart_id, 'product_price_id' => $product_price_id]);

        header('Content-Type: application/json');

        echo json_encode($result);
    }

    // DELETE REQUEST

    if ($_SERVER["REQUEST_METHOD"] == "DELETE")
    {
        // Access the substrings
        $cart_id = (int)$_GET['cart_id'];
        $product_price_id = (int)$_GET['product_price_id'];
        $deleteRow = (isset($_GET['deleteRow']) ? ";" : "LIMIT 1;");

        $queryString = $conn->prepare("DELETE FROM `cart_product`
                                             WHERE `cart_id` = :cart_id AND `price_id` = :product_price_id " . $deleteRow);

        $result = $queryString->execute(['cart_id' => $cart_id, 'product_price_id' => $product_price_id]);

        header('Content-Type: application/json');

        echo json_encode($result);
    }
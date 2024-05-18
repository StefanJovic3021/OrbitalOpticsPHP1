<?php
    include_once("conn.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $filterCategory = isset($_POST['categories']) ? $_POST['categories'] : [];
        $filterSearch = isset($_POST['search']) ? $_POST['search'] : "";
        $sortType = isset($_POST['sortType']) ? (int)$_POST['sortType'] : 0;
        $takeAll = isset($_POST['takeAll']) && filter_var($_POST['takeAll'], FILTER_VALIDATE_BOOLEAN);
        $pageNum = isset($_POST['currentPageNumber']) ? (int)$_POST['currentPageNumber'] : 0;
        $perPage = 12; // THIS AS WELL

        $categories = implode(", ", $filterCategory);
        $filterSearch = strtolower($filterSearch);
        $sortString = "";

        switch($sortType)
        {
            case 1:
            {
                // Price ascending
                $sortString = 'ORDER BY price ASC ';
                break;
            }
            case 2:
            {
                // Price descending
                $sortString = 'ORDER BY price DESC ';
                break;
            }
            case 3:
            {
                // Name ascending
                $sortString = 'ORDER BY name ASC ';
                break;
            }
            case 4:
            {
                // Name descending
                $sortString = 'ORDER BY name DESC ';
                break;
            }
        }

        $queryString =   "SELECT 
                                `product`.id AS 'id',
                                `product`.name AS 'name', 
                                `product`.description AS 'description', 
                                `product`.image_path AS 'image_path', 
                                `price`.price AS 'price', 
                                `category`.name AS 'category', 
                                `company`.name AS 'company'
                            FROM `product`
                            INNER JOIN `category` ON `product`.category_id = `category`.id 
                            INNER JOIN `company` ON `product`.company_id = `company`.id 
                            INNER JOIN 
                                (SELECT product_id, MAX(created_at) AS 'latest_date'
                                FROM `price` 
                                GROUP BY product_id) AS `latest_prices`
                            ON `product`.id = latest_prices.product_id
                            INNER JOIN `price` ON `latest_prices`.product_id = `price`.product_id AND `latest_prices`.latest_date = `price`.created_at
                            WHERE LOWER(`product`.name) LIKE '%$filterSearch%'";


        if ($categories != null)
        {
            $queryString .= "AND `product`.category_id IN($categories)";
        }

        $queryString .= $sortString;

        if(!$takeAll)
        {
            $queryString .= "LIMIT $perPage OFFSET " . ($perPage * $pageNum);
        }

        $result = $conn->query($queryString);

        $result = $result->fetchAll();

        header('Content-Type: application/json');

        echo json_encode($result);
    }
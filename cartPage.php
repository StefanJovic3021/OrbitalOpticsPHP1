<?php
    include_once ("php/conn.php");
    session_start();

    $loggedUser = (isset($_SESSION['user'])) ? ($_SESSION['user']->id) : null;

?>
<!DOCTYPE HTML>
<!--
	Hielo by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html>
    <!-- Head -->
    <?php include_once 'pages/components/head.php'; ?>

    <body>
        <!-- Header -->
        <?php include_once 'pages/components/header.php'; ?>

        <!-- Nav -->
        <?php include_once 'pages/components/navigation.php'; ?>

        <div id="cartPage">
            <!-- One -->
            <section id="One" class="wrapper style3">
                <div class="inner">
                    <header class="align-center">
                        <p>Your very own shopping cart</p>
                        <h2>Cart</h2>
                    </header>
                </div>
            </section>

            <!-- Custom section -->
            <section id="cartMain" data-uid="<?= ($loggedUser ? : ('ls')) ?>">
                <div id="cartFilled">
                    <div id="cartContent">
                        <table id="cartPanelTable">
                            <thead>
                            <th>Index</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Remove</th>
                            </thead>
                            <tbody id="cartPanelTableBody">
                            </tbody>
                        </table>
                    </div>
                    <div id="cartPanel">
                        <div id="cartPanelHeader">
                            <h3>Grand total</h3>
                            <div id="cartPanelHeaderLine"></div>
                        </div>
                        <div id="cartPanelBody">
                            <p>TEXT</p>
                        </div>
                    </div>
                </div>
                <div id="cartEmpty">
                    <img src="images/graphics/empty-cart.png" alt="Empty cart" />
                    <h3>Your cart is empty</h3>
                </div>
            </section>
        </div>

        <!-- Footer -->
        <?php include_once 'pages/components/footer.php'; ?>

    </body>
    <style>
        #cartMain {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 80rem;
            margin: 20px auto;
        }
        #cartMain #cartFilled {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            width: 100%;
            min-height: 600px;
        }
        #cartMain #cartFilled #cartContent, #cartMain #cartFilled #cartPanel {
            padding: 10px;
            background-color: #f2f2f2;
            border: 1px solid #d1d1d1;
            margin: 10px;
        }
        #cartMain #cartFilled #cartPanel #cartPanelBody p {
            color: green;
            font-size: 21px;
            font-weight: 500;
        }
        #cartMain #cartFilled #cartContent {
            width: 70%;
        }
        #cartMain #cartFilled #cartContent #cartPanelTable {
            width: 100%;
            border-collapse: collapse;
            margin: 0 0 2rem 0;
        }
        #cartMain #cartFilled #cartPanel {
            width: 30%;
        }
        #cartMain #cartFilled #cartContent * {
            vertical-align: middle;
        }
        #cartMain #cartFilled #cartContent table tbody tr {
            border: solid 1px;
            border-left: 0;
            border-right: 0;
            border-color: rgba(144, 144, 144, 0.25);
        }
        #cartMain #cartFilled #cartContent table tbody tr:nth-child(2n + 1) {
            background-color: rgba(144, 144, 144, 0.075);
        }
        #cartMain #cartFilled #cartContent table tr th {
            font-size: 0.9rem;
            font-weight: 700;
            padding: 0 0.75rem 0.75rem 0.75rem;
            text-align: left;
        }
        #cartMain #cartFilled #cartContent table tr th, #cartMain #cartFilled #cartContent table tr td {
            text-align: center;
            padding: 0.60rem 0.60rem;
        }
        #cartMain #cartFilled #cartContent table tr td .itemName {
            display: flex;
            align-items: center;
        }
        #cartMain #cartFilled #cartContent table tr td p {
            margin: 0;
        }
        #cartMain #cartFilled #cartContent table tr td .la-trash-alt {
            font-size: 26px;
            color: rgba(255, 0, 0, 0.4);
            transition: all 0.1s ease-in-out;
            cursor: pointer;
        }
        #cartMain #cartFilled #cartContent table tr td .la-trash-alt:hover {
            color: red;
        }
        #cartMain #cartFilled #cartContent table tr td .itemQuantity .la-caret-up,  #cartMain #cartFilled #cartContent table tr td .itemQuantity .la-caret-down{
            color: rgba(29, 29, 29, 0.4);
            font-size: 26px;
            transition: all 0.1s;
            cursor: pointer;
        }
        #cartMain #cartFilled #cartContent table tr td .itemQuantity .la-caret-up:hover, #cartMain #cartFilled #cartContent table tr td .itemQuantity .la-caret-down:hover {
            color: #1d1d1d;
        }
        #cartMain #cartFilled #cartContent table tr td .itemQuantity .la-caret-up:active, #cartMain #cartFilled #cartContent table tr td .itemQuantity .la-caret-down:active {
            transform: scale(0.9);
        }
        #cartMain #cartFilled #cartContent table tr td .itemName .itemPic {
            margin-right: 30px;
            width: 20%;
        }
        #cartMain #cartFilled #cartContent table tr td .itemName .itemPic img {
            height: 88px;
        }
        #cartMain #cartFilled #cartPanel #cartPanelHeader {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            margin-bottom: 10px;
        }
        #cartMain #cartFilled #cartPanel #cartPanelHeader h3 {
            margin: 5px 0px;
        }
        #cartMain #cartFilled #cartPanel #cartPanelHeader #cartPanelHeaderLine {
            width: 90%;
            background-color: #1d1d1d;
            height: 1px;
        }
        #cartMain #cartEmpty {
            margin: 50px 0px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-color: #f2f2f2;
            padding: 10px;
            border-radius: 20px;
            box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;
            user-select: none;
        }
        #cartMain #cartEmpty img {
            width: 50%;
        }
        #cartMain #cartEmpty h3 {
            margin: 15px 0px;
        }
    </style>
</html>
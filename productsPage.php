<?php
    include_once("php/conn.php");

    session_start();

    $allCategoriesQuery = "SELECT * FROM `category`;";

    $allCategories = $conn->query($allCategoriesQuery);

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

        <div id="productsPage">
            <!-- One -->
            <section id="One" class="wrapper style3">
                <div class="inner">
                    <header class="align-center">
                        <p>Explore our products with astronomically low prices</p>
                        <h2>Search products</h2>
                    </header>
                </div>
            </section>

            <!-- Custom section -->
            <section id="productsMain">
                <div id="filterSection">
                    <form id="filterForm">
                        <div class="filterBlock">
                            <div class="filterHead">
                                <div class="filterTitle">
                                    <h4>Search</h4>
                                    <i class="las la-angle-up hideToggle"></i>
                                </div>
                                <div class="filterLine"></div>
                            </div>
                            <div class="filterBody">
                                <div class="filterSearch">
                                    <input type="text" id="searchInput" placeholder="Search product..." name="searchInput" />
                                    <div id="searchGlass"><i class="las la-search"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="filterBlock">
                            <div class="filterHead">
                                <div class="filterTitle">
                                    <h4>Category</h4>
                                    <i class="las la-angle-up hideToggle"></i>
                                </div>
                                <div class="filterLine"></div>
                            </div>
                            <div class="filterBody">
                                <div id="categoryInput" class="filterCheckbox">
                                    <?php
                                        foreach($allCategories as $category)
                                        {
                                            echo "<div class='checkboxStyle'>
                                                <label for='$category->name'>$category->name</label>
                                                <input type='checkbox' id='$category->name' name='$category->name' value='$category->id' />
                                              </div>";
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="productSection">
                    <div id="productControls">
                        <div id="viewControls">
                            <p>View:</p>
                            <div id="gridView"><i class="las la-border-all selected"></i></div>
                            <div id="lineView"><i class="las la-list"></i></div>
                        </div>
                        <div id="sortControls">
                            <p>Sort by:</p>
                            <form id="sortingForm">
                                <select id="sortingDD" name="sortingType">
                                    <option value="0">Default</option>
                                    <option value="1">Price ascending</option>
                                    <option value="2">Price descending</option>
                                    <option value="3">Name A-Z</option>
                                    <option value="4">Name Z-A</option>
                                </select>
                            </form>
                        </div>
                    </div>
                    <div id="productShelf">
                        <!-- AJAX Dynamic products without refreshing the page -->
                    </div>
                    <div id="productPagePanel">
                        <div id="buttonLeft"><i class="las la-angle-left"></i></div>
                        <p>1 / 2</p>
                        <div id="buttonRight"><i class="las la-angle-right"></i></div>
                    </div>
                </div>
                <!-- Fix this part
                <div v-if="showProductInfo" id="productInfoBack">
                    <div id="productInfoWindow">
                        <div id="productInfoHeader">
                            <h3>Product Information</h3>
                            <i @click="showProductInfo = !showProductInfo" class="las la-times"></i>
                        </div>
                        <div id="productInfoBody">
                            <div id="prod_infoPictureBox">
                                <img :src="productObject.image" :alt="productObject.id" />
                            </div>
                            <div id="prod_infoTextBox">
                                <div id="prod_infoName">
                                    <h3>{{ productObject.name }}</h3>
                                </div>
                                <div id="prod_infoCompany">
                                    <p>{{ productObject.company_name }}</p>
                                </div>
                                <div id="prod_infoPrice">
                                    <p>${{ productObject.price }}</p>
                                </div>
                                <div id="prod_infoDescription">
                                    <p>Product description:</p>
                                    <p>{{ productObject.description }}</p>
                                </div>
                                <div id="prod_infoButton">
                                    <div id="cartButton">
                                        <i class="las la-shopping-cart"></i><p>Add to cart</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                -->
            </section>
        </div>

        <!-- Footer -->
        <?php include_once 'pages/components/footer.php'; ?>

    </body>
    <style>
        .filterBlock {
            width: 100%;
            padding: 10px;
            align-items: center;
            justify-content: center;
            background-color: #fff;
            overflow: hidden;
        }
        .filterBlock .filterHead {
            display: flex;
            flex-direction: column;
            background-color: #fff;
            position: relative;
            z-index: 0;
        }
        .filterBlock .filterHead .filterTitle {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
        }
        .filterBlock .filterHead .filterTitle h4 {
            font-weight: 500;
            margin: 0;
        }
        .filterBlock .filterHead .filterTitle i {
            -webkit-text-stroke: 1px rgb(0, 0, 0);
            cursor: pointer;
            transition: 0.3s ease-out;
        }
        .filterBlock .filterHead .filterTitle i:hover {
            -webkit-text-stroke: 2px rgb(0, 0, 0);
        }
        .filterBlock .filterHead .filterLine {
            width: 14%;
            height: 2px;
            background-color: #000;
            margin: 4px 0px;
            margin-bottom: 12px;
        }
        .filterBlock .filterBody {
            display: flex;
            flex-direction: column;
            transition: 0.3s ease-out;
            position: relative;
            z-index: 0;
        }
        .filterBlock .filterBody .filterSearch {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border: 2px solid rgba(128, 128, 128, 0.14);
        }
        .filterBlock .filterBody .filterSearch input {
            border: none;
            background: none;
            height: max-content;
        }
        .filterBlock .filterBody .filterSearch input:focus {
            box-shadow: none;
        }
        .filterBlock .filterBody .filterSearch i {
            font-size: 24px;
            padding: 10px;
            cursor: pointer;
        }
        .filterBlock .filterBody .filterSearch i:hover {
            color: green;
            -webkit-text-stroke: 0.7px green;
        }
        .filterBlock .filterBody .filterCheckbox {
            display: flex;
            width: 100%;
            flex-direction: column;
            align-items: flex-start;
        }
        .filterBlock .filterBody .filterCheckbox .checkboxStyle {
            display: flex;
            width: 100%;
            align-items: center;
            justify-content: space-between;
        }
        .filterBlock .filterBody .filterCheckbox .checkboxStyle label {
            margin: 0;
            width: 100%;
            font-size: 1rem;
            font-weight: 500;
        }
        input[type="checkbox"] {
            /* RESETING TEMPLATE SETTINGS */
            opacity: 1;
            float: none;
            margin-right: 0;
            width: initial;
            z-index: inherit;
            appearance: auto;
            /* SETTING CUSTOMS */
            margin: 10px 0px 10px 10px;
            width: 1.2rem;
            height: 1.2rem;
        }
        .selected {
            color: rgb(0, 147, 39);
        }
        #filterSection {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 25%;
            height: max-content;
            text-align: start;
        }
        #filterSection #filterForm {
            width: 100%;
            height: max-content;
            padding: 20px;
        }
        #productSection {
            /* border: 1px solid rgb(0, 76, 255);
            background-color: rgba(0, 76, 255, 0.07); */
            display: flex;
            flex-direction: column;
            width: 73%;
        }
        #productSection #productControls {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        #productSection #productControls p, form {
            margin: 0;
        }
        #productSection #productControls #viewControls, #productSection #productControls #sortControls {
            width: 33%;
            height: max-content;
            display: flex;
        }
        #productSection #productControls #viewControls {
            align-items: center;
            justify-content: flex-start;
        }
        #productSection #productControls #viewControls i {
            font-size: 27px;
            margin: 0px 7px;
            transition: 0.2s;
            cursor: pointer;
        }
        #productSection #productControls #viewControls i:hover {
            color: rgb(0, 147, 39);
            transition: 0.2s;
        }
        #productSection #productControls #sortControls {
            align-items: center;
            justify-content: flex-end;
        }
        #productSection #productControls #sortControls #sortingForm #sortingDD {
            margin-left: 5px;
            padding: 0px 12px;
            border-radius: 20px;
            border: 1px solid rgba(213, 213, 213, 0.8235294118);
            background: none;
            width: max-content;
        }
        #productSection #productControls #sortControls #sortingForm #sortingDD:focus {
            box-shadow: none;
        }
        #productSection #productShelf {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            width: 100%;
            padding: 10px;
        }
        #productSection #productPagePanel {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        #productSection #productPagePanel p {
            margin: 0;
            font-size: 18px;
        }
        #productSection #productPagePanel #buttonLeft, #productSection #productPagePanel #buttonRight {
            display: flex;
            align-items: center;
            justify-content: center;
            color: #000;
            padding: 5px;
            margin: 10px;
            transition: 0.2s;
            font-size: 25px;
            cursor: pointer;
        }
        #productSection #productPagePanel #buttonLeft:hover, #productSection #productPagePanel #buttonRight:hover {
            transition: 0.2s;
            -webkit-text-stroke: 0.7px green;
            color: green;
        }
        #productSection #productPagePanel #buttonLeft:active, #productSection #productPagePanel #buttonRight:active {
            transition: 0.2s;
            -webkit-text-stroke: 0.4px rgb(0, 0, 0);
        }
        #productsMain {
            display: flex;
            justify-content: space-between;
            width: 80rem;
            margin: 20px auto;
        }
        #productsPage {
            position: relative;
        }
        #productsMain #productInfoBack {
            position: absolute;
            background-color: rgba(0, 0, 0, 0.5);
            width: 100%;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 2;
        }
        #productsMain #productInfoBack #productInfoWindow {
            position: fixed;
            left: 50%;
            top: 50%;
            width: 60%;
            height: 600px;
            background-color: #fff;
            transform: translate(-50%, -50%);
            box-shadow: rgba(0, 0, 0, 0.3) 0px 19px 38px, rgba(0, 0, 0, 0.22) 0px 15px 12px;
            border-radius: 20px;
            overflow: hidden;
        }
        #productsMain #productInfoBack #productInfoWindow #productInfoHeader {
            width: 100%;
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            padding: 10px;
            background-color: #121212;
            color: #fff;
        }
        #productsMain #productInfoBack #productInfoWindow #productInfoHeader h3 {
            margin: 0;
            color: #fff;
        }
        #productsMain #productInfoBack #productInfoWindow #productInfoHeader i {
            font-size: 25px;
            cursor: pointer;
        }
        #productsMain #productInfoBack #productInfoWindow #productInfoBody {
            display: flex;
            padding: 20px;
        }
        #productsMain #productInfoBack #productInfoWindow #productInfoBody #prod_infoPictureBox {
            width: 50%;
            text-align: center;
            overflow: hidden;
        }
        #productsMain #productInfoBack #productInfoWindow #productInfoBody #prod_infoPictureBox img {
            height: 420px;
        }
        #productsMain #productInfoBack #productInfoWindow #productInfoBody #prod_infoTextBox {
            width: 50%;
            display: flex;
            padding: 10px;
            flex-direction: column;
            align-items: flex-start;
            justify-content: flex-start;
        }
        #productsMain #productInfoBack #productInfoWindow #productInfoBody #prod_infoTextBox p {
            margin: 0;
        }
        #productsMain #productInfoBack #productInfoWindow #productInfoBody #prod_infoTextBox #prod_infoName {
            margin: 10px 0px;
        }
        #productsMain #productInfoBack #productInfoWindow #productInfoBody #prod_infoTextBox #prod_infoName h3 {
            font-weight: bold;
            margin: 0;
        }
        #productsMain #productInfoBack #productInfoWindow #productInfoBody #prod_infoTextBox #prod_infoCompany p {
            text-decoration: underline;
            font-size: 22px;
            margin: 5px 0px;
        }
        #productsMain #productInfoBack #productInfoWindow #productInfoBody #prod_infoTextBox #prod_infoPrice p {
            font-size: 25px;
            font-weight: 600;
            color: rgb(0, 128, 0);
        }
        #productsMain #productInfoBack #productInfoWindow #productInfoBody #prod_infoTextBox #prod_infoDescription {
            margin-top: 30px;
            display: flex;
            flex-direction: column;
            text-align: start;
        }
        #productsMain #productInfoBack #productInfoWindow #productInfoBody #prod_infoTextBox #prod_infoDescription p {
            font-size: 20px;
        }
        #productsMain #productInfoBack #productInfoWindow #productInfoBody #prod_infoTextBox #prod_infoButton {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        #productsMain #productInfoBack #productInfoWindow #productInfoBody #prod_infoTextBox #prod_infoButton #cartButton {
            background-color: green;
            color: #fff;
            display: flex;
            align-items: baseline;
            justify-content: center;
            padding: 10px 20px;
            margin-top: 50px;
            cursor: pointer;
        }
        #productsMain #productInfoBack #productInfoWindow #productInfoBody #prod_infoTextBox #prod_infoButton #cartButton p {
            font-size: 20px;
        }
        #productsMain #productInfoBack #productInfoWindow #productInfoBody #prod_infoTextBox #prod_infoButton #cartButton i {
            font-size: 27px;
        }
        #productSection .product {
            border: 1px solid transparent;
            display: flex;
            text-align: start;
            margin-bottom: 10px;
            transition: 0.2s;
            cursor: default;
        }
        #productSection .product:hover {
            transform: scale(1.03);
            transition: 0.2s;
            border: 1px solid rgba(128, 128, 128, 0.4);
        }
        #productSection .displayGrid {
            display: flex;
            width: 24%;
            height: max-content;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        #productSection .displayLine {
            width: 100%;
            height: max-content;
            flex-direction: row;
        }
        #productSection .product p {
            margin: 0px;
        }
        #productSection .product .productHead {
            width: 100%;
            position: relative;
            text-align: center;
            overflow: hidden;
        }
        #productSection .displayLine .productHead {
            width: 60%;
        }
        #productSection .product .productHead img{
            height: 220px;
        }
        #productSection .product .productHead .editBtn {
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            top: 0;
            right: 0;
            margin: 5px;
            border: 2px solid rgb(88, 88, 88);
            border-radius: 100px;
            padding: 4px;
            opacity: 0.2;
            cursor: pointer;
            transition: 0.2s;
        }
        #productSection .product .productHead .editBtn:hover {
            opacity: 1;
            transition: 0.2s;
        }
        #productSection .product .productHead .editBtn i {
            font-size: 25px;
            color: rgb(88, 88, 88);
        }
        #productSection .product .productBody {
            width: 100%;
            padding: 5px;
        }
        #productSection .product .productBody .productName {
            color: #000;
            font-weight: 400;
            font-size: 18px;
            overflow: hidden;
            width: 215px;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
        }
        #productSection .product .productBody .productCompany {
            font-size: 16px;
            font-weight: 400;
            text-decoration: underline;
        }
        #productSection .product .productBody .productDesc {
            font-size: 14px;
            color: rgb(108, 108, 108);
            overflow: hidden;
            width: 220px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            margin-bottom: 15px;
        }
        #productSection .product .productBody .productPrice {
            font-size: 20px;
            color: green;
            font-weight: 500;
        }
        #productSection .displayLine .productBody .productName, #productSection .displayLine .productBody .productDesc {
            width: 100%;
        }
        #productSection .product .productFooter {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-around;
        }
        #productSection .product .displayLineFooter {
            width: 70%;
            flex-direction: column;
            justify-content: space-evenly;
        }
        #productSection .product .productFooter .addToCartBtn, #productSection .product .productFooter .moreInfoBtn {
            background-color: rgba(0, 255, 0, 0.1);
            border: 1px solid rgba(0, 255, 0, 0.3);
            text-align: center;
            width: 50%;
            padding: 5px;
            margin: 2px;
            font-size: 13px;
            color: #000;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.2s;
            -webkit-touch-callout: none; /* iOS Safari */
            -webkit-user-select: none; /* Safari */
            -khtml-user-select: none; /* Konqueror HTML */
            -moz-user-select: none; /* Old versions of Firefox */
            -ms-user-select: none; /* Internet Explorer/Edge */
            user-select: none; /* Non-prefixed version, currently
                                  supported by Chrome, Edge, Opera and Firefox */
        }
        #productSection .product .productFooter .addToCartBtn:hover, #productSection .product .productFooter .moreInfoBtn:hover {
            transform: scale(1.03);
            background-color: rgba(0, 255, 0, 0.3);
            border: 1px solid rgba(0, 255, 0, 0.6);
            transition: 0.2s;
        }
        #productSection .product .productFooter .addToCartBtn:active, #productSection .product .productFooter .moreInfoBtn:active {
            transform: scale(0.97);
            background-color: rgba(0, 255, 0, 0.5);
            border: 1px solid rgba(0, 255, 0, 0.9);
            transition: 0.1s;
        }
        #productsMain #productShelfEmpty {
            width: 60%;
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
        #productsMain #productShelfEmpty img {
            width: 50%;
        }
        #productsMain #productShelfEmpty h3 {
            margin: 15px 0px;
        }
    </style>
</html>
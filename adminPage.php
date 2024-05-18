<?php
    include_once ("php/conn.php");
    session_start();

    if(!isset($_SESSION['user']) || ($_SESSION['user']->role != 'admin'))
    {
        header('Location: index.php');
        exit;
    }

    function usersGet()
    {
        global $conn;
        $query = "SELECT `user`.`username`, `user`.`email`, `user`.`image_path`, `role`.`name` AS 'role'
                      FROM `user` INNER JOIN `role`
                        ON `user`.`role_id` = `role`.`id`";

        $result = $conn->query($query);

        return $result->fetchAll();
    }

    function productsGet()
    {
        global $conn;
        $query = "SELECT 
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
                INNER JOIN `price` ON `latest_prices`.product_id = `price`.product_id AND `latest_prices`.latest_date = `price`.created_at";

        $result = $conn->query($query);

        return $result->fetchAll();
    }

    $allUsers = usersGet();
    $usersNumerator = 1;

    $allProducts = productsGet();
    $productsNumerator = 1;
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

    <div id="adminPanel">
        <div id="headerBlock"></div>
        <div id="mainPanel">
            <div id="panelHeader">
                <h3>Admin Panel</h3>
                <div id="sideMenuBtn"><i class="las la-bars"></i></div>
            </div>
            <div id="panelBody">
                <div id="panelSideMenu">
                    <p id="userPanelToggle" class="panelButton"><i class="las la-user-cog"></i> Users</p>
                    <p id="productsPanelToggle" class="panelButton"><i class="las la-clipboard"></i> Products</p>
                    <p id="bannersPanelToggle" class="panelButton"><i class="las la-images"></i> Banner</p>
                    <p id="messagesPanelToggle" class="panelButton"><i class="las la-inbox"></i> Messages</p>
                </div>
                <div id="panelDesktop">
                    <div id="usersConfigPanel">
                        <div class="configPanelHeader">
                            <h3>Users Configuration Window</h3>
                        </div>
                        <div class="configPanelBody">
                            <div id="userConfigTable">
                                <table>
                                    <thead>
                                    <th><p>#</p></th>
                                    <th><p>Profile picture</p></th>
                                    <th><p>Username</p></th>
                                    <th><p>E-mail address</p></th>
                                    <th><p>Role</p></th>
                                    <th><p>Controls</p></th>
                                    </thead>
                                    <tbody>
                                        <?php foreach($allUsers as $user): ?>
                                        <tr>
                                            <td><p><?= $usersNumerator++ ?></p></td>
                                            <td><div class="profilePictureData" style="height: 40px; width: 40px; border-radius: 50%; margin-right: 10px; background-image: url('<?= $user->image_path ?>'); background-size: cover; background-repeat: no-repeat; background-position: center;"></div></td>
                                            <td><p><?= $user->username ?></p></td>
                                            <td><p><?= $user->email ?></p></td>
                                            <td><p><?= $user->role ?></p></td>
                                            <td>
                                                <div class="editUserControls">
                                                    <i class="las la-trash red"></i>
                                                    <i class="las la-user-edit green"></i>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div @click="createEditUserWindow('create')" id="addBtn">
                                <i class="las la-plus"></i><p>Add new user</p>
                            </div>
                        </div>
                    </div>
                    <!--
                    <div v-if="userPanelToggle && createEditUserToggle" id="userAddPanel">
                        <div class="configPanelHeader">
                            <h3>{{ userWindowNameContext }} User Window</h3>
                        </div>
                        <div class="configPanelBody">
                            <form id="createEditUserForm">
                                <div v-if="userWindowContentContext == 'create'" id="userAddForm">
                                    <div id="username">
                                        <label for="newUsername">Username:</label>
                                        <input type="text" id="newUsername" v-model="newUserUsername" placeholder="Jack_Cooper" />
                                    </div>
                                    <div id="email">
                                        <label for="newEmail">E-mail:</label>
                                        <input type="text" id="newEmail" v-model="newUserEmail" placeholder="jackcooper123@gmail.com" />
                                    </div>
                                    <div id="password">
                                        <label for="newPasword">Password:</label>
                                        <input type="text" id="newPasword" v-model="newUserPassword" placeholder="jackCooper#123" />
                                    </div>
                                    <div id="role">
                                        <label for="newRole">Role:</label>
                                        <select v-model="newUserRole">
                                            <option value="admin">Admin</option>
                                            <option value="user">User</option>
                                        </select>
                                    </div>
                                    <div id="submitButtons">
                                        <div @click="addNewUser(newUserUsername, newUserEmail, newUserPassword, newUserRole)" id="submit"><p>Create user</p></div>
                                        <div @click="cancelUserWindow" id="cancel"><p>Cancel</p></div>
                                    </div>
                                </div>
                                <div v-if="userWindowContentContext == 'edit'" id="userEditForm">
                                    <div id="username">
                                        <label for="newUsername">Username:</label>
                                        <input type="text" id="newUsername" v-model="oldUserUsername" />
                                    </div>
                                    <div id="email">
                                        <label for="newEmail">E-mail:</label>
                                        <input type="text" id="newEmail" v-model="oldUserEmail" />
                                    </div>
                                    <div id="password">
                                        <label for="newPasword">Password:</label>
                                        <input type="text" id="newPasword" v-model="oldUserPassword" />
                                    </div>
                                    <div id="role">
                                        <label for="newRole">Role:</label>
                                        <select v-model="oldUserRole">
                                            <option value="admin">Admin</option>
                                            <option value="user">User</option>
                                        </select>
                                    </div>
                                    <div id="submitButtons">
                                        <div @click="editOldUser(oldUserId, oldUserUsername, oldUserEmail, oldUserPassword, oldUserRole)" id="submit"><p>Edit user</p></div>
                                        <div @click="cancelUserWindow" id="cancel"><p>Cancel</p></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    -->
                    <div id="productsConfigPanel">
                        <div class="configPanelHeader">
                            <h3>Products Configuration Window</h3>
                        </div>
                        <div class="configPanelBody">
                            <div id="productsConfigTable">
                                <table>
                                    <thead>
                                    <th><p>#</p></th>
                                    <th><p>Image</p></th>
                                    <th><p>Product name</p></th>
                                    <th><p>Company</p></th>
                                    <th><p>Category</p></th>
                                    <th><p>Description</p></th>
                                    <th><p>Price</p></th>
                                    <th><p>Controls</p></th>
                                    </thead>
                                    <tbody id="productTableStyle">
                                        <?php foreach($allProducts as $product): ?>
                                        <tr>
                                            <td><p><?= $productsNumerator++ ?></p></td>
                                            <td><img src="<?= $product->image_path ?>" /></td>
                                            <td><p><?= $product->name ?></p></td>
                                            <td><p><?= $product->company ?></p></td>
                                            <td><p><?= $product->category ?></p></td>
                                            <td>
                                                <div class="prodDesc">
                                                    <p><?= $product->description ?></p>
                                                </div>
                                            </td>
                                            <td><p>$ <?= $product->price ?></p></td>
                                            <td>
                                                <div class="editProductControls">
                                                    <i class="las la-trash red"></i>
                                                    <i class="las la-tools green"></i>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div @click="createEditProductWindow('create')" id="addBtn">
                                <i class="las la-plus"></i><p>Add new product</p>
                            </div>
                        </div>
                    </div>
                    <!--
                    <div v-if="productsPanelToggle && createEditProductToggle" id="productAddPanel">
                        <div class="configPanelHeader">
                            <h3>{{ productWindowNameContext }} Product Window</h3>
                        </div>
                        <div class="configPanelBody">
                            <form id="createEditProductForm">
                                <div v-if="productWindowContentContext == 'create'" id="productAddForm">
                                    <div id="compactBlock">
                                        <div id="prodImage">
                                            <img :src="newProductImage" />
                                            <label for="image">Product image URL:</label>
                                            <input type="text" placeholder="Image URL" id="image" v-model="newProductImage" />
                                        </div>
                                        <div id="prodEssentials">
                                            <div id="productName">
                                                <label for="prodName">Product name:</label>
                                                <input type="text" id="prodName" placeholder="Product name" v-model="newProductName"/>
                                            </div>
                                            <div id="productCompany">
                                                <label for="prodCompany">Company name:</label>
                                                <input type="text" id="prodCompany" placeholder="Product company" v-model="newProductCompany"/>
                                            </div>
                                            <div id="productCategory">
                                                <label for="prodCategory">Product category:</label>
                                                <select id="prodCategory" v-model="newProductCategory">
                                                    <option value="telescope">Telescope</option>
                                                    <option value="clothes">Clothes</option>
                                                    <option value="toy">Toy</option>
                                                    <option value="equipment">Equpiment</option>
                                                    <option value="geeky gift">Geeky Gift</option>
                                                    <option value="accessories">Accessories</option>
                                                    <option value="reading">Reading</option>
                                                </select>
                                            </div>
                                            <div id="productPrice">
                                                <label for="prodPrice">Product price:</label>
                                                <input type="number" id="prodPrice" placeholder="399.99" v-model="newProductPrice"/>
                                            </div>
                                            <div id="productDate">
                                                <label for="prodDate">Added date:</label>
                                                <input type="date" id="prodDate" v-model="newProductDate"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="longBlock">
                                        <div id="productDescription">
                                            <label for="prodDescription">Product description:</label>
                                            <textarea id="prodDescription" v-model="newProductDesc"></textarea>
                                        </div>
                                    </div>
                                    <div id="submitButtons">
                                        <div @click="addNewProduct(newProductImage, newProductName, newProductCompany, newProductCategory, newProductDesc, newProductPrice, newProductDate)" id="submit"><p>Create product</p></div>
                                        <div @click="cancelProductWindow" id="cancel"><p>Cancel</p></div>
                                    </div>
                                </div>
                                <div v-if="productWindowContentContext == 'edit'" id="productAddForm">
                                    <div id="compactBlock">
                                        <div id="prodImage">
                                            <img :src="oldProductImage" />
                                            <label for="image">Product image URL:</label>
                                            <input type="text" placeholder="Image URL" id="image" v-model="oldProductImage" />
                                        </div>
                                        <div id="prodEssentials">
                                            <div id="productName">
                                                <label for="prodName">Product name:</label>
                                                <input type="text" id="prodName" placeholder="Product name" v-model="oldProductName"/>
                                            </div>
                                            <div id="productCompany">
                                                <label for="prodCompany">Company name:</label>
                                                <input type="text" id="prodCompany" placeholder="Product company" v-model="oldProductCompany"/>
                                            </div>
                                            <div id="productCategory">
                                                <label for="prodCategory">Product category:</label>
                                                <select id="prodCategory" v-model="oldProductCategory">
                                                    <option value="telescope">Telescope</option>
                                                    <option value="clothes">Clothes</option>
                                                    <option value="toy">Toy</option>
                                                    <option value="equipment">Equpiment</option>
                                                    <option value="geeky gift">Geeky Gift</option>
                                                    <option value="accessories">Accessories</option>
                                                    <option value="reading">Reading</option>
                                                </select>
                                            </div>
                                            <div id="productPrice">
                                                <label for="prodPrice">Product price:</label>
                                                <input type="number" id="prodPrice" placeholder="399.99" v-model="oldProductPrice"/>
                                            </div>
                                            <div id="productDate">
                                                <label for="prodDate">Added date:</label>
                                                <input type="date" id="prodDate" v-model="oldProductDate"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="longBlock">
                                        <div id="productDescription">
                                            <label for="prodDescription">Product description:</label>
                                            <textarea id="prodDescription" v-model="oldProductDesc"></textarea>
                                        </div>
                                    </div>
                                    <div id="submitButtons">
                                        <div @click="editOldProduct(oldProductId, oldProductImage, oldProductName, oldProductCompany, oldProductCategory, oldProductDesc, oldProductPrice, oldProductDate)" id="submit"><p>Edit product</p></div>
                                        <div @click="cancelProductWindow" id="cancel"><p>Cancel</p></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    -->
                </div>
            </div>
        </div>
    </div>

        <!-- Footer -->
        <?php include_once 'pages/components/footer.php'; ?>

    </body>
<style>
    #adminPanel {
        width: 100%;
        background-color: #fff;
        height: 100vh;
    }
    #adminPanel #headerBlock {
        background-color: #121212;
        height: 11vh;
        width: 100%;
    }
    #adminPanel #mainPanel {
        display: flex;
        flex-direction: column;
    }
    #adminPanel #mainPanel #panelHeader {
        width: 100%;
        background-color: #2e8b57;
        display: flex;
        justify-content: flex-start;
        align-items: baseline;
    }
    #adminPanel #mainPanel #panelHeader h3 {
        margin: 0;
        color: #fff;
        padding: 5px 20px;
    }
    #adminPanel #mainPanel #panelHeader #sideMenuBtn {
        cursor: pointer;
    }
    #adminPanel #mainPanel #panelHeader #sideMenuBtn i {
        font-size: 25px;
        color: #fff;
        margin: 0px 20px;
    }
    #adminPanel #mainPanel #panelHeader #sideMenuBtn i:hover {
        transform: scale(1.1);
        text-shadow: rgba(255,255,255,0.9) 0px 0px 9px;
    }
    #adminPanel #mainPanel #panelBody {
        width: 100%;
        max-height: max-content;
        display: flex;
        position: relative;
    }
    #adminPanel #mainPanel #panelBody #panelSideMenu {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        width: 15vw;
        background-color: rgb(227, 227, 227);
        box-shadow: rgba(0, 0, 0, 0.3) 0px 19px 38px, rgba(0, 0, 0, 0.22) 0px 15px 12px;
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        transition: all 0.3s ease-in-out;
        z-index: 10;
    }
    #adminPanel #mainPanel #panelBody #panelSideMenu p {
        margin: 0;
        padding: 20px 15px;
        width: 100%;
        border-bottom: 1px solid rgba(18, 18, 18, 0.16);
        transition: all 0.1s ease-in-out;
        cursor: pointer;
        background-color: rgba(18, 18, 18, 0.1);
        text-align: start;
    }
    #adminPanel #mainPanel #panelBody #panelSideMenu p:hover {
        background-color: #121212;
        color: #fff;
    }
    #adminPanel #mainPanel #panelBody #panelSideMenu i {
        font-size: 25px;
    }
    #adminPanel #mainPanel #panelBody #panelDesktop {
        width: 100vw;
        background-size: 40px 40px;
        background-image: radial-gradient(circle, rgba(0, 0, 0, 0.4) 1px, rgba(0, 0, 0, 0) 1px);
        height: 788px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }
    #adminPanel #mainPanel #panelBody #panelDesktop #usersConfigPanel,  #adminPanel #mainPanel #panelBody #panelDesktop #productsConfigPanel{
        display: flex;
        flex-direction: column;
        width: 60%;
        background-color: #fff;
        border-radius: 20px 20px 0px 0px;
        overflow: hidden;
        box-shadow: rgba(0, 0, 0, 0.3) 0px 19px 38px, rgba(0, 0, 0, 0.22) 0px 15px 12px;
        position: relative;
        z-index: 2;
    }
    #adminPanel #mainPanel #panelBody #panelDesktop #productsConfigPanel {
        width: 90%;
    }
    #adminPanel #mainPanel #panelBody #panelDesktop #userAddPanel, #adminPanel #mainPanel #panelBody #panelDesktop #productAddPanel {
        display: flex;
        flex-direction: column;
        width: 40%;
        background-color: #fff;
        border-radius: 20px 20px 0px 0px;
        overflow: hidden;
        box-shadow: rgba(0, 0, 0, 0.3) 0px 19px 38px, rgba(0, 0, 0, 0.22) 0px 15px 12px;
        position: absolute;
        z-index: 3;
    }
    #adminPanel #mainPanel #panelBody #panelDesktop #userAddPanel .configPanelBody #createEditUserForm, #adminPanel #mainPanel #panelBody #panelDesktop #productAddPanel #createEditProductForm {
        width: 100%;
        padding: 10px 30px;
    }
    #adminPanel #mainPanel #panelBody #panelDesktop #userAddPanel .configPanelBody #createEditUserForm #userAddForm div {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        text-align: start;
    }
    #adminPanel #mainPanel #panelBody #panelDesktop .configPanelBody #submitButtons {
        margin-top: 30px;
    }
    #adminPanel #mainPanel #panelBody #panelDesktop .configPanelBody #submitButtons p {
        margin: 0;
    }
    #adminPanel #mainPanel #panelBody #panelDesktop .configPanelBody #submitButtons #submit {
        background-color: #2e8b57;
        color: #fff;
        padding: 10px 30px;
        cursor: pointer;
        transition: all 0.1s ease-in-out;
    }
    #adminPanel #mainPanel #panelBody #panelDesktop .configPanelBody #submitButtons #submit:hover, #adminPanel #mainPanel #panelBody #panelDesktop .configPanelBody #submitButtons #cancel:hover {
        transform: scale(1.02);
        filter: brightness(1.2);
    }
    #adminPanel #mainPanel #panelBody #panelDesktop .configPanelBody #submitButtons #cancel {
        background-color: #f00;
        color: #fff;
        padding: 10px 30px;
        cursor: pointer;
        transition: all 0.1s ease-in-out;
    }
    #adminPanel #mainPanel #panelBody #panelDesktop #userAddPanel .configPanelBody #createEditUserForm #userAddForm input, #adminPanel #mainPanel #panelBody #panelDesktop #userAddPanel .configPanelBody #createEditUserForm #userAddForm select {
        width: 80%;
    }
    #adminPanel #mainPanel #panelBody #panelDesktop #userAddPanel .configPanelBody #createEditUserForm #userEditForm div {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        text-align: start;
    }
    #adminPanel #mainPanel #panelBody #panelDesktop #userAddPanel .configPanelBody #createEditUserForm #userEditForm input, #adminPanel #mainPanel #panelBody #panelDesktop #userAddPanel .configPanelBody #createEditUserForm #userEditForm select {
        width: 80%;
    }
    #adminPanel #mainPanel #panelBody #panelDesktop #productAddPanel {
        width: 60%;
    }
    #adminPanel #mainPanel #panelBody #panelDesktop #productAddPanel .configPanelBody #createEditProductForm #productAddForm {
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    #adminPanel #mainPanel #panelBody #panelDesktop #productAddPanel .configPanelBody #createEditProductForm #productAddForm label {
        margin: 0;
    }
    #adminPanel #mainPanel #panelBody #panelDesktop #productAddPanel .configPanelBody #createEditProductForm #productAddForm #compactBlock {
        width: 100%;
        display: flex;
        align-items: flex-start;
        justify-content: center;
    }
    #adminPanel #mainPanel #panelBody #panelDesktop #productAddPanel .configPanelBody #createEditProductForm #productAddForm #longBlock {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    #adminPanel #mainPanel #panelBody #panelDesktop #productAddPanel .configPanelBody #createEditProductForm #productAddForm #longBlock textarea {
        width: 900px;
        max-width: 900px;
        height: 120px;
        resize: none;
    }
    #adminPanel #mainPanel #panelBody #panelDesktop #productAddPanel .configPanelBody #createEditProductForm #productAddForm #compactBlock #prodEssentials, #adminPanel #mainPanel #panelBody #panelDesktop #productAddPanel .configPanelBody #createEditProductForm #productAddForm #compactBlock #prodImage {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 50%;
        padding: 10px;
    }
    #adminPanel #mainPanel #panelBody #panelDesktop #productAddPanel .configPanelBody #createEditProductForm #submitButtons {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    #adminPanel #mainPanel #panelBody #panelDesktop #productAddPanel .configPanelBody #createEditProductForm #productAddForm #compactBlock #prodImage img {
        height: 300px;
    }
    #adminPanel #mainPanel #panelBody #panelDesktop #productAddPanel .configPanelBody #createEditProductForm #productAddForm #compactBlock #prodEssentials div {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        width: 100%;
        margin: 10px 0px;
    }
    #adminPanel #mainPanel #panelBody #panelDesktop #productAddPanel .configPanelBody #createEditProductForm #productAddForm #compactBlock #prodEssentials div input, select {
        width: 70%;
    }
    #adminPanel #mainPanel #panelBody #panelDesktop .configPanelHeader {
        background-color: #121212;
    }
    #adminPanel #mainPanel #panelBody #panelDesktop .configPanelHeader h3 {
        font-size: 22px;
        margin: 0;
        padding: 10px;
        color: #fff;
    }
    #adminPanel #mainPanel #panelBody #panelDesktop .configPanelBody {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 10px;
    }
    #adminPanel #mainPanel #panelBody #panelDesktop #usersConfigPanel .configPanelBody #userConfigTable, #adminPanel #mainPanel #panelBody #panelDesktop #productsConfigPanel .configPanelBody #productsConfigTable {
        width: 100%;
        height: max-content;
        max-height: 500px;
        overflow-y: auto;
    }
    #adminPanel #mainPanel #panelBody #panelDesktop table {
        width: 100%;
        border-collapse: collapse;
        margin: 0 0 2rem 0;
    }
    #adminPanel #mainPanel #panelBody #panelDesktop .configPanelBody table p {
        margin: 0;
        text-align: start;
        -webkit-user-select: none;
        -ms-user-select: none;
        user-select: none;
        padding: 0.30rem 0.30rem;
    }
    #adminPanel #mainPanel #panelBody #panelDesktop .configPanelBody table i {
        font-size: 26px;
        cursor: pointer;
        transition: all 0.1s ease-in-out;
    }
    #adminPanel #mainPanel #panelBody #panelDesktop .configPanelBody table i:hover {
        transform: scale(1.1);
    }
    #adminPanel #mainPanel #panelBody #panelDesktop .configPanelBody table tbody tr {
        border: solid 1px;
        border-left: 0;
        border-right: 0;
        border-color: rgba(144, 144, 144, 0.25);
    }
    #adminPanel #mainPanel #panelBody #panelDesktop .configPanelBody table tbody tr td {
        vertical-align: baseline;
    }
    #adminPanel #mainPanel #panelBody #panelDesktop .configPanelBody table tbody tr td:nth-child(5) {
        text-transform: uppercase;
        font-weight: bold;
    }
    #adminPanel #mainPanel #panelBody #panelDesktop .configPanelBody table tr:hover {
        background-color: rgba(4, 255, 0, 0.15);
    }
    #adminPanel #mainPanel #panelBody #panelDesktop #usersConfigPanel .configPanelBody table .editUserControls {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    #adminPanel #mainPanel #panelBody #panelDesktop #productsConfigPanel .configPanelBody table .editProductControls {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
    }
    #adminPanel #mainPanel #panelBody #panelDesktop .configPanelBody #addBtn{
        margin-top: 50px;
        display: flex;
        align-items: baseline;
        justify-content: center;
        padding: 10px;
        width: max-content;
        background-color: #2e8b57;
        color: #fff;
        cursor: pointer;
        transition: all 0.1s ease-in-out;
    }
    #adminPanel #mainPanel #panelBody #panelDesktop .configPanelBody #addBtn:hover {
        transform: scale(1.02);
        filter: brightness(1.2);
    }
    #adminPanel #mainPanel #panelBody #panelDesktop .configPanelBody #addBtn p {
        margin: 0px 10px;
    }
    #adminPanel #mainPanel #panelBody #panelDesktop #productsConfigPanel .configPanelBody #productsConfigTable {
        display: flex;
        flex-wrap: wrap;
    }
    #productTableStyle {
        vertical-align: middle;
    }
    #productTableStyle tr td img {
        height: 100px;
        border-radius: 100px;
    }
    #productTableStyle td:nth-child(5) {
        text-transform: capitalize;
    }
    #productTableStyle td .prodDesc {
        width: 350px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    #productTableStyle i {
        font-size: 30px !important;
    }
    .hideSideMenu {
        left: -15vw !important;
    }
    .red {
        color: #f00;
    }
    .green {
        color: #2e8b57;
    }
    .selectedOpt {
        background-color: #484848 !important;
        color: #fff !important;
    }
</style>
</html>
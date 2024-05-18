<?php
    include_once ("php/conn.php");
    session_start();

    if(!isset($_SESSION['user']))
    {
        header('Location: index.php');
        exit;
    }

    // Temporary user class for dynamic profile picture change
    $userObj = new stdClass();
    $userObj->userImage = $_SESSION['user']->image_path;
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

    <div id="editAccountPage">
        <!-- One -->
        <section id="One" class="wrapper style3">
            <div class="inner">
                <header class="align-center">
                    <p>Here you can edit your account information</p>
                    <h2>Edit account</h2>
                </header>
            </div>
        </section>

        <!-- Custom section -->
        <div id="editAccountMain">
            <div id="editAccountSection">
                <div class="box">
                    <div class="content">
                        <header class="align-center">
                            <p>Insert new values below</p>
                            <h2>Edit</h2>
                        </header>
                        <div id="editAccountInputs">
                            <form id="editAccountForm" action="php/userEdit.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="userId" value="<?= $_SESSION['user']->id ?>" />
                                <table>
                                    <tr>
                                        <td rowspan="2">
                                            <div>
                                                <label for="profile_pic" id="profile_pic_label">
                                                    <i id="profile_pic_icon" class="las la-camera" style="background-image: url('<?= $_SESSION['user']->image_path ?>'); background-position: center; background-repeat: no-repeat; background-size: cover; color: transparent;"></i>
                                                </label>
                                                <input type="file" id="profile_pic" name="profilePicEdit" />
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <input type="text" placeholder="Username" name="usernameEdit" value="<?= $_SESSION['user']->username ?>"/>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <input type="password" placeholder="New password" name="passwordEdit" />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div>
                                                <input type="email" placeholder="E-Mail Address" name="emailEdit" value="<?= $_SESSION['user']->email ?>"/>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <input type="password" placeholder="Repeat new password" name="passwordAgainEdit" />
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <div id="editButtons">
                                    <input type="submit" value="SAVE" />
                                    <input type="reset" value="RESET" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include_once 'pages/components/footer.php'; ?>

</body>
<style>
    #profile_pic_label {
        background: rgba(144, 144, 144, 0.075);
        border: 1px solid rgba(144, 144, 144, 0.25);
        width: 100%;
        padding: 10px;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0px;
        cursor: pointer;
    }
    #profile_pic_label i {
        font-size: 40px;
        width: max-content;
        border-radius: 50%;
        padding: 40px;
        background-color: rgba(144, 144, 144, 0.15);
        margin: 0px;
        border: 1px solid rgba(144, 144, 144, 0.25);
    }
    #profile_pic {
        visibility: hidden;
        width: 0px;
        height: 0px;
    }
    #editAccountMain {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 90%;
        margin: 20px auto;
    }
    #editAccountMain #editAccountSection {
        margin: 20px 0px;
        box-shadow: rgba(0, 0, 0, 0.07) 0px 1px 2px, rgba(0, 0, 0, 0.07) 0px 2px 4px, rgba(0, 0, 0, 0.07) 0px 4px 8px, rgba(0, 0, 0, 0.07) 0px 8px 16px, rgba(0, 0, 0, 0.07) 0px 16px 32px, rgba(0, 0, 0, 0.07) 0px 32px 64px;
        height: max-content;
        width: 80%;
    }
    #editAccountMain #editAccountSection .box {
        margin: 0;
    }
    #editAccountMain #editAccountSection #editAccountForm {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    #editAccountMain #editAccountSection #editAccountForm table {
        width: 100%;
        margin-bottom: 10px;
    }
    #editAccountMain #editAccountSection #editAccountForm table tr, #editAccountMain #editAccountSection #editAccountForm table td {
        padding: 10px;
    }
    #editAccountMain #editAccountSection #editAccountForm table tr td {
        vertical-align: middle;
    }
    #editAccountMain #editAccountSection #editAccountForm table tr td div {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    #editAccountMain #editAccountSection #editAccountForm input{
        text-align: center;
    }
    #editAccountMain #editAccountSection #editAccountForm input:focus {
        box-shadow: 0 0 0 1px #00ff11;
    }
    #editAccountMain #editButtons {
        display: flex;
        align-content: center;
        justify-content: center;
    }
    input[type="checkbox"]:checked + label:before, input[type="radio"]:checked + label:before {
        background-color: #00ff11;
        border-color: #00ff11;
        color: #fff;
    }
    .inputError {
        background-color: rgba(255, 0, 0, 0.3) !important;
        border: 1px solid red !important;
        color: red !important;
    }
</style>
</html>
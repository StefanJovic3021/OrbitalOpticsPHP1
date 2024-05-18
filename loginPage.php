<?php
    include_once ("php/conn.php");
    session_start();

    if(isset($_SESSION['user']))
    {
        header('Location: index.php');
        exit;
    }
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

    <div id="loginPage">
        <!-- One -->
        <section id="One" class="wrapper style3">
            <div class="inner">
                <header class="align-center">
                    <p>Don't have an account? Register an account and gain special access!</p>
                    <h2>Log in | Register</h2>
                </header>
            </div>
        </section>

        <!-- Custom section -->
        <div id="loginMain">
            <div id="loginSection">
                <div class="box">
                    <div class="content">
                        <header class="align-center">
                            <p>Log in to your account</p>
                            <h2>Log in</h2>
                        </header>
                        <div id="loginInputs">
                            <form id="loginForm" action="php/login.php" method="POST">
                                <div>
                                    <input type="text" placeholder="E-Mail Address" id="emailLogin" name="emailLogin" />
                                </div>
                                <div>
                                    <input type="password" placeholder="Password" id="passwordLogin" name="passwordLogin" />
                                </div>
                                <div id="loginButtons">
                                    <input type="submit" value="LOG IN" />
                                    <input type="reset" value="CANCEL" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="registerSection">
                <div class="box">
                    <div class="content">
                        <header class="align-center">
                            <p>Register an account</p>
                            <h2>Register</h2>
                        </header>
                        <div id="registerInputs">
                            <form id="registerForm" action="php/register.php" method="POST" enctype="multipart/form-data">
                                <div>
                                    <label for="profile_pic" id="profile_pic_label"><i id="profile_pic_icon" class="las la-camera"></i></label>
                                    <input type="file" id="profile_pic" name="profilePicRegister" />
                                </div>
                                <div>
                                    <input type="text" placeholder="Username" name="usernameRegister" />
                                </div>
                                <div>
                                    <input type="email" placeholder="E-Mail Address" name="emailRegister" />
                                </div>
                                <div>
                                    <input type="password" placeholder="Password" name="passwordRegister" />
                                </div>
                                <div>
                                    <input type="password" placeholder="Repeat password" name="passwordAgainRegister" />
                                </div>
                                <div id="registerButtons">
                                    <input type="submit" value="REGISTER" />
                                    <input type="reset" value="CANCEL" />
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
        #loginMain {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 50rem;
            margin: 20px auto;
        }
        #loginMain #loginSection, #loginMain #registerSection {
            margin: 20px 0px;
            box-shadow: rgba(0, 0, 0, 0.07) 0px 1px 2px, rgba(0, 0, 0, 0.07) 0px 2px 4px, rgba(0, 0, 0, 0.07) 0px 4px 8px, rgba(0, 0, 0, 0.07) 0px 8px 16px, rgba(0, 0, 0, 0.07) 0px 16px 32px, rgba(0, 0, 0, 0.07) 0px 32px 64px;
            height: max-content;
            width: 80%;
        }
        #loginMain #loginSection .box, #loginMain #registerSection .box {
            margin: 0;
        }
        #loginMain #loginSection #loginForm input, #loginMain #registerSection #registerForm input{
            text-align: center;
            margin-bottom: 20px;
        }
        #loginMain #loginSection #loginForm input:focus, #loginMain #registerSection #registerForm input:focus {
            box-shadow: 0 0 0 1px #00ff11;
        }
        #loginMain #loginButtons, #loginMain #registerButtons {
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
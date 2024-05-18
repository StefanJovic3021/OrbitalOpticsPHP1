<?php
    include_once('conn.php');

    if(empty($_POST['usernameRegister']) || empty($_POST['emailRegister']) || empty($_POST['passwordRegister']))
    {
        header('Location: ../loginPage.php?error=field_missing');
    }

    $pictureDir = 'C:\\xampp\\htdocs\\PHP1\\predispitna_sajt\\images\\user_photos\\';

    if(!is_uploaded_file($_FILES['profilePicRegister']['tmp_name']))
    {
        $fileName = 'images/user_photos/sample-profile.png';
    }
    else
    {
        $fileName = $_FILES['profilePicRegister']['name'];
        $tmpName  = $_FILES['profilePicRegister']['tmp_name'];
        $fileSize = $_FILES['profilePicRegister']['size'];
        $fileType = $_FILES['profilePicRegister']['type'];

        $filePath = $pictureDir . time() . '_' . $fileName;

        $result  = move_uploaded_file($tmpName, $filePath);

        if (!$result)
        {
            echo "Error uploading file";
            exit;
        }
        $fileName = 'images/user_photos/' . time() . '_' . $fileName;
    }

    $fileName  = addslashes($fileName);

    $emailRegister = $_POST['emailRegister'];
    $passwordRegister = md5($_POST['passwordRegister']);
    $usernameRegister = $_POST['usernameRegister'];

    try
    {
        $registerQuery = $conn->prepare("INSERT INTO `user` (username, email, password, image_path, active)
                                               VALUES (:username, :email, :password, :image_path, :active);");
        $result = $registerQuery->execute(['username' => $usernameRegister, 'email' => $emailRegister, 'password' => $passwordRegister, 'image_path' => $fileName, 'active' => 1]);

        if($result)
        {
            $loginQuery = $conn->prepare("SELECT `user`.id AS 'id', `user`.email AS `email`, `user`.username AS 'username', `user`.password AS 'password', `role`.name AS 'role', `user`.image_path AS 'image_path'
                                                FROM `user` 
                                                INNER JOIN `role` ON `user`.role_id = `role`.id
                                                WHERE email = :email");
            $loginQuery->execute(['email' => $emailRegister]);
            $user = $loginQuery->fetch();

            session_start();

            $_SESSION['user'] = $user;

            header('Location: ../index.php?login=success');
            exit;
        }
    }
    catch(Exception $e)
    {
        echo $e->getMessage();
    }
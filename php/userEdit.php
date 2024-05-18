<?php
    include_once("conn.php");
    session_start();

    // Catching data inputs
    $newUserEmail = $_POST['emailEdit'];
    $newUsername = $_POST['usernameEdit'];
    $newUserPassword = empty($_POST['passwordEdit']) ? $_SESSION['user']->password : md5($_POST['passwordEdit']);
    $newUserPasswordRepeat = empty($_POST['passwordAgainEdit']) ? $_SESSION['user']->password : md5($_POST['passwordAgainEdit']);
    $userId = $_POST['userId'];

    // Catching file input if provided
    if(is_uploaded_file($_FILES['profilePicEdit']['tmp_name']))
    {
        $pictureDir = 'C:\\xampp\\htdocs\\PHP1\\predispitna_sajt\\images\\user_photos\\';
        $fileName = $_FILES['profilePicEdit']['name'];
        $tmpName  = $_FILES['profilePicEdit']['tmp_name'];
        $fileSize = $_FILES['profilePicEdit']['size'];
        $fileType = $_FILES['profilePicEdit']['type'];

        $filePath = $pictureDir . time() . '_' . $fileName;

        $result  = move_uploaded_file($tmpName, $filePath);

        if (!$result)
        {
            echo "Error uploading file";
            exit;
        }
        $fileName = 'images/user_photos/' . time() . '_' . $fileName;

        $fileName  = addslashes($fileName);

        $oldProfileImagePath = 'C:\\xampp\\htdocs\\PHP1\\predispitna_sajt\\' . str_replace("/", "\\", $_SESSION['user']->image_path);

        unlink($oldProfileImagePath);
    }
    else
    {
        $fileName = $_SESSION['user']->image_path;
    }

    // Sending data to update in database
    try
    {
        $editUserQuery = $conn->prepare("UPDATE `user`
                                               SET 
                                                   `username` = :username,
                                                   `email` = :email,
                                                   `password` = :password,
                                                   `image_path` = :image_path,
                                                   `modified_at` = NOW()
                                               WHERE 
                                                   `id` = :id;");

        $result = $editUserQuery->execute(['username' => $newUsername, 'email' => $newUserEmail, 'password' => $newUserPassword, 'image_path' => $fileName, 'id' => $userId]);

        // Getting the new user information and storing it in the active session
        if($result)
        {
            $loginQuery = $conn->prepare("SELECT `user`.id AS 'id', `user`.email AS `email`, `user`.username AS 'username', `user`.password AS 'password', `role`.name AS 'role', `user`.image_path AS 'image_path'
                                                FROM `user` 
                                                INNER JOIN `role` ON `user`.role_id = `role`.id
                                                WHERE email = :email");
            $loginQuery->execute(['email' => $newUserEmail]);
            $user = $loginQuery->fetch();

            session_start();

            $_SESSION['user'] = $user;

            header('Location: ../index.php?edit=success');
            exit;
        }
    }
    catch(Exception $e)
    {
        echo $e->getMessage();
    }

?>
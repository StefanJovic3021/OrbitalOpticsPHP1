<?php
    include_once('conn.php');

    if (empty($_POST['emailLogin']) || empty($_POST['passwordLogin']))
    {
        header('Location: ../loginPage.php?error=field_missing');
    }

    $emailLogin = $_POST['emailLogin'];
    $passwordLogin = md5($_POST['passwordLogin']);

    try
    {
        $loginQuery = $conn->prepare("SELECT `user`.id AS 'id', `user`.email AS `email`, `user`.username AS 'username', `user`.password AS 'password', `role`.name AS 'role', `user`.image_path AS 'image_path'
                                            FROM `user` 
                                            INNER JOIN `role` ON `user`.role_id = `role`.id
                                            WHERE email = :email");
        $loginQuery->execute(['email' => $emailLogin]);
        $user = $loginQuery->fetch();

        if ($user && ($passwordLogin == $user->password))
        {
            session_start();

            $_SESSION['user'] = $user;

            header('Location: ../index.php?login=success');
            exit;
        }
        else
        {
            header('Location: ../loginPage.php?error=invalid_credentials');
            exit;
        }
    }
    catch (Exception $e)
    {
        echo $e->getMessage();
    }
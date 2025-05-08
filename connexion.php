<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'include/nav.php'; ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 ms-3">
                <?php
                    if(isset($_POST['connexion'])){
                        $login=$_POST['login'];
                        $pass=$_POST['password'];
                        if(!empty($login)&&!empty($pass)){
                            require_once 'include/database.php';
                            $sqlState =$pdo -> prepare('SELECT * FROM utilisateur WHERE login=? AND password=?');
                            $sqlState -> execute([$login,$pass]);
                            if($sqlState -> rowCount()>=1){
                                session_start();
                                $session['utilisateur']=$sqlState->fetch();
                                header('location:admin.php');
                                echo 'Welcome '.$login;
                            } else {
                                ?>
                                <div class="alert alert-danger" role="alert">
                                    Invalid login or password
                                </div>
                                <?php

                            }
                        }
                    }
                ?>
                <h4>Log In</h4>
                <form method="post" action="">
                    <label class="form-label">Login</label>
                    <input type="text" class="form-control" name="login">
                    <label class="form-label mt-3">Password</label>
                    <input type="password" class="form-control" name="password" minlength="10">
                    <div class="form-text">
                        Your password must be longer than 10 characters
                    </div>
                    <input type="submit" value="Add" class="btn btn-primary btn-lg my-2" name="connexion">
                </form>
            </div>
        </div>
    </div>
</body>
</html>
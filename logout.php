<?
// Страница разавторизации

// Удаляем куки
setcookie("id", "", time() - 3600*24*30*12, "/");
setcookie("hash", "", time() - 3600*24*30*12, "/",null,null,true); // httponly !!!

// Переадресовываем браузер на страницу проверки нашего скрипта
header("Location: ./index.php"); 
// exit;
exit("<meta http-equiv='refresh' content='0; url= /index.php'>");

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Универвидениенсо</title>
</head>
<style type="text/css">

    body {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-flow: column;
        flex-wrap: wrap;
    }
    .polls {
        padding:10px; 
        text-align:center; 
        border:1px solid #EEEEEE; 
        width:700px;
    }
    .poll {
        text-align:left;
        display:flex;
        flex-wrap: wrap;
        width:100%;
        font-size:14px;
        margin: 10px 0;
    }
    .poll label {
        line-height: 1.55;
        flex: 0 0 9%;
    }
    .votes {
        text-align:center; 
        background-color:#CCCCFF; 
        border:1px solid #0033FF;
        margin:0 0 10px 0;
    }
    h3 {
        padding: 10px 0;
        margin: 0;
    }
    .btn {
        text-align: center;
        display: flex;
        justify-content: space-around;
        width: 100%;
        margin-top: 25px;
    }
    .menu {
        list-style: none;
        display: inline-flex;
    }
    .nav__link {
        padding: 0 15px;
    }
</style>  
<body>
<header>
        <div class="nav__menu">
            <ul class="menu">
                <li class="nav__link"><a href="./" class="link">Главная</a></li>                          
                <li class="nav__link"><a href="./final.php" class="link">Результат</a></li>   
            </ul>
        </div>
    </header>

<form method="POST">
    Логин <input name="login" type="text" required><br>
    Пароль <input name="password" type="password" required><br>
    Не прикреплять к IP(не безопасно) <input type="checkbox" name="not_attach_ip"><br>
    <input name="submit" type="submit" value="Войти">
</form>

</body>
</html>
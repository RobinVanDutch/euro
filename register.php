<?
// Страница регистрации нового пользователя

// Соединямся с БД
$link=mysqli_connect("localhost","root","root","euro");

if(isset($_POST['submit']))
{
    $err = [];

    // проверям логин
    if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST['login']))
    {
        $err[] = "Логин может состоять только из букв английского алфавита и цифр";
    }

    if(strlen($_POST['login']) < 3 or strlen($_POST['login']) > 30)
    {
        $err[] = "Логин должен быть не меньше 3-х символов и не больше 30";
    }

    // проверяем, не сущестует ли пользователя с таким именем
    $query = mysqli_query($link, "SELECT user_id FROM users WHERE user_login='".mysqli_real_escape_string($link, $_POST['login'])."'");
    if(mysqli_num_rows($query) > 0)
    {
        $err[] = "Пользователь с таким логином уже существует в базе данных";
    }

    // Если нет ошибок, то добавляем в БД нового пользователя
    if(count($err) == 0)
    {

        $login = $_POST['login'];

        // Убераем лишние пробелы и делаем двойное хеширование
        $password = md5(md5(trim($_POST['password'])));

        $users = $_POST['users'];
        $users2 = $_POST['users2'];

        mysqli_query($link,"INSERT INTO users SET user_login='".$login."', user_password='".$password."', user_polls='".$users."', user_polls2='".$users2."'");
        header("Location: ./login.php"); 
        // exit;
        exit("<meta http-equiv='refresh' content='0; url= /login.php'>");   
    }
    else
    {
        print "<b>При регистрации произошли следующие ошибки:</b><br>";
        foreach($err AS $error)
        {
            print $error."<br>";
        }
    }

    
}

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
К кому закреплен:
    <select name="users" id="">
        <option name="zero" value="Без закрепления">Без закрепления</option>
    <?
            $test = mysqli_query($link, "SELECT id,title FROM polls");
            $users = '';
            foreach ($test as $gg) {
                echo '<option class="user" name="user-'.$gg["id"].'" value="'.$gg["title"].'">'.$gg["title"].'</option>';
                $users = $gg['title'];
            }
            print_r ($users);
    ?>
    </select>
К кому закреплен2:
<select name="users2" id="">
    <option name="zero" value="Без закрепления">Без закрепления</option>
<?
        $test = mysqli_query($link, "SELECT id,title FROM polls");
        $users = '';
        foreach ($test as $gg) {
            echo '<option class="user" name="user-'.$gg["id"].'" value="'.$gg["title"].'">'.$gg["title"].'</option>';
            $users = $gg['title'];
        }
        print_r ($users);
?>
</select>
<input name="submit" type="submit" value="Зарегистрироваться">
</form>

</body>
</html>
<?
// Страница авторизации

// Функция для генерации случайной строки
function generateCode($length=6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0,$clen)];
    }
    return $code;
}

// Соединямся с БД
$link=mysqli_connect("localhost","root","root","euro");

if(isset($_POST['submit']))
{
    // Вытаскиваем из БД запись, у которой логин равняеться введенному
    $query = mysqli_query($link,"SELECT user_id, user_password FROM users WHERE user_login='".mysqli_real_escape_string($link,$_POST['login'])."' LIMIT 1");
    $data = mysqli_fetch_assoc($query);

    // Сравниваем пароли
    if($data['user_password'] === md5(md5($_POST['password'])))
    {
        // Генерируем случайное число и шифруем его
        $hash = md5(generateCode(10));

        if(!empty($_POST['not_attach_ip']))
        {
            // Если пользователя выбрал привязку к IP
            // Переводим IP в строку
            $insip = ", user_ip=INET_ATON('".$_SERVER['REMOTE_ADDR']."')";
        }

        // Записываем в БД новый хеш авторизации и IP
        mysqli_query($link, "UPDATE users SET user_hash='".$hash."' ".$insip." WHERE user_id='".$data['user_id']."'");

        // Ставим куки
        setcookie("id", $data['user_id'], time()+60*60*24*30, "/");
        setcookie("hash", $hash, time()+60*60*24*30, "/", null, null, true); // httponly !!!

        // Переадресовываем браузер на страницу проверки нашего скрипта
        header("Location: ./index.php"); 
        // // exit;
        exit("<meta http-equiv='refresh' content='0; url= /index.php'>");
        // echo "<script type='text/javascript'>window.top.location='http://универвидениенсо.рф/';</script>";exit;
    }
    else
    {
        print "Вы ввели неправильный логин/пароль";
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
    <link rel="stylesheet" href="style.css">
</head>
  
<body>
<header>
        <div class="parallax">
            <div class="nav__menu">
                <div class="logo">
                    <a href="./index.php"><img src="./4.png" alt=""/></a>    
                </div>
            </div>
        </div>
    </header>
    <main class="main">
        <div class="container">
            <div class="block__auth">
                <div class="auth__container">
                    <form class="form__auth" method="POST">
                        <div class="elem__auth"><div><span>Логин:</span></div><div><input name="login" type="text" required></div></div>
                        <div class="elem__auth"><div><span>Пароль:</span></div><div><input name="password" type="password" required></div></div>
                        <div class="elem__auth" style="opacity: 1;justify-content: space-around;align-items: center;">Проверка IP(включена) <input type="checkbox" name="not_attach_ip" checked></div>
                        <input class="btn__login" name="submit" type="submit" value="Войти">
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
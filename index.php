<?php

    $link=mysqli_connect("localhost","root","root","euro");

    if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])) {
        $query = mysqli_query($link, "SELECT *,INET_NTOA(user_ip) AS user_ip FROM users WHERE user_id = '".intval($_COOKIE['id'])."' LIMIT 1");
        $userdata = mysqli_fetch_assoc($query);

        if(($userdata['user_hash'] !== $_COOKIE['hash']) or ($userdata['user_id'] !== $_COOKIE['id'])
        or (($userdata['user_ip'] !== $_SERVER['REMOTE_ADDR'])  and ($userdata['user_ip'] !== "0"))) {
            setcookie("id", "", time() - 3600*24*30*12, "/");
            setcookie("hash", "", time() - 3600*24*30*12, "/", null, null, true); // httponly !!!
            // print "Хм, что-то не получилось";
        } else {
            // print "Привет, ".$userdata['user_login'].". Всё работает!";
        }
    } else {
        // print "Включите куки";
    }


    $db=mysqli_connect("localhost","root","root","euro");
    $res=mysqli_query($db,"set names utf8");

    $res=mysqli_fetch_array(mysqli_query($db,"SELECT max(id) FROM polls LIMIT 1"));
    $poll_id=$res[0];

    if (isset($_GET["poll_id"]) and is_numeric($_GET["poll_id"]) and $_GET["poll_id"]>0){
    $res=mysqli_fetch_array(mysqli_query($db,"SELECT id FROM polls
    WHERE id='".$_GET["poll_id"]."' LIMIT 1"));
    if ($res[0]!='') $poll_id=$res[0];
    }
    $poll=mysqli_fetch_array(mysqli_query($db,"SELECT id,title FROM polls
    WHERE id='".$poll_id."'"));



    ?>
    
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width">
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
                <ul class="menu">
                    <?if (!empty($userdata['user_login'])) {
                        echo '<li class="nav__link"><a href="./logout.php" class="link">Выйти</a></li>';
                    } else {
                        echo '<li class="nav__link"><a href="./login.php" class="link">Войти</a></li>';
                    }
                    ?>
                    
                    
                <? 
                    if($userdata['user_login'] == "admin")  {
                        // echo '<li class="nav__link"><a href="./register.php" class="link">Регистрация</a></li>
                        // <li class="nav__link"><a href="./admin_polls.php" class="link">Админка</a></li>';
                        echo '<li class="nav__link"><a href="./final.php" class="link">Результат</a></li>';
                    } else {

                    }
                ?>
                    
                </ul>
            </div>
        </div>
    </header>
    
      
    <?php

// test 

        $test = mysqli_query($db, "SELECT id,title FROM polls");
        // $test = mysqli_query($db, "SELECT poll_answer.poll_id AS ids, polls.id AS pollsid, poll_answer.id AS poll_answersid, polls.title, poll_answer.title AS val FROM polls LEFT JOIN poll_answer ON poll_answer.poll_id=polls.id;");

   
    if (!empty($userdata['user_login'])) {
        echo '<main class="main-login">';
                echo '<div class="container-login">';
        echo '<div class="container-main__login">';
        foreach($test as $gg) {       
            if(($userdata['user_polls'] != $gg['title'] || $userdata['user_polls'] == "Без закрепления") && ($userdata['user_polls2'] != $gg['title'] || $userdata['user_polls2'] == "Без закрепления")) {
                echo '<div class="polls"><h3>'.$gg["title"].'</h3>';
                echo '<div class="poll" attr-ids="'.$gg["id"].'" id="poll_'.$gg["id"].'">'; //2
                $res=mysqli_query($db,"SELECT id,title FROM poll_answer
                    WHERE poll_id='".$gg["id"]."' ORDER BY id ");      
                while ($answer=mysqli_fetch_array($res)) echo '<label><input type="radio" data="'.$answer["title"].'"
                    name="item-'.$gg["id"].'" value="'.$answer["id"].'">'.$answer["title"].'</label><br>';    
                echo '<input style="opacity: 0; display: none; position: absolute;" type="submit" id="vote" class="voters" value="Голосовать">';
                echo '</div></div><br>';
            } else {
                echo '';
            }
        }

        // echo '<input type="submit" id="view_res" class="btn_res" value="Посмотреть результат">';
        echo '<input type="submit" id="vote" class="votes" value="Голосовать">';
        echo '</div>';
    } else {
        // echo'';
        echo '<main class="main">';
                echo '<div class="container">';
                echo '<div class="container-main">';
        echo'<section class="background_out"><div class="center__login"><div class="login__block"><h1>Вам необходимо авторизоваться!</h1></div></div></section>';
        // print_r('login:' . $userdata['user_login']);
        // echo $test;
    }
?>
</div>
</div>
</main>
<script src="../radio-buttons-script.js"></script>
<script src="../jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var $counts = Array.from(document.querySelectorAll('.poll'));
        var count = [];
        var outer = [];
        var ff = [];
        var mass =  $(".poll").toArray().reverse();
        var ggs = [];
        var p = $counts.length;
        var g = 0;
        for(var len = $counts.length , i = len; --i >= 0;) {
            ggs[g] = $(mass[g]).attr("attr-ids");
            g = len - i;
            count[i] = Number(i) + Number($('#vote').parents(".poll").attr("id").split('_')[1]);    
            var gg =  Number($('#vote').parents(".poll").attr("id").split('_')[1]); 
     
            $(".btn_res").click(function(){ //#view_res
                outer[$('.voters').parents(".poll").find('input:checked').val()] = gg;
                jQuery.post("./polls_result.php",{poll_id:gg},rating_poll);
                gg = gg + 1;
            });
            $(".votes").click(function(){ //#vote        
                p = p - 1;
                var ggwp = ggs[p];
                ff = $('.voters').parents(`.poll#poll_${ggwp}`).find('input:checked').val();
                console.log(ggwp + " : " + ff);
                jQuery.post("./polls_result.php",{poll_id:ggwp,
                     answer_id:ff},rating_poll);  
                     gg = gg + 1;          
                     
            });   
        }
    function rating_poll(data){
        $(".poll").fadeOut(500, function(){$(this).html(data).fadeIn(500);});
    }
    });
</script>
</body>
</html>  
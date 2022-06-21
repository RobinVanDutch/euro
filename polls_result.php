<!DOCTYPE html>
<html lang="en">
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
<!-- <header>
        <div class="nav__menu">
            <ul class="menu">
                <li class="nav__link"><a href="./" class="link">Главная</a></li>                          
                <li class="nav__link"><a href="./final.php" class="link">Результат</a></li>   
            </ul>
        </div>
    </header> -->
<?php
if (isset($_POST["poll_id"]) and is_numeric($_POST["poll_id"])) {
    $poll_id=$_POST["poll_id"];
}
else $poll_id='';
if (isset($_POST["answer_id"]) and is_numeric($_POST["answer_id"])) {
    $answer_id=$_POST["answer_id"];
}
else $answer_id='';

if ($poll_id>0) {
 $db=mysqli_connect("localhost","root","root","euro");
 $res=mysqli_query($db,"set names utf8");

if ($answer_id!='') {
 $ip=$_SERVER['REMOTE_ADDR'];

 $res=mysqli_query($db,"SELECT count(id) FROM poll_ip
     WHERE poll_id='".$poll_id."' and ip=INET_ATON('".$ip."') LIMIT 1");

 $number=mysqli_fetch_array($res);

 if ($number[0]==0) {
    $res=mysqli_query($db,"INSERT INTO poll_ip (poll_id,ip,date)
        values ('".$poll_id."',INET_ATON('".$ip."'),'".time()."')");
    $res=mysqli_query($db,"UPDATE poll_answer SET votes=(votes+1)
        WHERE id='".$answer_id."' LIMIT 1");
    $answer='Ваш голос учтен!';
 }

 else $answer='Вы уже голосовали!';
 
}

 $summa=mysqli_fetch_array(mysqli_query($db,"SELECT max(votes) AS max_v, sum(votes)
     AS sum_v FROM poll_answer WHERE poll_id='".$poll_id."' LIMIT 1"));
 if ($summa["max_v"]==0) $summa["max_v"]=1;
 $res=mysqli_query($db,"SELECT title,votes FROM poll_answer
     WHERE poll_id='".$poll_id."' ORDER BY votes DESC");

 while ($rating=mysqli_fetch_array($res)) {
    echo '<div style="opacity:0;width:560px;float:left;">'.$rating["title"];
    echo '<div class="votes" style="opacity:0;width:'.($rating["votes"]/$summa["max_v"]*560);
    echo 'px;">'.$rating["votes"].'</div></div><div style="opacity:0;float:right;"><br>';
    if ($summa["sum_v"]==0) echo '0 %</div>';
    else echo round(100*$rating["votes"]/$summa["sum_v"],2).' %</div>';
 }
 echo '<div style="opacity:0;width:100%;float:left;">Голосов: <b>'.$summa["sum_v"].'</b>';
 echo '<div style="opacity:0;color:#CC0000; text-align:center;">'.$answer.'</div></div>';
 
}
?>

</body>
</html>


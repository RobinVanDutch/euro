
<!DOCTYPE html>
<html lang="en">
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
                <ul class="menu">     
                <? 
                echo '<li class="nav__link"><a href="./logout.php" class="link">Выйти</a></li>';
                        echo '<li class="nav__link"><a href="./final.php" class="link">Результат</a></li>';
                ?>     
                </ul>
            </div>
        </div>
    </header>
<?
 echo '<main class="main-login">';
 echo '<div class="container-login">';
echo '<div class="container-main__login">';
    $link=mysqli_connect("localhost","root","root","euro");
    $db=mysqli_connect("localhost","root","root","euro");
    $res=mysqli_query($db,"set names utf8");
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


    $test = mysqli_query($db, "SELECT polls.title AS name, poll_answer.poll_id AS asid, SUM(poll_answer.title*poll_answer.votes) 
    AS summa FROM poll_answer LEFT JOIN polls ON poll_answer.poll_id=polls.id GROUP BY poll_id ORDER BY summa DESC");
    $respa = mysqli_query($db, "SELECT id,title FROM polls");
    $n = 1; 
    
    foreach($test as $gg) {      
        echo '<div class="polls"><h3>'.$n.". ".$gg["name"].'</h3>';
        $n = $n + 1;
        echo '<div class="poll" id="poll_'.$gg["asid"].'">'; //2
        $res=mysqli_query($db,"SELECT id,title FROM poll_answer
            WHERE poll_id='".$gg["asid"]."' ORDER BY id ");
        echo 'Баллы: ' . $gg['summa'];
            
        if ($summa["max_v"]==0) $summa["max_v"]=1;
        $resp=mysqli_query($db,"SELECT title,votes FROM poll_answer
            WHERE poll_id='".$poll_id."' ORDER BY votes DESC");

        echo '</div></div><br>';
    }
    echo '</div>
    </div>
    </main>';
?>

</body>
</html>
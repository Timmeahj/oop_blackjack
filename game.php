<?php

declare(strict_types=1);
ini_set('display_errors', "1");
ini_set('display_startup_errors', "1");
error_reporting(E_ALL);
session_start();

$stand = 0;
require 'blackjack.php';

if(isset($_SESSION['playerScore']) && isset($_SESSION['playerCards'])){
    $player = new Blackjack($_SESSION['playerScore'],$_SESSION['playerCards']);
} else{
    $player = new Blackjack(0,[]);
}

if(isset($_SESSION['dealerScore']) && isset($_SESSION['dealerCards'])){
    $dealer = new Blackjack($_SESSION['dealerScore'],$_SESSION['dealerCards']);
    $_SESSION['dealer'] = $dealer;
} else{
    $dealer = new Blackjack(0,[]);
    $_SESSION['dealer'] = $dealer;
}

if(isset($_GET["action"])){
    if($_GET["action"] == "hit"){
        $player->hit();
        $_SESSION['playerScore'] = $player->getScore();
        $_SESSION['playerCards'] = $player->getCards();
        if($_SESSION['playerScore'] > 21){
            echo "you lose";
            $_SESSION['playerScore'] = null;
            $_SESSION['playerCards'] = null;
            $_SESSION['dealerScore'] = null;
            echo "<form><button class=\"again\" type=\"submit\" name=\"action\" value=\"again\">Play again</button></form>";
        }
        if($_SESSION['playerScore'] == 21){
            echo "you win";
            $_SESSION['playerScore'] = null;
            $_SESSION['playerCards'] = null;
            $_SESSION['dealerScore'] = null;
            echo "<form><button class=\"again\" type=\"submit\" name=\"action\" value=\"again\">Play again</button></form>";
        }
    }
    if($_GET["action"] == "stand"){
        $player->stand();
        $stand = 1;
    }

    if($_GET["action"] == "surrender"){
        $player->surrender();
    }

    if($_GET["action"] == "again"){
        header("Refresh:0; url=game.php");
        $_SESSION['playerScore'] = null;
        $_SESSION['playerCards'] = null;
        $_SESSION['dealerScore'] = null;
    }
}



?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8" />
        <title>Blackjack</title>
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" />
        <link rel="stylesheet" href="normalize.css" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css" />
    </head>
    <body>
    <form>
        <?php
        if(isset($_SESSION['playerCards'])){
            echo "Your card is ".end($_SESSION['playerCards'])."<br/>";
            echo "Your score is ".$_SESSION['playerScore']."<br/>";
        }
        if($stand == 1){
            echo "Your score is ".$_SESSION['playerScore']."<br/>";
            echo "Dealer score is ".$_SESSION['dealerScore']."<br/>";
        }

        ?>
        <button type="submit" name="action" value="hit">Hit</button>
        <button type="submit" name="action" value="stand">Stand</button>
        <button type="submit" name="action" value="surrender">Surrender</button>
    </form>
    <script src="script.js"></script>
    </body>
    </html>
<?php


/*
echo '<h2>$_GET</h2>';
var_dump($_GET);
echo '<h2>$_POST</h2>';
var_dump($_POST);
echo '<h2>$_COOKIE</h2>';
var_dump($_COOKIE);
echo '<h2>$_SESSION</h2>';
var_dump($_SESSION);*/

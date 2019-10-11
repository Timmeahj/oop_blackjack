<?php


class Blackjack
{
    private $score;
    private $cards;

    public function __construct(int $score, array $cards)
    {
        $this->score = $score;
        $this->cards = $cards;
    }

    public function hit() {
        $card = rand(1, 11);
        array_push($this->cards, $card);
        $this->score += $card;
    }

    public function stand() {
        do {
            $_SESSION['dealer']->hit();
            $_SESSION['dealerScore'] = $_SESSION['dealer']->getScore();
            $_SESSION['dealerCards'] = $_SESSION['dealer']->getCards();
        } while ($_SESSION['dealerScore'] < 15);
        if($_SESSION['dealerScore'] > 21){
            echo "dealer loses";
            $_SESSION['playerScore'] = null;
            $_SESSION['playerCards'] = null;
            $_SESSION['dealerScore'] = null;
            $_SESSION['dealerCards'] = null;
            echo "<form><button class=\"again\" type=\"submit\" name=\"action\" value=\"again\">Play again</button></form>";
        } else{
            if($_SESSION['dealerScore'] >= $_SESSION['playerScore']){
                echo "dealer wins";
                $_SESSION['playerScore'] = null;
                $_SESSION['playerCards'] = null;
                $_SESSION['dealerScore'] = null;
                $_SESSION['dealerCards'] = null;
                echo "<form><button class=\"again\" type=\"submit\" name=\"action\" value=\"again\">Play again</button></form>";
            } else{
                echo "you win";
                $_SESSION['playerScore'] = null;
                $_SESSION['playerCards'] = null;
                $_SESSION['dealerScore'] = null;
                $_SESSION['dealerCards'] = null;
                echo "<form><button class=\"again\" type=\"submit\" name=\"action\" value=\"again\">Play again</button></form>";
            }
        }
    }

    public function surrender() {
        do {
            $_SESSION['dealer']->hit();
            $_SESSION['dealerScore'] = $dealer->getScore();
            $_SESSION['dealerCards'] = $dealer->getCards();
        } while ($_SESSION['dealerScore'] < 15);
        echo "you lost, dealer score: ".$_SESSION['dealerScore'];
        $_SESSION['playerScore'] = null;
        $_SESSION['playerCards'] = null;
        $_SESSION['dealerScore'] = null;
        $_SESSION['dealerCards'] = null;
        echo "<form><button class=\"again\" type=\"submit\" name=\"action\" value=\"again\">Play again</button></form>";
    }

    public function getScore(){
        return $this->score;
    }

    public function getCards(){
        return $this->cards;
    }
}
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
            $_SESSION['message'] = "You win!";
        } else{
            if($_SESSION['dealerScore'] >= $_SESSION['playerScore']){
                $_SESSION['message'] = "You lose.";
            } else{
                $_SESSION['message'] = "You win!";
            }
        }
    }

    public function surrender(Blackjack $dealer) {
        do {
            $dealer->hit();
            $_SESSION['dealerScore'] = $dealer->getScore();
            $_SESSION['dealerCards'] = $dealer->getCards();
        } while ($dealer->getScore() < 15);
        $_SESSION['message'] = "You lose, dealer score: ".$dealer->getScore()."<br/>";
    }

    public function getScore(){
        return $this->score;
    }

    public function getCards(){
        return $this->cards;
    }
}
<?php
namespace TPClass\backgammon;

class Game{
    protected $p1;
    protected $p2;
    protected $board;
    protected $currentTour;

    public function __construct($p1, $p2){
        $this->p1 = new Player ($p1, -1);
        $this->p2 = new Player ($p2, 1);

        $this->currentTour = 0;
    }

    public function start(){
        $this->board = new Board();
        $this->board->drawBoard();
        $throw1 = 0;
        $throw2 = 0;

        while($throw1 === $throw2) {
            $this->p1->throw_dices(1);
            $throw1 = $this->p1->currentDices[0];

            $this->p2->throw_dices(1);
            $throw2 = $this->p2->currentDices[0];
        }


        if ($throw1 > $throw2) {
            $this->beginTour($this->p1);
        } else {
            $this->beginTour($this->p2);
        }
    }

    public function beginTour($player){
        $this->currentTour++;

        $this->board->currentPlayer = $player;
        echo '<h1>Tour n°'.$this->currentTour.'</h1>';
        echo '<p><strong class="player' . $player->color . '">' . $player->name . ' commence à jouer.</strong></p>';
        $player->throw_dices();

        echo '<p>Liste des coups possibles pour <strong>' . $player->name . '</strong> :</p>';

        if ($player->currentDices[0] === $player->currentDices[1]) {
            $saveDices = $player->currentDices;

            $indexDice = $this->play();
            $player->removeDice($indexDice);
            $this->play();

            $player->currentDices = $saveDices;
        }


        $indexDice = $this->play();
        $player->removeDice($indexDice);
        $this->play();

        if ($this->currentTour < 20) {
            // Si on est blanc
            if ($player->color > 0) {
                $this->beginTour($this->p1);
            } else {
                $this->beginTour($this->p2);
            }
        }
    }

    public function play () {


        $color = $this->board->currentPlayer->color;
        $this->board->allowedMoves = [];

        $this->board->reverse_array();

        $nbCheckersAtHome = 0;
        for ($i = 6; $i <= 23 ; $i++) {
            $point = $this->board->points[$i];

            if ($color > 0 && $point > 0 || $color < 0 && $point < 0) {
                $nbCheckersAtHome += abs($point);
            }
        }

        $myIndexBar = 0;
        if ($color < 1) {
            $myIndexBar = 1;
        }

        $nbCheckersAtHome + abs($this->board->bar[$myIndexBar]);

        $this->board->reverse_array();

        if (($color > 0 && $this->board->bar[0] > 0) || ($color < 0 && $this->board->bar[1] > 0)) {
           $possibilities = $this->board->checkBarPossibilities();
        } else if ($nbCheckersAtHome === 0) {
           echo '<h2>Go home</h2>';
           $possibilities = $this->board->checkAllPossibilities();
           $possibilities += $this->board->checkHomePossibilities();
        } else {
           $possibilities = $this->board->checkAllPossibilities();
        }




        if (count($possibilities) > 0) {
            // LE PLAYER FAIT SON CHOIX
            $myChoice = $possibilities[rand(0, count($possibilities) - 1)];
            $indexDice = $myChoice['indexDice'];


            if ($myChoice['status'] === 'bar') {
                $this->board->goToBar($myChoice['to']);
            }

            $this->board->moveChecker($myChoice['from'], $myChoice['to']);

            $this->board->drawBoard();

            return $indexDice;
        }

        return 0;
    }


}

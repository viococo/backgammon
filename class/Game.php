<?php

class Game{
    protected $p1;
    protected $p2;
    protected $board;

    public function __construct($p1, $p2){
        $this->p1 = new Player ($p1, -1);
        $this->p2 = new Player ($p2, 1);
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
            $this->play($this->p1);
        } else {
            $this->play($this->p2);
        }
    }

    public function play($player){
        $this->board->currentPlayer = $player;
        echo '<p><strong class="player' . $player->color . '">' . $player->name . ' commence à jouer.</strong></p>';
        $player->throw_dices();

        echo '<p>Liste des coups possibles pour <strong>' . $player->name . '</strong> :</p>';
        $allCheckers = $this->board->getBoard();

        echo '<ul>';
        $possibilities = $this->board->checkMyPossibilities();
        echo '</ul>';

        // LE PLAYER FAIT SON CHOIX
        $myChoice = $possibilities[rand(0, count($possibilities) - 1)];
        $indexDice = $myChoice['indexDice'];

        $player->removeDice($indexDice);

        $from = $myChoice['from'];
        $to = $myChoice['to'];

        echo '<p>Le joueur déplace from '.($from+1).' to '.($to+1).'</p>';
        if ($myChoice['toBar']) {
            var_dump('go to bar !!');
            $this->board->goToBar($to);
        }

        $this->board->moveChecker($from, $to);

        $this->board->drawBoard();


        // if($myChoice['toBar'])
    }


}

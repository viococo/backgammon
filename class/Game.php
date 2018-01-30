<?php

class Game{
    protected $p1;
    protected $p2;
    protected $board;

    public function __contruct($p1, $p2){
        $this->p1 = new Player ($p1, -1);
        $this->p2 = new Player ($p2, 1);
    }
    
    protected function start(){
        $this->board = new Board();

        if($this->p1->throw_dices(1)[0] < $this->p2->throw_dices(1)[0])
        {
            $this->p2->play();
        } else {
            $this->p1->play();
        }
    }

}

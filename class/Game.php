<?php

class Game{
    protected $p1;
    protected $p2;
    protected $board;

    public function __construct($p1, $p2){
        $this->p1 = new Player ($p1, -1);
        var_dump($this->p1);
        $this->p2 = new Player ($p2, 1);
    }
    
    public function start(){
        $this->board = new Board();
        $throw1 = 0;
        $throw2 = 0;
        while($throw1 === $throw2) {
            $throw1 = $this->p1->throw_dices(1)[0];
            $throw2 = $this->p2->throw_dices(1)[0];
        }
        if($throw1 < $throw2)
        {
            $this->p2->play();
        } else {
            $this->p1->play();
        }
    }

}

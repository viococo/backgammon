<?php

    Class Player
    {
        protected $name =  null;
        protected $color = null; // 1 ou 0 (W/B)
        protected $score = 0;

        public function __construct($name, $color) {
            $this->name = $name;
            $this->color = $color;
        }

        public function throw_dices($nb = 2){
            $dices = [];
            for ($i = 0; $i < $nb; $i++){
                $dices[] = rand(0, 6);
            }
            var_dump($this->name, $dices);
            return $dices;
        }
        
        public function play(){
            $name = $this->name;
            var_dump($name . ' commence à jouer.');
            var_dump('Liste des checkers de ' . $name . ' :');
            $game = new Game();
            $game->getMyCheckers();
        }
    }
?>

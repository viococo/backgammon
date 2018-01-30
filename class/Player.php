<?php

    Class Player
    {
        protected $name =  null;
        protected $color = null; // 1 ou 0 (W/B)
        protected $score = 0;
        protected $currentDices = [0, 0];

        public function __construct($name, $color) {
            $this->name = $name;
            $this->color = $color;
        }

        public function __get($elem) {
            return $this->$elem;
        }

        public function __set($elem, $value) {
            return $this->$elem = $value;
        }

        public function throw_dices($nb = 2){
            $dices = [];
            for ($i = 0; $i < $nb; $i++){
                $dices[] = rand(1, 6);
            }
            var_dump($this->name, $dices);
            $this->currentDices = $dices;
        }

        public function removeDice($indexDice) {
            unset($this->currentDices[$indexDice]);
        }
    }
?>

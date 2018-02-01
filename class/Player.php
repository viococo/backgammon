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

            $pluriel = ($nb === 2) ? 's' : '';

            echo '<p><i>' . $this->name . ' lance le'.$pluriel.' dés : </i>';

            for ($i = 0; $i < $nb; $i++){
                $dices[] = rand(1, 6);
                $space = ($i > 0) ? ' - ' : '';
                echo '<strong>'.$space.$dices[$i].'</strong>';
            }

            echo '</p>';
            $this->currentDices = $dices;
        }

        public function removeDice($indexDice) {
            // On assigne le dès non-utilisé en premier
            if ($indexDice === 1) {
                $this->currentDices[0] = $this->currentDices[0];

            } else {
                $this->currentDices[0] = $this->currentDices[1];
            }

            // Et on supprime l'autre
            unset($this->currentDices[1]);

        }
    }
?>

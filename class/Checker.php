<?php
    Class Checker
    {
        protected $position =  null; // Numéro de la pointe
        protected $id_player = null; // Player
        protected $status = 0; // Status 0[on board] / 1[bar] / 2[end]

        public function __construct($position, $player) {
            $this->position = $position;
            $this->id_player = $player;
        }
    }
?>

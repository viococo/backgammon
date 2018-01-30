<?php
    Class Board
    {
        // STOCKER LES 24 EMPLACEMENTS POUR LES 24 FLECHES
        protected $history = [];
        protected $points = [];
        protected $bar = [0, 0];

        public function __construct() {
            $this->points = [2, 0, 0, 0, 0, -5, 0, -3, 0, 0, 0, 5, -5, 0, 0, 0, 3, 0, 5, 0, 0, 0, 0, -2];
        }

        public function getMyCheckers($player) {
            echo '<p>Récupérer les jetons du joueur : ' . $player->name. '</p>';

            for ($i = 0; $i < count($this->points); $i++) {
                var_dump($this->points[$i]);
            }
        }
    }
?>

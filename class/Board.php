<?php
    Class Board
    {
        // STOCKER LES 24 EMPLACEMENTS POUR LES 24 FLECHES
        protected $history = [];
        protected $points = [];
        protected $bar = [0, 0];
        protected $allowedMoves = [];

        public function __construct() {
            $this->points = [2, 0, 0, 0, 0, -1, 0, -3, 0, 0, 0, 5, -5, 0, 0, 0, 3, 0, 1, 0, 0, 0, 0, -2];
        }

        public function getBoard() {
            return $this->points;
        }

        public function showPossibilty($from, $to, $indexDice, $toBar = false) {
            $this->allowedMoves[] = ['from' => $from, 'to' => $to, 'indexDice' => $indexDice, 'toBar' => $toBar];

            var_dump('- from '.($from + 1).' to '. ($to + 1) . ($toBar ? ' (tu manges)' : ''));

        }

        public function checkMyPossibilities($player) {
            var_dump($player);
            $color = $player->color;
            $dices = $player->currentDices;


            echo '<p>Liste des checkers de ' . $player->name . ' :</p>';

            // Si on est noir
            if ($color > 0) {
                $this->points = array_reverse($this->points);
            }

            echo '<p>Liste des coups possibles :</p>';
            for ($i = 0; $i < count($this->points); $i++) {

                $currentCheckers = $this->points[$i];

                if ($color > 0 && $currentCheckers > 0 || $color < 0 && $currentCheckers < 0) {

                    for ($indexDice = 0; $indexDice < count($dices); $indexDice++) {
                        $targetPos = $i - $dices[$indexDice];

                        // Si t'es dans le tableau
                        if ($targetPos > 0) {
                            $targetCheckers = $this->points[$targetPos];

                            // Si les jetons sont à toi
                            if ($targetCheckers > 0 && $color > 0 || $targetCheckers < 0 && $color < 0 || $targetCheckers === 0) {
                                // TODO : TU PEUX JOUER
                                $this->showPossibilty($i, $targetPos, $indexDice);

                            } else { // Sinon les jetons sont à l'autre !
                                if (abs($targetCheckers) < 2) {
                                    // TODO : TU PEUX JOUER + MANGER
                                    $this->showPossibilty($i, $targetPos, $indexDice, true);
                                }
                            }
                        }
                    }
                }
            }

            // Si on est noir
            if ($color > 0) {
                $this->points = array_reverse($this->points);
            }

            return $this->allowedMoves;
        }


        public function moveChecker($from, $to) {
            
        }

    }
?>

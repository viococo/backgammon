<?php
    Class Board
    {
        protected $history = [];
        protected $points = [];
        protected $bar = [0, 0]; // blanc, noir
        protected $allowedMoves = [];
        protected $currentPlayer;

        public function __construct() {
            // Stocker le contenu initial des 24 flèches
            $this->points = [2, 0, 0, 0, 0, -5, 0, -3, 0, 0, 0, 5, -5, 0, 0, 0, 3, 0, 5, 0, 0, 0, 0, -2];
            // $this->points = [2, 0, 0, 0, 0, -1, 0, -3, 0, 0, 0, 5, -5, 0, 0, 0, 3, 0, 1, 0, 0, 0, 0, -2];
            // $this->points = [2, 1, 1, 1, 1, -1, 1, -3, 1, 1, 1, 5, -5, 1, 1, 1, 3, 1, 1, 1, 1, 1, 1, -2];
        }

        public function drawBoard() {
            echo '<div class="board">';
            foreach ($this->points as $indexPoint => $point) {
                echo '<div class="point">';

                for ($i = 0; $i < abs($point); $i++) {
                    $color = ($point > 0) ? 'white' : 'black';
                    echo '<div class="checker '.$color.'"></div>';
                }

                echo '</div>';

                if ($indexPoint === 5 || $indexPoint === 17) {
                    echo '<div class="bar">';

                    $color = 'white';
                    $index = 0;

                    if ($indexPoint === 17) {
                        $color = 'black';
                        $index = 1;
                    }

                    for ($i=0; $i < $this->bar[$index]; $i++) {
                        echo '<div class="checker '.$color.'"></div>';
                    }

                    echo '</div>';
                }

                if ($indexPoint === 11) {
                    echo '</div><div class="board board2">';
                }

            }
            echo '</div>';
        }

        public function __set($elem, $value) {
            return $this->$elem = $value;
        }

        public function getBoard() {
            return $this->points;
        }

        public function showPossibilty($from, $to, $indexDice, $toBar = false) {

            // On stock les déplacements possibles
            $this->allowedMoves[] = [
                'from' => $from,
                'to' => $to,
                'indexDice' => $indexDice,
                'toBar' => $toBar];

            // On affiche les choix possibles
            echo '<li> from '.($from + 1).' to '. ($to + 1) . ($toBar ? ' (tu manges)' : ''). '</li>';
        }

        public function checkMyPossibilities() {
            $color = $this->currentPlayer->color;
            $dices = $this->currentPlayer->currentDices;

            $this->reverse_array();

            // On parcourt tous les hommes du tableau
            for ($i = 0; $i < count($this->points); $i++) {

                // Homme du départ
                $currentCheckers = $this->points[$i];

                // Il faut que l'homme du départ soit du même signe que la couleur (négatif ou positif)
                if ($color > 0 && $currentCheckers > 0 || $color < 0 && $currentCheckers < 0) {

                    // On parcourt les dès
                    for ($indexDice = 0; $indexDice < count($dices); $indexDice++) {

                        // Calcul du déplacement
                        $targetPos = $i - $dices[$indexDice];

                        // Si la cible est dans le tableau
                        if ($targetPos > 0) {

                            // Homme cible
                            $targetCheckers = $this->points[$targetPos];

                            // Si le(s) jeton(s) cible t'appartient
                            // Ou s'il n'y a pas personne sur la flèche
                            if ($targetCheckers > 0 && $color > 0 || $targetCheckers < 0 && $color < 0 || $targetCheckers === 0) {
                                $this->showPossibilty($i, $targetPos, $indexDice);
                            } else if (abs($targetCheckers) < 2) {
                                // Sinon, si il appartient à l'adversaire (et qu'il est seul)
                                $this->showPossibilty($i, $targetPos, $indexDice, true);
                            }
                        }
                    }
                }
            }

            $this->reverse_array();

            return $this->allowedMoves;
        }

        public function reverse_array() {
            if ($this->currentPlayer->color > 0) {
                // Si on est blanc on inverse le tableau
                $this->points = array_reverse($this->points);
            }
        }

        public function goToBar($elemToBar) {
            // Si on est blanc
            if ($this->currentPlayer->color > 0) {
                $this->bar[1] += 1; // on met un noir à la barre
            } else {
                $this->bar[0] += 1; // on met un blanc à la barre
            }

            $this->reverse_array();

            $this->points[$elemToBar] -= 1; // On retire le checker demandé

            $this->reverse_array();
        }

        public function moveChecker($from, $to) {
            $this->reverse_array();

            // Si on est blanc
            if ($this->currentPlayer->color > 0) {
                $this->points[$from] -= 1; // On retire le checker de son point de départ
                $this->points[$to] += 1; // Et on l'ajoute à la flèche target
            } else {
                $this->points[$from] += 1; // On retire le checker de son point de départ
                $this->points[$to] -= 1; // Et on l'ajoute à la flèche target
            }

            $this->reverse_array();
        }

    }
?>

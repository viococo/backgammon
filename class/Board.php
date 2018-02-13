<?php
    namespace TPClass\backgammon;

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
        }

        public function __get($elem) {
            return $this->$elem;
        }

        public function drawBoard() {
            echo '<div class="board">';

            $nbCheckers = 0;
            $nbCheckersBlanc = 0;
            $nbCheckersNoir = 0;

            foreach ($this->points as $indexPoint => $point) {
                echo '<div class="point"><span class="white">'. (24 - $indexPoint) . '</span><span class="black">' .($indexPoint + 1).'</span>';

                for ($i = 0; $i < abs($point); $i++) {
                    $color = ($point > 0) ? 'white' : 'black';
                    echo '<div class="checker '.$color.'"></div>';
                    $nbCheckers++;

                    if($color === 'white') {
                        $nbCheckersBlanc++;
                    } else {
                        $nbCheckersNoir++;
                    }
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
                        $nbCheckers++;

                        if($color === 'white') {
                            $nbCheckersBlanc++;
                        } else {
                            $nbCheckersNoir++;
                        }
                    }

                    echo '</div>';
                }

                if ($indexPoint === 11) {
                    echo '</div><div class="board board2">';
                }

            }
            echo '</div>';

            if ($nbCheckersBlanc === 0) {
                exit('<h1>Bob a gagné.</h1>');
            } else if ($nbCheckersNoir === 0) {
                exit('<h1>Alice a gagné.</h1>');
            }
        }

        public function __set($elem, $value) {
            return $this->$elem = $value;
        }

        public function showPossibilty($from, $to, $indexDice, $status = false) {

            // On stock les déplacements possibles
            $this->allowedMoves[] = [
                'from' => $from,
                'to' => $to,
                'indexDice' => $indexDice,
                'status' => $status];


             if(is_numeric($to)) {
                $to++;
             }

             if(is_numeric($from)) {
                $from++;
             }

             $currentDices = $this->currentPlayer->currentDices;

             if (count($currentDices) === 1) {
                 $dices = '<strong>' .$currentDices[0]. '</strong>';
             } else {
                 $dices = '<strong>' .$currentDices[0]. '</strong>-' .$currentDices[1]. '';

                 if ($indexDice === 1) {
                     $dices = '' .$currentDices[0]. '-<strong>' .$currentDices[1]. '</strong>';
                 }
             }




             $color = $this->currentPlayer->color;

             if ($color > 0) {
                 $color = 'blanc';
             } else {
                 $color = 'noir';
             }

             $etoile = '';
             if ($status === 'bar') {
                 $etoile = '*';
             }

            // On affiche les choix possibles
            echo '<li>'.$color.' '.$dices.' ' .$from.'/'. $to . ''.$etoile.'</li>';
        }

        public function checkAllPossibilities() {
            $color = $this->currentPlayer->color;
            $dices = $this->currentPlayer->currentDices;

            $this->reverse_array();

            echo '<ul>';

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
                        if ($targetPos >= 0) {

                            // Homme cible
                            $targetCheckers = $this->points[$targetPos];

                            // Si le(s) jeton(s) cible t'appartient
                            // Ou s'il n'y a pas personne sur la flèche
                            if ($targetCheckers > 0 && $color > 0 || $targetCheckers < 0 && $color < 0 || $targetCheckers === 0) {
                                $this->showPossibilty($i, $targetPos, $indexDice);
                            } else if (abs($targetCheckers) < 2) {
                                // Sinon, si il appartient à l'adversaire (et qu'il est seul)
                                $this->showPossibilty($i, $targetPos, $indexDice, 'bar');
                            }
                        }
                    }
                }
            }

            echo '</ul>';

            $this->reverse_array();

            return $this->allowedMoves;
        }

        public function checkBarPossibilities() {
            $this->reverse_array();

            $color = $this->currentPlayer->color;

            foreach ($this->currentPlayer->currentDices as $indexDice => $dice) {
                $targetPos = (24 - $dice);
                $targetCheckers = $this->points[$targetPos];

                // Si le(s) jeton(s) cible t'appartient
                // Ou s'il n'y a pas personne sur la flèche
                if ($targetCheckers > 0 && $color > 0 || $targetCheckers < 0 && $color < 0 || $targetCheckers === 0) {
                    $this->showPossibilty('bar', $targetPos, $indexDice);
                } else if (abs($targetCheckers) < 2) {
                    // Sinon, si il appartient à l'adversaire (et qu'il est seul)
                    $this->showPossibilty('bar', $targetPos, $indexDice, 'bar');
                }
            }

            $this->reverse_array();

            return $this->allowedMoves;
        }

        public function checkHomePossibilities() {
            $this->reverse_array();
            $color = $this->currentPlayer->color;

            foreach ($this->currentPlayer->currentDices as $indexDice => $dice) {
                // first index = 0
                $dice = $dice - 1;

                $targetCheckers = $this->points[$dice];

                if ($targetCheckers > 0 && $color > 0 || $targetCheckers < 0 && $color < 0 || $targetCheckers) {
                    $this->showPossibilty($dice, 'leave', $indexDice, 'leave');
                } else if($targetCheckers === 0) {

                    $findChecker = false;
                    for ($i = $dice; $i < 6; $i++) {
                        $checker = $this->points[$i];

                        if ($checker > 0 && $color > 0 || $checker < 0 && $color < 0)  {
                            $findChecker = true;
                            break;
                        }
                    }

                    if (!$findChecker) {
                        for ($i = $dice; $i >= 0; $i--) {
                            $checker = $this->points[$i];

                            if ($checker > 0 && $color > 0 || $checker < 0 && $color < 0)  {
                                $this->showPossibilty($i, 'leave', $indexDice, 'leave');
                                break;
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

            echo '<p class="attention">Le joueur mange un pion advserse !</p>';

            if ($this->currentPlayer->color > 0) {
                // Si on est blanc on inverse le tableau
                $this->points = array_reverse($this->points);

                $this->points[$elemToBar] += 1; // On retire un point noir (-x + 1)
            } else {
                $this->points[$elemToBar] -= 1; // Sinon on retire un point blanc (x - 1)
            }

            // On remet le tableau dans le bon ordre si besoin
            $this->reverse_array();
        }

        public function moveChecker($from, $to) {

            $this->reverse_array();

            if($to === 'leave') {
                // Si on est blanc
                if ($this->currentPlayer->color > 0) {
                    $this->points[$from] -= 1; // On retire le checker de son point de départ
                } else {
                    $this->points[$from] += 1; // On retire le checker de son point de départ
                }
            } else {
                if($from === 'bar') {
                    // Si on est blanc
                    if ($this->currentPlayer->color > 0) {
                        $this->bar[0] -= 1; // on enlève un blanc à la barre
                    } else {
                        $this->bar[1] -= 1; // on enlève un noir à la barre
                    }
                } else {
                    // Si on est blanc
                    if ($this->currentPlayer->color > 0) {
                        $this->points[$from] -= 1; // On retire le checker de son point de départ
                    } else {
                        $this->points[$from] += 1; // On retire le checker de son point de départ
                    }
                }

                if ($this->currentPlayer->color > 0) {
                    $this->points[$to] += 1; // Et on l'ajoute à la flèche target
                } else {
                    $this->points[$to] -= 1; // Et on l'ajoute à la flèche target
                }
            }



            $this->reverse_array();

            if(is_numeric($to)) {
               $to++;
            }

            if(is_numeric($from)) {
               $from++;
            }

            echo '<p>Le joueur se déplace from '.($from).' to '.($to).'</p>';

        }

    }
?>

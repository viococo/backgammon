<?php
    Class Point
    {
        protected $name =  null;
        protected $pions = []; // liste de pions
        protected $color = null; // 1 ou 2
        protected $score = 0;

        public function __construct($name, $color) {
            $this->name = $name;
            $this->color = $color;
        }
    }
?>

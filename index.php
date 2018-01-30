<pre><?php
require_once('class/Board.php');
require_once('class/Checker.php');
require_once('class/Game.php');
require_once('class/Player.php');
require_once('class/Points.php');

$game = new Game ('Alice', 'Bob');
$game->start();

?></pre>

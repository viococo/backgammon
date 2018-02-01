<style media="screen">
    html {
        background: #f5f5f5;
    }

    .player1,
    .player-1 {
        display: inline-block;
        background: #fff;
        color: #292929;
        padding: 5px;
    }

    .player-1 {
        background: #292929;
        color: #fff;
    }

    .board {
        display: flex;
        flex-direction: row-reverse;
        justify-content: center;
    }

    .board.board2 {
        flex-direction: row;
    }

    .point {
        border: 1px solid grey;
        display: flex;
        flex-direction: column;
        min-width: 17px;
        margin-top: 10px;
    }

    .checker {
        display: inline-block;
        width: 15px;
        height: 15px;
        background: #292929;
        border-radius: 50%;
        border: 1px solid #292929;
    }

    .checker.white {
        background: #fff;
    }

    .bar {
        background: grey;
        width: 17px;
        margin: 10px 10px 0;
    }
</style>

<pre><?php
require_once('class/Board.php');
require_once('class/Checker.php');
require_once('class/Game.php');
require_once('class/Player.php');
require_once('class/Points.php');

$game = new Game ('Alice', 'Bob');
$game->start();

?></pre>

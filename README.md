# backgammon
Jeu de backgammon
___

## Liste des entités
### PARTIE
new partie () {
    class
}

### PLATEAU - BOARD
- flèches 6 x 2 x 2
- 

### JOUEURS - PLAYER
- sens
- 15 pions
- couleur
- score
> methods :
- pips
- win : score ++

### HOMMES - Checker
- position (numéro flèche ?)
- etat : bar / en cours / dernière case
- couleur / joueur

### FLECHES - Points
- couleur
- état : fermée / pas fermée

### Notation deplacement :
- chaque déplacement fait se note entre parenthèse 
- le score du dés est représenté par un tiret
- le déplacement a/b 
- si double alors nombre de fois que le déplacement a été fait entre []
- si prend un piont de l'adversaire on ajoute un astérisque
- (Noir 3-3 6/3[2], 8/5[2])
- (Blanc 1-2 8/5*)
# Presten the Game
Simple PHP implementation of game Presten (Mao Mao)

 * Shuffle a deck of 52 playing cards (no Jokers). Pass seven cards to each player. The
remainder is called the drawing stack.
 * At the beginning of the game the topmost card is revealed, then the players each get a turn to
play cards.
 * One can play a card if it corresponds to the suit or value of the open card. E.g. on a 10 of
spades, only other spades can be played or other 10s. If a player is not able to play, they
should draw one card from the stack
 * Once the drawing stack is empty, the player will have to skip a turn if he / she cannot play a
card.
 * Whoever gets rid of his/her cards first wins the game.
 * If no one have a card to play and there are no cards in deck. It's a draw
 
 
## How to run

* Run composer to setup autoload.php. via Docker: `bin/composer install`
* Run the script `bin/run.php` or via Docker: `bin/php bin/run.php`
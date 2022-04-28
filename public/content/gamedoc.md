###Flödesschema:
Nedan har jag i ett flödesschema beskrivit det övergripande tänkta flödet i spelet, från startskärm genom olika spelmoment.

![Flödesschema](/img/flowchart.png)

###Pseudokod:
Nedan beskriver jag den huvudsakliga spelloopen som den sköts via controllern med hjälp av en route för post. Jag har inkluderat pseudokod för klassen game, vari variabler samt metoder som krävs för spellogiken har samlats, samt för funktionen gamePost som sköter POST-routen /game/process. Jag har ej inkluderat klassen player eller hand även om metoder från dessa kallas. Det bör vara tydligt vad som händer i dessa metoder utifrån deras namn.

```
class Game () {
    constructor() {
        SET dealer TO new Player()
        SET player TO new Player()
        SET deck TO new Deck()
        SET state TO “start”
    }

    public function dealCardToPlayer() {
        CALL player.addCard with return value from deck.popCard
    }

    public function dealCardToDealer() {
        CALL dealer.addCard with return value from deck.popCard
    }

    public function checkWinner() {
        IF player.hand.getValue > 21
            return False
        ELSE IF dealer.hand.getValue > 21
            return True
        ELSE IF player.hand.getValue > dealer.hand.getValue
            return True
        ELSE IF 
            return False
        ENDIF
    }

    public function awardWinnings(bool win) {
        IF win is True
            ADD player.currentBet to player.totalCash
        ELSE
            SUB player.currentBet from player.totalCash 
        ENDIF
    }

    public function runDealerAi() {
        WHILE dealer.hand.getValue < 18
            CALL this.dealCardToDealer()
        ENDWHILE
    }

    public function setState(string state) {
        SET this.state TO state
    }
}

response function gamePost(sessionInterface session, Request request) {
    SET go TO postVariables[“go”]
    SET pass TO = postVariables[“pass”]
    SET reset TO = postVariables["reset"]
    SET start TO = postVariables["start"]
    SET bet TO = postVariables[“bet”]
    SET newRound TO postVariables["newRound]
    
    IF start == true
        SET currentGame TO new Game()
        CALL currentGame.dealCardToPlayer
        CALL currentGame.setState WITH "bet"
    ELSE IF bet == true
        CALL currentGame.setBetAmount WITH postVariables[“betValue”]
        CALL currentGame.setState WITH “ongoingGame”
    ELSE IF go == true
        CALL game.dealCardToPlayer
        IF currentGame.player.hand.getValue >= 21
            CALL currentGame.checkWinner
            CALL currentGame.awardWinnings
        ELSE
            CALL currentGame.setState WITH “ongoingGame”
        ENDIF
    ELSE IF pass == true
        CALL currentGame.runDealerAi
        CALL currentGame.checkWinner
        CALL currentGame.awardWinnings
        CALL currentGame.setState WITH “endRound”
    ELSE IF newRound == true
        CALL currentGame.resetHands
        CALL currentGame.resetDeck
        CALL currentGame.dealCardToPlayer
        CALL currentGame.setState WITH "bet"
    ELSE IF reset == true
        SET currentGame TO new Game()
    ENDIF
    SET sessionVariables[“game”] to currentGame 
}
```


###Klasser:
För spelet 21 planerar jag att implementera fem klasser: card, deck, hand, player samt game. Card, deck och hand har jag implementerat sedan tidigare kursmoment, medan player samt game är nya för detta kursmoment och spelet. Nedan följer en kort beskrivning av varje klass:

####Card:
Klass för spelkort, innehåller rang (vilket dubblerar som värde), färg, id samt bildlänk.
Innehåller metoder för att hämta värden samt ändra värde på ess.

####Deck:
Klass för kortlek som i konstruktorn skapar en array med 52 kort (Deriverade klasser möjliga med fler kort eller jokrar) och som innehåller metoder för att sortera och blanda kortlek, hämta antal kort, hämta bild-filnamn för ett eller alla kort samt för att avlägsna ett kort från leken.

####Hand:
Klass för hand. Skapas med en tom array för kort och har metoder för att lägga till kort samt interagera med korten.

####Player:
Klass för spelare som innehåller spelarhand, insats, totalt antal pengar samt metoder för att hämta, ställa in och interagera med dessa.

Game:
Huvudklassen för spelet som innehåller variabler och objektinstanser som krävs för spelet samt metoder som sköter all logik för spelet (Det bör noteras att “spelloopen” sköts via kontroller-filen och ej i klassen).

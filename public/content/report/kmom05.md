

## Kmom04

När det kommer till enhetstestning har vi tidigare behandlat detta relativt genomgående i kursen oopython, varför jag kände mig ganska bekväm med detta. 
I mångt och mycket kände jag att PHPUnit fungerade på ett snarlikt sätt, varför jag inte heller kände några större problem med att börja koda testerna. Även om jag inte använde mig av det i detta kursmoment är jag intresserad av att fördjupa mig i mockning för testningssyfte, något som vi gick igenom i pythonkursen och som självklart kan vara
relevant även för php-kod. Kodtäckning med xdebug var väldigt värdefullt och hjälpte mig att se till att alla delar av källkoden testades. Detta var för mig nytt, då vi inte använde oss av något sådant verktyg under pythonkursen.
Enhetstester överlag känner jag är ett värdefullt verktyg, i synnerhet när projekt ökar i storlek och det blir svårare att testa alla fall själva direkt i programmet
eller webbläsaren. För källkoden lyckades jag nå 100% kodtäckning för alla filer som skulle kollas. Jag skrev inga tester för controllers. Xdebug var här väldigt värdefullt för att kunna se till att allting täcktes. Det sagt så är det möjligt att vissa av enhetstesterna kunde kännas överflödiga då de endast testade enkla getters och setters.

När jag började skriva testerna fanns det vissa metoder som var svåra att testa, i synnerhet för min "game"-klass. Detta då kortlekarna blandades och man inte kunde 
veta vilka kort som skulle delas ut. För att lösa detta lade jag till några extra metoder i klassen, dels för att sortera kortleken och även för att kunna starta ett spel
med en skräddarsydd kortlek enbart för testning. Detta behövdes för att kunna få förutsägbara resultat när det kom till att testa metoder för poängräkning samt för kontroll av vinstvillkor. Jag lade även till metoder för att räkna kort i händer och kortlek för testning, metoder som inte behövdes direkt i spelet.

När det kommer till huruvida testbar kod innebär snyggare och renare kod tror jag att det kan hjälpa till med att säkerställa att onödig kod kan rensas bort när man undersöker
koden för testbarhet med avsikt att få full täckning. Detta genom att identifiera kod som inte kan nås, bland annat på grund av villkor som aldrig uppfylls. Å andra sidan kan det även leda till att man behöver lägga till metoder som enbart används för testning och som annars inte krävs för funktionaliteten på programmet. Jag upplevde att detta var fallet för mig där jag var tvungen att lägga till metoder i game-klassen.

För detta kursmoment rör mitt TIL just enhetstestning, och även dokumentering av kod i php och hur man kan installera och konfigurera verktyg för detta på projektbasis med hjälp av composer. Enhetstestning och autodokumentering är något vi berört i tidigare kurser, oopython respektive javascriptkursen, varför det inte var nytt för mig. Det var dock som sagt användbart hur man kan arbeta med detta i php.
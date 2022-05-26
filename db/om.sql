--
-- Insert values into articles
--
--DROP TABLE IF EXISTS article;
--CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;

SET FOREIGN_KEY_CHECKS=0;

UPDATE article 
SET content = "När det kommer till kodkvalitet är detta något som jag har försökt ha i åtanke allteftersom jag kodat, även om det i spurter ofta blivit så att jag först fastställer funktionaliteten som jag är ute efter i kod, utan närmare eftertanke på stil och organisation, varefter jag gått igenom tester, både stiltester och linters så som phpcs, phpcbf, phpmd och phpstan, och därefter granskat min kodbas efter bästa förmåga med hjälp av mer omfattande analysverktyg så som phpmetrics och scrutinizer. På så sätt har jag gått igenom många rundor av att skriva ner rå kod, analysera och refaktorera. Testning har även kommit in i bilden, och jag har genom dessa lyckats luska ut problem så som problem med färger vid konfiguration av tabellerna som byggs upp med hjälp av chartjs och används på hemsidan.

Jag önskar först tala om stilfix och linters, dessa är verktyg som jag har väldigt god användning av och gärna kör igenom sinsemellan, då jag gärna har en tendens att få ner funktionalitet på papper utan närmaste eftertanke på kod och eventuella problem vad gäller villkorssatser, nullvärden, variabler, variabelnamn mm. På så sätt kan jag gå få ner jag behöver få ner i kod, och sedan justera allteftersom. Med hjälp av detta har jag lyckats få ner anmärkningar från dessa verktyg till 0 på min egenkomponerade kod. Det bör nämnas att jag ej fått 100% resultat från de linters vi använder oss av i kursen, utan har från phpmd fått anmärkningar på korta variabelnamn ($id) och variabel och parameter-namn som inte är i camelcase (t.ex. indicator_id) i de entity-klasserna och booleanArgumentFlag-varningar i repositoryklasserna. Jag har dessutom fått read-only-variable-property-varningar från phpstan
för $id-egenskaperna i entityklasserna, en varning som jag stängt av genom kommentarer i filerna. Då dessa klasser är autogenererade och då klassegenskaperna i entity-klasserna gärna ska matcha kolumnnamn i databasen har jag valt att ignorera dessa filer.

När det kommer till enhetstestning har jag skapat enhetstester med 100% täckning för alla klasser förutom controller, entity och repository-klassen, som vi enligt instruktion kunde ignorera. Dessa tester har använts för att se att rätt typ av variabel returneras för ChartCreator-klassen och att rätt värden returneras där det har varit rimligt att testa detta, t.ex. arrayFlip-metoden ArrayUtils och för getDatasets och getOptions-metoderna från ChartCreator-klassen. Genom dessa tester har jag lyckats rota ut problem i koden, t.ex. felaktig syntax, eller felaktigt tilldelade värden, och de har på så sätt varit till stor hjälp.

Att arbeta med kodstil, linters och testning är ofta ett relatvt enkelt, om än ibland monotont arbete, då jag med dessa verktyg lätt kan gå igenom koden rad för rad för att hitta och korrigera problem. Mer komplicerat blir det att arbeta mot analyser från verktyg som phpmetrics och scrutinizer, även om scrutinizer kan peka ut specifika problem i koden, får man här istället mer övergripande mätvärden för kodkvalitet som måste beaktas och hanteras på klass- och metodnivå, framförallt vad rör tre av de fyra c:na, complexity, cohesion och coupling. Dessa mätvärden rör snarare problematik rörande klass- och metodstruktur än specifik kodproblematik. Jag har använt mig huvudsakligen av phpmetrics under projektets gång, då detta ger ett snabbt och responsivt svar, medan scrutinizer har använts i ett senare skede för att bekräfta uppgifter från php-metrics och hitta mer specifika problem ner på metodnivå. Då det huvudsakliga arbetet för projektet har utförts i controller-klasser, med endast två mindre hjälpar-klasser, ChartCreator och ArrayUtils, har komplexitet och i viss utsträckning även metod- och klasstorlek varit de mätvärden som jag funnit vara av mest nytta. Genom att följa klasskomplexiteten i både PhpMetrics och Scrutinizer har jag kunnat identifiera problematiska områden i koden där jag behövde förenkla. Indicator-routen för enskilda indikatorer är ett utmärkt exempel på detta. Då jag istället för att hårdkoda sidor för varje indikator, valde att hämta information dynamiskt från databasen baserat på routeparametern som skickades med, innebar detta en lång, ibland tillsynes osammanhängande, kodmassa med många villkorssatser och for-loopar. För att lösa detta gick jag igenom koden i flera iterationer och identifierade bitar av kod som kunde lyftas ut till separata klasser och metoder (t.ex. ChartCreator-klassen, vars funktionalitet jag ursprungligen hade i route-metoden, samt metoden arrayFlip som också kunde lyftas ut) samt villkorssatser och for-loopar som kunde elimineras. Detta arbete hjälpte till med att organisera koden och göra den mindre komplex, vilket tillsammans med kommentarer gjorde det hela något mer överskådligt. Resultatet kunde synas tydligt i mätvärden med mindre komplexitet och bättre underhållningsindex. Det sagt är metoden av sin natur, där mycket av koden inte kan lyftas ut och mycket data från olika tre entities måste hantera, fortfarande relativt komplex och något problematiskt. Vad gäller ren kodmassa och visuell komplexitet lyckades jag minska detta något med hjälp av Doctrines relationsmappning, där tabeller för indikatorer och diagram-data kopplades ihop med en många-till-en relation. På samma sätta gick jag igenom UserController-klassen, en relativt problematisk klass, för att försöka eliminera onödiga loopar och villkorssatser. Här var det dock desto svårare, då många av metoderna hanterar flera olika variabler relaterade till användare som måste kontrolleras efter förfrågan från POST. Den sista åtgärden jag arbetat med i mån av komplexitet var att dela upp controllerklasserna pga av deras omfattning. Detta är något jag ogärna göra då jag vill samla relaterade route-metoder, men jag bestämde mig att dela upp klasserna ProjectController och UserController en klass för reset-routes och en för resterande projektklasser (hem, indikatorer, omsida), respektive en route för GET-routes och en för POST-routes för UserController-klassen.

När det kommer till de två resterande kodkvalitetsindikatorerna har de varit svårare att arbeta med. Tre av controllerklasserna, CardGameController, LibraryController och LibraryController och tillsammans med samtliga autogenererade repository-klasserna har fått ett inte helt optimalt LCOM-värde på 2. När det kommer till controllerklasserna får man anta att detta beror på att dessa fungerar som samlingsklasser och de olika route-metoderna använder olika resurser efter behov, liksom jag nämnde och diskuterade under föregeånde kursmoment. Därtill verkar jag ha fått en falsk-positiv för deck-klassen, som, i sin funktion att hantera en array av kort, i min mening borde ha fått ett värde på 1. Även detta diskuterade jag under kursmoment 6. Sist men inte minst har även coupling-värdet varit något problematiskt för controllerklasserna på grund av de många beroendena på externa klasser. Här har tre klasser, CardController, LibraryController och ResetController 6 efferenta koppling, CardGameController och UserPostController 7 efferenta kopplingar och ProjectController 8. Det höga värdet för ProjectController har att göra med de många entity-klasserna som måste importeras. Detta höga antal efferenta kopplingar leder i analysen också till hög instabilitet då dessa klasser ej har några afferenta koppling. Liksom för cohesion, sammanhållning, såg jag inga goda möjligheter för förbättringar i kodkvalitet. 

Utöver arbete med kodstil och linters samt arbete i samband med övergripande analys har jag även arbetat med att kommentera kod och gruppera i logiska kodblock i metoderna för förbättrad läsbarhet. Detta har möjligtvis inte så stor effekt på mätvärden, med undantag för kommentarer, men det är väldigt viktigt för att förbättra läsbarhet och underlätta underhåll.

När det kommer till kodkvalitet tror jag att jag genom mitt arbete har förbättrat koden på flera punkter, först och främst läsbarhet och överskådlighet, vilket i sin tur underlättar underhåll. Genom att arbeta med komplexitet har jag lyckats förenkla vissa metoder, i synnerhet i controllers, och även lyckats bryta ut en del kod i vad jag anser vara en logisk enhet. Här bör jag lägga en notis om utbrytning av kod och ArrayUtils-klassen. Denna innehåller endast en metod, vilket kan ses som onödigt, men tanken med denna klass var att kunna använda den som utility-klass och bygga ut den efterhand. Det har diskuterats och debatterats mycket om utility-klassers vara eller icke vara, men jag kände här att detta var det bästa alternativet, trots det faktum att klassen löper risk att få dålig sammanhållning, med flera metoder som gör varsin sak.
 Arbetet med framförallt komplexitet har även hjälpt att producera bättre mätvärden: inga metoder med cyklomatisk komplexitet på över 5 och högsta WMC-värde på 29 (från föregående kursmoment). Jag har även lyckats förbättra underhållsindex för både ProjectController-klasserna och UserController-klasserna, även om en av dessa fortfarande lyser rött i PhpMetrics. I Scrutinizer får jag ett sammanlagt betyg på 9.98, ner från 10 under föregeånde kursmoment, men fortfarande, anser jag, ett gott betyg. I scrutinizer visas kodtäckning som endast 19%, men det bör noteras att detta inkluderar samtliga filer i src-katalogen, inklusive controller, entity och repository-klasser. Samtliga av de klasser som ska täckas enligt instruktion har 100 % kodtäckning och rapporten från PHP Unity visar detta. Jag valde att inte exkludera kataloger eller filer i src från scrutinizer-analysen då jag ville få en full bild av läget.

###ORM 
När det kommer till ORM och databashantering valde jag detta projekt då jag ville utforska arbete mot databaser i större utsträckning. För projektet har jag skapat 8 nya tabeller med tillhörande entity- och repositoryklasser, 4 stycket tabeller som motsvarar statistik om hållbar konsumtion, 1 tabell med demografi för Sverige, 1 tabell för artiklar, som samlar samtliga längre textstycken på projektsidan, inklusive denna text, en tabell för indikatorer med övergripande information om indikatorn samt en tabell för diagraminställningar. Därtill innehåller databasen tabellerna book och user från kmom05, varav jag har modifierat tabellen och entityn för user i enlighet med kraven för projektet. Av dessa tabeller har jag jag en många-till-en relation mellan chartdata, som innehåller diagraminställningar, och indikatortabellen, en en-till-en relation mellan chartdata och artikel, respektive indikator- och artikel tabellerna, samt en en-till-en relation mellan tabellen för statistik om materialåtgång och demografi. Detta upplägg med tre tabeller som är kopplade sinsemellan och med en fjärde grupp tabeller, känder jag var en logisk lösning, som lätt möjliggör dynamisk hämtning av data från ett enda värde. Enligt krav 06 skulle var det meningen att man skulle joina och/eller sätta upp relationer mellan tabeller, vilket jag här valt att göra helt via doctrine och ORM genom att för varje tabell skapa ställa in relevanta relationer (ManyToOne, OneToOne mm.). Dessa relationer använder jag sedan för att på sidorna för de enskilda indikatorerna lätt kunna komma åt motsvarande entity med hjälp av get-metoder, t.ex. <code>$Indicator->getCharDatas</code> eller <code>$chartdata->getArticle()</code>. Jag uttnyttjar även dessa metoder i en egendefinierad metod i Material Entity-klassen, där jag använder getters för att hämta värden från demografi och utifrån detta räkna fram nya värden att föra in i diagrammen. Jag funderade länge på hur jag skulle kunna använda join i en ny repository-metod för att undvika flera queries, som förklarat i Symfonys hjälpsidor, men jag bestämde mig för att inte arbeta på detta sätt då jag behöver använda generiska metoder pga av sidans dynamiska struktur.

Nedan följer en lista på tabellerna i databasen som används för projektet:
- **article**: Har tre kolumner: id, titel och content. Innehåller artiklar/textstycken med tillhörande titlar.
- **chartdata**: Har fyra kolumner: id, article_id, indicator_id och type. Typ avser diagramtyp (eg. stapel), och de andra värdena avser relationer till respektive tabell. För artiklar: en ett-till-ett relation och till indikatorer en många-till-en relation.
- **indicator**: Har fem kolumner: id, article_id, route, header och multiple. Samlar övergripande information om indikatorer. Article_id avser en en-till en relation till en artikel, route avser indikatorsidans motsvarande route-parameter, header är titel och multiple avser huruvida data ska visas i ett eller flera diagram.
- **demographics**: Har fyra kolumner_ id, year, population och gdp. Visar svensk demografi per år och används av material-entity för att räkna fram värden för materialåtgång.
- **foodwaste**: Har fem kolumner: id, sektor, y2012, y2014 och y2015. Visar matsvinn per sektor och år.
- **material**: Har fyra kolumner: id, footprint, year och demographics_id och year. Visar materialåtgång per år. Footprint materialfotavtryck i ton och demographics_id är en motsvarar en-till-en relation till demografikolumnen.
- **pollution**: Har fyra kolumner: id, år, sweden och global. Visar globala och svenska utsläpp från svensk konsumtion per år.
- **recycling**: Har fem kolumner: id, år, recycling, other och dumping. Visar statistik per år för olika former av återvinning och bortskaffning.
- **user**: Har sex kolumner: id, acronym, password, email, type och img. Innehåller användardata. Typ avser admin- eller vanlig användare, img en url-sträng och password innehåller en password-hash."
WHERE id = 2;
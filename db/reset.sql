-- MariaDB dump 10.19  Distrib 10.6.5-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: juko21
-- ------------------------------------------------------
-- Server version	10.6.5-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `article`
--

DROP TABLE IF EXISTS `article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article`
--

LOCK TABLES `article` WRITE;
/*!40000 ALTER TABLE `article` DISABLE KEYS */;
INSERT INTO `article` VALUES (1,'Hållbar konsumtion och utveckling','Vår planet har försett oss med ett överflöd av naturresurser, men vi människor har inte nyttjat det på ett ansvarsfullt sätt och konsumerar nu långt bortom vad vår planet klarar av. Visste du exempelvis att 1/3 av den mat som produceras slängs? Att uppnå hållbar utveckling kräver att vi minskar vårt ekologiska fotavtryck genom att ändra hur vi producerar och konsumerar varor och resurser.\n\nHållbar konsumtion innebär inte bara miljöfördelar utan även sociala och ekonomiska fördelar såsom ökad konkurrenskraft, tillväxt på såväl den lokala som globala marknaden, ökad sysselsättning, förbättrad hälsa och minskad fattigdom. Omställning till en hållbar konsumtion och produktion av varor är en nödvändighet för att minska vår negativa påverkan på klimat, miljö och människors hälsa.'),(2,'Om projektet och kodkvalitet','När det kommer till kodkvalitet är detta något som jag har försökt ha i åtanke allteftersom jag kodat, även om det i spurter ofta blivit så att jag först fastställer funktionaliteten som jag är ute efter i kod, utan närmare eftertanke på stil och organisation, varefter jag gått igenom tester, både stiltester och linters så som phpcs, phpcbf, phpmd och phpstan, och därefter granskat min kodbas efter bästa förmåga med hjälp av mer omfattande analysverktyg så som phpmetrics och scrutinizer.\" På så sätt har jag gått igenom många rundor av att skriva ner rå kod, analysera och refaktorera. Testning har även kommit in i bilden, och jag har genom dessa lyckats luska ut problem så som problem med färger vid konfiguration av tabellerna som byggs upp med hjälp av chartjs och används på hemsidan.\n\nJag önskar först tala om stilfix och linters, dessa är verktyg som jag har väldigt god användning av och gärna kör igenom sinsemellan, då jag gärna har en tendens att få ner funktionalitet på papper utan närmaste eftertanke på kod och eventuella problem vad gäller villkorssatser, nullvärden, variabler, variabelnamn mm. På så sätt kan jag gå få ner jag behöver få ner i kod, och sedan justera allteftersom. Med hjälp av detta har jag lyckats få ner anmärkningar från dessa verktyg till 0 på min egenkomponerade kod. Det bör nämnas att jag ej fått 100% resultat från de linters vi använder oss av i kursen, utan har från phpmd fått anmärkningar på korta variabelnamn ($id) och variabel och parameter-namn som inte är i camelcase (t.ex. indicator_id) i de entity-klasserna och booleanArgumentFlag-varningar i repositoryklasserna. Jag har dessutom fått read-only-variable-property-varningar från phpstan\nför $id-egenskaperna i entityklasserna, en varning som jag stängt av genom kommentarer i filerna. Då dessa klasser är autogenererade och då klassegenskaperna i entity-klasserna gärna ska matcha kolumnnamn i databasen har jag valt att ignorera dessa filer.\n\nNär det kommer till enhetstestning har jag skapat enhetstester med 100% täckning för alla klasser förutom controller, entity och repository-klassen, som vi enligt instruktion kunde ignorera. Dessa tester har använts för att se att rätt typ av variabel returneras för ChartCreator-klassen och att rätt värden returneras där det har varit rimligt att testa detta, t.ex. arrayFlip-metoden ArrayUtils och för getDatasets och getOptions-metoderna från ChartCreator-klassen. Genom dessa tester har jag lyckats rota ut problem i koden, t.ex. felaktig syntax, eller felaktigt tilldelade värden, och de har på så sätt varit till stor hjälp.\n\nAtt arbeta med kodstil, linters och testning är ofta ett relatvt enkelt, om än ibland monotont arbete, då jag med dessa verktyg lätt kan gå igenom koden rad för rad för att hitta och korrigera problem. Mer komplicerat blir det att arbeta mot analyser från verktyg som phpmetrics och scrutinizer, även om scrutinizer kan peka ut specifika problem i koden, får man här istället mer övergripande mätvärden för kodkvalitet som måste beaktas och hanteras på klass- och metodnivå, framförallt vad rör tre av de fyra c:na, complexity, cohesion och coupling. Dessa mätvärden rör snarare problematik rörande klass- och metodstruktur än specifik kodproblematik. Jag har använt mig huvudsakligen av phpmetrics under projektets gång, då detta ger ett snabbt och responsivt svar, medan scrutinizer har använts i ett senare skede för att bekräfta uppgifter från php-metrics och hitta mer specifika problem ner på metodnivå. Då det huvudsakliga arbetet för projektet har utförts i controller-klasser, med endast två mindre hjälpar-klasser, ChartCreator och ArrayUtils, har komplexitet och i viss utsträckning även metod- och klasstorlek varit de mätvärden som jag funnit vara av mest nytta. Genom att följa klasskomplexiteten i både PhpMetrics och Scrutinizer har jag kunnat identifiera problematiska områden i koden där jag behövde förenkla. Indicator-routen för enskilda indikatorer är ett utmärkt exempel på detta. Då jag istället för att hårdkoda sidor för varje indikator, valde att hämta information dynamiskt från databasen baserat på routeparametern som skickades med, innebar detta en lång, ibland tillsynes osammanhängande, kodmassa med många villkorssatser och for-loopar. För att lösa detta gick jag igenom koden i flera iterationer och identifierade bitar av kod som kunde lyftas ut till separata klasser och metoder (t.ex. ChartCreator-klassen, vars funktionalitet jag ursprungligen hade i route-metoden, samt metoden arrayFlip som också kunde lyftas ut) samt villkorssatser och for-loopar som kunde elimineras. Detta arbete hjälpte till med att organisera koden och göra den mindre komplex, vilket tillsammans med kommentarer gjorde det hela något mer överskådligt. Resultatet kunde synas tydligt i mätvärden med mindre komplexitet och bättre underhållningsindex. Det sagt är metoden av sin natur, där mycket av koden inte kan lyftas ut och mycket data från olika tre entities måste hantera, fortfarande relativt komplex och något problematiskt. Vad gäller ren kodmassa och visuell komplexitet lyckades jag minska detta något med hjälp av Doctrines relationsmappning, där tabeller för indikatorer och diagram-data kopplades ihop med en många-till-en relation. På samma sätta gick jag igenom UserController-klassen, en relativt problematisk klass, för att försöka eliminera onödiga loopar och villkorssatser. Här var det dock desto svårare, då många av metoderna hanterar flera olika variabler relaterade till användare som måste kontrolleras efter förfrågan från POST. Den sista åtgärden jag arbetat med i mån av komplexitet var att dela upp controllerklasserna pga av deras omfattning. Detta är något jag ogärna göra då jag vill samla relaterade route-metoder, men jag bestämde mig att dela upp klasserna ProjectController och UserController en klass för reset-routes och en för resterande projektklasser (hem, indikatorer, omsida), respektive en route för GET-routes och en för POST-routes för UserController-klassen.\n\nNär det kommer till de två resterande kodkvalitetsindikatorerna har de varit svårare att arbeta med. Tre av controllerklasserna, CardGameController, LibraryController och LibraryController och tillsammans med samtliga autogenererade repository-klasserna har fått ett inte helt optimalt LCOM-värde på 2. När det kommer till controllerklasserna får man anta att detta beror på att dessa fungerar som samlingsklasser och de olika route-metoderna använder olika resurser efter behov, liksom jag nämnde och diskuterade under föregeånde kursmoment. Därtill verkar jag ha fått en falsk-positiv för deck-klassen, som, i sin funktion att hantera en array av kort, i min mening borde ha fått ett värde på 1. Även detta diskuterade jag under kursmoment 6. Sist men inte minst har även coupling-värdet varit något problematiskt för controllerklasserna på grund av de många beroendena på externa klasser. Här har tre klasser, CardController, LibraryController och ResetController 6 efferenta koppling, CardGameController och UserPostController 7 efferenta kopplingar och ProjectController 8. Det höga värdet för ProjectController har att göra med de många entity-klasserna som måste importeras. Detta höga antal efferenta kopplingar leder i analysen också till hög instabilitet då dessa klasser ej har några afferenta koppling. Liksom för cohesion, sammanhållning, såg jag inga goda möjligheter för förbättringar i kodkvalitet. \n\nUtöver arbete med kodstil och linters samt arbete i samband med övergripande analys har jag även arbetat med att kommentera kod och gruppera i logiska kodblock i metoderna för förbättrad läsbarhet. Detta har möjligtvis inte så stor effekt på mätvärden, med undantag för kommentarer, men det är väldigt viktigt för att förbättra läsbarhet och underlätta underhåll.\n\nNär det kommer till kodkvalitet tror jag att jag genom mitt arbete har förbättrat koden på flera punkter, först och främst läsbarhet och överskådlighet, vilket i sin tur underlättar underhåll. Genom att arbeta med komplexitet har jag lyckats förenkla vissa metoder, i synnerhet i controllers, och även lyckats bryta ut en del kod i vad jag anser vara en logisk enhet. En notis om utbrytning av kod, ArrayUtils-klassen innehåller endast en metod, vilket kan ses som onödigt, men tanken med denna klass var att kunna använda den som utility-klass och bygga ut den efterhand. Arbetet med framförallt komplexitet har även hjälpt att producera bättre mätvärden: inga metoder med cyklomatisk komplexitet på över 5 och högsta WMC-värde på 29 (från föregående kursmoment). Jag har även lyckats förbättra underhållsindex för både ProjectController-klasserna och UserController-klasserna, även om en av dessa fortfarande lyser rött i PhpMetrics. I Scrutinizer får jag ett sammanlagt betyg på 9.98, ner från 10 under föregeånde kursmoment, men fortfarande, anser jag, ett gott betyg. I scrutinizer visas kodtäckning som endast 19%, men det bör noteras att detta inkluderar samtliga filer i src-katalogen, inklusive controller, entity och repository-klasser. Samtliga av de klasser som ska täckas enligt instruktion har 100 % kodtäckning och rapporten från PHP Unity visar detta. Jag valde att inte exkludera kataloger eller filer i src från scrutinizer-analysen då jag ville få en full bild av läget.\n\n###ORM \nNär det kommer till ORM och databashantering valde jag detta projekt då jag ville utforska arbete mot databaser i större utsträckning. För projektet har jag skapat 8 nya tabeller med tillhörande entity- och repositoryklasser, 4 stycket tabeller som motsvarar statistik om hållbar konsumtion, 1 tabell med demografi för Sverige, 1 tabell för artiklar, som samlar samtliga längre textstycken på projektsidan, inklusive denna text, en tabell för indikatorer med övergripande information om indikatorn samt en tabell för diagraminställningar. Därtill innehåller databasen tabellerna book och user från kmom05, varav jag har modifierat tabellen och entityn för user i enlighet med kraven för projektet. Av dessa tabeller har jag jag en många-till-en relation mellan chartdata, som innehåller diagraminställningar, och indikatortabellen, en en-till-en relation mellan chartdata och artikel, respektive indikator- och artikel tabellerna, samt en en-till-en relation mellan tabellen för statistik om materialåtgång och demografi.'),(3,'Hur påverkar vår konsumtion omställningen?','När det talas om grön omställning och åtgärder för att motverka klimatförändring ligger fokus ofta på vad som händer i närområdet, i det egna landet. Sverige har länge varit i framkant med att minska sitt klimatavtryck, men vissar detta verkligen hela bilden? Nedan kan ni se vad effekten av denna omställning vad avser konsumtion. Även om vi har lyckats få ner växthusutsläpp från egna utsläpp inom landets gränser är det enda som har hänt att dessa utsläpp har flyttat utomlands. På 8 år mellan har det totala utsläppet härledd från konsumtion i Sverige legat i stort sett stilla.'),(4,'Ät upp din mat!','Många är vi som under barndomen fick röda öron från allt gnäll om att äta upp maten på tallriken, men kanske var inte våra föräldrar helt fel ute. Matsvinn är ett stort problem i den industrialiserade värlen, och vi slänger varje år tillräckligt mycket mat för att klara oss ytterligare ett år på det.\n\nDetta är inte bara ett problem rent ekonomiskt men har en stor påverkan på klimatet, allt från produktionskedjor till logistik, all mat måste trots allt skeppas någonstans ifrån, till problem som uppstår vid återvinning eller deposition. Mycket av den mat vi slänger kan förvisso återvinnas, men det som inte återvinns deponeras på soptippen, där den mycket potenta växthusgasen skapas, eller bränns, vilket producerar koldioxid.'),(5,'Ingenting försvinner allt finns kvar!','För de som kommer ihåg sommarlovsprogrammet Tippen har dessa ord säkert etsat sig fast i bakhuvudet. När vi tagit ut soporna och återvinningen försvinner det vi kastas bort från vår syn, men det betyder inte att de gått upp i rök. Vi har kommit en lång väg sen dagarna då allting slängdes på tippen eller skickades till förbränning utan återtanke, men det finns fortfarande en lång väg att gå, mellan 2010 och 2016 har mängden som går inte återvinns ökat något.\n\nStatistiken nedan baseras på den nationella avfallsstatistiken och visar endast slutbehandling, dvs sortering och förbehandling framgår ej. Det bör noteras att muddermassor och gruvavfall ej ingår i statistiken pga av sin stora andel, 77% av allt avfall 2016. Detta gjort det svårt att synliggöra hanteringen av annat avfall, det vi ser och kommer nära varje dag.'),(6,'Att ta och ge','Det finns många dimensioner när det kommer till hur vi genom vår konsumtion påverkar miljön och klimatet. Vi tar från vår miljö genom materialutvinning och ger tillbaka genom föroreningar och nedskräpning. Vi fokuserar ofta på utsläpp och återvinning, men ett minst lika viktigt mätvärde är materialåtgång. Varje år förbrukar vi genom vår konsumtion hundratals miljoner ton material, vare sig det är metaller och tungmetaller, trä eller kolbaserade material.\n\nDenna materialåtgång kallar vi vårt materialfotavtryck. Mellan 2000 och 2017 har vi sett en oroväckande utveckling med en ökning av vårt materialfotavtryck på 66%, från cirka 192 miljoner ton 2000 till närmare 320 miljoner ton 2017. Detta har många långtgående konsekvenser. Inte bara utarmar vi våra naturresurser, men materialutvinning är ofta en industriell och ur miljöaspekt mycket skadlig procedur som skadar vår naturmiljö genom utsläpp av växthusgaser och skadliga ämnen som tungmetaller, och inte minst genom att allt materiall som utvunnits vid någon punkt kommer att behöva återvinnas eller i värsta fall bortskaffas, vilket vidare kan orsaka stora skador t.ex. genom nedskräpning av värlshaven.'),(7,'Utsläpp i Sverige','När det kommer till utsläpp från svensk konsumtion i Sverige kan man se en liten men tydlig nedgång från 2008 till 2016.'),(8,'Utsläpp globalt','De globala utsläppen härledda från svensk konsumtion har ökat nästan lika mycket som svenska utsläpp har minskat'),(9,'Totala utsläpp','De globala utsläppen härledda från svensk konsumtion har ökat nästan lika mycket som svenska utsläpp har minskat, Som kan ses här har de totala utsläppen inte minskat, utan har i stort sett legat stilla mellan 2008 och 2016, med en uppgång i mellanåren'),(10,'Matsvinn per person 2012','Under 2012 såg vi betydligt högre nivåer av matsvinn inom livsmedelsindustrin och i butiker. * Matavfallsstatistiken för 2012 omfattar varken matavfall som hälls ut via avloppet i hushållen eller matavfall från primärproduktion, det vill säga jordbruk och fiske'),(11,'Matsvinn per person 2014','Under 2014 ser vi en markant ökning i matsvinn från hushåll, men kraftig minskning i matsvinn från livsmedelsindustrin och livsmedelsbutiker, vilket bör ses som ett gott betyg.'),(12,'Matsvinn per person 2016','Under 2016 ser vi en viss minskning av matsvinn inom livsmedelsindustrin och i hushåll. * Ingen uppdatering har gjorts av mängderna för primärinustrin för 2016.'),(13,'Materialåtervinning (inkl. rötning och kompostering)','Detta diagram visar konventionell materialåtervinning, inklusive rötning, kompostering och annan återvinning så som metaller från stoft och askor. Under de senaste 6 åren har denna form av återvinning, i stick och stäv med vad som är önskvärt faktiskt gått ner.'),(14,'Annan återvinning','Med annan återvinning menas avfall som används som funktionsmaterial och/eller konstruktionsmaterial på eller utanför deponi, samt energiåtervinning. Likt konventionell materialåtervinning har denna form av återvinning inte ökat och istället minskat med 1 procentenhet sedan 2010.'),(15,'Bortskaffning','Med bortskaffning menas deponering, förbränning utan energiåtervinning, infiltration, utsläpp i vatten samt behandling i markbädd. I kontrast med återvinning har bortskaffning av sopor ökat med 2 procentenheter mellan 2010 och 2016.'),(16,'Materialfotavtryck i ton','Vårt totala materialfotavtryck i Sverige har mellan 2000 och 2017 sett en markant ökning från ca. 192 miljoner ton till närmare 320 miljoner ton, en oroväckande ökning på 66%.'),(17,'Materialfotavtryck i ton per person','Sett till vår befolkning ser vi en något mindre, men fortfarande markant ökning från 22 ton per person till 32 ton per person, en ökning på nästan 46%. Det innebär en daglig materialåtgång per person på nästan 88 kg.'),(18,'Materialfotavtryck i ton mkr BNP','Sett till vår BNP, räknat per miljoner kronor ser vi en mindre ökning, från 63 ton per mkr 2000 till 73 ton per mkr 2016. Även om detta är en mindre relativ ökning jämförd me andra mätvärdet, är det fortfarande högst problematiskt, och ekonomisk tillväxt bör och får inte bli en ursäkt för ökad materialåtgång\n*Notera att BNP inte är tillgängligt för 2017.');
/*!40000 ALTER TABLE `article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `book`
--

DROP TABLE IF EXISTS `book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isbn` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book`
--

LOCK TABLES `book` WRITE;
/*!40000 ALTER TABLE `book` DISABLE KEYS */;
INSERT INTO `book` VALUES (2,'80 dagar runt jorden','9781421806426','Jules Verne','jordenrunt.jpg'),(3,'Djungelboken','9780763623173','Rudyard Kipling','djungelboken.jpg'),(5,'Dracula','9780393064506','Bram Stoker','dracula.jpg'),(6,'Alice i underlandet','9780399222412','Lewis Carroll','alice.jpg');
/*!40000 ALTER TABLE `book` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chartdata`
--

DROP TABLE IF EXISTS `chartdata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chartdata` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `indicator_id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_6B27932A7294869C` (`article_id`),
  KEY `IDX_6B27932A4402854A` (`indicator_id`),
  CONSTRAINT `FK_6B27932A4402854A` FOREIGN KEY (`indicator_id`) REFERENCES `indicator` (`id`),
  CONSTRAINT `FK_6B27932A7294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chartdata`
--

LOCK TABLES `chartdata` WRITE;
/*!40000 ALTER TABLE `chartdata` DISABLE KEYS */;
INSERT INTO `chartdata` VALUES (1,7,1,'line'),(2,8,1,'line'),(3,9,1,'line'),(4,10,2,'bar'),(5,11,2,'bar'),(6,12,2,'bar'),(7,13,3,'line'),(8,14,3,'line'),(9,15,3,'line'),(10,16,4,'line'),(11,17,4,'line'),(12,18,4,'line');
/*!40000 ALTER TABLE `chartdata` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `demographics`
--

DROP TABLE IF EXISTS `demographics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `demographics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` int(11) NOT NULL,
  `population` int(11) NOT NULL,
  `gdp` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `demographics`
--

LOCK TABLES `demographics` WRITE;
/*!40000 ALTER TABLE `demographics` DISABLE KEYS */;
INSERT INTO `demographics` VALUES (1,2000,8882792,3071793),(2,2001,8909128,3120126),(3,2002,8940788,3184877),(4,2003,8975670,3260034),(5,2004,9011392,3400566),(6,2005,9047752,3496349),(7,2006,9113257,3660662),(8,2007,9182927,3785421),(9,2008,9256347,3764334),(10,2009,9340682,3568744),(11,2010,9415570,3782582),(12,2011,9482855,3883926),(13,2012,9555893,3872331),(14,2013,9644864,3920284),(15,2014,9747355,4022286),(16,2015,9851017,4201543),(17,2016,9995153,4314311),(18,2017,10120242,0);
/*!40000 ALTER TABLE `demographics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20220526163916','2022-05-26 18:39:21',376);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `foodwaste`
--

DROP TABLE IF EXISTS `foodwaste`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `foodwaste` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sector` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `y2012` int(11) NOT NULL,
  `y2014` int(11) NOT NULL,
  `y2016` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `foodwaste`
--

LOCK TABLES `foodwaste` WRITE;
/*!40000 ALTER TABLE `foodwaste` DISABLE KEYS */;
INSERT INTO `foodwaste` VALUES (1,'Hushåll',81,100,97),(2,'Primärproduktion',0,10,10),(3,'Storkök',7,7,7),(4,'Restauranger',8,7,7),(5,'Livsmedelsindustri',18,8,5),(6,'Livsmedelsbutiker',5,3,3),(7,'Totalt',118,134,129);
/*!40000 ALTER TABLE `foodwaste` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `indicator`
--

DROP TABLE IF EXISTS `indicator`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `indicator` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `route` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `header` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `multiple` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_D1349DB37294869C` (`article_id`),
  CONSTRAINT `FK_D1349DB37294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `indicator`
--

LOCK TABLES `indicator` WRITE;
/*!40000 ALTER TABLE `indicator` DISABLE KEYS */;
INSERT INTO `indicator` VALUES (1,3,'utslapp','Konsumtionsbaserade utsläpp',1),(2,4,'matsvinn','Matsvinn i Sverige',1),(3,5,'atervinning','Återvinning och bortskaffning',1),(4,6,'materialfotavtryck','Materialfotavtryck',0);
/*!40000 ALTER TABLE `indicator` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `material`
--

DROP TABLE IF EXISTS `material`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `material` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `demographics_id` int(11) NOT NULL,
  `footprint` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_7CBE7595C1571BCE` (`demographics_id`),
  CONSTRAINT `FK_7CBE7595C1571BCE` FOREIGN KEY (`demographics_id`) REFERENCES `demographics` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `material`
--

LOCK TABLES `material` WRITE;
/*!40000 ALTER TABLE `material` DISABLE KEYS */;
INSERT INTO `material` VALUES (1,1,192463100,2000),(2,2,218915230,2001),(3,3,228353740,2002),(4,4,256329650,2003),(5,5,272641130,2004),(6,6,250903660,2005),(7,7,295546910,2006),(8,8,307006020,2007),(9,9,285778610,2008),(10,10,222097570,2009),(11,11,281746700,2010),(12,12,296310410,2011),(13,13,298560560,2012),(14,14,302172490,2013),(15,15,306832530,2014),(16,16,310799600,2015),(17,17,315130450,2016),(18,18,319513070,2017);
/*!40000 ALTER TABLE `material` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messenger_messages`
--

LOCK TABLES `messenger_messages` WRITE;
/*!40000 ALTER TABLE `messenger_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messenger_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pollution`
--

DROP TABLE IF EXISTS `pollution`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pollution` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` int(11) NOT NULL,
  `sweden` double NOT NULL,
  `global` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pollution`
--

LOCK TABLES `pollution` WRITE;
/*!40000 ALTER TABLE `pollution` DISABLE KEYS */;
INSERT INTO `pollution` VALUES (1,2008,41,62),(2,2009,40,48),(3,2010,43,60),(4,2011,40,64),(5,2012,38,68),(6,2013,37,69),(7,2014,36,63),(8,2015,36,62),(9,2016,36,65);
/*!40000 ALTER TABLE `pollution` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recycling`
--

DROP TABLE IF EXISTS `recycling`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recycling` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` int(11) NOT NULL,
  `recycling` int(11) NOT NULL,
  `other` int(11) NOT NULL,
  `dumping` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recycling`
--

LOCK TABLES `recycling` WRITE;
/*!40000 ALTER TABLE `recycling` DISABLE KEYS */;
INSERT INTO `recycling` VALUES (1,2010,27,56,17),(2,2012,26,59,15),(3,2014,24,60,16),(4,2016,26,55,19);
/*!40000 ALTER TABLE `recycling` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `acronym` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (3,'$2y$10$2i5AG194XDGqJ/z32Bb3KOwsY.oO2kkcg/WZusvC2s3nMMYmWMUqW','admin@admin.com','admin','admin','https://www.gravatar.com/avatar/64e1b8d34f425d19e1ee2ea7236d3028?d=mp&s=80'),(10,'$2y$10$4XixhsXLlECNwZRMw58k/.KfwTHyTi7lQ4LWi1FAV8/wHmsleDOka','doe@example.com','regular','doe','https://www.gravatar.com/avatar/de21b8c123847c80205e93b301437b45?d=mp&s=80');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-05-26 17:49:19

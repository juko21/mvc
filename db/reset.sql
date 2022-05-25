-- MariaDB dump 10.19  Distrib 10.6.5-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: mvcproject
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
INSERT INTO `article` VALUES (1,'Hållbar konsumtion och utveckling','Vår planet har försett oss med ett överflöd av naturresurser, men vi människor har inte nyttjat det på ett ansvarsfullt sätt och konsumerar nu långt bortom vad vår planet klarar av. Visste du exempelvis att 1/3 av den mat som produceras slängs? Att uppnå hållbar utveckling kräver att vi minskar vårt ekologiska fotavtryck genom att ändra hur vi producerar och konsumerar varor och resurser.\n\nHållbar konsumtion innebär inte bara miljöfördelar utan även sociala och ekonomiska fördelar såsom ökad konkurrenskraft, tillväxt på såväl den lokala som globala marknaden, ökad sysselsättning, förbättrad hälsa och minskad fattigdom. Omställning till en hållbar konsumtion och produktion av varor är en nödvändighet för att minska vår negativa påverkan på klimat, miljö och människors hälsa.'),(2,'Om projektet',' \"Denna sida är en del av slutprojektet i kursen MVC vid Blekinge Tekniska högskola\"'),(3,'Hur påverkar vår konsumtion omställningen?','När det talas om grön omställning och åtgärder för att motverka klimatförändring ligger fokus ofta på vad som händer i närområdet, i det egna landet. Sverige har länge varit i framkant med att minska sitt klimatavtryck, men vissar detta verkligen hela bilden? Nedan kan ni se vad effekten av denna omställning vad avser konsumtion. Även om vi har lyckats få ner växthusutsläpp från egna utsläpp inom landets gränser är det enda som har hänt att dessa utsläpp har flyttat utomlands. På 8 år mellan har det totala utsläppet härledd från konsumtion i Sverige legat i stort sett stilla.'),(4,'Ät upp din mat!','Många är vi som under barndomen fick röda öron från allt gnäll om att äta upp maten på tallriken, men kanske var inte våra föräldrar helt fel ute. Matsvinn är ett stort problem i den industrialiserade värlen, och vi slänger varje år tillräckligt mycket mat för att klara oss ytterligare ett år på det.\n\nDetta är inte bara ett problem rent ekonomiskt men har en stor påverkan på klimatet, allt från produktionskedjor till logistik, all mat måste trots allt skeppas någonstans ifrån, till problem som uppstår vid återvinning eller deposition. Mycket av den mat vi slänger kan förvisso återvinnas, men det som inte återvinns deponeras på soptippen, där den mycket potenta växthusgasen skapas, eller bränns, vilket producerar koldioxid.'),(5,'Ingenting försvinner allt finns kvar!','För de som kommer ihåg sommarlovsprogrammet Tippen har dessa ord säkert etsat sig fast i bakhuvudet. När vi tagit ut soporna och återvinningen försvinner det vi kastas bort från vår syn, men det betyder inte att de gått upp i rök. Vi har kommit en lång väg sen dagarna då allting slängdes på tippen eller skickades till förbränning utan återtanke, men det finns fortfarande en lång väg att gå, mellan 2010 och 2016 har mängden som går inte återvinns ökat något.\n\nStatistiken nedan baseras på den nationella avfallsstatistiken och visar endast slutbehandling, dvs sortering och förbehandling framgår ej. Det bör noteras att muddermassor och gruvavfall ej ingår i statistiken pga av sin stora andel, 77% av allt avfall 2016. Detta gjort det svårt att synliggöra hanteringen av annat avfall, det vi ser och kommer nära varje dag.'),(6,'Att ta och ge','Det finns många dimensioner när det kommer till hur vi genom vår konsumtion påverkar miljön och klimatet. Vi tar från vår miljö genom materialutvinning och ger tillbaka genom föroreningar och nedskräpning. Vi fokuserar ofta på utsläpp och återvinning, men ett minst lika viktigt mätvärde är materialåtgång. Varje år förbrukar vi genom vår konsumtion hundratals miljoner ton material, vare sig det är metaller och tungmetaller, trä eller kolbaserade material.\n\nDenna materialåtgång kallar vi vårt materialfotavtryck. Mellan 2000 och 2017 har vi sett en oroväckande utveckling med en ökning av vårt materialfotavtryck på 66%, från cirka 192 miljoner ton 2000 till närmare 320 miljoner ton 2017. Detta har många långtgående konsekvenser. Inte bara utarmar vi våra naturresurser, men materialutvinning är ofta en industriell och ur miljöaspekt mycket skadlig procedur som skadar vår naturmiljö genom utsläpp av växthusgaser och skadliga ämnen som tungmetaller, och inte minst genom att allt materiall som utvunnits vid någon punkt kommer att behöva återvinnas eller i värsta fall bortskaffas, vilket vidare kan orsaka stora skador t.ex. genom nedskräpning av värlshaven.'),(7,'Utsläpp i Sverige','När det kommer till utsläpp från svensk konsumtion i Sverige kan man se en liten men tydlig nedgång från 2008 till 2016.'),(8,'Utsläpp globalt','De globala utsläppen härledda från svensk konsumtion har ökat nästan lika mycket som svenska utsläpp har minskat'),(9,'Totala utsläpp','De globala utsläppen härledda från svensk konsumtion har ökat nästan lika mycket som svenska utsläpp har minskat, Som kan ses här har de totala utsläppen inte minskat, utan har i stort sett legat stilla mellan 2008 och 2016, med en uppgång i mellanåren'),(10,'Matsvinn per person 2012','Under 2012 såg vi betydligt högre nivåer av matsvinn inom livsmedelsindustrin och i butiker. * Matavfallsstatistiken för 2012 omfattar varken matavfall som hälls ut via avloppet i hushållen eller matavfall från primärproduktion, det vill säga jordbruk och fiske'),(11,'Matsvinn per person 2014','Under 2014 ser vi en markant ökning i matsvinn från hushåll, men kraftig minskning i matsvinn från livsmedelsindustrin och livsmedelsbutiker, vilket bör ses som ett gott betyg.'),(12,'Matsvinn per person 2016','Under 2016 ser vi en viss minskning av matsvinn inom livsmedelsindustrin och i hushåll. * Ingen uppdatering har gjorts av mängderna för primärinustrin för 2016.'),(13,'Materialåtervinning (inkl. rötning och kompostering)','Detta diagram visar konventionell materialåtervinning, inklusive rötning, kompostering och annan återvinning så som metaller från stoft och askor. Under de senaste 6 åren har denna form av återvinning, i stick och stäv med vad som är önskvärt faktiskt gått ner.'),(14,'Annan återvinning','Med annan återvinning menas avfall som används som funktionsmaterial och/eller konstruktionsmaterial på eller utanför deponi, samt energiåtervinning. Likt konventionell materialåtervinning har denna form av återvinning inte ökat och istället minskat med 1 procentenhet sedan 2010.'),(15,'Bortskaffning','Med bortskaffning menas deponering, förbränning utan energiåtervinning, infiltration, utsläpp i vatten samt behandling i markbädd. I kontrast med återvinning har bortskaffning av sopor ökat med 2 procentenheter mellan 2010 och 2016.'),(16,'Materialfotavtryck i ton','Vårt totala materialfotavtryck i Sverige har mellan 2000 och 2017 sett en markant ökning från ca. 192 miljoner ton till närmare 320 miljoner ton, en oroväckande ökning på 66%.'),(17,'Materialfotavtryck i ton per person','Sett till vår befolkning ser vi en något mindre, men fortfarande markant ökning från 22 ton per person till 32 ton per person, en ökning på nästan 46%. Det innebär en daglig materialåtgång per person på nästan 88 kg.'),(18,'Materialfotavtryck i ton mkr BNP','Sett till vår BNP, räknat per miljoner kronor ser vi en mindre ökning, från 63 ton per mkr 2000 till 73 ton per mkr 2016. Även om detta är en mindre relativ ökning jämförd me andra mätvärdet, är det fortfarande högst problematiskt, och ekonomisk tillväxt bör och får inte bli en ursäkt för ökad materialåtgång\n*Notera att BNP inte är tillgängligt för 2017.');
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
  PRIMARY KEY (`id`)
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
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20220516181328','2022-05-16 20:13:34',78),('DoctrineMigrations\\Version20220517080841','2022-05-17 10:08:50',78),('DoctrineMigrations\\Version20220525164200','2022-05-25 18:42:06',255);
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
  `route` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `article_id` int(11) NOT NULL,
  `header` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `multiple` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `indicator`
--

LOCK TABLES `indicator` WRITE;
/*!40000 ALTER TABLE `indicator` DISABLE KEYS */;
INSERT INTO `indicator` VALUES (1,'utslapp',3,'Konsumtionsbaserade utsläpp',1),(2,'matsvinn',4,'Matsvinn i Sverige',1),(3,'atervinning',5,'Återvinning och bortskaffning',1),(4,'materialfotavtryck',6,'Materialfotavtryck',0);
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
  `year` int(11) NOT NULL,
  `footprint` int(11) NOT NULL,
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
INSERT INTO `material` VALUES (1,1,2000,192463100),(2,2,2001,218915230),(3,3,2002,228353740),(4,4,2003,256329650),(5,5,2004,272641130),(6,6,2005,250903660),(7,7,2006,295546910),(8,8,2007,307006020),(9,9,2008,285778610),(10,10,2009,222097570),(11,11,2010,281746700),(12,12,2011,296310410),(13,13,2012,298560560),(14,14,2013,302172490),(15,15,2014,306832530),(16,16,2015,310799600),(17,17,2016,315130450),(18,18,2017,319513070);
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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

-- Dump completed on 2022-05-25 23:51:46

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use ParsedownExtra;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Article;
use App\Entity\Demographics;
use App\Entity\Pollution;
use App\Entity\Foodwaste;
use App\Entity\Recycling;
use App\Entity\Indicator;
use App\Entity\Chartdata;
use App\Charts\Charts;


class ProjectController extends AbstractController
{
    /**
     * @Route("/proj/", name="proj-home")
     */
    public function index(
        SessionInterface $session,
        ManagerRegistry $doctrine,
        ChartBuilderInterface $chartBuilder
        ): Response {
        $parseDown = new ParsedownExtra();
        $entityManager = $doctrine->getManager();

        $content = $entityManager->getRepository(Article::class)->find(1);
        $contentTitle = $content->getTitle();
        $content = $parseDown->text($content->getContent());

        $data = [
            "title" => "HÅLLBAR KONSUMTIONOCH PRODUKTION",
            "header" => "HÅLLBAR KONSUMTION<br>OCH PRODUKTION",
            "subHeader" => "",
            "contentTitle" => $contentTitle,
            "content" => $content
        ];
        return $this->render('proj/index.html.twig', $data);
    }

    /**
     * @Route("/proj/about/", name="proj-about")
     */
    public function about(SessionInterface $session): Response
    {
        return $this->render('proj/index.html.twig');
    }

    /**
     * @Route("/proj/indikatorer/", name="proj-indicators")
     */
    public function indicators(
        SessionInterface $session,
        ManagerRegistry $doctrine,
        string $indicator,
        ChartBuilderInterface $chartBuilder
    ): Response
    {

        return $this->render('proj/index.html.twig');
    }

    /**
     * @Route("/proj/indikatorer/{indicator}", name="proj-indicator-select")
     */
    public function indicatorSelect(
        SessionInterface $session,
        ManagerRegistry $doctrine,
        string $indicator,
        ChartBuilderInterface $chartBuilder
    ): Response
    {
        $entityTypes = ["utslapp" => "Pollution", "matsvinn" => "Foodwaste", "atervinning" => "Recycling"];
        $entityManager = $doctrine->getManager();

        // Fetch chart data from Repository, make accessible dynamically (without knowing 
        // column names and method names in entity) and flip 2d array so that each column gets an array
        $parseDown = new ParsedownExtra();
        $statData = [];
        $dbStatData = $entityManager->getRepository('App\Entity\\' .$entityTypes[$indicator])->findAll();
        $dbStatData = array_map(function($item) { return $item->getAll(); }, $dbStatData);

        for($i = 0; $i < count($dbStatData[0]); $i++) {
            foreach ($dbStatData as $key => $value) {
                $statData[$i][] = $value[$i];
            }
        }

        $indicatorData = $entityManager->getRepository(Indicator::class)->findOneBy(["route" => $indicator]);
        $chartData = $entityManager->getRepository(Chartdata::class)->findBy(["indicator_id" => $indicatorData->getId()]);
        $articleRep = $entityManager->getRepository(Article::class);

        foreach ($chartData as $key => $chart) {
            $chartHeaders[] = $articleRep->find($chart->getArticleId())->getTitle();
            $chartTexts[] = $articleRep->find($chart->getArticleId())->getContent();
        }
        for ( $i = 0; $i < count($statData) - 1; $i++) {
            $charts[] = $chartBuilder->createChart($chartData[0]->getType());
            $chartSets = Charts::getBarChartSettings($statData[0], [$statData[$i + 1]], [$chartHeaders[$i]]);
            $charts[$i]->setData($chartSets[0]);
            $charts[$i]->setOptions($chartSets[1]);
        }
        $data = [
            "title" => "Indikatorer: " . $indicatorData->getHeader(),
            "header" => "INDIKATORER",
            "subHeader" => $indicatorData->getHeader(),
            "contentTitle" => $articleRep->find($indicatorData->getArticleId())->getTitle(),
            "content" => $parseDown->text($articleRep->find($indicatorData->getArticleId())->getContent()),
            "charts" => $charts,
            "chartHeaders" => $chartHeaders,
            "chartTexts" => $chartTexts
        ];
        return $this->render('proj/indicator.html.twig', $data);
    }

    /**
     * @Route("/proj/indikatorer2/{indicator}", name="proj-indicator2-select")
     */
    public function indicatorSelect2(
        SessionInterface $session,
        ManagerRegistry $doctrine,
        string $indicator,
        ChartBuilderInterface $chartBuilder
    ): Response
    {
        $entityTypes = ["utslapp" => "Pollution", "matsvinn" => "Foodwaste", "atervinning" => "Recycling"];
        $entityManager = $doctrine->getManager();

        // Fetch chart data from Repository, make accessible dynamically (without knowing 
        // column names and method names in entity) and flip 2d array so that each column gets an array
        $parseDown = new ParsedownExtra();
        $statData = [];
        $dbStatData = $entityManager->getRepository('App\Entity\\' .$entityTypes[$indicator])->findAll();
        $dbStatData = array_map(function($item) { return $item->getAll(); }, $dbStatData);

        for($i = 0; $i < count($dbStatData[0]); $i++) {
            foreach ($dbStatData as $key => $value) {
                $statData[$i][] = $value[$i];
            }
        }

        $indicatorData = $entityManager->getRepository(Indicator::class)->findOneBy(["route" => $indicator]);
        $chartData = $entityManager->getRepository(Chartdata::class)->findBy(["indicator_id" => $indicatorData->getId()]);
        $articleRep = $entityManager->getRepository(Article::class);

        foreach ($chartData as $key => $chart) {
            $chartHeaders[] = $articleRep->find($chart->getArticleId())->getTitle();
            $chartTexts[] = $articleRep->find($chart->getArticleId())->getContent();
        }
        
        $charts[] = $chartBuilder->createChart($chartData[0]->getType());
        $chartSets = Charts::getBarChartSettings($statData[0], array_slice($statData, 1), $chartHeaders, true);
        $charts[0]->setData($chartSets[0]);
        $charts[0]->setOptions($chartSets[1]);

        $data = [
            "title" => "Indikatorer: " . $indicatorData->getHeader(),
            "header" => "INDIKATORER",
            "subHeader" => $indicatorData->getHeader(),
            "contentTitle" => $articleRep->find($indicatorData->getArticleId())->getTitle(),
            "content" => $parseDown->text($articleRep->find($indicatorData->getArticleId())->getContent()),
            "charts" => $charts,
            "chartHeaders" => $chartHeaders,
            "chartTexts" => $chartTexts
        ];
        return $this->render('proj/indicator.html.twig', $data);
    }
}

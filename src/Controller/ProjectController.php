<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use ParsedownExtra;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Article;
use App\Entity\Pollution;
use App\Entity\Foodwaste;
use App\Entity\Recycling;
use App\Entity\Material;
use App\Entity\Indicator;
use App\Entity\Chartdata;
use App\ChartCreator\ChartCreator;
use App\Utils\ArrayUtils;

class ProjectController extends AbstractController
{
    /**
     * Route method for main landing page for project
     *
     * @param ManagerRegistry $doctrine
     * @param SessionInterface $session
     * @return response
     * @Route("/proj", name="proj-home")
     */
    public function index(
        ManagerRegistry $doctrine,
        SessionInterface $session
    ): Response {
        $loggedIn = $session->get("loggedIn");
        $parseDown = new ParsedownExtra();
        $entityManager = $doctrine->getManager();

        $content = $entityManager->getRepository(Article::class)->find(1);
        $indicatorData = $entityManager->getRepository(Indicator::class)->findAll();
        $contentTitle = $content->getTitle();
        $content = $parseDown->text($content->getContent());
        $indicators = array_map(function ($item) {
            return $item->getHeader();
        }, $indicatorData);
        $indicatorRoutes = array_map(function ($item) {
            return $item->getRoute();
        }, $indicatorData);

        $data = [
            "title" => "HÅLLBAR KONSUMTIONOCH PRODUKTION",
            "header" => "HÅLLBAR KONSUMTION<br>OCH PRODUKTION",
            "subHeader" => "",
            "contentTitle" => $contentTitle,
            "content" => $content,
            "indicatorsTitle" => "Indikatorer",
            "indicators" => $indicators,
            "indicatorRoutes" => $indicatorRoutes,
            'loggedIn' => $loggedIn
        ];
        return $this->render('proj/index.html.twig', $data);
    }

    /**
     * Route method for about page for project
     *
     * @param ManagerRegistry $doctrine
     * @param SessionInterface $session
     * @return response
     * @Route("/proj/about", name="proj-about")
     */
    public function about(
        ManagerRegistry $doctrine,
        SessionInterface $session
    ): Response {
        $loggedIn = $session->get("loggedIn");
        $parseDown = new ParsedownExtra();
        $entityManager = $doctrine->getManager();

        $content = $entityManager->getRepository(Article::class)->find(2);
        $contentTitle = $content->getTitle();
        $content = $parseDown->text($content->getContent());

        $data = [
            "title" => "KMOM10: Om slutprojektet",
            "header" => "KMOM10",
            "subHeader" => "Om slutprojektet",
            "contentTitle" => $contentTitle,
            "content" => $content,
            'loggedIn' => $loggedIn
        ];
        return $this->render('proj/about.html.twig', $data);
    }

    /**
     * Route method for clean-code article
     *
     * @param ManagerRegistry $doctrine
     * @param SessionInterface $session
     * @return response
     * @Route("/proj/cleancode", name="proj-cleancode")
     */
    public function cleanCode(
        ManagerRegistry $doctrine,
        SessionInterface $session
    ): Response {
        $loggedIn = $session->get("loggedIn");
        $parseDown = new ParsedownExtra();
        $entityManager = $doctrine->getManager();

        $content = $entityManager->getRepository(Article::class)->find(19);
        $contentTitle = $content->getTitle();
        $content = $parseDown->text($content->getContent());

        $data = [
            "title" => "KMOM10: Om slutprojektet",
            "header" => "KMOM10",
            "subHeader" => "Om ren kod",
            "contentTitle" => $contentTitle,
            "content" => $content,
            'loggedIn' => $loggedIn
        ];
        return $this->render('proj/cleancode.html.twig', $data);
    }

    /**
     * Route method for indicatorSelect. Used with route parameter
     * to send user to correct indicator page
     *
     * @param ManagerRegistry $doctrine
     * @param string $indicator Route parameter
     * @param SessionInterface $session
     * @return response
     * @Route("/proj/indikatorer/{indicator}", name="proj-indicator-select")
     */
    public function indicatorSelect(
        ManagerRegistry $doctrine,
        string $indicator,
        SessionInterface $session
    ): Response {
        $loggedIn = $session->get("loggedIn");
        $parseDown = new ParsedownExtra();
        $entityManager = $doctrine->getManager();

        $entityTypes = [
            "utslapp" => "Pollution", "matsvinn" => "Foodwaste",
            "atervinning" => "Recycling", "materialfotavtryck" => "Material"
        ];

        // Get indicator for route as well as all indicators for links
        $indicatorAll = $entityManager->getRepository(Indicator::class)->findAll();
        $indicatorData = $entityManager->getRepository(Indicator::class)->findOneBy(["route" => $indicator]);

        // fetch indicator headers and routes
        $indicatorHeaders = array_map(function ($item) {
            return $item->getHeader();
        }, $indicatorAll);
        $indicatorRoutes = array_map(function ($item) {
            return $item->getRoute();
        }, $indicatorAll);

        // Get articleRepository an main article
        $article = $indicatorData->getArticle();

        // Get chart data settings from db and whether charts are multi or single line
        $chartData = $indicatorData->getChartdatas();
        $multiple = $indicatorData->isMultiple();

        // Get all entities containing data for corresponding indicator
        $dataEntities = $entityManager->getRepository('App\Entity\\' . $entityTypes[$indicator])->findAll();

        // Fetch raw data from data entities
        $rawStatistics = array_map(function ($item) {
            return $item->getAll();
        }, $dataEntities);

        // Flip the arrays so that values from each db table column are put in its own array
        $arrayUtils = new ArrayUtils();
        $statistics = $arrayUtils->arrayFlip($rawStatistics);

        // Create new arrays for $dataX and $dataY
        $dataX = $statistics[0];
        $dataY = [];

        // Get chartheaders for datasets and corresponding texts, assign labels => data $dataY
        $chartHeaders = [];
        $chartTexts = [];
        foreach ($chartData as $key => $chart) {
            $chartHeaders[] = $chart->getArticle()->getTitle();
            $chartTexts[$key] = '<h3>' . $chartHeaders[$key] . '</h3>';
            $chartTexts[$key] .= '<p>' . $chart->getArticle()->getContent()  . '</p>';
            $dataY[$chartHeaders[$key]] = $statistics[$key + 1];
        }

        // Construct charts
        $charts = [];
        if ($multiple) {
            $chartTexts = [implode('', $chartTexts)]; // Implode all chart texts to 1-element array neater display
            $dataY = [$dataY];
        }

        $count = 0;
        foreach ($dataY as $value) {
            $chartCreator = new ChartCreator(
                $dataX,
                $multiple ? $value : [$value],
                true,
                $chartData[$count]->getType()
            );
            $charts[] = $chartCreator->createChart();
            $count++;
        }

        // Set data for twig template
        $data = [
            "header" => $indicatorData->getHeader(),
            "contentTitle" => $article->getTitle(),
            "content" => $parseDown->text($article->getContent()),
            "charts" => $charts,
            "chartTexts" => $chartTexts,
            "indicators" => $indicatorHeaders,
            "indicatorRoutes" => $indicatorRoutes,
            'loggedIn' => $loggedIn
        ];
        return $this->render('proj/indicator.html.twig', $data);
    }
}

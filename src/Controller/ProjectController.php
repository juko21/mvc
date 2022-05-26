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
use Doctrine\DBAL\Connection;

class ProjectController extends AbstractController
{
    /**
     * Route method for main landing page for project
     *
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
     * Route method for database reset page
     *
     * @Route("/proj/reset", name="proj-reset")
     */
    public function reset(SessionInterface $session): Response
    {
        $loggedIn = $session->get("loggedIn");
        $data = [
            'title' => 'Återställ databas',
            'header' => 'Kmom10 projekt',
            'subHeader' => 'Återställ databas',
            'loggedIn' => $loggedIn
        ];
        return $this->render('proj/reset.html.twig', $data);
    }

    /**
     * Route method for database reset page
     *
     * @Route("/proj/reset-processing", name="proj-reset-processing")
     */
    public function resetProcess(
        Request $request,
        Connection $connection
    ): Response {
        if ($request->request->get("reset") !== null) {
            $sql = file_get_contents($this->getParameter('kernel.project_dir') . '/db/reset.sql');
            //$entityManager = $doctrine->getManager();
            //$conn = $entityManager->getConnection();
            $stmt = $connection->prepare($sql);
            $stmt->executeQuery();

            $this->addFlash("notice", "Databas återställd");
            return $this->redirectToRoute('proj-reset');
        }
        $this->addFlash("notice", "Felaktig åtkomst av route");
        return $this->redirectToRoute('proj-reset');
    }

    /**
     * Route method for indicatorSelect. Used with parameter
     * to send user to correct indicator page
     *
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

        // Get articleRepository
        $articleRep = $entityManager->getRepository(Article::class);

        // Get all entities containing data for corresponding indicator
        $dataEntities = [];
        $dataEntities = $entityManager->getRepository('App\Entity\\' . $entityTypes[$indicator])->findAll();

        // Fetch raw data from data entities
        $rawStatistics = array_map(function ($item) {
            return $item->getAll();
        }, $dataEntities);

        // Flip the arrays so that values from each db table column are put in its own array
        $statistics = [];
        $count = count($rawStatistics[0]);
        for ($i = 0; $i < $count; $i++) {
            foreach ($rawStatistics as $key => $value) {
                $statistics[$i][] = $value[$i];
            }
        }

        // Get chart data settings from db
        $chartData = $indicatorData->getChartdatas();

        // Get bool multiple, signifies whether datasets are combined into chart or separate
        $multiple = $indicatorData->isMultiple();

        // Get chartheaders for datasets and corresponding texts
        $chartHeaders = [];
        $chartTexts = [];
        foreach ($chartData as $key => $chart) {
            $chartHeaders[] = $articleRep->find($chart->getArticleId())->getTitle();
            $chartTexts[$key] = '<h3>' . $chartHeaders[$key] . '</h3>';
            $chartTexts[$key] .= '<p>' . $articleRep->find($chart->getArticleId())->getContent()  . '</p>';
        }
    
        // Construct charts
        $charts = [];
        $count = count($statistics) - 1;

        if ($multiple) {
            $count = 1; // Set number of charts to 1 if multiple line chart is indicated
            $chartTexts = [implode('', $chartTexts)]; // Implode all chart texts to 1-element array neater display
        }
        for ($i = 0; $i < $count; $i++) {
            $chartCreator = new ChartCreator(
                $statistics[0],
                $multiple ? array_slice($statistics, 1) : [$statistics[$i + 1]],
                $multiple ? $chartHeaders : [$chartHeaders[$i]],
                true,
                true,
                $chartData[0]->getType()
            );
            $charts[] = $chartCreator->createChart();
        }

        // Set data for twig template
        $data = [
            "title" => "Indikatorer: " . $indicatorData->getHeader(),
            "header" => "INDIKATORER",
            "subHeader" => $indicatorData->getHeader(),
            "contentTitle" => $articleRep->find($indicatorData->getArticleId())->getTitle(),
            "content" => $parseDown->text($articleRep->find($indicatorData->getArticleId())->getContent()),
            "charts" => $charts,
            "chartTexts" => $chartTexts,
            "indicatorsTitle" => "Övriga indikatorer",
            "indicators" => $indicatorHeaders,
            "indicatorRoutes" => $indicatorRoutes,
            'loggedIn' => $loggedIn
        ];
        return $this->render('proj/indicator.html.twig', $data);
    }
}




        /*
        // Loop through datasets and create charts, if multiple line chart indicated, send all datasets at once
        // an finish loop after 1 iteration
        for ($i = 0; $i < $count; $i++) {
            $charts[] = $chartBuilder->createChart($chartData[0]->getType());
            $chartSets = new ChartSettings(
                $statistics[0],
                $multiple ? array_slice($statistics, 1) : [$statistics[$i + 1]],
                $multiple ? $chartHeaders : [$chartHeaders[$i]],
                true
            );
            $charts[$i]->setData($chartSets->getDataset());
            $charts[$i]->setOptions($chartSets->getOptions());
        }
        */
<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use ParsedownExtra;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Article;
use App\Entity\Pollution;
use App\Entity\Foodwaste;
use App\Entity\Recycling;
use App\Entity\Material;
use App\Entity\Indicator;
use App\Entity\Chartdata;
use App\ChartSettings\ChartSettings;
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
        ChartBuilderInterface $chartBuilder,
        SessionInterface $session
    ): Response {
        $loggedIn = $session->get("loggedIn");
        $entityTypes = [
            "utslapp" => "Pollution", "matsvinn" => "Foodwaste",
            "atervinning" => "Recycling", "materialfotavtryck" => "Material"
        ];
        $entityManager = $doctrine->getManager();

        $parseDown = new ParsedownExtra();
        $statData = [];
        $dbStatData = $entityManager->getRepository('App\Entity\\' . $entityTypes[$indicator])->findAll();
        $dbStatData = array_map(function ($item) {
            return $item->getAll();
        }, $dbStatData);
        $count = count($dbStatData[0]);
        for ($i = 0; $i < $count; $i++) {
            foreach ($dbStatData as $key => $value) {
                $statData[$i][] = $value[$i];
            }
        }

        $indicatorAll = $entityManager->getRepository(Indicator::class)->findAll();
        $indicatorData = $entityManager->getRepository(Indicator::class)->findOneBy(["route" => $indicator]);

        $indicators = array_map(function ($item) {
            return $item->getHeader();
        }, $indicatorAll);
        $indicatorRoutes = array_map(function ($item) {
            return $item->getRoute();
        }, $indicatorAll);

        $chartData = $indicatorData->getChartdatas();
        $articleRep = $entityManager->getRepository(Article::class);
        $multiple = $indicatorData->isMultiple();

        $chartHeaders = [];
        $chartTexts = [];
        foreach ($chartData as $key => $chart) {
            $chartHeaders[] = $articleRep->find($chart->getArticleId())->getTitle();
            $chartTexts[$key] = '<h3>' . $chartHeaders[$key] . '</h3>';
            $chartTexts[$key] .= '<p>' . $articleRep->find($chart->getArticleId())->getContent()  . '</p>';
        }
        $charts = [];
        $count = count($statData) - 1;
        if ($multiple) {
            $count = 1;
            $chartTexts = [implode('', $chartTexts)];
        }
        for ($i = 0; $i < $count; $i++) {
            $charts[] = $chartBuilder->createChart($chartData[0]->getType());
            $chartSets = new ChartSettings(
                $statData[0],
                $multiple ? array_slice($statData, 1) : [$statData[$i + 1]],
                $multiple ? $chartHeaders : [$chartHeaders[$i]],
                true
            );
            $charts[$i]->setData($chartSets->getDataset());
            $charts[$i]->setOptions($chartSets->getOptions());
        }

        $data = [
            "title" => "Indikatorer: " . $indicatorData->getHeader(),
            "header" => "INDIKATORER",
            "subHeader" => $indicatorData->getHeader(),
            "contentTitle" => $articleRep->find($indicatorData->getArticleId())->getTitle(),
            "content" => $parseDown->text($articleRep->find($indicatorData->getArticleId())->getContent()),
            "charts" => $charts,
            "chartTexts" => $chartTexts,
            "indicatorsTitle" => "Övriga indikatorer",
            "indicators" => $indicators,
            "indicatorRoutes" => $indicatorRoutes,
            'loggedIn' => $loggedIn
        ];
        return $this->render('proj/indicator.html.twig', $data);
    }
}

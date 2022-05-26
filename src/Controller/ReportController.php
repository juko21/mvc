<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use ParsedownExtra;

/**
 * Controller class for main report page for course
 */
class ReportController extends AbstractController
{
    /**
     * Main landing page for report page
     *
     * @return response
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('index.html.twig');
    }

    /**
     * Route for about page
     *
     * @return response
     * @Route("/about", name="about")
     */
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }

    /**
     * Route for reports
     *
     * @return response
     * @Route("/report", name="report")
     */
    public function report(): Response
    {
        $parseDown = new ParsedownExtra();
        $files = glob('content/report/*.{md}', GLOB_BRACE);
        $content = [];

        foreach ($files as $file) {
            $content[] = "<section>" . $parseDown->text(file_get_contents($file)) . "</section>";
        }

        return $this->render(
            'report.html.twig',
            ["title" => "Rapporter", "content" => $content]
        );
    }

    /**
     * Route for report on metrics
     *
     * @return response
     * @Route("/metrics", name="metrics")
     */
    public function metrics(): Response
    {
        $parseDown = new ParsedownExtra();
        $file = 'content/metrics/metrics.md';
        $content = "<section>" . $parseDown->text(file_get_contents($file)) . "</section>";

        return $this->render(
            'report.html.twig',
            ["title" => "Metrics", "content" => [$content]]
        );
    }
}

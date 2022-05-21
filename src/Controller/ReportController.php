<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use ParsedownExtra;

class ReportController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(SessionInterface $session): Response
    {
        $loggedIn = $session->get('loggedIn');

        return $this->render('index.html.twig', ["loggedIn" => $loggedIn]);
    }

    /**
     * @Route("/about", name="about")
     */
    public function about(SessionInterface $session): Response
    {
        $loggedIn = $session->get('loggedIn');

        return $this->render('about.html.twig', ["loggedIn" => $loggedIn]);
    }

    /**
     * @Route("/report", name="report")
     */
    public function report(SessionInterface $session): Response
    {
        $parseDown = new ParsedownExtra();
        $loggedIn = $session->get('loggedIn');

        $files = glob('content/report/*.{md}', GLOB_BRACE);
        $content = [];
        foreach ($files as $file) {
            $content[] = "<section>" . $parseDown->text(file_get_contents($file)) . "</section>";
        }
        return $this->render('report.html.twig', ["content" => $content, "loggedIn" => $loggedIn]);
    }

    /**
     * @Route("/metrics", name="metrics")
     */
    public function metrics(SessionInterface $session): Response
    {
        $parseDown = new ParsedownExtra();
        $loggedIn = $session->get('loggedIn');

        $files = glob('content/metrics/metrics.md', GLOB_BRACE);
        $content[] = "<section>" . $parseDown->text(file_get_contents($file)) . "</section>";

        return $this->render('report.html.twig', ["content" => $content, "loggedIn" => $loggedIn]);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use ParsedownExtra;
use Symfony\asset;

class ReportController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('index.html.twig');
    }

    /**
     * @Route("/about", name="about")
     */
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }

    /**
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
        return $this->render('report.html.twig', ["content" => $content]);
    }
}

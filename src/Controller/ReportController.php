<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use ParsedownExtra;

class ReportController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(): Response
    {
        $number = random_int(0, 200);

        return $this->render('index.html.twig', [
            'number' => $number,
        ]);
    }

    /**
     * @Route("/about")
     */
    public function about(): Response
    {
        $number = random_int(0, 200);

        return $this->render('about.html.twig', [
            'number' => $number,
        ]);
    }

    /**
     * @Route("/report ")
     */
    public function report(): Response
    {

        $Parsedown = new ParsedownExtra();

        $files = glob('content/report/*.{md}', GLOB_BRACE);
        $content = [];
        foreach($files as $file) {
            $content[] = "<section>" . $Parsedown->text(file_get_contents($file)) . "</section>";
        }
        return $this->render('report.html.twig', ["content" => $content]);
    }
}

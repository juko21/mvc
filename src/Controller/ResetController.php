<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\DBAL\Connection;

/**
 * Controller class for resetting database
 * - split from Project controller
 */
class ResetController extends AbstractController
{
    /**
     * Route method for database reset page
     *
     * @param SessionInterface $session
     * @return response
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
     * POST Route method for database reset page
     *
     * @param Request $request
     * @param Connection $connection
     * @return response
     * @Route(
     *      "/proj/reset-processing",
     *      name="proj-reset-processing",
     *      methods={"POST"}
     * )
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
}

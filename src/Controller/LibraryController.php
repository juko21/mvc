<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Book;
use App\Repository\BookRepository;

class LibraryController extends AbstractController
{
    #[Route('/library', name: 'app_library')]
    public function index(SessionInterface $session): Response
    {
        $loggedIn = $session->get('loggedIn');

        return $this->render(
            'library/index.html.twig',
            ['controller_name' => 'LibraryController', "loggedIn" => $loggedIn]
        );
    }

    /**
     * @Route(
     *      "/library/new",
     *      name="library_create"
     * )
     */
    public function createBook(SessionInterface $session): Response
    {
        $loggedIn = $session->get('loggedIn');

        return $this->render(
            'library/createbook.html.twig',
            ["headerH2" => "Registrera ny bok", "loggedIn" => $loggedIn]
        );
    }

    /**
     * @Route(
     *      "/library/new_process",
     *      name="library_create_process",
     *      methods={"POST"}
     * )
     */
    public function createBookPostProcess(BookRepository $bookRepository, Request $request): Response
    {
        $title = $request->request->get('title');
        $isbn = $request->request->get('isbn');
        $author = $request->request->get('author');
        $img = $request->request->get('img');

        $book = new Book();
        $book->setTitle($title);
        $book->setIsbn($isbn);
        $book->setAuthor($author);
        $book->setImg($img);

        $bookRepository->add($book, true);

        $this->addFlash("notice", "Lade till boken " . $book->getTitle());

        return $this->redirectToRoute('library_create');
    }

    /**
    * @Route("/library/show", name="library_show_all")
    */
    public function showAllProduct(
        BookRepository $bookRepository,
        SessionInterface $session
    ): Response {
        $loggedIn = $session->get('loggedIn');
        $books = $bookRepository->findAll();

        return $this->render(
            'library/showbooks.html.twig',
            ["title" => "Visa böcker", "books" => $books, "loggedIn" => $loggedIn]
        );
    }

    /**
     * @Route("/library/show/{bookId}", name="library_show_by_id")
     */
    public function showBookById(
        SessionInterface $session,
        BookRepository $bookRepository,
        int $bookId
    ): Response {
        $loggedIn = $session->get('loggedIn');
        $book = $bookRepository->find($bookId);

        return $this->render(
            'library/showbooks.html.twig',
            ["title" => "Visa bok", "books" => [$book], "loggedIn" => $loggedIn]
        );
    }

    /**
     * @Route("/library/show/isbn/{isbn}", name="library_show_by_isbn")
     */
    public function showBookByIsbn(
        SessionInterface $session,
        BookRepository $bookRepository,
        string $isbn
    ): Response {
        $loggedIn = $session->get('loggedIn');
        $book = $bookRepository->findOneBy(["isbn" => $isbn]);

        return $this->render(
            'library/showbooks.html.twig',
            ["title" => "Visa bok", "books" => [$book], "loggedIn" => $loggedIn]
        );
    }

    /**
     * @Route(
     *      "/library/update",
     *      name="library_update",
     *      methods={"POST"}
     * )
     */
    public function updateBook(
        SessionInterface $session,
        BookRepository $bookRepository,
        Request $request
    ): Response {
        $bookId = $request->request->get('update');
        $loggedIn = $session->get('loggedIn');
        $book = $bookRepository->find($bookId);

        return $this->render(
            'library/updatebook.html.twig',
            ["title" => "Uppdatera bok", "book" => $book, "loggedIn" => $loggedIn]
        );
    }

    /**
     * @Route(
     *      "/library/update_process",
     *      name="library_update_process",
     *      methods={"POST"}
     * )
     */
    public function updateBookPostProcess(BookRepository $bookRepository, Request $request): Response
    {
        $title = $request->request->get('title');
        $isbn = $request->request->get('isbn');
        $author = $request->request->get('author');
        $img = $request->request->get('img');
        $bookId = $request->request->get('submit');

        $book = $bookRepository->find($bookId);

        $book->setTitle($title);
        $book->setIsbn($isbn);
        $book->setAuthor($author);
        $book->setImg($img);

        // actually executes the queries (i.e. the INSERT query)
        $bookRepository->add($book, true);

        return $this->redirectToRoute('library_show_by_isbn', ["isbn" => $isbn]);
    }

    /**
     * @Route(
     *      "/library/delete",
     *      name="library_delete",
     *      methods={"POST"}
     * )
     */
    public function deleteBook(
        SessionInterface $session,
        BookRepository $bookRepository,
        Request $request
    ): Response {
        $bookId = $request->request->get('delete');
        $loggedIn = $session->get('loggedIn');
        $book = $bookRepository->find($bookId);

        return $this->render(
            'library/deletebook.html.twig',
            ["title" => "Radera bok", "book" => $book, "loggedIn" => $loggedIn]
        );
    }

    /**
     * @Route(
     *      "/library/delete_process",
     *      name="library_delete_process",
     *      methods={"POST"}
     * )
     */
    public function deleteBookPostProcess(BookRepository $bookRepository, Request $request): Response
    {
        $bookId = $request->request->get('submit');

        $book = $bookRepository->find($bookId);

        $bookRepository->remove($book, true);

        return $this->redirectToRoute('library_show_all');
    }
}

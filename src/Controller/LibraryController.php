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
    public function index(): Response
    {
        return $this->render(
            'library/index.html.twig',
            ['controller_name' => 'LibraryController']
        );
    }

    /**
     * @Route(
     *      "/library/new",
     *      name="library_create"
     * )
     */
    public function createBook(): Response
    {
        return $this->render(
            'library/createbook.html.twig',
            ["headerH2" => "Registrera ny bok"]
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
        BookRepository $bookRepository
    ): Response {
        $books = $bookRepository->findAll();

        return $this->render(
            'library/showbooks.html.twig',
            ["title" => "Visa böcker", "books" => $books]
        );
    }

    /**
     * @Route("/library/show/{bookId}", name="library_show_by_id")
     */
    public function showBookById(
        BookRepository $bookRepository,
        int $bookId
    ): Response {
        $book = $bookRepository->find($bookId);

        return $this->render(
            'library/showbooks.html.twig',
            ["title" => "Visa bok", "books" => [$book]]
        );
    }

    /**
     * @Route("/library/show/isbn/{isbn}", name="library_show_by_isbn")
     */
    public function showBookByIsbn(
        BookRepository $bookRepository,
        string $isbn
    ): Response {
        $book = $bookRepository->findOneBy(["isbn" => $isbn]);

        return $this->render(
            'library/showbooks.html.twig',
            ["title" => "Visa bok", "books" => [$book]]
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
        BookRepository $bookRepository,
        Request $request
    ): Response {
        $bookId = $request->request->get('update');
        $book = $bookRepository->find($bookId);

        return $this->render(
            'library/updatebook.html.twig',
            ["title" => "Uppdatera bok", "book" => $book]
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
        
        if($bookId) {
            $book = $bookRepository->find($bookId);

            $book->setTitle($title);
            $book->setIsbn($isbn);
            $book->setAuthor($author);
            $book->setImg($img);

            $bookRepository->add($book, true);
            return $this->redirectToRoute('library_show_by_isbn', ["isbn" => $isbn]);
        }
        return $this->redirectToRoute('library_show_all');
    }

    /**
     * @Route(
     *      "/library/delete",
     *      name="library_delete",
     *      methods={"POST"}
     * )
     */
    public function deleteBook(
        BookRepository $bookRepository,
        Request $request
    ): Response {
        $bookId = $request->request->get('delete');
        $book = $bookRepository->find($bookId);

        return $this->render(
            'library/deletebook.html.twig',
            ["title" => "Radera bok", "book" => $book]
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
        if(isset($book)) {
            $bookRepository->remove($book, true);
        }
            return $this->redirectToRoute('library_show_all');
    }
}

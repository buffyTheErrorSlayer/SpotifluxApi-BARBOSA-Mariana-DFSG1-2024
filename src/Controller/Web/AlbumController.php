<?php

namespace App\Controller\Web;

use App\Entity\Album;
use App\Form\AlbumType;
use App\Repository\AlbumRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/albums')]
class AlbumController extends AbstractController
{
    #[Route('/', name: 'app_web_album_index', methods: ['GET'])]
    public function index(AlbumRepository $albumRepository): Response
    {
        return $this->render('web/album/index.html.twig', [
            'albums' => $albumRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_web_album_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $album = new Album();
        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($album);
            $entityManager->flush();

            return $this->redirectToRoute('app_web_album_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('web/album/new.html.twig', [
            'album' => $album,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_web_album_show', methods: ['GET'])]
    public function show(Album $album): Response
    {
        return $this->render('web/album/show.html.twig', [
            'album' => $album,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_web_album_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Album $album, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_web_album_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('web/album/edit.html.twig', [
            'album' => $album,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_web_album_delete', methods: ['POST'])]
    public function delete(Request $request, Album $album, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$album->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($album);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_web_album_index', [], Response::HTTP_SEE_OTHER);
    }
}

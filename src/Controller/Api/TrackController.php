<?php

namespace App\Controller\Api;

use App\Repository\TrackRepository;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TrackController extends AbstractController
{

    public function __construct(
        private TrackRepository $trackRepository, 
        private EntityManagerInterface $em,
        private SerializerInterface $serializer
        )
    {

    }
    #[Route('/api/track', name: 'app_api_track')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/Api/TrackController.php',
        ]);
    }
}

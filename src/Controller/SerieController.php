<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SerieController extends AbstractController
{
//    #[Route('/serie', name: 'app_serie')]
//    public function index(EntityManagerInterface $em): Response
//    {
//        $serie = new Serie();
//        $serie -> setName('Stargate SG1')
//            ->setStatus('En cours')
//            ->setGenre('animé')
//            ->setFirstAirDate(new \DateTime('1999-01-01'))
//            -> setDateCreated(new \DateTime('now'));
//
//        $em->persist($serie);
//        $em->flush();
//
//     return new Response('Une serie a été créée');
//    }
#[Route('/serie/list', name: 'list', methods: ['GET'])]
public function list(SerieRepository $serieRepository): Response{

    $series = $serieRepository->findAll();

    return $this->render('serie/list.html.twig', [
        'series' => $series
    ]);
}
}

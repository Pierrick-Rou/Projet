<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
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

    #[Route('/serie/list/{page}', name: 'list', methods: ['GET'], requirements: ['page' => '\d+'], defaults: ['page' => 1])]
    public function listReturning(SerieRepository $serieRepository,int $page,ParameterBagInterface $parameterBag): Response{

    $nbrPerPage = $parameterBag->get('serie')['nb_max'];
    $offset = ($page -1) * $nbrPerPage;
    $criteria = [
        'status' => 'returning',
        'genre' => 'drama',
    ];



        $series = $serieRepository->findBy(
            $criteria,
            ['popularity' => 'DESC' ],
        $nbrPerPage,
            $offset
        );
        $total = $serieRepository->count($criteria);
        $totalPages = ceil($total / $nbrPerPage);

        return $this->render('serie/list.html.twig', [
            'series' => $series,
            'totPage' => $totalPages,
            'page' => $page,
        ]);

    }

    #[route('/serie/list-custom', name: 'custome-list', methods: ['GET'])]
    public function listCustum(SerieRepository $serieRepository):Response
    {
        $series = $serieRepository->findSeriesCustum(400,8);
        return $this->render('serie/list.html.twig', [
            'page'=>1,
           'totPage'=>10,
            'series'=>$series,

        ]);
    }

}

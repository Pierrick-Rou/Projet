<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Form\SerieType;
use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
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
    public function list(SerieRepository $serieRepository): Response
    {

        $series = $serieRepository->findAll();

        return $this->render('serie/list.html.twig', [
            'series' => $series
        ]);

    }

    #[Route('/serie/list/{page}', name: 'list', methods: ['GET'], requirements: ['page' => '\d+'], defaults: ['page' => 1])]
    public function listReturning(SerieRepository $serieRepository, int $page, ParameterBagInterface $parameterBag): Response
    {

        $nbrPerPage = $parameterBag->get('serie')['nb_max'];
        $offset = ($page - 1) * $nbrPerPage;
        $criteria = [
//        'status' => 'returning',
//        'genre' => 'drama',
        ];


        $series = $serieRepository->findBy(
            $criteria,
            ['popularity' => 'DESC'],
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

    #[route('/serie/list/{id}', name: 'custome-list', methods: ['GET'])]
    public function listCustum(SerieRepository $serieRepository): Response
    {
        $serie = $serieRepository->findOneBy();
        return $this->render('serie/list/detailFilm.html.twig', [

            'series' => $serie,

        ]);
    }

    #[Route('/serie/create', name: '_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $serie = new Serie();
        $form = $this->createForm(SerieType::class, $serie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($serie);
            $em->flush();
            return $this->redirectToRoute('_details', ['id' => $serie->getId()]);
        }

        return $this->render('serie/edit.html.twig', [
            'serie_form' => $form->createView()
        ]);


    }
    #[Route('/detail/{id}', name: '_details', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function detail(Serie $serie): Response
    {


        if (!$serie) {
            throw $this->createNotFoundException('This serie does not exist!');
        }
        return $this->render('serie/detailFilm.html.twig', [
            'serie' => $serie,
        ]);
    }

    #[Route('/serie/update/{id}', name: '_update', requirements: ['id' => '\d+'])]
    public function uptade(Serie $serie, Request $request, EntityManagerInterface $em): Response
    {

        $form = $this->createForm(SerieType::class, $serie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($serie);
            $em->flush();

            $this->addFlash('succes', 'une serie a été mis à jour');
            return $this->redirectToRoute('_details', ['id' => $serie->getId()]);
        }

        return $this->render('serie/edit.html.twig', [
            'serie_form' => $form->createView()
        ]);


    }

}

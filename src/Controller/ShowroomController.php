<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\CarType;
use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ShowroomController extends AbstractController
{
    #[Route('/showroom', name: 'app_showroom')]
    public function index(): Response
    {
        return $this->render('showroom/index.html.twig', [
            'controller_name' => 'ShowroomController',
        ]);
    }

    #[Route('/list', name: 'app_list')]
    public function list(CarRepository $carRepository): Response
    {
        $car = $carRepository->findAll();
        return $this->render('showroom/list.html.twig', [
            'show' => $car
        ]);
    }

    #[Route('/list/{nce}', name: 'app_listbyid')]
    public function listid(CarRepository $carRepository, $nce): Response
    {

        $carbyid[] = $carRepository->find($nce);
        //var_dump($carbyid) . die();
        return $this->render('showroom/details.html.twig', [
            'showbyid' => $carbyid
        ]);
    }

    #[Route('/add', name: 'app_add')]
    public function add(CarRepository $carRepository, Request $req): Response
    {
        $car = new Car();
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($req);
        if ($form->isSubmitted()) {
            $carRepository->save($car, true);
            return $this->redirectToRoute('app_list');
        }

        return $this->renderForm('showroom/add.html.twig', [
            'formadd' => $form
        ]);
    }


    #[Route('/update/{nce}', name: 'app_update')]
    public function update(CarRepository $carRepository, Request $req, $nce): Response
    {
        $carfind = $carRepository->find($nce);
        $form = $this->createForm(CarType::class, $carfind);
        $form->handleRequest($req);
        if ($form->isSubmitted()) {
            $carRepository->save($carfind, true);
            return $this->redirectToRoute('app_list');
        }
        return $this->renderForm('showroom/update.html.twig', [
            'formupdate' => $form
        ]);
    }

    #[Route('/delete/{nce}', name: 'app_delete')]
    public function delete(CarRepository $carRepository, $nce): Response
    {
        $car = $carRepository->find($nce);
        $carRepository->remove($car, true);
        return $this->redirectToRoute('app_list');
    }
}

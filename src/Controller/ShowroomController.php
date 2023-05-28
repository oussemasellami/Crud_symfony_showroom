<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\CarType;
use App\Form\SearchType;
use App\Repository\CarRepository;
use App\Repository\ShowroomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ShowroomController extends AbstractController
{
    #[Route('/order', name: 'app_showroom')]
    public function index(CarRepository $carRepository, Request $req): Response
    {
        $cars = $carRepository->findAll();
        $order = $carRepository->getOrderbyKilometrage();
        $max = $carRepository->maxKilometrage();
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($req);
        if ($form->isSubmitted()) {
            $dataform = $form->getData();

            $result = $carRepository->searchCar($dataform);
            // var_dump($result) . die();

            return $this->render('showroom/order.html.twig', array('order' => $order, 'cars' => $result, 'max' => $max, 'search' => $form->createView()));
        }
        return $this->render('showroom/order.html.twig', array('order' => $order, 'cars' => $cars, 'max' => $max, 'search' => $form->createView()));
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

    #[Route('/listcarinshowroom/{id}', name: 'app_listcarinshowroom')]
    public function listcarinshowroom(CarRepository $carRepository, ShowroomRepository $showroomRepository, $id): Response
    {
        $showroom = $showroomRepository->find($id);
        $carshowroom = $carRepository->getCarsByShowroom($id);
        return $this->render('showroom/listinshowroom.html.twig', [
            'showroom' => $showroom,
            'carshowroom' => $carshowroom
        ]);
    }
}

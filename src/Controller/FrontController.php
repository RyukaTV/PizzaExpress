<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController {    
    
    #[Route('/', methods: ['GET'])]
    public function displayAccueil() {
        return $this->render('accueil.html.twig', ['title' => 'accueil']);
    }

    #[Route('/menu', methods: ['GET'])]
    public function displayCarte() {
        $pizzas = [
            ['title' => 'Margherita', 'description' => 'Tomate, mozzarella, basilic frais.', 'price' => 10.75],
            ['title' => 'Pepperoni', 'description' => 'Pepperoni, mozzarella, sauce tomate.', 'price' => 12.5],
            ['title' => 'Végétarienne', 'description' => 'Légumes frais, mozzarella, sauce tomate.', 'price' => 11],
            ['title' => 'Quatre Fromages', 'description' => 'Mozzarella, gorgonzola, parmesan, chèvre, miel, sauce tomate.', 'price' => 13.5],
            ['title' => 'Reine', 'description' => 'Jambon, champignons, mozzarella, sauce tomate.', 'price' => 12.0],
            ['title' => 'Calzone', 'description' => 'Pizza pliée, jambon, mozzarella, ricotta, sauce tomate.', 'price' => 13.0],
            ['title' => 'Diavola', 'description' => 'Salami piquant, mozzarella, sauce tomate, olives.', 'price' => 14.0],
            ['title' => 'Napolitaine', 'description' => 'Anchois, câpres, olives, sauce tomate, mozzarella.', 'price' => 13.0],
            ['title' => 'Capricciosa', 'description' => 'Artichauts, jambon, champignons, olives, mozzarella, sauce tomate.', 'price' => 14.5],
        ];

        return $this->render('menu.html.twig', ['title' => 'menu', 'pizzas' => $pizzas]);
    }
}
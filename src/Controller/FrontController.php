<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ApiLinker;

class FrontController extends AbstractController {  
    
    private $apiLinker;
  
    public function __construct(ApiLinker $apiLinker) {
        $this->apiLinker = $apiLinker;
     }
    
    #[Route('/', methods: ['GET'])]
    public function displayAccueil() {
        $response = $this->apiLinker->getData('/sectionProduits/selected', null);
        return $this->render('accueil.html.twig', ['title' => 'accueil', 'selectedPizzas' => json_decode($response)]);
    }

    #[Route('/menu', methods: ['GET'])]
    public function displayCarte() {
        $response = $this->apiLinker->getData('/sectionProduits', null);
        return $this->render('menu.html.twig', ['title' => 'menu', 'sections' => json_decode($response)]);
    }
}
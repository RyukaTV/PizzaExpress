<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ApiLinker;
use Symfony\Component\HttpFoundation\Request;

class PageController extends AbstractController {  
    
    private $apiLinker;
  
    public function __construct(ApiLinker $apiLinker) {
        $this->apiLinker = $apiLinker;
     }
    
    #[Route('/', methods: ['GET'])]
    public function displayAccueil(Request $request) {
        $response = $this->apiLinker->getData('/sectionProduits/selected', null);
        return $this->render('accueil.html.twig', ['title' => 'accueil', 'selectedPizzas' => json_decode($response), 'prenom'=> $request->getSession()->get("username")]);
    }

    #[Route('/menu', methods: ['GET'])]
    public function displayCarte(Request $request) {
        //call 127.0.0.1:3000/api/sectionProduits
        $response = $this->apiLinker->getData('/sectionProduits', null);
        return $this->render('menu.html.twig', ['title' => 'menu', 'sections' => json_decode($response), 'prenom'=> $request->getSession()->get("username")]);
    }

    #[Route('/users', methods: ['GET'], condition: "service('route_checker').checkAdmin(request)")]
    public function displayUtilisateursPage(Request $request) {
        $session = $request->getSession();
        $token = $session->get('token-session');

        $response = $this->apiLinker->getData('/users', $token);
        $users = json_decode($response);

        return $this->render('users.html.twig', ['users' => $users, 'role' => 'admin', 'prenom'=> $request->getSession()->get("username")]);
    }

}
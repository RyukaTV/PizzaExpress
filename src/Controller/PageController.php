<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ApiLinker;
use Symfony\Component\HttpFoundation\Request;
use App\Service\RouteChecker;
use App\Service\JsonConverter;

class PageController extends AbstractController
{

    private $jsonConverter;
    private $apiLinker;

    public function __construct(ApiLinker $apiLinker, JsonConverter $jsonConverter)
    {
        $this->apiLinker = $apiLinker;
        $this->jsonConverter = $jsonConverter;
    }

    #[Route('/', methods: ['GET'])]
    public function displayAccueil()
    {
        $response = $this->apiLinker->getData('/sectionProduits/selected', null);
        return $this->render('accueil.html.twig', ['title' => 'accueil', 'selectedPizzas' => json_decode($response)]);
    }

    #[Route('/menu', methods: ['GET'])]
    public function displayCarte()
    {
        $response = $this->apiLinker->getData('/sectionProduits', null);
        return $this->render('menu.html.twig', ['title' => 'menu', 'sections' => json_decode($response)]);
    }

    #[Route('/admin', methods: ['GET'])]
    public function displayUtilisateursPage(Request $request, RouteChecker $routeChecker)
    {
        if (!$routeChecker->checkAdmin($request)) {
            return $this->redirectToRoute("app_page_displayaccueil");
        }
        $token = $request->getSession()->get('token-session');

        $response = $this->apiLinker->getData('/admin/*', $token);
        return $this->render('admin.html.twig', ['users' => json_decode($response)]);
    }

    #[Route('/fidelite', methods: ['GET'])]
    public function displayFidelitePage()
    {
        return $this->render("fidelite.html.twig", ['title' => 'fidelite']);
    }

    #[Route('/myself', methods: ['GET'])]
    public function displayAccountPage(Request $request, RouteChecker $routeChecker)
    {
        if (!$routeChecker->checkUser($request)) {
            return $this->redirectToRoute("app_page_displayaccueil");
        }
        return $this->render("myself.html.twig", ['title' => 'myself']);
    }

    #[Route('/myself', methods: ['POST'])]
    public function aaa(Request $request)
    {
        $prenom = $request->request->get("name");
        $email = $request->request->get("email");

        if (isset($email) && !empty($email)) {
            $data = $this->jsonConverter->encodeToJson(['email' => $email]);
            $responce = $this->apiLinker->postData('/users/changeEmail', $data, $request->getSession()->get("token-session"));
            $this->refreshSession($request, $responce);
        }
        if (isset($prenom) && !empty($prenom)) {
            $data = $this->jsonConverter->encodeToJson(['prenom' => $prenom]);
            $responce = $this->apiLinker->postData('/users/changeName', $data, $request->getSession()->get("token-session"));
            $this->refreshSession($request, $responce);
        }

        $password = $request->request->get("password");
        $repassword = $request->request->get("repassword");
        if (isset($password) && !empty($password) && isset($repassword) && !empty($repassword)) {
            $data = $this->jsonConverter->encodeToJson(['password' => $password, 'repassword' => $repassword]);
            $this->apiLinker->postData('/password', $data, $request->getSession()->get("token-session"));
        }

        return $this->redirectToRoute('app_page_displayaccountpage');
    }

    private function refreshSession(Request $request, $jsondata)
    {
        $data= json_decode($jsondata, true);
        $request->getSession()->set("token-session", $data["token"]);
        foreach (json_decode($data["user"], true) as $key => $value) {
            $request->getSession()->set($key, $value);
        }
    }
}

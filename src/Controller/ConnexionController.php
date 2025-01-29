<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\JsonConverter;
use App\Service\ApiLinker;

class ConnexionController extends AbstractController
{

    private $jsonConverter;
    private $apiLinker;

    public function __construct(ApiLinker $apiLinker, JsonConverter $jsonConverter)
    {
        $this->apiLinker = $apiLinker;
        $this->jsonConverter = $jsonConverter;
    }

    #[Route('/login', methods: ['POST'])]
    public function connexion(Request $request)
    {
        try {
            $email = htmlspecialchars($request->request->get("email"), ENT_QUOTES);
            $password = htmlspecialchars($request->request->get("password"), ENT_QUOTES);

            if (!empty($email) && !empty($password)) {
                $data = $this->jsonConverter->encodeToJson(['email' => $email, 'password' => $password]);
                $response = $this->apiLinker->postData('/token', $data, null);
                $responseObject = json_decode($response);

                $session = $request->getSession();
                $session->set("token-session", $responseObject->token);

                $selfresponse = $this->apiLinker->getData("/myself", $session->get("token-session"));
                $selfObject= json_decode($selfresponse);

                foreach ($selfObject as $key => $value) {
                    $session->set($key, $value);
                }
                return $this->redirectToRoute('app_page_displayaccueil');
            }

            return $this->redirectToRoute('app_connexion_diplayloginform');
        } catch (\Throwable $th) {
            //throw $th;
            $session = $request->getSession();
            $session->set('message', 'Identifiants invalides!');
            return $this->redirectToRoute("app_connexion_diplayloginform");
        }
        
    }

    #[Route('/login', methods: ['GET'])]
    public function diplayLoginForm()
    {
        return $this->render("login.html.twig", ['title' => 'login']);
    }

    #[Route('/logout', methods: ['GET'])]
    public function deconnexion(Request $request)
    {
        $session = $request->getSession();
        $session->remove("token-session");
        $session->clear();

        return $this->redirectToRoute('app_page_displayaccueil');
    }
}

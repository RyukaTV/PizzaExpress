<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Routing\Attribute\AsRoutingConditionService;
use Symfony\Component\HttpFoundation\Request;

#[AsRoutingConditionService(alias: 'route_checker')]
class RouteChecker {

    public function checkUser(Request $request) {
        $session = $request->getSession();
        if(empty($session->get('token-session'))) {
            return false;
        }

        return true;
    }

    public function checkAdmin(Request $request) {
        $session = $request->getSession();
        if(empty($session->get('token-session'))) {
            return false;
        }
   
        if(!in_array('ROLE_ADMIN', $session->get('roles'))) {
            return false;
        }

        return true;
    }
}
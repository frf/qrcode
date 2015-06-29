<?php

namespace Sistema\Controller;

use Silex\Application;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;

class QrController {
    public function gerarAction(Request $request, Application $app) {  

            $txt = $request->get("txt");
            
            if($txt == ""){
                $txt = "http://www.fabiofarias.com.br";
            }
            
            $oQr = $app['qrCode']($txt);
            
            $response = new Response();
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', 'GET,PUT,POST,DELETE,OPTIONS');
    
            return $oQr->getResponse($response);
    }
}

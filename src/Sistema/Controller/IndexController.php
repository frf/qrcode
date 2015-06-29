<?php

namespace Sistema\Controller;

use Silex\Application;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class IndexController {
    public function indexAction(Request $request, Application $app) {  
//        
//        
//        $oLista = \CondominioQuery::create()->find();
//
//        $data = array(        
//            'aLista'=>$oLista
//        );
//        
        //var_dump($token->getUser());
        return $app['qrCode']($text)->getResponse();      
    }
}

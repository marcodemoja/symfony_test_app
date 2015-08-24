<?php

namespace AppBundle\EventListener;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;



class TokenListener {

    private $tokens;

    public function __construct($tokens)
    {
        $this->tokens = $tokens;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();
       /*
         * $controller passato può essere una classe o una Closure. Non è frequente in Symfony ma può accadere.
         * Se è una classe, è in formato array
         */
        if (!is_array($controller)) {
            return;
        }

        if($controller[0] instanceof TokenAuthenticatedController) {

            $token = $event->getRequest()->query->get('token');
            var_dump($token);
            if (!in_array($token, $this->tokens)) {
                throw new AccessDeniedHttpException('Questa azione ha bisogno di un token valido!');
            }
            $event->getRequest()->attributes->set('auth_token', $token);
        }
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        // verifica se onKernelController ha segnato la richiesta come autenticata
        if (!$token = $event->getRequest()->attributes->get('auth_token')) {
            return;
        }

        $response = $event->getResponse();

        // crea un hash e lo imposta come header della risposta
        $hash = sha1($response->getContent().$token);
        $response->headers->set('X-CONTENT-HASH', $hash);
    }

}
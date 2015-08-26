<?php

namespace AppBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use \Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManager;
use AppBundle\Utils\WordMatchesCounter;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Matches;

class FormsListener {

    protected $em;

    public function __construct(EntityManager $em){
        $this->em = $em;
    }

    public function onKernelRequest(GetResponseEvent $event){
            $request = $event->getRequest();
            //print_r($request->getContent());
            $nome = $request->get('appbundle_profilo[nome]',null,true);
            $cognome = $request->get('appbundle_profilo[cognome]',null,true);

        if( $this->isDuplicateProfile($nome, $cognome)){
                $message  = json_encode(array('message' => 'duplicate entry for '.$nome.' '.$cognome));
                $response =  new Response($message,409);
                $response->headers->set('Content-Type','application/json');

                return $event->setResponse($response);
            }
    }


    public function onKernelResponse(FilterResponseEvent $event){

        if( $event->getRequest()->isMethod('POST') &&
            $event->getRequest()->getContentType('form') &&
            $event->getResponse()->isSuccessful()
        ){
            $content = $event->getResponse()->getContent();
            $params = json_decode($content);

            if($params instanceof \stdClass){
                if(property_exists($params,'id1')){
                    $this->updateMatchesByProfilo($params->id1);
                }elseif(property_exists($params,'id2')){
                    $this->updateMatchesByProfiloEsteso($params->id2);
                }
            }

        }
    }

    private function isDuplicateProfile($nome,$cognome){
        $en = $this->em->getRepository('AppBundle:Profilo')->findBy(array('nome' => $nome , 'cognome' => $cognome));
        $return = !$en ? false : true;

        return $return;
    }

    private function updateMatchesByProfilo($id){
        $profili_estesi = $this->em->getRepository('AppBundle:ProfiloEsteso')->findAll();
        $profilo = $this->em->getRepository('AppBundle:Profilo')->findBy(array('id1' => $id));

        foreach($profili_estesi as $k => $p){
            $matches = $this->em->getRepository('AppBundle:Matches')->findBy(array('id1' => $id,'id2' => $p->getId2()));

            if(!$matches){
                $word_count = WordMatchesCounter::countMatches($profilo[0]->getDescrizione(),$p->getDescrizioneEstesa());
                $match = new Matches();
                $match->setId1($id)
                    ->setId2($p->getId2())
                    ->setMatchCount($word_count);

                $this->em->persist($match);
                $this->em->flush();
            }
        }

        return;
    }

    private function updateMatchesByProfiloEsteso($id){
        $profili = $this->em->getRepository('AppBundle:Profilo')->findAll();
        $profilo_esteso = $this->em->getRepository('AppBundle:ProfiloEsteso')->findBy(array('id2' => $id));
        foreach($profili as $k => $p){
            $matches = $this->em->getRepository('AppBundle:Matches')->findBy(array('id1' => $p->getId1(),'id2' => $id));

            if(!$matches){
                $word_count = WordMatchesCounter::countMatches($p->getDescrizione(),$profilo_esteso[0]->getDescrizioneEstesa());
                $match = new Matches();
                $match->setId1($p->getId1())
                    ->setId2($id)
                    ->setMatchCount($word_count);

                $this->em->persist($match);
                $this->em->flush();

            }
        }

        return;

    }

}

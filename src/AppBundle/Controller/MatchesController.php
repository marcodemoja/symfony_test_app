<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity;
use AppBundle\Form\MatchesType;

/**
 * Matches controller.
 *
 * @Route("/matches")
 */
class MatchesController extends Controller
{

    /**
     * Export CSV words match count
     * @Route("/", name="export_csv");
     * @Method("GET")
     */
    public function exportAction(Request $request){

        $repository = $this->getDoctrine()->getRepository('AppBundle:Matches');
        $query = $repository->createQueryBuilder('s');
        $query->orderBy('s.id', 'DESC');

        $data = $query->getQuery()->getResult(); $filename = "export_".date("Y_m_d_His").".csv";

        $response = $this->render('default/export.html.twig', array('data' => $data));

        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Description', 'Submissions Export');
        $response->headers->set('Content-Disposition', 'attachment; filename='.$filename);
        $response->headers->set('Content-Transfer-Encoding', 'binary');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');

        return $response;
    }






}

<?php

namespace AppBundle\Controller;

use AppBundle\Entity\site;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Site controller.
 *
 * @Route("site")
 */
class SiteController extends Controller
{
    /**
     * Lists all site entities.
     *
     * @Route("/", name="site_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sites = $em->getRepository('Site.php')->findAll();

        return $this->render('site/index.html.twig', array(
            'sites' => $sites,
        ));
    }

    /**
     * Finds and displays a site entity.
     *
     * @Route("/{id}", name="site_show")
     * @Method("GET")
     */
    public function showAction(site $site)
    {

        return $this->render('site/show.html.twig', array(
            'site' => $site,
        ));
    }
}

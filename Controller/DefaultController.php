<?php

namespace rmatil\CmsBundle\Controller;

use rmatil\CmsBundle\Constants\EntityNames;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {


        return $this->render('rmatilCmsBundle:Default:index.html.twig');
    }
}

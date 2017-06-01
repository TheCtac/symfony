<?php 
namespace Acme\HelloBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;	

class HelloController extends Controller
{
	public function indexAction($name)
	{
        //echo new Response($name);
		return $this->render('AcmeHelloBundle:Hello:index.html.twig', array('name' => $name));
	}
	public function aboutAction($name)
    {
        return $this->render('AcmeHelloBundle:Hello:about.html.twig', array('name' => $name));
    }

}
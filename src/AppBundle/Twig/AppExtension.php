<?php
namespace AppBundle\Twig;

use Acme\TanksBundle\Controller\FunctionsController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;   

class AppExtension extends \Twig_Extension
{   
    protected $entityManager;

    public function __construct($entityManager = null)
	{
        $this->entityManager = $entityManager;
    }
	public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('get_tags', array($this, 'get_tags')),
            new \Twig_SimpleFilter('user_info', array($this, 'user_info')),
            new \Twig_SimpleFilter('count', array($this, 'count')),
            new \Twig_SimpleFilter('text_form', array($this, 'text_form'))
        );
    }
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('getUserLogin', array($this, 'getUserLogin'))
        );
    }   
    function get_tags($tags){
        $func=new FunctionsController();
        $tags_=$func->get_tags($tags);
    return $tags_;
    }
    
    function user_info($user){
        $func=new FunctionsController();
        $user=$func->user_infoAction($user);
    return;
    }
    
    function text_form($text){
        $func=new FunctionsController();
        $text_=$func->form_text($text);
    return $text_;
    }
    function count($data){
        $count=count($data);
    return $count;
    }
    function getUserLogin($id){
<<<<<<< HEAD
       $func = new FunctionsController();
       $user = $func->getUserLogin($id);
    return $user;
    }   
=======
        $id = intval($id);
        $repository = $this->entityManager->getRepository('AcmeTanksBundle:users');
        $user=$repository->findOneById($id);
        if (!$user){
            return 'невідомий';
        }
    return $user->getLogin();
    }
>>>>>>> 8ecc14b76ae25cdb1869256d758f6825c03cd74a
    public function getName()
    {
        return 'app_extension';
    }
}

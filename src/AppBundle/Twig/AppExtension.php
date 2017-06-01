<?php
namespace AppBundle\Twig;

use Acme\TanksBundle\Controller\FunctionsController;

class AppExtension extends \Twig_Extension
{	
	public function getFilters()
    {
        return array(new \Twig_SimpleFilter('get_tags', array($this, 'get_tags')),
					 new \Twig_SimpleFilter('user_info', array($this, 'user_info')),
					 new \Twig_SimpleFilter('count', array($this, 'count')),
					 new \Twig_SimpleFilter('text_form', array($this, 'text_form'))
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
	
    public function getName()
    {
        return 'app_extension';
    }
}
<?php 
namespace Acme\TanksBundle\Controller;

use Twig\Environment;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;	
use Acme\TanksBundle\Entity\tanks_;
use Acme\TanksBundle\Entity\ratings;
use Acme\TanksBundle\Entity\messages;
use Acme\TanksBundle\Controller\FunctionsController;

class TanksController extends Controller
{
	public $func ;
	private $musqli;
	public $this_user;

	function __construct()
	{
		$this -> func = new FunctionsController;
		$this->mysqli = new \mysqli("localhost", "root", "", "tanks");
//		$this-> mysqli = new \mysqli("localhost", "id1711110_root", "rapers", "id1711110_tanks");
		$this->this_user = $this->func->get_cookie('login');
	}

	public function indexAction()
	{	
		$html = file_get_contents('https://worldoftanks.ru');
		$pat = array('/href="\//');
		$repl = array('href="https://worldoftanks.ru/');
		$html = preg_replace($pat,$repl,$html);
		$file_ = fopen('news.html','w+');
		fwrite($file_, $html);	
		fclose($file_);
		return $this->render('AcmeTanksBundle::base.html.twig');
	}
	public function studyAction(){
		$file_ = fopen('names.csv','r+');
		if ($file_) {
		  $header_arr = explode(';' , preg_replace('/\r|\n/i', '', fgets($file_)));
		  while($line = fgets($file_)) {
			$line_exp = explode(';' , preg_replace('/\r|\n/i', '', $line));
			if(count($line_exp) < count($header_arr)){
				$line_exp[] = '';
			}
			$line_ar[] = $line;
			$full_ar[] = array_combine($header_arr,$line_exp);
		  } 
          fclose($file_);
		  $full_ar = array_slice($full_ar,10,20);
		  //var_dump($full_ar[0]);
		  $file_ = fopen('names.xml','w+');
		  
		  $xml = new \XMLWriter;
		  $xml->openmemory();
		    $xml->setIndent(true); //робити відступ
            $xml->setIndentString(' ');  //символ відступу
		    $xml->startDocument('1.0', 'UTF-8'); 
			$xml->startElement('abons'); 
			  	foreach($full_ar as $abon){
				  $xml->startElement('abon');
                   	foreach($abon as $key => $value){
						$xml->startElement($key);
						  $xml->text($value);
						$xml->endElement();
					}
			      $xml->endElement();
                }				  
			$xml->endElement(); 
		  $text = $xml->outputMemory(); 
		  $xml->endDocument(); 
		  fwrite($file_, $text);	
		  fclose($file_);
		  $file_ = fopen('names.xml','r');
		  $text = fread($file_, 666666);
		 
		  $text = preg_replace('/<+/', '&lt', $text);
		  $text = preg_replace('/>+/', '&gt', $text);
		  $text = preg_replace('/(\n|\r)+/', '<br>&nbsp', $text);
		  
		  fclose($file_);
		  
		  $tab = array("UTF-8", "ASCII", "Windows-1252", "ISO-8859-15", "ISO-8859-1", "ISO-8859-6", "CP1256"); 
          $chain = ""; 
          foreach ($tab as $i) { 
            foreach ($tab as $j) { 
              //$chain .= " $i - $j ".iconv($i, $j, "$line_ar[1]")."<br>"; 
            } 
          } 
          //var_dump($line_ar[1]); 
        }
		return $this->render('AcmeTanksBundle::study.html.twig',array('names' => $line_ar, 'xml'=>$text));		
	}
	public function getThisUser(){
		$user = 'undefined';
		$login = $this->func->get_cookie('login');
		if(empty($login)){
			return $user;
		}
		$repository = $this->getDoctrine()->getRepository('AcmeTanksBundle:users');
		$user = $repository->findOneByLogin($login);
		$voit_ = ($user->getRating() < 1 ? 0.1 :$user->getRating() / 100);
		$voit_ = ($user->getRating() > 300 ? 3 :$user->getRating() / 100);
		
		$user = array('login'=>$user->getLogin(),'id'=>$user->getId(),'voit'=>$voit_, 'photo'=>$user->getPhoto());
		return $user;	
	}
	public function reviewAction($type,$page,$level)
    {	
		if( $level == 0){
			$lev = '';
	    }else{
			$lev = $level.'-го рівня';
		}
		switch($type){
			case "TT":$vid_='важких танків ';break;
			case "ST":$vid_='середніх танків ';break;
			case "LT":$vid_='легких танків ';break;
			case "PT":$vid_='ПТ-САУ ';break;
			case "SAU":$vid_='САУ ';break;
			case "all":$vid_='танків ';break;
		}
		$vid_ .= $lev; 
		
		$repository = $this->getDoctrine()->getRepository('AcmeTanksBundle:tanks_');
		if($type=='all'){
			$tanks=$repository->findTanks('name','',$level);
		}else{	
			$tanks=$repository->findTanks('name',"t.type='".$type."'",$level);
		}
		$count = count($tanks);
		$tanks = array_slice($tanks, ($page - 1)*4, 4);
		
		return $this->render('AcmeTanksBundle::review.html.twig',
		array('data'=>$tanks,'vid'=>$vid_,'page'=>$page,'count'=>$count,'type'=>$type,'level'=>$level));
   }
	public function ForumAction($tag,$page)
    {		
		$repository = $this->getDoctrine()->getRepository('AcmeTanksBundle:themes');
		if($tag=='all'){
			$themes=$repository->findThemes('name','');
		}else{	
			$themes=$repository->findThemes('name',"t.tags like'%".$tag."%'");
		}
		if($tag=='all'){$tag='Танковий';}

		return $this->render('AcmeTanksBundle::forum.html.twig', array('data'=>$themes,'tag'=>$tag,'page'=>'$page'));
    }
	
	public function ThemeAction($theme)
    {		
		$repository = $this->getDoctrine()->getRepository('AcmeTanksBundle:themes');
		$data=$repository->findOneByName($theme);
		if(!$data){$theme='Не знайдено';}
		
		$repository = $this->getDoctrine()->getRepository('AcmeTanksBundle:comments');
		$comm=$repository->findByTheme(preg_replace("/'/","\'",$theme));
		$comm_num=count($comm);
		return $this->render('AcmeTanksBundle::theme.html.twig', array('data'=>$data,'theme'=>$theme,'comm'=>$comm));
    }
	public function HomeAction(){
		
		$request = Request::createFromGlobals();
		$hash=$request->cookies->get('hash');
		
		if(empty($hash)){
			//if (array_key_exists('HTTP_REFERER',$_SERVER)){
			// if ( parse_url($_SERVER['HTTP_REFERER'])['path'] == '/tanks/home'){
			//      header('Location:http://localhost:8000/tanks');
			//     die();
			//  } else {
			//      $resp = new Response("<img src = 'https://img.memesuper.com/23d25658bd2443337635256e88242b85_free-your-mind-and-try-again-try-again-memes_636-478.jpeg'>");
     		//      return $resp;
			//  }
			//} else {
				  header('Location:http://localhost:8000/tanks');
			      die();
			//}
		}
		
		$repository =$this->getDoctrine()->getRepository('AcmeTanksBundle:users');
		$user=$repository->findOneByHash($hash);
		
		$rat_='салага';$col_='#f11';
		$rating_=$user->getRating();
		
		if($rating_>20){$rat_='бувалий';$col_='#f90';}
		if($rating_>40){$rat_='просунутий';$col_='#ff0';}
		if($rating_>60){$rat_='знаток';$col_='#4f4';}
		if($rating_>80){$rat_='мудрець';$col_='#09f';}
		if($rating_>100){$rat_='гуру';$col_='#b2f';}
		
		$repository = $this->getDoctrine()->getRepository('AcmeTanksBundle:themes');
		$themes=$repository->findByAuthor($user->getLogin());
		
		$repository = $this->getDoctrine()->getRepository('AcmeTanksBundle:comments');
		$comms=$repository->findByUser($user->getLogin());
        //$data=array($login_,$photo_,$about,$rating_,$date_,$age_,$city_,$male_,$rat_,$col_);
		
		return $this->render('AcmeTanksBundle::home.html.twig', array('data'=>$user,'rat'=>$rat_,'col'=>$col_, 'themes'=>$themes, 'comms'=>$comms));
	}	
	public function adminAction(){
		return $this->render('AcmeTanksBundle::base.html.twig',array('xml'=>''));		
	}

	public function premAction(){
		$xml = file_get_contents('https://api.privatbank.ua/p24api/pubinfo?exchange&coursid=5');
		$dom = new \domDocument;
		$dom->loadXML($xml);

		//var_dump($dom);
		$rows = $dom->getElementsByTagName( "row" );
		$exch=array();
		foreach( $rows as $row )
		{
			$exchangerate = $row->firstChild;
			$ccy = $exchangerate->getAttribute('ccy');
			$buy = round($exchangerate->getAttribute('buy'),2);
			$sale = round($exchangerate->getAttribute('sale'),2);
 
			if($ccy!='BTC'){
				$exch[]=array('ccy'=>$ccy,'buy'=>$buy,'sale'=>$sale);
			}	
		}
        /*
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
		// Following line is compulsary to add as it is:
        curl_setopt($ch, CURLOPT_POSTFIELDS,
                    "xmlRequest=" . $input_xml);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
        $data = curl_exec($ch);
        curl_close($ch);
		
		$s=simplexml_load_string($data);
		echo $s->row[1]->exchangerate[0]->attributes();
		*/
		
		return $this->render('AcmeTanksBundle::prem.html.twig',array('data'=>$exch));		
	}
	
	public function registrationAction()
	{
		return $this->render('AcmeTanksBundle::registration.html.twig');		
	}
	public function oneTankAction($name)
	{
		$name=$this->mysqli->real_escape_string($name);
		$repository = $this->getDoctrine()->getRepository('AcmeTanksBundle:tanks_');
		$tank=$repository->findOneByName($name);
		
		$repository = $this->getDoctrine()->getRepository('AcmeTanksBundle:comments');
		$comm=$repository->findByTheme(preg_replace("/'/","\'",$name));
		$comm_num=count($comm);
		
		if(count($tank)==0){
			return $this->render('AcmeTanksBundle::nofound.html.twig');						
		}	
		return $this->render('AcmeTanksBundle::oneTank.html.twig',array('data'=>$tank,'comm'=>$comm));				
	}
	public function userRedAction(){
		$request = Request::createFromGlobals();
		$hash=$request->cookies->get('hash');
		
		if(empty($hash)){
			$resp = new Response("<img src = 'https://img.memesuper.com/23d25658bd2443337635256e88242b85_free-your-mind-and-try-again-try-again-memes_636-478.jpeg'>");
     		return $resp;
		}
		$repository =$this->getDoctrine()->getRepository('AcmeTanksBundle:users');
		$user=$repository->findOneByHash($hash);
		return $this->render('AcmeTanksBundle::userRed.html.twig',array('user'=>$user));				
	}
    public function userMessAction($type){
		$user = $this->getThisUser();
		if ($type == 'in'){
			$where = 'm.to_id = '.strval($user['id']);
		}elseif($type == 'proc'){
			$where = 'm.type_mess = 1 and m.from_id = '.strval($user['id']);		
		}else{
			$where = 'm.type_mess = 2 and m.from_id = '.strval($user['id']);					
		}
		$repository =$this->getDoctrine()->getRepository('AcmeTanksBundle:messages');
		$mess=$repository->findAllUserMess($where,'');

		return $this->render('AcmeTanksBundle::mess_list.html.twig', array('data'=>$mess));
	}
}
<?php 
namespace Acme\TanksBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;	
use Acme\TanksBundle\Entity\tanks_;
use Acme\TanksBundle\Entity\themes;
use Acme\TanksBundle\Entity\users;
use Acme\TanksBundle\Entity\comments;
use Acme\TanksBundle\Entity\ratings;
use Acme\TanksBundle\Entity\messages;
use Symfony\Component\HttpFoundation\Cookie;
use Acme\TanksBundle\Controller\FunctionsController;

class AjaxController extends Controller
{
	public $func;
	private $mysqli;
	public $this_user;

	public function __construct()
	{
		$this -> func = new FunctionsController;
		$this->this_user = $this->func->get_cookie('login');
		$this-> mysqli = new \mysqli("localhost", "root", "", "tanks");
//		$this-> mysqli = new \mysqli("localhost", "id1711110_root", "rapers", "id1711110_tanks");
	}

	public function indexAction($mathod,$param = 0)
	{	
		$result_=$this->$mathod($param);
		return new Response($result_);
	}
	public function all()
	{
		return $this->render('AcmeTanksBundle::nofound.html.twig');
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
		
		$user = array('login'=>$user->getLogin(),'id'=>$user->getId(),'voit'=>$voit_);
		return json_encode($user);	
	}
	public function getTanksByName($param)
	{
		$functions = $this -> func;	
		$param=$functions->u0_to_cyr($param);
		
		$repository = $this->getDoctrine()->getRepository('AcmeTanksBundle:tanks_');	
		$tanks=$repository->findTanks('name',"t.name like '%".$param."%'",0);
		if(count($tanks)>0)
		{
			echo "<br><t style='font-size:20px;color:#fa0'>знайдено ".count($tanks)." результатів</t><br><br>";
			return $this->renderView('AcmeTanksBundle::tank.html.twig', array('data'=>$tanks));
		}else{
			return $this->renderView('AcmeTanksBundle::nofound.html.twig');
		}	
	}
	
	public function user_enter()
	{
		if(!isset($_GET['hash'])){
			$login_=$this->mysqli->real_escape_string($_GET['login']);
			$pass_=$this->mysqli->real_escape_string($_GET['pass']);
			$pass_=md5(md5($pass_));
			$repl_=array('a'=>'bb','b'=>'cc','c'=>'aa','0'=>'o');
			$pass_=strtr($pass_,$repl_);
			$pass_=substr($pass_,0,20);
		}else{
			$hash=$this->mysqli->real_escape_string($_GET['hash']);
			$hash=substr($hash,0,strlen($hash)-13);
		}
		$data='0';
		
		$repository = $this->getDoctrine()->getRepository('AcmeTanksBundle:users');	
		if(isset($hash)){
			$user=$repository->findByHash($hash);	
		}else{
			$user=$repository->get_user('login',"u.login='".$login_."' and u.pass='".$pass_."'");	
		}
		if(!$user){return $data;}
		
		foreach($user as $value){
			$login=$value->getLogin();
			$active=$value->getActive();
			if(isset($hash)){
				$value->setActive(1);
				$active=1;
				$em = $this->getDoctrine()->getEntityManager()->flush();
			}
			$hash=$value->getHash();
		}
		
		if($active==1){
			$cookie=array('login'=>$login,'hash'=>$hash);
			$response=new Response();
			$response->headers->setCookie(new Cookie('login',$login, time()+(3600*24*30))); 
			$response->headers->setCookie(new Cookie('hash',$hash, time()+(3600*24*30))); 
			$response->send();
			$data='1';
		}else{
			$data='2';
		}
		//$request->cookies->get('login');
		if(isset($_GET['hash'])){
			return $this->redirect($this->generateUrl('acme_tanks_homepage'));
		}
		return $data;
	}
	
	public function exit_user()
	{
		$response=new Response();
		$response->headers->clearCookie('login');
		$response->headers->clearCookie('hash');
		$response->send();	
		return;
	}
	public function add_comm()
	{
		$user_ = $this->this_user;
		$comm_=$this->mysqli->real_escape_string($_GET['comm']);
		$theme_=$this->mysqli->real_escape_string($_GET['theme']);
		$type_=$this->mysqli->real_escape_string($_GET['type']);
		
		$new_comm=new comments();
		$new_comm->setTheme($theme_);
		$new_comm->setType($type_);		
		$new_comm->setUser($user_);
		$new_comm->setComm($comm_);
		$new_comm->setTheme($theme_);
		//$new_comm->setDate(date('Y-m-d h:i:s'));
		$new_comm->setDate(new \DateTime('now'));
		$new_comm->setTab(0);
		$new_comm->setRating(0);
		//$new_comm->setAnsw_id(0);
	
		$em = $this->getDoctrine()->getEntityManager();
		$em->persist($new_comm);
		$em->flush();
		$data=json_encode(array('theme'=>$theme_,'type'=>$type_));
		
		return $data;
	}
	public function show_new_comm($id)
	{
		$repository = $this->getDoctrine()->getRepository('AcmeTanksBundle:comments');
		$comm=$repository->findOneByID($id);
		
		return $this->renderView('AcmeTanksBundle::comment.html.twig',array('comm'=>$comm));
	}
	public function new_tank()
	{
		$tank_=$this->mysqli->real_escape_string($_POST['tank_name_']);
		$level_=floatval($_POST['level_']);
		$type_=$this->mysqli->real_escape_string($_POST['type_']);
		$armo_=floatval($_POST['tank_armo_']);
		$guns_=floatval($_POST['tank_gun_']);
		$speed_=floatval($_POST['tank_speed_']);
		$history_=$this->mysqli->real_escape_string($_POST['tank_history_']);

		$functions = $this -> func;	
		$photo_='Photo/'.$functions->url_to_cyr($_FILES['tank_photo_']['name']);
		$photo_source_=$_FILES['tank_photo_']['tmp_name'];
		$load_=\move_uploaded_file($photo_source_,iconv('utf-8','cp1251',$photo_));
		
		$new_tank=new tanks_();
		$new_tank->setName($tank_);
		$new_tank->setType($type_);
		$new_tank->setLevel($level_);
		$new_tank->setArmo($armo_);
		$new_tank->setGuns($guns_);
		$new_tank->setSpeed($speed_);
		$new_tank->setPhoto($photo_);
		$new_tank->setHistory($history_);
				
		$em = $this->getDoctrine()->getEntityManager();
		$em->persist($new_tank);
		$em->flush(); 
		
		$repository = $this->getDoctrine()->getRepository('AcmeTanksBundle:tanks_');
		$new_tank=$repository->findByName($tank_);
		
		return $this->renderView('AcmeTanksBundle::tank.html.twig',array('data'=>$new_tank));
	}
	public function getMaus()
	{
		$repository = $this->getDoctrine()->getRepository('AcmeTanksBundle:tanks_');
		$new_tank=$repository->findByName('Maus');

		return /*How to recieve object?*/;
	}
	public function new_theme()
	{
		$name_=$this->mysqli->real_escape_string($_POST['theme_name']);
		$tags_=$this->mysqli->real_escape_string($_POST['theme_tags']);
		$body_=mysqil_real_escape_string($_POST['theme_text']);
		$author_=$this->mysqli->real_escape_string($_POST['theme_author']);

		$functions = $this -> func;	
		$photo_='Photo/forum'.$functions->url_to_cyr($_FILES['theme_photo_']['name']);
		$photo_source_=$_FILES['theme_photo_']['tmp_name'];
		$load_=move_uploaded_file($photo_source_,iconv('utf-8','cp1251',$photo_));
		
		$new_theme=new themes();
		$new_theme->setAuthor($author_);
		$new_theme->setName($name_);
		$new_theme->setTags($tags_);
		$new_theme->setBody($body_);
		$new_theme->setPhotos($photo_);
		$new_theme->setDate(new \DateTime('now'));
		$new_theme->setRating(0);
		
		$em = $this->getDoctrine()->getEntityManager();
		$em->persist($new_theme);
		$em->flush(); 
		
		$repository = $this->getDoctrine()->getRepository('AcmeTanksBundle:themes');
		$new_theme=$repository->findByName($name_);
		
		return $this->renderView('AcmeTanksBundle::themes.html.twig',array('data'=>$new_theme));
	}
	public function new_user()
	{
		$functions = $this -> func;	

		$login_= $this->mysqli->real_escape_string($_POST['login']);
		$email_= $this->mysqli->real_escape_string($_POST['email']);
		$age_= floatval($_POST['age']);
		$city_= $this->mysqli->real_escape_string($_POST['city']);
		$male_= $this->mysqli->real_escape_string($_POST['male']);
		$pass_=md5(md5(trim($_POST['pass1'])));
		$repl_=array('a'=>'bb','b'=>'cc','c'=>'aa','0'=>'o');
		$pass_=strtr($pass_,$repl_);
		$pass_=substr($pass_,0,20);
		$hash_=md5($functions->codegen(10));
		$about_= $this->mysqli->real_escape_string($_POST['about']);

		$repository = $this->getDoctrine()->getRepository('AcmeTanksBundle:users');
		$users=$repository->findByLogin($login_);
		
		if(count($users)>0 or $login_==''){
			return 'Користувач з таким логіном вже існує!';
		}	

		$photo_='Photo/users/'.$functions->url_to_cyr($_FILES['user_photo_']['name']);
		$photo_source_=$_FILES['user_photo_']['tmp_name'];
		$functions->resize_img($photo_source_,200);
		$load_=move_uploaded_file($photo_source_,iconv('utf-8','cp1251',$photo_));

		$new_user=new users();
		$new_user->setLogin($login_);
		$new_user->setPass($pass_);
		$new_user->setEmail($email_);
		$new_user->setPhoto($photo_);
		$new_user->setAbout($about_);
		$new_user->setAge($age_);
		$new_user->setCity($city_);
		$new_user->setMale($male_);
		$new_user->setHash($hash_);
		$new_user->setDate(new \DateTime('now'));
		$new_user->setLikedTags('');
		$new_user->setVoit(0.1);
		$new_user->setActive(0);
		$new_user->setRating(0);
		
		$em = $this->getDoctrine()->getEntityManager();
		$em->persist($new_user);
		$em->flush(); 
		
		/*$mass_=''
		$headers ='MIME-Version: 1.0' . "\r\n";
		$headers.='Content-type: text/html; charset=utf-8' . "\r\n";
		mail($mail_,'Активація аккауту '+$login_,$mass_,$headers);
		*/
		$data=array('login'=>$login_,'pass'=>$_POST['pass1'],'hash'=>$hash_);
		
		$message = \Swift_Message::newInstance()
        ->setSubject('Активація аккаунту '.$login_)
		->setFrom('thestas0211@gmail.com')
		->setTo($email_)
        ->setBody(
            $this->renderView('AcmeTanksBundle::mail.html.twig',array('data' => $data)),
            'text/html'
		);
		$this->get('mailer')->send($message);
		
		return;
	}
	public function loginCheck()
	{
		$login=$this->mysqli->real_escape_string($_GET['login']);
		if($login==''){
			return "<t style='color:red'>Введіть коректний логін!</t>";
		}
		$repository = $this->getDoctrine()->getRepository('AcmeTanksBundle:users');
		$new_user=$repository->findByLogin($login);

		if(count($new_user)>0){
			return "<t style='color:red'>Користувач з таким логіном вже існує!</t>";
		}else{
			return "<t style='color:green'>Логін вільний</t>";
		}	
	}
	public function xmlFind()
	{
		$pib = $this->mysqli->real_escape_string($_GET['pib']);
		mb_internal_encoding("UTF-8");
		$pib = mb_strtoupper($pib);
		
		$xml = new \XMLReader();
		$xml->open('names.xml');
		$ret = '';
		
		while($xml->read()){
		 if($xml->name == 'abon'){
            $a = $xml->readInnerXML();
			if( strpos($a, $pib) > 0){
				$ret .= $a.'<br>';
			}
			//echo $xml->name . ' - ' . $xml->value . '<br>';
		 }	
		}
		if(strlen($ret) == 0){$ret = 'Не знайдено';}
		return $ret;
	}
	public function red_user()
	{
		$functions = $this -> func;
		
		$email_= $this->mysqli->real_escape_string($_POST['email']);
		$age_= floatval($_POST['age']);
		$city_= $this->mysqli->real_escape_string($_POST['city']);
		$male_= $this->mysqli->real_escape_string($_POST['male']);
		$about_= $this->mysqli->real_escape_string($_POST['about']);

		$hash = $this -> func -> get_cookie('hash');
		
		$repository = $this->getDoctrine()->getRepository('AcmeTanksBundle:users');
		$user = $repository->findOneByHash($hash);
		
		if(!$user or empty($hash)){
			return new Response("<img src = 'https://img.memesuper.com/23d25658bd2443337635256e88242b85_free-your-mind-and-try-again-try-again-memes_636-478.jpeg'>");
		}	
        
		if (!empty($_FILES['user_photo_']['tmp_name'])){
		  $photo_='Photo/users/'.$functions->url_to_cyr($_FILES['user_photo_']['name']);
		  $photo_source_=$_FILES['user_photo_']['tmp_name'];
		  $functions->resize_img($photo_source_,200);
		  $load_=move_uploaded_file($photo_source_,iconv('utf-8','cp1251',$photo_));
        }
		
		$user->setEmail($email_);
		if(!empty($_FILES['user_photo_']['tmp_name'])){
			$user->setPhoto($photo_);
		}
		$user->setAbout($about_);
		$user->setAge($age_);
		$user->setCity($city_);
		$user->setMale($male_);
		
		$em = $this->getDoctrine()->getEntityManager();
		$em->persist($user);
		$em->flush(); 
	}
	public function rating(){
		$login_= $this->mysqli->real_escape_string($_POST['login']);
		$id_= intval($_POST['id']);
		$voit_= floatval($_POST['voit']);
		$theme_= $this->mysqli->real_escape_string($_POST['theme']);
		
		$repository = $this->getDoctrine()->getRepository('AcmeTanksBundle:themes');
		$theme_full = $repository->findOneByName($theme_);
		$theme_id = $theme_full->getId();
		$theme_author = $theme_full->getAuthor();
			
		if($theme_author == $login_){
			if($voit_>0){
			  return json_encode(array('new_rating'=>'karma-sucker detected'));
			}else{
			  return json_encode(array('new_rating'=>'<br>dont punish yourself<br>it will make other<br>'));				
			}
		}
		
		//check prev voice and change if need
		$repository = $this->getDoctrine()->getRepository('AcmeTanksBundle:ratings');
		//$ratings = $repository->findAllUserRat('','r.user_id = '.$id_.' and r.theme_id = '.$theme_id);
		$ratings = $repository->findOneBy(array('user_id' => $id_, 'theme_id' => $theme_id));
		if($ratings)
		{
			$rat_value = $ratings->getValue();
		    if($voit_ == $rat_value)
		    {
			    return json_encode(array('new_rating'=>'you are already voted')); 
		    }else{
				$voit_ = 2 * $voit_;
				$ratings ->setValue($rat_value*(-1));
			}
		}else
		{
    		$ratings = new ratings();				
		    $ratings->setUserId($id_);
		    $ratings->setThemeId($theme_id);
		    $ratings->setTanksId(0);
		    $ratings->setCommId(0);
		    $ratings->setValue($voit_);
		}	

		//change theme rating
		$now_rating = $theme_full->getRating();
		$theme_full->setRating($now_rating + $voit_);
		
		//change author rating
		$repository = $this->getDoctrine()->getRepository('AcmeTanksBundle:users');
		$author_full = $repository->findOneByLogin($theme_author);
		
		$author_full->setRating( $author_full->getRating() + $voit_ );
		
		//Save changes
		
		$em = $this->getDoctrine()->getEntityManager();
		$em->persist($ratings);
		$em->persist($theme_full);
		$em->persist($author_full);
		$em->flush(); 

		return json_encode(array('new_rating'=>$now_rating + $voit_));
	}
	public function sendMess(){
		$name = $this->mysqli->real_escape_string($_POST['name']);
		$theme_ = $this->mysqli->real_escape_string($_POST['theme']);
		$body_ = $this->mysqli->real_escape_string($_POST['body']);
		
		$user = json_decode($this->getThisUser(), true);
		$from_ = $user['id'];

		$repository = $this->getDoctrine()->getRepository('AcmeTanksBundle:users');
		$to_full = $repository->findOneByLogin($name);
		if(empty($to_full)){
			return 'Адресата не знайдено !';
		}
		$to_ = $to_full->getId();
		
		if(empty($from_)){
			return 'Ви не зареїстровані !';
		}
		if($from_ == $to_){
			return 'Так самотньо ? Поспілкуйтесь з іншими форумчанами ))';
		}
		$mess = new messages();				
		$mess->setFromId($from_);
		$mess->setToId($to_);
		$mess->setBody($body_);
		$mess->setTypeMess(1);
		$mess->setSendDate(new \DateTime('now'));
		$mess->setResDate(new \DateTime('now'));
		$mess->setTheme($theme_);
				
		$em = $this->getDoctrine()->getEntityManager();
		$em->persist($mess);
		$em->flush(); 	
		
		return('Ваше повідомлення доставлено !');
	}
	
}
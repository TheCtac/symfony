<?php
namespace Acme\TanksBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;	
use Acme\TanksBundle\Entity\users;
use Acme\TanksBundle\Entity\ratings;
use Acme\TanksBundle\Entity\messages;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class FunctionsController extends Controller
{
function clear_string($str_){
	$tags_=array("select"=>"","select"=>"","="=>"","+"=>"","-"=>"","*"=>"","/"=>"","|"=>"","\\"=>"");
	$str_=strip_tags($str_);	
	$str_=trim($str_);
	$str_=strtr($str_,$tags_);
return $str_;	
}	

function u0_to_cyr($str) {
$arr_replace_utf = array('\u0410', '\u0430','\u0411','\u0431','\u0412','\u0432',
'\u0413','\u0433','\u0414','\u0434','\u0415','\u0435','\u0401','\u0451','\u0416',
'\u0436','\u0417','\u0437','\u0418','\u0438','\u0419','\u0439','\u041a','\u043a',
'\u041b','\u043b','\u041c','\u043c','\u041d','\u043d','\u041e','\u043e','\u041f',
'\u043f','\u0420','\u0440','\u0421','\u0441','\u0422','\u0442','\u0423','\u0443',
'\u0424','\u0444','\u0425','\u0445','\u0426','\u0446','\u0427','\u0447','\u0428',
'\u0448','\u0429','\u0449','\u042a','\u044a','\u042b','\u044b','\u042c','\u044c',
'\u042d','\u044d','\u042e','\u044e','\u042f','\u044f');
$arr_replace_cyr = array('А', 'а', 'Б', 'б', 'В', 'в', 'Г', 'г', 'Д', 'д', 'Е', 'е',
'Ё', 'ё', 'Ж','ж','З','з','И','и','Й','й','К','к','Л','л','М','м','Н','н','О','о',
'П','п','Р','р','С','с','Т','т','У','у','Ф','ф','Х','х','Ц','ц','Ч','ч','Ш','ш',
'Щ','щ','Ъ','ъ','Ы','ы','Ь','ь','Э','э','Ю','ю','Я','я');
$str1 = str_replace($arr_replace_utf,$arr_replace_cyr,$str);
return $str1;
}

function url_to_cyr($str){ 
$s= strtr ($str, array ("%20"=>" ", "%D0%B0"=>"а", "%D0%90"=>"А", "%D0%B1"=>"б", "%D0%91"=>"Б", "%D0%B2"=>"в", "%D0%92"=>"В", "%D0%B3"=>"г", "%D0%93"=>"Г", "%D0%B4"=>"д", "%D0%94"=>"Д", "%D0%B5"=>"е", "%D0%95"=>"Е", "%D1%91"=>"ё", "%D0%81"=>"Ё", "%D0%B6"=>"ж", "%D0%96"=>"Ж", "%D0%B7"=>"з", "%D0%97"=>"З", "%D0%B8"=>"и", "%D0%98"=>"И", "%D0%B9"=>"й", "%D0%99"=>"Й", "%D0%BA"=>"к", "%D0%9A"=>"К", "%D0%BB"=>"л", "%D0%9B"=>"Л", "%D0%BC"=>"м", "%D0%9C"=>"М", "%D0%BD"=>"н", "%D0%9D"=>"Н", "%D0%BE"=>"о", "%D0%9E"=>"О", "%D0%BF"=>"п", "%D0%9F"=>"П", "%D1%80"=>"р", "%D0%A0"=>"Р", "%D1%81"=>"с", "%D0%A1"=>"С", "%D1%82"=>"т", "%D0%A2"=>"Т", "%D1%83"=>"у", "%D0%A3"=>"У", "%D1%84"=>"ф", "%D0%A4"=>"Ф", "%D1%85"=>"х", "%D0%A5"=>"Х", "%D1%86"=>"ц", "%D0%A6"=>"Ц", "%D1%87"=>"ч", "%D0%A7"=>"Ч", "%D1%88"=>"ш", "%D0%A8"=>"Ш", "%D1%89"=>"щ", "%D0%A9"=>"Щ", "%D1%8A"=>"ъ", "%D0%AA"=>"Ъ", "%D1%8B"=>"ы", "%D0%AB"=>"Ы", "%D1%8C"=>"ь", "%D0%AC"=>"Ь", "%D1%8D"=>"э", "%D0%AD"=>"Э", "%D1%8E"=>"ю", "%D0%AE"=>"Ю", "%D1%8F"=>"я", "%D0%AF"=>"Я")); 
return $s; 
} 
function get_tags($tags){
	$url_='/tanks/forum/';
	$tags_='';
	$tags_array=explode(",",$tags);
	foreach($tags_array as $key=>$value){
		$value=trim($this->url_to_cyr($value));
		$tags_=$tags_."<a title='".$value."' href='".$url_.$value."'>".$value."</a> ";
	}	
return $tags_;
}	
function form_text($text_){
		$pattern=array('/\n/','/\n/','/\t/');
		$replace=array('<br>','<br>','&nbsp;&nbsp;&nbsp;&nbsp;');
		$form_text=preg_replace($pattern,$replace,$text_);
return $form_text;		
}
function resize_img($image,$w_o = false, $h_o = false) {
    if (($w_o < 0) || ($h_o < 0)) {
      echo "Некорректные входные параметры";
      return false;
    }
    list($w_i, $h_i, $type) = getimagesize($image); // Получаем размеры и тип изображения (число)
    $types = array("", "gif", "jpeg", "png"); // Массив с типами изображений
    $ext = $types[$type]; // Зная "числовой" тип изображения, узнаём название типа
    if ($ext) {
      $func = 'imagecreatefrom'.$ext; // Получаем название функции, соответствующую типу, для создания изображения
      $img_i = $func($image); // Создаём дескриптор для работы с исходным изображением
    } else {
      $error='Некорректное изображение'; // Выводим ошибку, если формат изображения недопустимый
      return $error;
    }
    /* Если указать только 1 параметр, то второй подстроится пропорционально */
    if (!$h_o) $h_o = $w_o / ($w_i / $h_i);
    if (!$w_o) $w_o = $h_o / ($h_i / $w_i);
    $img_o = imagecreatetruecolor($w_o, $h_o); // Создаём дескриптор для выходного изображения
    imagecopyresampled($img_o, $img_i, 0, 0, 0, 0, $w_o, $h_o, $w_i, $h_i); // Переносим изображение из исходного в выходное, масштабируя его
    $func = 'image'.$ext; // Получаем функция для сохранения результата
    return $func($img_o, $image); // Сохраняем изображение в тот же файл, что и исходное, возвращая результат этой операции
  }
function CodeGen($length=6){
    $chars="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
	$code = "";
	$clen = strlen($chars) - 1;  
    while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0,$clen)];  
    }
    return $code;
}
function user_infoAction($data){

		$author=$data;
		$repository =$this->getDoctrine()->getRepository('AcmeTanksBundle:users');
		$user=$repository->findOneByLogin($author);
		
		$rat_='салага';$col_='#f11';
		$rating_=$user->getRating();
		if($rating_>20){$rat_='бувалий';$col_='#f90';}
		if($rating_>40){$rat_='просунутий';$col_='#ff0';}
		if($rating_>60){$rat_='знаток';$col_='#4f4';}
		if($rating_>80){$rat_='мудрець';$col_='#09f';}
		if($rating_>100){$rat_='гуру';$col_='#b2f';}
		
		return $this->render('AcmeTanksBundle::user.html.twig', array('data'=>$user,'rat'=>$rat_,'col'=>$col_));
		
}
function get_cookie($cookie_name){
		$request = Request::createFromGlobals();
		$value = $request->cookies->get($cookie_name);
		return $value;
}
}

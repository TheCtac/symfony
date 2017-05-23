 <?php Header("Content-Type: text/html;charset=UTF-8");

include 'functions.php';

$login_= mysql_real_escape_string($_POST['login']);
$email_= mysql_real_escape_string($_POST['email']);
$age_= mysql_real_escape_string($_POST['age']);
$city_= mysql_real_escape_string($_POST['city']);
$male_= mysql_real_escape_string($_POST['male']);
$pass_=md5(md5(trim($_POST['pass1'])));
$repl_=array('a'=>'bb','b'=>'cc','c'=>'aa','0'=>'o');
$pass_=strtr($pass_,$repl_);
$hash_=md5(codegen(10));
$about_= mysql_real_escape_string($_POST['about']);

$photo_='Photo/users/'.url_to_cyr($_FILES['user_photo_']['name']);
$photo_source_=$_FILES['user_photo_']['tmp_name'];
resize_img($photo_source_,200);

$load_=move_uploaded_file($photo_source_,iconv('utf-8','cp1251',$photo_));

$data=array($login_,$email_,$pass_,form_text($about_),$photo_source_);

$con_=new mysqli('localhost','stas','rapers','tanks');

$stmt=$con_->prepare("select count(id) FROM users where login=?");
$stmt->bind_param('s',$login_);
$stmt->bind_result($id_);
$stmt->execute();
$stmt->fetch();
$stmt->close();

if($id_>0 or $login_==''){
	$data=array('Користувач з таким логіном вже існує!');
	$con_->close();
	echo json_encode($data);
	return;
}	

$stmt=$con_->prepare("insert into users (login,pass,email,photo,about,hash,voit,age,city,male,date) values (?,?,?,?,?,?,?,?,?,?,now())" );
$stmt->bind_param('ssssssddss',$login_,$pass_,$email_,$photo_,$about_,$hash_,$voit_,$age_,$city_,$male_);
$voit_=0.1;
$stmt->execute();
$stmt->close();

$con_->close();

$mass_="<html>
<head>
    <meta http-equiv='content-type' content='text/html; charset=utf-8'>
</head>
<body>
	<div style='width:50%;margin-left:24.5%;border:2px #fa0 solid;padding:1%;background:#ddd;text-align:center;'>
		<img src='http://blitzworldoftanks.ru/wp-content/uploads/2014/11/update_1.4-tiger.png' width='100%'><br>
		<p style='font-size:30;'>Дякуємо за реєстрацію на нашому сайті</p>
		При реєстрації Ви ввели наступні дані:<br>
		Логін: ".$login_."<br>
		&nbsp;&nbsp;&nbsp;Пароль: ".$_POST['pass1']."<br>
		для активації аккаунту перейдіть по посиланню:<br><br>
			<a href='http://localhost/sites/tanks/user_enter.php?id=".$hash_.'g4dbb9bfd231s'."' title='активувати аккаунт' style='text-decoration:none;'>
				<div style='width:16%;margin-left:41%;padding:1%;background:#fa0;border-radius:3px;border:1px solid #aaa;color:#fff'>Активувати</div>
			</a>
	</div>	
</body></html>";
$headers ='MIME-Version: 1.0' . "\r\n";
$headers.='Content-type: text/html; charset=utf-8' . "\r\n";

mail($mail_,'Активація аккауту '+$login_,$mass_,$headers);

$data=array($login_,$pass_,$email_,$photo_,$about_,$hash_,$voit_);
echo json_encode($data);
return;
?>


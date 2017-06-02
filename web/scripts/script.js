
$('document').ready(function(){        
/*
*delete div
*/
  $('.close').click(function(){
	  var elem = this.parentNode;
	  
	  $(elem).animate({
		  opacity:0,
		  display:'none'
	  });
  });  


/*
*  src-alt change
*/
  $('.img_repl').on('mouseover', function(){
	var src=this.src;
	var alt=this.alt;
	this.src=alt;
	this.alt=src;	
  });
  
  $('.img_repl').on('mouseout', function(){
	var src=this.src;
	var alt=this.alt;
	this.src=alt;
	this.alt=src;		
  });

/*
*messForm
*/
  $('.mess').click(function(){
	  $('#messTitle').empty();
 	  var name = this.getAttribute('name');
	  if ( document.getElementById('theme_name') != 'undefined')
	  {
		document.messForm.theme.value = document.getElementById('theme_name').innerHTML; 
	  }
   	  document.getElementById('mess').style.display = 'block';
   	  document.getElementById('mess').style.opacity = 1;
	  $('#messTitle').prepend('Повідомлення користувачу ' + name);
	  document.getElementById('messBut').setAttribute('name',name);
  });
/*
* send message 
*/  
  $('#messBut').click(function(){
	var name = this.getAttribute('name');
	var theme = document.messForm.theme.value;
	var body = document.messForm.body.value;
    var valid = '';
	valid += str_validate(name,1);
	valid += str_validate(theme,2);
	valid += str_validate(body,2);
	
	if (valid !=''){show_mess(valid);return;}
	data  = { name:name, theme:theme, body:body }
	$.ajax({
		url:'/tanks/ajax/sendMess',
		data:data,
		type:'POST',
		success:function(retData){
		    $('#mess').animate({
		      opacity:0,
		      display:'none'
	        });
			show_mess(retData);
		},
		error:function(xhr,status,error){ show_mess("Сталась помилка :" + error) }
	});

  }); 
/*
*mess_type
*/  
    $('.mess_type').click(function(e){
		e.preventDefault();
		var this_div = this;
		var src = this_div.parentNode.href;
		if ( src  == ' ' || src  == 'undefined' || src  == null){return false;}
		$('#user_mess').load(src, function(responseTxt, statusTxt, xhr){
            if(statusTxt == "success"){
				var divs = document.getElementsByClassName('mess_type');
		        var kl = divs.length;
		        for (i = 0; i < kl; i++){
			        divs[i].removeAttribute("id");
		        }
                this_div.setAttribute("id", "mess_this");
			}else{
                show_mess("Помилка: " + xhr.status + ": " + xhr.statusText + "<br>Спробуйте пізніше !");
			}
        });
		return false;
	});

/*
*ZOOM_ZOOM
*/
$('#zoom').on('click', function(){
  
  if(typeof on  == 'undefined' || on == 0){
    on = 1;
  }else{
	on = 0;
  }	
  if(on == 1)
  { 
    var view =  document.getElementById('zoom-view');
    view.style.display = 'block';
    view.innerHTML = ''
	view.style.width = window.outerWidth/3+'px';
    view.style.height = window.outerHeight/2+'px';
    document.onmousemove = function(e) {
      var elem = e.target;
	  var view_width = view.style.width;
      var view_height = view.style.height;
	  if(elem.hasAttribute('zoomable')){
        var box = elem.getBoundingClientRect();
        var shiftX = e.pageX - (box.left + pageXOffset);
        var shiftY = e.pageY - (box.top + pageYOffset);	  
	    var left_ = parseInt(view_width) * shiftX/elem.width *-2 + 'px';
	    var top_ = parseInt(view_height) * shiftY/elem.height *-2 + 'px';
	    view.innerHTML = '<img src="'+ elem.src +'" style = "position:relative;width:300%;left:'+ left_ +';top:'+ top_ +'">';
	    view.style.height = view.childNodes[0].clientHeight / 3 + 'px' ;
	  //<br>'+left_ + ':' + elem.width + ':' + shiftX + ':' + shiftY;
	  }
	  
    }
  }else{
	  document.getElementById('zoom-view').style.display = 'none';
	  document.onmousemove = null;
  }	
});

/*
*Весела гра Перетягни танчік
*/
$('document').ready(function(){
var kl=0 	 
var tank = document.getElementById('tank');

if(tank == null) return;
var garage=document.getElementById('droppable');
tank.onmousedown = function(e){
  garage.innerHTML = 'Тягни сюди';
  var box = tank.getBoundingClientRect();
  var old_x = box.left;
  var old_y = box.top;  
  var shiftX = e.pageX - (box.left + pageXOffset);
  var shiftY = e.pageY - (box.top + pageYOffset);
  
  tank.style.position = 'absolute';
  moveAt(e);
  document.body.appendChild(tank);
  tank.style.zIndex = '1000';
  
  function moveAt(e){
	  tank.style.left = (e.pageX - shiftX) + 'px';
	  tank.style.top = (e.pageY - shiftY) + 'px';
      garage.style.boxShadow = '5px 5px 10px #fa0';	  
  }
  
  document.onmousemove = function(e) {
	moveAt(e);
  }
  tank.onmouseup = function(e) {
	  document.onmousemove = null;
	  tank.onmouseup  = null;
	  tank.hidden = true;
	  var elem = document.elementFromPoint(e.clientX, e.clientY);
	  var elem = elem.closest('#droppable');
	  if (!elem) {
		tank.hidden = false;
		return;
	  }
	  garage.style.position = 'relative';
	  for (i = 1; i<4; i++){ 
		$(garage).animate({
		    top:'+=15px',
		    height:'-=15px'
	    },"fast");
	  	$(garage).animate({
		    top:'-=15px',
		    height:'+=15px'
	    });
	    
	  }
	  setTimeout(function(){
	    kl++;
	    garage.innerHTML = kl;	
	    garage.style.boxShadow = '';
	    tank.hidden = false;
	    $(tank).animate({
		  top: old_y,
		  left: old_x
	    });
      },1800);
  }
  tank.ondragstart = function() {
    return false;
  }
}
});

/*
*  Plus - minus
*/

  $('.vote-plus,.vote-minus').on('click',function(){
      var user = getThisUser();
	  if( user == 'undefined'){
		  enter();
		  return;
	  }
	  var userObj = JSON.parse(user);
	  userObj.theme = document.querySelector('#theme_name').innerHTML;
	  userObj.voit = (this.className == 'vote-plus' ? userObj.voit : userObj.voit*-1);
	  $.ajax({
		url:'/tanks/ajax/rating',
		data: userObj,
		type:'POST',
		success : function(data){ 
 			 data = JSON.parse(data);
			 var mainspan = document.querySelectorAll('.vote-plus')[0].parentNode;
			 var fontElem = mainspan.getElementsByTagName('font')[0];
			 $(fontElem).html(data.new_rating);
		},
		error:function(xhr,status,error){ show_mess("Сталась помилка :" + error) }	  
	});  
  });
  
});

function getThisUser(userdata){
	user = '';
	$.ajax({
		url:'/tanks/ajax/getThisUser',
		type:'POST',
		async:false,
		success : function(data){ window.user = data ; },
		error:function(){ window.user = 'undefined'; }	  
	});
	return user;
}

function find_(){

    var tank_ = document.form1.tank1.value;
    var tank_ = tank_.replace(' ','%20');

    document.form1.tank1.value = '';
    url_ = '/tanks/ajax/getTanksByName/'+tank_;

    window.onpopstate = null;
    $('#theme_').load(url_);
    history.pushState(null, null, location.pathname);
    window.onpopstate = function(){
        $('#theme_').load(location.pathname +' #theme_');
        //document.getElementById('theme_').innerHTML;		
    };
}

function change_photo(){
	var src=this.src;
	var alt=this.alt;
	this.src=alt;
	this.alt=src;
}
function exit_user(){
	var date=new Date(1970,00);
	//document.cookie="login=;expires="+date;
		$.ajax({
		url:'/tanks/ajax/exit_user',
		success:function(){location.reload();}
	});
}	

function returned_find_(ReturnedData){
//show_mess(ReturnedData);
$('#theme_').empty();
$('#theme_').append('<br>Броня :'+ReturnedData[0]+'<br>Урон :'+ReturnedData[1]+'<br>'+ReturnedData[2]);
}

function openmenu(item_){
if(item_==1 || item_==3){
exit;
}
x=$('#tank_a').offset().left;
y=$('#menu_').offset().top;
document.getElementById('menu_list').style.visibility='visible'
document.getElementById('menu_list').style.left=x-25+'px';
document.getElementById('menu_list').style.top=y-7+'px';
document.getElementById('menu_list').style.opacity=1;
}

function closemenu(item_){
if(item_==1 || item_==3){
exit;
}
document.getElementById('menu_list').style.visibility='hidden';
}

function get_info(type_){
if(type_==false){type_=true;}
}

function add_open(div){
div='#'+div;
$(div).animate({
	height:'toggle'
});
}

function add_view(){
$('#photo_value').empty().append(this.files[0].name);
var users = {};
users = {
	male : {
		john : { 
          surname:'cena',
		  age:18			
		},
		piter : {
		  surname:'Gabriel',
	      age:42
		},
		stepan : {
	      surname:'Wonder',
		  age:53
		}
	},
	female : {
		Tiffany : { 
          surname:'Brook',
		  age:41			
		},
		Lucy : {
		  surname:'Okornel',
		  age:38
		},
		Jenny : {
		  surname:'Casper',
		  age:27
		}		
	}
}

$('#photo_prev').empty().append(objBrow(this.files));
}

function objBrow(obj, space){
  if (space === undefined) {
	  var space = '&nbsp';
  }
  if (t === undefined) {
           var t = '';
  } 
  for (key in obj){
	t = t + space +key + (typeof obj[key] == 'object' ? ' ' + obj[key]+' -> ' : ' = '+obj[key]) + '<br>' ;
    if (typeof obj[key] == 'object') {
		t = t + objBrow( obj[key], space + '&nbsp&nbsp&nbsp' );
    };
  }
  return t;
}

function add_new_tank_(){

data=new FormData(document.add_tank_form);

photo_=document.add_tank_form.tank_photo_.files[0];
tank_=document.add_tank_form.tank_name_.value;
tank_level_=document.add_tank_form.level_.value;
tank_type_=document.add_tank_form.type_.value;
tank_armo_=document.add_tank_form.tank_armo_.value;
tank_gun_=document.add_tank_form.tank_gun_.value;
tank_speed_=document.add_tank_form.tank_speed_.value;

if(photo_&&tank_&&tank_level_&&tank_type_&&tank_armo_&&tank_gun_&&tank_speed_){
	pause_(1);
	$.ajax({
		url:'/tanks/ajax/new_tank',
		data:data,
		type:'POST',
		processData:false,
		contentType:false,
		success:loaded2,
		error:function(){show_mess('Сталась помилка!');pause_(2);}
	});
}else{
	error_="Введіть необхідні поля :";
	if(!photo_){error_=error_+" фото,";}
	if(!tank_){error_=error_+" назва танка,";}
	if(!tank_level_){error_=error_+" рівень танка,";}
	if(!tank_type_){error_=error_+" тип,";}
	if(!tank_armo_){error_=error_+" броня,";}
	if(!tank_gun_){error_=error_+" урон,";}
	if(!tank_speed_){error_=error_+" швидкість,";}
	error_=error_.substr(0,error_.length-1)+' !';
	show_mess(error_);
}
}

function pause_(do_){
if(do_==1){
$('body').append("<div id='pause_'\ style='position:fixed;top:8px;left:8px;width:99%;height:97%;background:url(/images/loader_back.png) round;z-index:1000'>\
<img src='/images/loader.gif' style='position:relative;width:100px;top:43%;'></div>")
}else{
$('#pause_').remove();
}
}	

function loaded2(returneddata){
	pause_(2);
	add_open('add_tank_')
	$('#new_block').append(returneddata);	
	window.scrollTo(0,3000);	
}
function add_new_theme(){
	val=document.getElementsByName('theme_text')[0].value;
	//text=val.replace(/\n|\t|\s/gm,'<br>');
	text=val.replace(/\n/gm,'<br>');
	name_=document.getElementsByName('theme_name')[0].value;
	tags_=document.getElementsByName('theme_tags')[0].value;
	theme_photo_=document.getElementsByName('theme_photo_')[0].files[0]
	theme_body_=document.getElementsByName('theme_text')[0].value;
	theme_author_=document.getElementsByName('theme_author')[0].value;
	if(name_&&tags_&&theme_body_){
		pause_(1);
		//data={name:name_,tags:tags_,theme_body:theme_body_,theme_author:theme_author_};
		data=new FormData(document.add_theme_form);
		$.ajax({
			url:'/tanks/ajax/new_theme',
			data:data,
			type:'POST',
			processData:false,
			contentType:false,
			success:theme_added,
			error:function(){show_mess('Сталась помилка!');pause_(2);}
		});
	}else{
		error_="Введіть необхідні поля :";
		if(!name_){error_=error_+" назва теми,";}
		if(!tags_){error_=error_+" теги,";}
		if(!theme_body_){error_=error_+" текст теми,";}
		error_=error_.substr(0,error_.length-1)+' !';
		show_mess(error_);		
	}
	
}
function theme_added(data){
	add_open('new_theme');
	pause_(2);
	$('#new_block').append(data);	
	window.scrollTo(0,3000);	
}
function send_reg(){
	err_=loginCheck();
	if(err_>0){
		return;
	}
	email_=document.getElementsByName('email')[0].value;
	login_=document.getElementsByName('login')[0].value;
	pass1_=document.getElementsByName('pass1')[0].value;
	pass2_=document.getElementsByName('pass2')[0].value;
	error_=' ';
	if(login_.search(/^[\w-']+$/)==-1){
		error_='введено некоректний логін, дозволені символи:A-Z,a-z,0-9,-,_,\'\n';
	}
	if(email_.search(/^[\w-]+@[\w-]+\.\w+$/)==-1){
		error_=error_+'введена невірна електрона пошта\n';
	}
	if(pass1_!==pass2_){
		error_=error_+'невірно введене підтвердження паролю\n';
	}
	if(pass1_.length<5 || pass1_.length>20){
		error_=error_+'довжина паролю повина бути від 5 до 20 символів';
	}
	if(!login_||!pass1_||!pass2_||!email_){
		error_='введіть необхідні поля';
	}
	if(error_!=' '){
		show_mess(error_);
		exit;
	}
	data=new FormData(document.registr_form);
	$.ajax({
		url:'/tanks/ajax/new_user',
		data:data,
		type:'POST',
		processData:false,
		contentType:false,
		success:user_added,
		error:function(){show_mess('Сталась помилка! Перевірте введені поля')}
	});
}
function user_added(data){
	if(!data || data==null || data==''){
		mess_='Дякуємо за реєстрацію на нашому сайті!<br>\
		На ваш е-мейл відправлено лист, за допомогою якого Ви зможете активувати Ваш аккаунт.'
	}else{
		mess_=data;
	}	
	$('#reg_div').empty().append("<br><p style='font-size:20;'>"+mess_+"</p><br><br>");
}

function send_red(){

	email_=document.getElementsByName('email')[0].value;
	error_=' ';
	if(email_.search(/^[\w-]+@[\w-]+\.\w+$/)==-1){
		error_=error_+'введена невірна електрона пошта\n';
	}
	if(error_!=' '){
		show_mess(error_);
		exit;
	}
	data=new FormData(document.registr_form);
	$.ajax({
		url:'/tanks/ajax/red_user',
		data:data,
		type:'POST',
		processData:false,
		contentType:false,
		success:function(){location.replace("http://localhost:8000/tanks/home");},
		error:function(){show_mess('Сталась помилка! Перевірте введені поля')}
	});
}

function enter(){
	var div1=document.getElementById('enter_form');
	var div2=document.getElementById('f1').parentElement;
	$(div2).remove();
	$(div1).empty();
	div1.style.overflow='hidden';
	$(div1).animate({
		width:'+=20',
		height:62+'px'
	})
	$(div1).append("<div id='enter_button' onclick='enter_user()' ><br>увійти</div>\
	<input id='log' type='text' name='enter_login' value='' placeholder='введіть логін'><br><br>\
	<input type='password' name='enter_pass' value='' placeholder='введіть пароль'>")
	document.getElementById('log').focus();
}
function enter_user(){
	var login_=document.getElementsByName('enter_login')[0].value;
	var pass_=document.getElementsByName('enter_pass')[0].value;
	var error_=' ';
	if(login_.search(/^[\w-']+$/)==-1){
		error_='введено некоректний логін\n';
	}
	if(pass_.search(/^[\w-']+$/)==-1){
		error_='введено некоректний пароль\n';
	}
		if(error_!=' '){
		show_mess(error_);
		exit;
	}
	var data={login:login_,pass:pass_};
	$.ajax({
		url:'/tanks/ajax/user_enter',
		data:data,
		type:'GET',
		success:function(rdata){
			if(rdata=='1'){
				location.reload();
			}else if(rdata=='2'){
				show_mess('Аккаунт не активовано');
			}else{
				show_mess('Невірний логін чи пароль');
			};
		},
		error:function(){show_mess('Сталась помилка! Перевірте введені дані')}
	})
}

function addTab(id) {
    var el = document.getElementById(id);
	
	// получим позицию каретки
	val = el.value;
    start = el.selectionStart;
    end = el.selectionEnd;
	
	// установим значение textarea в: текст до каретки + tab + текст после каретки
    el.value = val.substring(0, start) + '\t' + val.substring(end);

    // переместим каретку
    el.selectionStart = el.selectionEnd = start + 1;
}
function add_new_comm(type_){
	var form=document.getElementById('new_comm_form');
	var user_=form.user.value,
	comm_=form.new_comm.value,
	theme_=form.theme.value;
	
	if(comm_.length==0){
		show_mess('Коментар не може бути порожнім');
		return;
	}
	if(comm_.search(/^[\w\s-_'а-яА-яіІЁё,.:;?!%()]+$/)==-1){
		show_mess('введено некоректний коментар, дозволені символи:A-Z,a-z,а-я,А-Я,0-9,-,_,\'');
		return;
	}
	var data={comm:comm_,user:user_,theme:theme_,type:type_};
	$.ajax({
		url:'/tanks/ajax/add_comm',
		data:data,
		type:'GET',
		success:function(retData){
				retData=JSON.parse(retData);
				form.new_comm.value='';
				$('#comments').load('/tanks/'+retData.type+'/'+retData.theme.replace(/ /g,'%20')+' #comments' ,function(){add_open('new_comm');window.scrollTo(0,3000);});				
		},
		error:function(){show_mess('Сталась помилка! Перевірте введені дані');}
	});
}
function loginCheck(){
	
	login_=document.getElementsByName('login')[0].value;
	data={login:login_};
	err_=0;
	//document.getElementById('send_reg').getAttributeNode('onclick').value='loginCheck()';
	$('#loginCheck').empty().append("<img src='/images/loader.gif' height='20px'>");
	
	$.ajax({
		url:'/tanks/ajax/loginCheck',
		data:data,
		type:'GET',
		//async: false,
		success:function(data){
			$('#loginCheck').empty().append(' '+data);
			if(data=="<t style='color:green'>Логін вільний</t>"){err_=0;}
		},
		error:function(){
			$('#loginCheck').empty().append(' От халепа,сталась помилка!');
		}
	});
	return err_;
}
function find_in_xml(){
 
  var form = document.getElementsByName('xmlFind')[0];
  var pib_ = form.pib.value;
  var data  = {pib:pib_};
  	if(pib_.length==0){
		show_mess('Введіть прізвище');
		return;
	}
	if(pib_.search(/^[\w\s-_'а-яА-яіІЁё,.:;?!%()]+$/)==-1){
		show_mess('введено некоректний ПІБ, дозволені символи:A-Z,a-z,а-я,А-Я,0-9,-,_,\'');
		return;
	}
	
		$.ajax({
		url:'/tanks/ajax/xmlFind',
		data:data,
		type:'GET',
		//async: false,
		success:function(data){
			$('#new_theme').append('<br>' + data + '<br>');
		},
		error:function(){
			$('#new_theme').append('<br> От халепа,сталась помилка! <br>');
		}
	});
}
function str_validate(text_,type){
	//type = 1 - english lettrs 2 - eng/ru letters and signs (punctuation);
	if (text_.length == 0){
		return 'Порожне значення ! ';
	}
	if (text_.search(/^[\w\s-_'а-яА-яіІЁёЄє,.:;?!%()]+$/) == -1 && type == 2){
		return 'введено некоректне значення ! ';
	}
	if (text_.search(/^[\w\s-_]+$/) == -1 && type ==1){
		return 'введено некоректне значення ! ';
	}
	return '';
}
function pageChange(){
	//var cache = document.getElementById('theme_').innerHTML;
    window.removeEventListener("popstate", function(){} );
	var block = document.getElementById('pager').getAttribute('block');
	var url = document.getElementById('pager').getAttribute('url');
	var page = this.innerHTML;
	if(block === null || url === null || page === null){
		show_mess('Сталась помилка.<br>Спробуйте пізніше');
		return;
	}	
	window.onpopstate = null;
	$(block).load(url + page +' '+ block);
    history.pushState(null, null, url + page);
	$('html, body').animate({scrollTop: 0}, 400);
    window.onpopstate = function(){
	    $(block).load(location.pathname +' '+ block);
	    //document.getElementById('theme_').innerHTML;		
	};
}
function show_mess(text_){
	var elem = "<div id='show_mess'>\
	      <div class='close'>X</div><br><br>\
		  " + text_ + "<br><br>\
		  <div class='button'>ОК</div>\
		</div>";
	  $('body').append(elem);
	  document.getElementById('show_mess').style.display = 'block';
	  $('#show_mess').animate({
		  opacity:1,
		  top : '+=30px'
	  });
	  $('#show_mess').click(function(){
		  $('#show_mess').remove();
      });  
}

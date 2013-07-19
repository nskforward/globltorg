// Aranai neuron Avto Size Image
// расспространение без согласия автора, запрещено.
// mavea@mail.ru
// onload="resizing_pictures(this,65,72,'resize');"
// onload="resizing_pictures(this,65,72,'cnow');"
function Show(){
	var ttt=document.getElementById('HidePic');
	var sss=document.getElementById('Pic');
	var x=ttt.width;
	var y=ttt.height;
	var n=100;
	if (x>n&&y<=n){y*=n/x;x=n;}
	if (x<=n&&y>n){x*=n/y;y=n;}
	if (x>n&&y>n) {
		  if (x>y){y*=n/x;x=n}
		 else if (x<y){x*=n/y;y=n}
		 else {y=n;x=n};
	}
	sss.width=x;sss.height=y;
	sss.src=ttt.src;
}

function PreLoadImg(sss){
	var ttt=document.getElementById('HidePic');
	ttt.src=sss.src;
	Show();
}

var Imagel = new Image();
var Imagec = '';
var Imagew = '';
var Imageh = '';
Imagel.onload = function(){
alert(this.width+' '+this.height);
resizing_pictures(Imagec,Imagew,Imageh,'resize',this.width,this.height);
}

function resizing_new_pictures(imag,imag_width,imag_height){
Imagec = imag;
Imagew = imag_width;
Imageh = imag_height;
Imagel.src = imag.src;
}
	
function resizing_pictures(imag,imag_width,imag_height,type,x,y){
	if (type!='cnow'){type='resize';}
	if (x){}else{var x=imag.width;}
	if (y){}else{var y=imag.height;}
	var sx=imag_width/x;
	var sy=imag_height/y;
	if (type=='resize'){
		if (x>imag_width&&y<=imag_height){y*=sx;x=imag_width;}
		else if (x<=imag_width&&y>imag_height){x*=sy;y=imag_height;}
		else if (x>imag_width&&y>imag_height) {
			if (sx<sy){y*=sx;x*=sx}
			else if (sx>=sy){x*=sy;y*=sy}
			else {y=imag_height;x=imag_width};
		}else{
			if (sx<sy){y*=sx;x*=sx}
			else if (sx>=sy){x*=sy;y*=sy}
			else {y=imag_height;x=imag_width};
		}
	}else{
		if (x>imag_width&&y<=imag_height){x*=sy;y=imag_height;}
		else if (x<=imag_width&&y>imag_height){y*=sx;x=imag_width;}
		else if (x>imag_width&&y>imag_height) {
			if (sx>sy){y*=sx;x*=sx}
			else if (sx<=sy){x*=sy;y*=sy}
			else {y=imag_height;x=imag_width};
		}else{
			if (sx>sy){y*=sx;x*=sx}
			else if (sx<=sy){x*=sy;y*=sy}
			else {y=imag_height;x=imag_width};
		}
	
	}
	imag.width=x;
	imag.height=y;
	imag.style.visibility='inherit';
	if ($(imag).parents('.sidebarN').attr('class')){
		var ob=$(imag).parent();
		var obi=$(imag);
		if(ob.parents('.sidebarN').attr('id')=='sidebar-2'){
			ob.css({'margin-left':-Math.round((ob.width()-x-12)/2),'margin-top':-Math.round((ob.height()-y-12)/2)});
		}else{
			ob.css({'margin-left':-Math.round((ob.width()-x-12)/2),'margin-top':-Math.round((ob.height()-y-12)/2)});
		}
	}
}

$(document).ready(function() {
$('#content').height($('#main').height()-30);
});
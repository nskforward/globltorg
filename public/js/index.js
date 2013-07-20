var banBaners=false;
function baner_hide(){
$('[rel="gallery"]').css('display','none').removeClass('vBaner');
}
function baner_show(b){
$('#'+b+'[rel="gallery"]').css('display','block').addClass('vBaner');
}
function baner_rand(){
if (baners.length>3){
var x=Math.floor( Math.random( ) * (baners.length) );
var y=Math.floor( Math.random( ) * (baners.length) );
if (x==y){y=y+1;}
var z=Math.floor( Math.random( ) * (baners.length) );
if (x==z){z=z+1;}
if (y==z){z=z+1;}
if (y>=baners.length){y=y-baners.length;}
if (z>=baners.length){z=z-baners.length;}
if (x==y){y=y+1;}
if (x==z){z=z+1;}
if (y==z){z=z+1;}
/*$('.expozition .clear').html(x+' '+y+' '+z);*/
baner_hide();
}else{
var x=0;
var y=1;
var z=2;
banBaners=true;
}
baner_show(baners[x]);
baner_show(baners[y]);
baner_show(baners[z]);
}
function bigimage_hide(){
$('img.indeximage').css('display','none').removeClass('vImage');
}
function bigimage_show(b){
$('img.indeximage#'+b+'').css('display','block').addClass('vImage');
}
function bigimage_rand(){
var x=Math.floor( Math.random( ) * (bigImage.length) );
bigimage_hide();
bigimage_show(bigImage[x]);
}
function reloads_baners(){
baner_rand();
if (!banBaners){
reload_basket_time=window.setTimeout("reloads_baners();", 10000);
}
}
function reloads_bigimage(){
bigimage_rand();
reload_basket_time=window.setTimeout("reloads_bigimage();", 6000);
}
var baners=[];
var bigImage=[];
$(document).ready(function() {
$('[rel="gallery"]').each(function(){
baners[baners.length]=$(this).attr('id');
});
$('img.indeximage').each(function(){
bigImage[bigImage.length]=$(this).attr('id');
});
var reload_basket_time = window.setTimeout("reloads_baners();", 1);
var reload_basket_time = window.setTimeout("reloads_bigimage();", 6000);
});
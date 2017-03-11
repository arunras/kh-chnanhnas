var st_search="Search...";
function getHTTPObject(){
	if (window.ActiveXObject) 
		return new ActiveXObject("Microsoft.XMLHTTP");
	else if (window.XMLHttpRequest) 
		return new XMLHttpRequest();
	else {
		alert("Your browser does not support AJAX.");
	return null;
	}
}
function getWHSreen(){
	 var viewportwidth;
	 var viewportheight; 
	 // the more standards compliant browsers (mozilla/netscape/opera/IE7) use window.innerWidth and window.innerHeight
	 if (typeof window.innerWidth != 'undefined'){
		  viewportwidth = window.innerWidth;
		  viewportheight = window.innerHeight;
	 }
	// IE6 in standards compliant mode (i.e. with a valid doctype as the first line in the document)
	 else if (typeof document.documentElement != 'undefined'
		 && typeof document.documentElement.clientWidth !=
		 'undefined' && document.documentElement.clientWidth != 0)
	 {
		   viewportwidth = document.documentElement.clientWidth;
		   viewportheight = document.documentElement.clientHeight;
	 }
	 // older versions of IE
	 else
	 {
		   viewportwidth = document.getElementsByTagName('body')[0].clientWidth;
		   viewportheight = document.getElementsByTagName('body')[0].clientHeight;
	 }
	 var obj=new Object();
	 obj.Width=viewportwidth;
	 obj.Heigth=viewportheight;
	 return obj;
	 
}
function getScrollXY()
{
	var x,y;
	x=document.documentElement.scrollLeft;
	y=document.documentElement.scrollTop;
	var XY = new Object();
	XY.x = x;
	XY.y = y;
	return XY;
}
function feedback(){
		/*var ele = document.getElementsByTagName('body')[0];
		var feed=document.createElement('div');
		var alink=document.createElement('a');
		alink.href='mailto:someone@camitss.com';
		var img =document.createElement('img');
		img.src='images/feedback.png';
		alink.appendChild(img);
		feed.appendChild(alink);
		feed.id='feedback';
		ele.appendChild(feed);
		feed.style.left=0;
		//feed.style.top=xy.Heigth;
		feed.style.top=220+"px";*/
		
	}
function getUrlParam(name)
{
	var url=window.location.toString();
	var tem=url.split("?");
	var reval="";
	for(i=0;i<tem.length;i++)
	{
		var avar=tem[i];
		var avar_name=avar.split("=")[0];
		if(avar_name==name){
			reval=avar.split("=")[1];
		}
	}
	return reval;
}
function getUrlPound(){
	var url=window.location.toString();
	var tem=url.split("#");
	var reval=tem[1];
	return reval;
}
function getUrlPoundLink(a){
	var url=a.href;
	var tem=url.split("#");
	var reval=tem[1];
	return reval;
}
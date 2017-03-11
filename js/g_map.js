var map=null;
var geocoder=null;
var start_address=null;
var start_pixel=null;
var start_marker=null;
var start_latlng=null;
var gdir=null;
var end_marker=null;

function FullScreenControl(){
}
FullScreenControl.prototype=new GControl();
FullScreenControl.prototype.initialize=function(){
	var container = document.createElement('div');
	var zoomInDiv = document.createElement('div');
	this.setButtonStyle_(zoomInDiv);
	container.appendChild(zoomInDiv);
	zoomInDiv.appendChild(document.createTextNode("Large"));
	zoomInDiv.appendChild(document.createTextNode("\nView"));
	GEvent.addDomListener(zoomInDiv,'click',function(){
		PopupCenter_MAP('include/map_fullsreen.php','Large View',1020,867);
		//alert("HI");
	});
	map.getContainer().appendChild(container);
	return container;
}
FullScreenControl.prototype.setButtonStyle_=function(button){
	button.style.textDecoration = "none";
	button.style.color = "#0000cc";
	button.style.backgroundColor = "#fffde3";
//	button.style.background="url(address.png)";
	button.style.font = "11px Arial";
	button.style.border = "1px solid black";
	button.style.padding="5px";
	button.style.padding="5px";
	button.style.marginBottom = "-5px";
	button.style.textAlign = "center";
	button.style.width = "3em";
	button.style.height = "3em";
	button.style.cursor = "pointer";
}
FullScreenControl.prototype.getDefaultPosition = function() {
      return new GControlPosition(G_ANCHOR_BOTTOM_RIGHT, new GSize(7, 7));
}
//End Of FullScreen Control

function CloseScreenControl(){
}
CloseScreenControl.prototype=new GControl();
CloseScreenControl.prototype.initialize=function(){
	var container = document.createElement('div');
	var zoomInDiv = document.createElement('div');
	this.setButtonStyle_(zoomInDiv);
	container.appendChild(zoomInDiv);
	zoomInDiv.appendChild(document.createTextNode("Close"));
	zoomInDiv.appendChild(document.createTextNode("\nWindow"));
	GEvent.addDomListener(zoomInDiv,'click',function(){
		window.close();
	});
	map.getContainer().appendChild(container);
	return container;
}
CloseScreenControl.prototype.setButtonStyle_=function(button){
	button.style.textDecoration = "none";
	button.style.color = "#0000cc";
	button.style.backgroundColor = "#fffde3";
//	button.style.background="url(address.png)";
	button.style.font = "11px Arial";
	button.style.border = "1px solid black";
	button.style.padding="5px";
	button.style.marginBottom = "0px";
	button.style.textAlign = "center";
	button.style.width = "3em";
	button.style.height = "3em";
	button.style.cursor = "pointer";
}
CloseScreenControl.prototype.getDefaultPosition = function() {
      return new GControlPosition(G_ANCHOR_BOTTOM_RIGHT, new GSize(7, 7));
}
//End of CloseScreencontrol
function getUrlParam(name)
{
	var url=window.location.toString();
	var tem=url.split("?")[1];
	var tem=tem.split("&");
	var reval="";
	for(i=0;i<tem.length;i++)
	{
		var avar=tem[i];
		var avar_name=avar.split("=")[0];
		if(avar_name==name){
			reval=avar.split("=")[1];
			return reval
		}
	}
	return reval;
}
function PopupCenter_MAP(pageURL, title,w,h) {
	//alert("HI");
	var left = (screen.width/2)-(w/2);
	var top = (screen.height/2)-(h/2);
	window.open (pageURL + "?city=" + getUrlParam('city')+"&height="+(h-300), "", 'toolbar=0, location=0, directories=0, status=0, menubar=0, scrollbars=1, resizable=1, copyhistory=0, width='+w+', height='+h+', top='+top+', left='+left);
	//window.open (pageURL + "?city=" + getUrlParam('city'),"mywindow","menubar=1,resizable=1,width=350,height=250");
	//return false;
}
function close_map(){
	GUnload();
}
function setStartAddress(start_pixel){
	var point = map.fromContainerPixelToLatLng(start_pixel);
	if(start_marker!=null) map.removeOverlay(start_marker);
	start_marker=addDirectionMarker(point.lat(), point.lng(), "http://go.buononavi.com/images/go.png");
	map.addOverlay(start_marker);
	if(start_marker && end_marker){
	  findDirection(start_marker,end_marker);
	}
	else{}
}
function setEndAddress(lat,lng){
	end_marker=addDirectionMarker(lat,lng, "");
	if(start_marker && end_marker){
		findDirection(start_marker,end_marker);
	}
	map.removeOverlay(end_marker);
	return false;
}
function findDirection(from, to) {
	gdir.clear();
	//gdir.load("from: " + fromAddress + " to: " + toAddress,{ "locale": locale });
	var points=[];
	points[0]=[from.getLatLng().lat(),from.getLatLng().lng()];
	points[1]=[to.getLatLng().lat(),to.getLatLng().lng()];              
	gdir.loadFromWaypoints(points,{getPolyline:true,getSteps:true,preserveViewport:false});
	map.removeOverlay(end_marker);
}
function addDirectionMarker(latitude,longitude,imageURL){
	var marker;
	if(imageURL!=null){
		var micon=new GIcon();
		micon.image=imageURL;
		micon.iconSize=new GSize(20,34);
		micon.iconAnchor=new GPoint(10,32);
		micon.infoWindowAnchor=new GPoint(10,32);
		micon.shadow="";
		marker=new GMarker(new GLatLng(latitude,longitude),{icon:micon,draggable:true});
	}
	else{
		marker=new GMarker(new GLatLng(latitude,longitude),{draggable:true});
	}
	marker.enableDragging();
	GEvent.addListener(marker,'dragend',function(){
		if(end_marker&&start_marker){
			findDirection(start_marker,end_marker);
		}
	});
	GEvent.addListener(marker,'click',function(){});
	//map.addOverlay(marker);
	return marker;
}
function show_map(city,url){
	if (GBrowserIsCompatible()) {
		url_path=url;
		map = new GMap2(document.getElementById("show_map"));
		map.addControl(new GLargeMapControl3D());
		map.addControl(new GMapTypeControl());
		map.setCenter(new GLatLng(11.557340, 104.925003), 14);
		map.enableScrollWheelZoom();
		map.setMapType(G_MAPMAKER_NORMAL_MAP);
		//map.setUIToDefault();
		//map.enableGoogleBar();
		gdir = new GDirections(map);
		if(url_path==""){
			map.addControl(new FullScreenControl());
		}
		else{
			map.addControl(new CloseScreenControl());
		}
		load_markers();
		GEvent.addListener(map,"singlerightclick",function(pixel,tile,overlay){
			start_pixel = pixel;
			var x=pixel.x;
			var y=pixel.y;
			var lng=map.fromDivPixelToLatLng(start_pixel);
			start_marker=new GMarker(lng,{draggable:true});
			map.clearOverlays();
			load_markers();
			setStartAddress(start_pixel);
			GEvent.addListener(start_marker,"dragstart",function(){});
			GEvent.addListener(start_marker,"dragend",function(){
				start_latlng=start_marker.getLatLng();
				setStartAddress(start_pixel);
			});
			
		});
	}
}
function load_markers(){
map.clearOverlays();
var city=getUrlParam("city");
GDownloadUrl(url_path+"get_data_xml.php?city="+city, function(data){
	var xml=GXml.parse(data);
	var markers = xml.documentElement.getElementsByTagName("restaurant");
	for(var i=0; i<markers.length;i++){
		var id=markers[i].getAttribute("id");
		var name=markers[i].getAttribute("name");
		var des=markers[i].getAttribute("description");
		var cuisine=markers[i].getAttribute("cuisine");
		var available=markers[i].getAttribute("available");
		var environment=markers[i].getAttribute("environment");
		var dinning=markers[i].getAttribute("dinning");
		var purpose=markers[i].getAttribute("purpose");
		var lastupdate=markers[i].getAttribute("lastupdate")
		
		var lattitude=markers[i].getAttribute("lattitute");
		var longtitude=markers[i].getAttribute("longtitute");
		var picture=markers[i].getAttribute("picture");
		var aceleda=markers[i].getAttribute("aceleda");
		var anz=markers[i].getAttribute("anz");
		var visa=markers[i].getAttribute("visa");
		var express=markers[i].getAttribute("express");
		var master=markers[i].getAttribute("master");
		var jcb=markers[i].getAttribute("jcb");
		var holiday=markers[i].getAttribute("holiday");
		var wifi=markers[i].getAttribute("wifi");
		var union=markers[i].getAttribute("union");
		var phone=markers[i].getAttribute("phone");
		//var point=new GLatLng(parseFloat(lattitude),parseFloat(longtitude));
		var ma=new create_marker(lattitude,longtitude,name,picture,des,anz,aceleda,visa,master,express,jcb,available,holiday,cuisine,environment,purpose,dinning,id,wifi,union,phone)
		map.addOverlay(ma);
	}
});
}
function jump_restaurant(id){
	window.close();
	window.open('../restaurant.php?resID='+id);
}
function zoom_out(){
	var current_zoom_level=map.getZoom();
	map.setZoom(current_zoom_level-1);
	return false;
}
function zoom_in(){
	var current_zoom_level=map.getZoom();
	map.setZoom(current_zoom_level+1);
	return false;
}
function create_marker(lat,lng,name,picture,des,anz,aceleda,visa,master,express,jcb,available,holiday,cuisine,environment,purpose,dinning,id,wifi,union,phone){
	//var gicon=GIcon(G_DEFAULT_ICON,"private.png");
	var point=new GLatLng(parseFloat(lat),parseFloat(lng));
	var payment="";
	if(wifi==1){ payment=payment+ "<img src='"+url_path+"images/wi-fi.jpg' title='wifi' />";}
	if(anz==1){ payment=payment+ "<img src='"+url_path+"images/anz.jpg' title='ANZ' />";}
	if(aceleda==1){ payment=payment+ "<img src='"+url_path+"images/gold_dot.jpg' title='ACLEDA' />";}
	if(visa==1){ payment=payment+ "<img src='"+url_path+"images/visa.jpg' title='Visa' />";}
	if(master==1){ payment=payment+ "<img src='"+url_path+"images/master.jpg' title='Master' />";}
	if(express==1){ payment=payment+ "<img src='"+url_path+"images/amex.jpg' title='A E'/>";}
	if(jcb==1){ payment=payment+ "<img src='"+url_path+"images/jcb.jpg' title='JCB' />";}
	if(union==1){ payment=payment+ "<img src='"+url_path+"images/union.jpg' title='Union' />";}
	var hour="";
	if(available!=""){
		var tem=available.split(";");
		if(tem[0]!="") hour=hour+"Breakfirst: " + tem[0] + "<br/>";
		if(tem[1]!="") hour=hour+"Lunch&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: " + tem[1] + "<br/>";
		if(tem[2]!="") hour=hour+"Dinner&nbsp;&nbsp;&nbsp;&nbsp;: " + tem[2] + "<br/>";
		if(tem[3]!="") hour=hour+"Super&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; " + tem[3] + "<br/>";
	}
	var cuisine_show="";
	if(cuisine!=""){
		var tem=cuisine.split(";");
		for(var i=0;i<tem.length;i++){
			if(tem[i]!="") cuisine_show=cuisine_show+tem[i]+"/";
		}
	}
	cuisine_show=cuisine_show.substring(0,cuisine_show.length-1);
	var environment_show="";
	if(environment!=""){
		var tem=environment.split(";");
		for(var i=0;i<tem.length;i++){
			if(tem[i]!="") environment_show=environment_show+tem[i]+"<br/>";
		}
	}
	environment_show=environment_show.substring(0,environment_show.length-5);
	var purpose_show="";
	if(purpose!=""){
		var tem=purpose.split(";");
		for(var i=0;i<tem.length;i++){
			if(tem[i]!="") purpose_show=purpose_show+tem[i]+"<br/>";
		}
	}
	purpose_show=purpose_show.substring(0,purpose_show.length-5);
	var dinning_show="";
	if(dinning!=""){
		var tem=dinning.split(";");
		for(var i=0;i<tem.length;i++){
			if(tem[i]!="") dinning_show=dinning_show+tem[i]+"<br/>";
		}
	}
	dinning_show=dinning_show.substring(0,dinning_show.length-5);
	
	var gicon = new GIcon(G_DEFAULT_ICON);
	gicon.image = "/images/private.png";

	var amarker=new GMarker(point,gicon);
	var htmlintroduction="<table cellpadding='0' cellspacing='10' width='300px'>"
	if(url_path==""){
		htmlintroduction+="<tr><td width='50%'><a href='restaurant.php?resID="+ id +"'><img src='"+ url_path+picture +"' height='100px' /></a></td><td width='50%' valign='top'><table height='100%' width='100%' border='0px' cellpadding='0' cellspacing='0'><tr valign='top' height='80px'><td><strong><a href='restaurant.php?resID=" + id + "'>" + name.replace(";","<br/>") + "</a></strong></td></tr><tr><td height='10%'><a href='#' onclick='return zoom_out();'>[Zoom Out]</a>&nbsp;|&nbsp;<a href='#' onclick='return zoom_in();'>[Zoom In]</a></td></tr></table>";
			}
	else{
		htmlintroduction+="<tr><td width='50%'><a href='#' onclick='jump_restaurant("+id+")'><img src='"+ url_path+picture +"' height='100px' /></a></td><td width='50%' valign='top'><table height='100%' width='100%' border='0px' cellpadding='0' cellspacing='0'><tr valign='top' height='80px'><td><strong><a href='#' onclick='jump_restaurant("+id+")'>" + name.replace(";","<br/>") + "</a></strong></td></tr><tr><td height='10%'><a href='#' onclick='return zoom_out();'>[Zoom Out]</a>&nbsp;|&nbsp;<a href='#' onclick='return zoom_in();'>[Zoom In]</a></td></tr></table>";
	}
	htmlintroduction+="</td></tr><tr><td colspan='2'>"+ des +"</td></tr></table><a href='#' onclick='return setEndAddress("+ lat + "," + lng +");'>Direction</a>";
	
	var htmlbasic="";
	htmlbasic="<table border='0px' bordercolor='#FFF' cellpadding='5' cellspacing='2' width='300px'><tr><td bgcolor='#FEF0F0' width='30%'><strong>Open Hour</strong></td><td width='70%' valign='top'>"+ hour +"</td></tr><tr><td bgcolor='#FEF0F0'><strong>Holidays</strong></td><td>"+ holiday +"</td></tr><tr><td bgcolor='#FEF0F0'><strong>Cuisine</strong></td><td>"+ cuisine_show +"</td></tr><tr><td bgcolor='#FEF0F0'><strong>Phone</strong></td><td><strong>"+ phone +"</strong></td></tr>";
	if(url_path==""){
		htmlbasic+="<tr><td colspan=2><a href='"+url_path+"restaurant.php?resID="+id+"'>[Restaurant Homepage]</a></td></tr><tr><td colspan='2'><br/>"+ payment +"</td></tr></table>";
	}
	else{
		htmlbasic+="<tr><td colspan=2><a onclick='jump_restaurant("+id+")' href='#'>[Restaurant Homepage]</a></td></tr><tr><td colspan='2'><br/>"+ payment +"</td></tr></table>";
	}
	var htmlfeature="<table cellpadding='0' width='300px' cellspacing='0'><tr><td width='50%'><h4>Environment</h4>"+environment_show+"<h4>Purpose & Scene</h4>"+purpose_show+"<h4>Dinning Option</h4>"+dinning_show+"</td></tr></table>";

	var infoTabs=[
					new GInfoWindowTab("Introduction", htmlintroduction),
					new GInfoWindowTab("Basic Info", htmlbasic)
				  ];
	//new GInfoWindowTab("Feature", htmlfeature)
	GEvent.addListener(amarker, 'click', function() {
		amarker.openInfoWindowTabsHtml(infoTabs);
	});
	return amarker;
}


$(function() {
	var totalPanels			= $(".scrollContainer").children().size();
		
	var regWidth			= $(".panel").css("width");
	var regImgWidth			= $(".panel img").css("width");
	var regImgHeight		= $(".panel img").css("height");
	var regTitleSize		= $(".panel h2").css("font-size");
	var regParSize			= $(".panel p").css("font-size");
	
	var movingDistance	    = 300;
	
	var curWidth			= 350;
	var curImgWidth			= 326;
	var curImgHeight		= 235;
	var curTitleSize		= "14px";
	var curParSize			= "12px";

	var $panels				= $('#slider .scrollContainer > div');
	var $container			= $('#slider .scrollContainer');

	$panels.css({'float' : 'left','position' : 'relative'});
    
	$("#slider").data("currentlyMoving", false);

	$container
		.css('width', ($panels[0].offsetWidth * $panels.length) + 100 )
		.css('left', "-350px");

	var scroll = $('#slider .scroll').css('overflow', 'hidden');

	function returnToNormal(element) {
		$(element)
			.animate({ width: regWidth})
			.find("img")
			.animate({ width: regImgWidth })
			.animate({ height: regImgHeight })
		    .end()
			.find("h2")
			.animate({ fontSize: regTitleSize })
			.end()
			.find("p")
			.animate({ fontSize: regParSize });
	};
	
	function growBigger(element) {
		$(element)
			.animate({ width: curWidth })
			.find("img")
			.animate({ width: curImgWidth })
			.animate({ height: curImgHeight })
		    .end()
			.find("h2")
			.animate({ fontSize: curTitleSize })
			.end()
			.find("p")
			.animate({ fontSize: curParSize });
	}
	
	//direction true = right, false = left
	function change(direction) {
	   
	    //if not at the first or last panel
		if((direction && !(curPanel < totalPanels)) || (!direction && (curPanel <= 1))) { return false; }	
        
        //if not currently moving
        if (($("#slider").data("currentlyMoving") == false)) {
            
			$("#slider").data("currentlyMoving", true);
			
			var next         = direction ? curPanel + 1 : curPanel - 1;
			var leftValue    = $(".scrollContainer").css("left");
			var movement	 = direction ? parseFloat(leftValue, 10) - movingDistance : parseFloat(leftValue, 10) + movingDistance;
		
			$(".scrollContainer")
				.stop()
				.animate({
					"left": movement
				}, function() {
					$("#slider").data("currentlyMoving", false);
				});
			
			returnToNormal("#panel_"+curPanel);
			growBigger("#panel_"+next);
			
			curPanel = next;
			
			//remove all previous bound functions
			$("#panel_"+(curPanel+1)).unbind();	
			
			//go forward
			$("#panel_"+(curPanel+1)).click(function(){ stop_slide(); change(true);});
			
            //remove all previous bound functions															
			$("#panel_"+(curPanel-1)).unbind();
			
			//go back
			$("#panel_"+(curPanel-1)).click(function(){ stop_slide();change(false); }); 
			
			//remove all previous bound functions
			$("#panel_"+curPanel).unbind();
		}
	}
		
	function stop_slide(){clearInterval(run_left); run_left = null;clearInterval(run_right); run_right = null;}
	// Set up "Current" panel and next and prev
	growBigger("#panel_3");	
	var curPanel = 3;
	
	$("#panel_"+(curPanel+1)).click(function(){ stop_slide(); change(true);});
	$("#panel_"+(curPanel-1)).click(function(){ stop_slide();change(false);}); //clearInterval(startI);startI=null; 
	
	//when the left/right arrows are clicked
	$(".right").click(function(){ stop_slide(); change(true);});	
	$(".left").click(function(){ stop_slide(); change(false);});
	var run_left=null,run_right=null;
	run_right=setInterval(runImageRight,2500);
	function runImageLeft()
	{
		change(false);
		if(curPanel==1){
			clearInterval(run_left);
			run_left=null;
			run_left=setInterval(runImageRight,2500);
		}
		//document.getElementById('test_track').innerHTML=curPanel +"  " +totalPanels;
	} 
	function runImageRight(){
		change(true);
		if(curPanel==totalPanels){
			clearInterval(run_right);
			run_right=null;
			run_left=setInterval(runImageLeft,2500);
		}
		//document.getElementById('test_track').innerHTML=curPanel +"  " +totalPanels;
	}
	//var start_stop = setInterval( runImage ,100 );
	
	$(window).keydown(function(event){
	  switch (event.keyCode) {
			case 13: //enter
				$(".right").click();
				break;
			case 32: //space
				$(".right").click();
				break;
	    case 37: //left arrow
				$(".left").click();
				break;
			case 39: //right arrow
				$(".right").click();
				break;
	  }
	});
	
});
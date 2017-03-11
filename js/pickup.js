$(document).ready(function(){
    $("#fcontent.forpickup").find("textarea").cleditor();
    
    $("#facebox.forpickup").find("div.close").click(function(){
        $("#facebox.forpickup").hide(200);
    });
       
});

function show_pickup_des(e){
    XY = getXY(e);
    $("#facebox.forpickup").css("top", XY.y + "px");
    $("#facebox.forpickup").css("left", XY.x + "px");

    $('#facebox.forpickup').css("visibility", "visible");        
    $('#facebox.forpickup').show(200);
    
    $("#facebox.forpickup").find("button").click(function(){
        $.post(
            "include/save_pickup_description.php",
            $(this).closest("form").serialize(),
            function(){
                alert("Save Successfully.");
                $("#facebox.forpickup").find("div.close").trigger("click");
            }
        );
        return false;
    });
    
    return false;
}
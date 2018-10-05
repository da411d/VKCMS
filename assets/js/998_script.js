function reInitFooter(){
	$("body").css("margin-bottom", $(".footer").height() + 32 + "px");
}
$(this).on("resize", reInitFooter);
$(this).ready(reInitFooter);
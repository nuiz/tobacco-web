/*-----------------------------------------------------------------------------------*/
/*	jQuery for MassivePixelCreation Custom Shortcodes
/*	version 1.0
/*-----------------------------------------------------------------------------------*/

jQuery(document).ready(function($){
/* Toggle Handler */
	$(".toggle-content").hide();
	$("div.toggle-header").click(function(){
		$(this).toggleClass("active").next().slideToggle("normal");
		$(this).find('h3').toggleClass("active").next().slideToggle("normal");
		return false;
	});
/* End Toggle Handler */
});
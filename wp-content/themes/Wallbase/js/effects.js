jQuery(document).ready(function() {

/* Navigation */
jQuery('#submenu ul.sf-menu').superfish({ 
		delay:       500,								// 0.1 second delay on mouseout 
		animation:   {opacity:'show',height:'show'},	// fade-in and slide-down animation 
		dropShadows: true		// disable drop shadows 
	
	});	

/* Menu Show/Hide */

jQuery("#botmenu").hide();
jQuery(window).load(function()  {
jQuery('#botmenu').slideDown(1000, function() {
    jQuery('.trig').addClass("trigu");
	});
});

jQuery('.strigger').toggle(function(){

	jQuery('#botmenu').slideUp(500, function() {
    jQuery('.trig').removeClass("trigu");
	});
	}, function(){
	jQuery('#botmenu').slideDown(1000, function() {
    jQuery('.trig').addClass("trigu");
	});
	});

	
	
/* Prettyphoto	 */
	
jQuery("a[rel^='prettyPhoto']").prettyPhoto({theme: 'pp_default',overlay_gallery: true });
	
	
	
	
});
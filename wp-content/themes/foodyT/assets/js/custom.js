var winHeight = jQuery(window).height();
var winfooterHeight = jQuery("footer.site-footer").outerHeight();
var winheaderHeight = jQuery("#masthead").outerHeight();
var totalHeight =  winHeight - winfooterHeight; 

jQuery(document).ready(function(){
	  
	jQuery(".fheight").css('height',totalHeight);
	jQuery(".fheight").css('padding-top',winheaderHeight);
});

jQuery(document).ready(function(){
	  
	jQuery(".home .fheight").css('height',winHeight);
	jQuery(".home .fheight").css('padding-top',winheaderHeight);
});


/* Responsive search page  */

jQuery(document).ready(function(){
	  
	jQuery(".toggleSearch").click(function(){
		jQuery(".search-res").slideToggle();
		
	});
	
	jQuery(".toggleSearch1").click(function(){
		jQuery("#menu-sidebar-menu").slideToggle();
		
	});
	
});


/* Search page end  */


jQuery(window).resize(function(){
var winHeight = jQuery(window).height();
var winfooterHeight = jQuery("#header").outerHeight();
var winheaderHeight = jQuery("#masthead").outerHeight();
var totalHeight =  winHeight - winfooterHeight; 
	// alert(totalHeight);
	jQuery(".fheight").css('height',totalHeight);
	jQuery(".fheight").css('padding-top',winheaderHeight);
});



jQuery(window).resize(function(){
var winHeight = jQuery(window).height();
var winfooterHeight = jQuery(".home #header").outerHeight();
var winheaderHeight = jQuery(".home #masthead").outerHeight();
//var totalHeight =  winHeight - winfooterHeight; 
	// alert(totalHeight);
	jQuery(".home .fheight").css('height',winHeight);
	jQuery(".home .fheight").css('padding-top',winheaderHeight);
});


jQuery(window).scroll(function() {
if (jQuery(this).scrollTop() > 1){  
    jQuery('header#masthead').addClass("sticky");
     var srcImg = jQuery('#blackLogoHidden').val();
    jQuery('#whiteLogo').attr("src",srcImg);

  }
  else{
    jQuery('header#masthead').removeClass("sticky");
    var srcImg = jQuery('#whiteLogoHidden').val();
    jQuery('#whiteLogo').attr("src",srcImg);

  }
});



jQuery(window).scroll(function() {
if (jQuery(this).scrollTop() > 100){  
    jQuery('#s_detail_header').addClass("sticky");

  }
  else{
    jQuery('#s_detail_header').removeClass("sticky");
  }
});


/* Responsive Menu Start */


var ww = document.body.clientWidth;
jQuery(document).ready(function() {
    jQuery(".primary-menu li a").each(function() {
        if (jQuery(this).next().length > 0) {
            jQuery(this).addClass("parent");
        };
    })
    jQuery(".toggleMenu").click(function(e) {
        e.preventDefault();
        jQuery(this).toggleClass("active");
        jQuery(".primary-menu").slideToggle();
    });
    adjustMenu();
})
jQuery(window).bind('resize orientationchange', function() {
    ww = document.body.clientWidth;
    adjustMenu();
});
var adjustMenu = function() {
    if (ww <= 1024) {
        jQuery(".toggleMenu").css("display", "inline-block");
        if (!jQuery(".toggleMenu").hasClass("active")) {
            jQuery(".primary-menu").hide();
        } else {
            jQuery(".primary-menu").show();
        }
        jQuery(".primary-menu li").unbind('mouseenter mouseleave');
        jQuery(".primary-menu li a.parent").unbind('click').bind('click', function(e) {
            e.preventDefault();
            jQuery(this).parent("li").toggleClass("hover");
        });
    } else if (ww >= 1024) {
        jQuery(".toggleMenu").css("display", "none");
        jQuery(".primary-menu").show();
        jQuery(".primary-menu li").removeClass("hover");
        jQuery(".primary-menu li a").unbind('click');
        jQuery(".primary-menu li").unbind('mouseenter mouseleave').bind('mouseenter mouseleave', function() {
            jQuery(this).toggleClass('hover');
        });
    }
}

/* Responsive End Start */

jQuery(document).ready(function(){

if (jQuery(window).width() < 767) {
   jQuery( "#loginform input, #home .search input#searchHomePage" ).focusin(function() {
		jQuery('header#masthead').addClass('fixed');
	});
	
	 jQuery( "#loginform input, #home .search input#searchHomePage" ).blur(function() {
		jQuery('header#masthead').removeClass('fixed');
	});
	 
}
else{
	
 jQuery( "#loginform input, #home .search input#searchHomePage" ).focusout(function() {
		jQuery('header#masthead').removeClass('fixed');
	});

}
});




jQuery(function() {

jQuery('div#menu').mmenu({ 
 position  : "right",
zposition : "front",
clone: false  

});

});
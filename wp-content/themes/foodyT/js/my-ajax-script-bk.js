jQuery("document").ready(function () {
        jQuery("#cancelSubscription").click(function() {
        	var result = confirm("Are you sure you want to cancel Subscription?");
			if (result) {
				         var userId = jQuery("#getUserId").val();
			        	 jQuery.ajax({
					         type : "post",
					         url : myAjax.ajaxurl,
					         data : {action: "update_plan",userId: userId},
							success:function(data){
						      jQuery(".cancelSus").show();
						      jQuery('html, body').animate({scrollTop:0}, 'slow');
							  setTimeout(function(){  window.location.reload(true); }, 5000);
							}
			            });
			        }
        	   });

                jQuery(".catMenu li").click(function() {
                	var idName = jQuery(this).find('a').attr('idname');
						jQuery('.catMenu li').removeClass('active');
	                	jQuery(this).addClass('active');
						jQuery('html, body').animate({
				        'scrollTop' : jQuery("#"+idName).position().top-50
				       });


                });

                jQuery('.dish img').on('click', function () {
			         var image = jQuery(this).attr('src');
			         jQuery(".showimage").attr("src", image);
			       
			    });

			     jQuery('.lang').on('click', function () {
			        window.location.reload();
			       
			    });

			  jQuery('.icons li').click(function(){
				jQuery('.icons li').removeClass('active');
				jQuery(this).addClass('active');
				var iconName = jQuery(this).attr('iconName');
				var placeHolder = jQuery(this).attr('placeHolder');
				jQuery('#searchHomePage').attr('name',iconName);
				jQuery('#searchHomePage').attr('placeholder',placeHolder);
		});



           });

//#setcookie("googtrans", "/en/es", time()+3600, "/", "www.cmsbox.in/wordpress/foodyT/");
//#setcookie("googtrans", "/en/es", time()+3600, "/", ".cmsbox.in/wordpress/foodyT/");

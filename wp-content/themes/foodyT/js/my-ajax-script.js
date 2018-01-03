jQuery("document").ready(function () {
	
	  jQuery(".paymentReminder").click(function() {
		   var r = confirm("Are you sure want to Send Offline Payment Reminder?");
			if (r == true) {
				  var post_id = jQuery(this).data('postid');
				  jQuery.ajax({
							 type : "post",
							 url : myAjax.ajaxurl,
							 data : {action: "offlinePayment",postid: post_id},
							 success:function(data){
								// alert(data);
								 jQuery("#offlinePaymentMsg").show();
							  }
					   });
				}
		});
	
	//jQuery('#acf-plan_type input').attr('readonly');
	jQuery('#acf-plan_type select').prop('disabled', true);

         jQuery(".twitCountId").click(function() {
	      var dish_id = jQuery(this).data('dishid');
                	 jQuery.ajax({
					         type : "post",
					         url : myAjax.ajaxurl,
					         data : {action: "twitCount",dishId: dish_id},
							success:function(data){
								// alert(data);
						      }
			            });
			 });

    //      jQuery(".catMenu li a").click(function() {
	   //    var catId = jQuery(this).data('catid');
    //             	 jQuery.ajax({
				// 	         type : "post",
				// 	         url : myAjax.ajaxurl,
				// 	         data : {action: "setCatId",catId: catId},
				// 			success:function(data){
				// 				window.location.reload(true);
				// 		      }
			 //            });
			 // });

         jQuery(".fbCount").click(function() {
	      var dish_id = jQuery(this).data('dishid');
                	 jQuery.ajax({
					         type : "post",
					         url : myAjax.ajaxurl,
					         data : {action: "fbCount",dishId: dish_id},
							success:function(data){
								// alert(data);
						      }
			            });
			 });
         
    if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
	      jQuery(".whatsCount").click(function() {
	      	      var dish_id = jQuery(this).data('dishid');
			        	 jQuery.ajax({
					         type : "post",
					         url : myAjax.ajaxurl,
					         data : {action: "whatsupCount",dishId: dish_id},
							success:function(data){
						      }
			            });
			 });
	 }

        jQuery("#cancelSubscription").click(function() {
        	var result = confirm("Are you sure you want to cancel Subscription?");
			if (result) {
				         jQuery("#ajaxLoaderUpdate").show();
				         var userId = jQuery("#getUserId").val();
			        	 jQuery.ajax({
					         type : "post",
					         url : myAjax.ajaxurl,
					         data : {action: "update_plan",userId: userId},
							success:function(data){
						      jQuery(".cancelSus").show();
						      jQuery("#ajaxLoaderUpdate").hide();
						      jQuery('html, body').animate({scrollTop:0}, 'slow');
							  setTimeout(function(){  window.location.reload(true); }, 5000);
							}
			            });
			        }
        	   });

          jQuery("#email").blur(function() {
				         var userEmail = jQuery("#email").val();
			        	 jQuery.ajax({
					         type : "post",
					         url : myAjax.ajaxurl,
					         data : {action: "emailIdTest",email: userEmail},
							success:function(data){
								if(data){
									jQuery("#email_exit").show();
									jQuery("#email").css({
										"border-color": "red",
									    "border-width":"1px",
									   "border-style":"solid"
									});
									}else{jQuery("#email_exit").hide();
									jQuery("#email").css({
										"border-color": "#ccc",
									    "border-width":"1px",
									   "border-style":"solid"
									});
								}
						
							 }
			            });
			         });

          jQuery(".comment_form").submit(function(e) {
          	   e.preventDefault();
          	   var formData = jQuery(this).serialize();
			        	 jQuery.ajax({
					         type : "post",
					         url : myAjax.ajaxurl,
					         data: formData + '&action=rating_form',
							success:function(data){
								jQuery(".ratingSucess").show();
								jQuery(".comment_title").val('');
								jQuery(".comment_description").val('');
								jQuery('input[name="star"]').prop('checked', false);
								setTimeout(function(){ 
									 jQuery(".ratingSucess").fadeOut(); 
									// document.getElementById('fblogout').click();

								 }, 3000);


							}
			            });

			        
        	   });


  jQuery(".imgFlag").click(function() {
				         var lanCode = jQuery(this).attr('data-value');
			        	 jQuery.ajax({
					         type : "post",
					         url : myAjax.ajaxurl,
					         data : {action: "change_language",lang: lanCode},
							 success:function(data){
						      //jQuery(".cancelSus").show();
						      //jQuery('html, body').animate({scrollTop:0}, 'slow');
							  window.location.reload(true);
							}
			            });
			       
        	   });



        jQuery(".singlePageFlag li a").click(function(e) {
				var href_info = jQuery(this).attr('datahref');
	        	jQuery.ajax({
			         type : "post",
			         url : myAjax.ajaxurl,
			         data : {action: "change_language"},
					 success:function(data){
				      //jQuery(".cancelSus").show();
				      //jQuery('html, body').animate({scrollTop:0}, 'slow');
					 window.location.href =href_info;

					}
	            });
			       
        	   });
var winwidth = jQuery(window).width();
if(winwidth<=767){
	jQuery(".desktopCat a").click(function(){
		var idName = jQuery(this).attr('idname');
		jQuery('.desktopCat').removeClass('active');
		jQuery(this).addClass('active');
		jQuery('.close').trigger('click');
		jQuery('html, body').animate({
	    'scrollTop' : jQuery("#"+idName).position().top-50
	   },1000);
	});
}else{
	jQuery(".desktopCat a").click(function(){
		var idName = jQuery(this).attr('idname');
		jQuery('.desktopCat').removeClass('active');
		jQuery(this).addClass('active');
		jQuery('.close').trigger('click');
		jQuery('html, body').animate({
	    'scrollTop' : jQuery("#"+idName).position().top-80
	   },1000);
	});
}
jQuery(".mobileCat a").click(function(){
	var idName = jQuery(this).attr('idname');
	jQuery('.mobileCat').removeClass('active');
	jQuery(this).addClass('active');
	jQuery('.close').trigger('click');
	jQuery('html, body').animate({
    'scrollTop' : jQuery("#"+idName).position().top-80
   },1000);
});



       jQuery(".list-view").click(function() {
       	$('.mobileCat').attr("style", "display: block !important");
       	$('.desktopCat').attr("style", "display: none !important");

       });
       jQuery(".grid-view").click(function() {
       $('.mobileCat').attr("style", "display: none !important");
       	$('.desktopCat').attr("style", "display: block !important");

       });



        jQuery('.mainDishImg').on('click', function () {
	         var image = jQuery(this).attr('src');
	         jQuery(".showimage").attr("src", image);
	       
	    });

               jQuery("body").on('keypress', '.priceFiled,.s_price' , function(event){
			        var key = window.event ? event.keyCode : event.which;
				    if (event.keyCode === 8 || event.keyCode === 46 || event.keyCode === 80 
				    	|| event.keyCode === 83 || event.keyCode === 77 || event.keyCode === 47 
				    	|| event.keyCode === 112 || event.keyCode === 115 || event.keyCode === 109) {
				        return true;
				    } else if ( key < 48 || key > 57 ) {
				        return false;
				    } else {
				    	return true;
				    }
			    });
    //            $('.priceFiled,.s_price').keypress(validateNumber);

				// function validateNumber(event) {
				//     var key = window.event ? event.keyCode : event.which;
				//     if (event.keyCode === 8 || event.keyCode === 46 || event.keyCode === 80 || event.keyCode === 83 || event.keyCode === 77 || event.keyCode === 47) {
				//         return true;
				//     } else if ( key < 48 || key > 57 ) {
				//         return false;
				//     } else {
				//     	return true;
				//     }
				// };
    

			//      jQuery('.lang').on('click', function () {
			//      	var ss = jQuery(this).attr("languageVal");
			//      	//alert("hello");
			//      	checkCookie();
			//      	//alert(ss);
			//      	window.location.href=ss;
			//      	window.location.reload();


			       
			//     });



			// 	function setCookie(cname,cvalue,exdays) {
			//     var d = new Date();
			//     d.setTime(d.getTime() + (exdays*24*60*60*1000));
			//     var expires = "expires=" + d.toGMTString();
			//     document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/; domain=.cmsbox.in";
			//     }

			//   //   function delete_cookie ( cookie_name, valid_domain )
			// 		// {
			// 		// 	alert("chalna");
			// 		// // https://www.thesitewizard.com/javascripts/cookies.shtml
			// 		// var domain_string = valid_domain ? ("; domain=" + valid_domain) : '' ;
			// 		// document.cookie = cookie_name + "=; max-age=0; path=/" + domain_string ;
			// 		// }



			
			// function checkCookie() {

			//            // var user;
			//            // user = lan;

		 //            //    setCookie("googtrans", user, 30);
			//            setCookie("selectLan", 'spani', 30);
			//             // delete_cookie( "selectLan", ".cmsbox.in" );

			//  }


			  jQuery('.icons li').click(function(){
				jQuery('.icons li').removeClass('active');
				jQuery(this).addClass('active');
				var iconName = jQuery(this).attr('iconName');
				var placeHolder = jQuery(this).attr('placeHolder');
				jQuery('#searchHomePage').attr('name',iconName);
				jQuery('#searchHomePage').attr('placeholder',placeHolder);
		});


});

function Viewdish(dishid)
{
       	jQuery(".ratingSucess").hide();
        jQuery.ajax({
         type : "post",
         url : myAjax.ajaxurl,
         data : {action: "viewdish",dishid: dishid},
                success:function(data)
                {
                 //alert(data);
                }
        });
}

          

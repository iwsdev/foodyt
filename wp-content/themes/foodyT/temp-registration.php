<?php
/*
Template Name:registration page
*/
get_header();  
global $wpdb;

 //$title = 'Buns $ jai * <> @ ^ ) jaii raj & hh';
 //$title = html_entity_decode($title);

               // $new_post = array(
				//'post_title'	=>	$title,
				//'post_content'	=>	'tseting',
				//'post_status'	=>	'publish',           // Choose: publish, preview, future, draft, etc.
				//'post_type'	=>	'post'  //'post',page' or use a custom post type if you want to
				//);
			    // $pid = wp_insert_post($new_post,true);

          // die;



 //echo "<pre>";
			//print_r($_SESSION['currInfo']);
			//print_r($_SESSION['image']);
			//echo "<br>pid".$_SESSION['pid'];
			//echo "<br>ppid".$_SESSION['ppid'];
			//echo "<br>uid".$_SESSION['uid'];
               //unset($_SESSION['pid']);
               //unset($_SESSION['uid']);
               //unset($_SESSION['userId']);
               //unset($_SESSION['currInfo']);
               //unset($_SESSION['image']);
$cuisine = $wpdb->prefix."cuisine";
$posttable = $wpdb->prefix."posts";
if(isset($_SESSION['pid']))
{
   $pageId = $_SESSION['pid'];// If payment fail get the post id
}
else
{
	$pageId=0;
}
$currInfo = $_SESSION['currInfo'];// If payment fail get the form detail data
$logoPostId = get_post_meta($pageId, 'logo_image', true);
$resultLogo = $wpdb->get_row("SELECT guid FROM $posttable WHERE ID = $logoPostId ", ARRAY_A);
$logoImg = $resultLogo['guid'];
$bannerPostId = get_post_meta($pageId, 'banner_image', true);
$resultBanner = $wpdb->get_row("SELECT guid FROM $posttable WHERE ID = $bannerPostId", ARRAY_A);
$bannerImg = $resultBanner['guid'];
//echo "<pre>";
//print_r($currInfo);
?>
<input type="hidden" id="siteUrl" value="<?php echo site_url();?>"><!--To get site url in js -->
<div class="loader-overlay ajaxLoaderImg" id="ajaxLoaderImg" style="display:none;">
        <div class="a-loader" style="text-align: center;">
           <p id="addOnMsgPayment" class="addOnMsgPayment">Please wait, we are processing...</p>
           <img style="width:40px;" src="<?Php echo get_template_directory_uri()?>/assets/images/ajax-loader.gif">
        </div>
 </div>

<form id="myform" method="post" action="<?php echo site_url(); ?>/thank-you" enctype="multipart/form-data">
<section id="digital_menu_form1" class="digital_menu_form2">
<div class="container">

   <div class="row">
			    <div class="col-sm-6">
					  	 <div class="form-group">
					      <label for="restaurantName"><?= $_SESSION['lan']['restaurant_name']?></label>
					      <input type="text" class="form-control" name="restaurantName" id="restaurantName" placeholder="<?= $_SESSION['lan']['restaurant_name']?>" value="<?= $currInfo['restaurantName'] ?>">
					    </div>

					    <div class="form-group">
					      <label for="restaurantDescription"><?= $_SESSION['lan']['restaurant_description']?></label>
					       <textarea name="restaurantDescription" class="form-control" id="restaurantDescription" placeholder="<?= $_SESSION['lan']['restaurant_description']?>" ><?= $currInfo['restaurantDescription'] ?></textarea>
					    </div>

					    <div class="form-group">
					      <label for="address"><?= $_SESSION['lan']['address']?></label>
					      <textarea name="address" class="form-control" id="address" placeholder="<?= $_SESSION['lan']['address']?>"><?= $currInfo['address'] ?></textarea>
					    </div>
					  <div class="form-group">
							<label for="m_number"><?= $_SESSION['lan']['mobile_no']?></label>
							<input type="text" name="mobileNumber" class="form-control" id="m_number" placeholder="<?= $_SESSION['lan']['mobile_placeholder']?>" value="<?= $currInfo['mobileNumber'] ?>">
					  </div>
					
				<div class="form-group language" id="">
					<label for="pwd" class="pwd"><?= $_SESSION['lan']['languageText']?></label>
					<select  name='language[]' id='selectlan' multiple='multiple'>
				<?php
	               $EnlanList = array('Spanish'=>'Spanish','English'=>'English','French'=>'French','Italian'=>'Italian','japanese'=>'japanese');
	               $EslanList = array('Spanish'=>'Español','English'=>'Inglés','French'=>'Francés','Italian'=>'Italiano','japanese'=>'Japonés');
                   $lanListNew = $currInfo['language'];	
					if($_SESSION['lanCode']=='' || $_SESSION['lanCode']=='es'){
						 foreach($EslanList as $key=>$val){
							  if(in_array($key,$lanListNew)){
								echo $selected="selected";
							  } else{
								$selected="";
							  }
				  	       echo "<option $selected value=".$key."> $val</option>";
				  	    }
					  }
				 else if($_SESSION['lanCode']=='' || $_SESSION['lanCode']=='en'){
						 foreach($EnlanList as $key=>$val){
							 if(in_array($key,$lanListNew)){
								echo $selected="selected";
							  } else{
								$selected="";
							  }
				  	       echo "<option $selected value=".$key."> $val</option>";
				  	    }
				 }
					
				?>
				 </select>
				<label  id="error-chekLanguage" >Please select at least one language.</label>

              </div>
					
						   <div class="row becon">
								<!--<div class="col-sm-4 pop">
						       <div class="title">Beacon <a href="#" data-toggle="modal" data-target="#beconModal" class="beacon-pop"><i class="fa fa-question-circle-o" aria-hidden="true"></i></a></div>
						       <label class="checkbox-inline"><input type="checkbox"  id="beacon"  name="additionalCharge[]" value="5"><span><?= $_SESSION['lan']['yes_i_want']?></span></label>
						        <div class="price">*<?php //echo get_post_meta(167,'beacon_price',true);?>€ <?php //echo $_SESSION['lan']['addition']?></div>
						       </div>-->
						    <div class="col-sm-6 pop">
						       <div class="title"><?= $_SESSION['lan']['monthly_report'][0]?> <a href="#" data-toggle="modal" data-target="#monthlyReportModal" class="beacon-pop"><i class="fa fa-question-circle-o" aria-hidden="true"></i></a></div>
						       <label class="checkbox-inline"><input type="checkbox" checked="" id="monthlyReport"  name="monthlyReport" value="1"><span><?= $_SESSION['lan']['yes_i_want']?></span></label>

						    </div>
						    <div class="col-sm-6 pop" >
						    <div class="title"><?= $_SESSION['lan']['photograph'][0]?> <a href="#" data-toggle="modal" data-target="#photographModal" class="beacon-pop"><i class="fa fa-question-circle-o" aria-hidden="true"></i></a></div>
						       <label class="checkbox-inline"><input type="checkbox"  <?php if($currInfo['photographs_by_foodyt_tram_price']!=0){echo "checked";}?> id="photograph" name="photograph" value="<?php echo get_post_meta(167,'photographs_by_foodyt_tram_price',true);?>"><span><?= $_SESSION['lan']['yes_i_want']?></span></label>
						       <div class="price">*<?php echo get_post_meta(167,'photographs_by_foodyt_tram_price',true);?>€ <?= $_SESSION['lan']['addition']?></div>

						    </div>
						   </div>
						</div>


			
			<div class="col-sm-6">
			<div class='row imgData'>	
			    <div class="col-md-8">
				  <div class="form-group">
				   <label for="fileupload">Logo</label>
				     	<input   name="fileupload" id="fileupload" class="fileupload" tabindex="35" type="file">
				  </div>
				  <label  id="error-logo" ><?= $_SESSION['lan']['error_registration']['valid_img']?>.</label>

				 </div>
				 <div class="col-md-4 centerImg">
					<figure>
						<img class="acf-image-image" src="<?php if($logoImg){echo $logoImg;} else { echo get_template_directory_uri();?>/assets/images/<?php echo  $_SESSION['lan']['prev_img']; } ?>" alt="">
					</figure>

				 </div>
			  </div>


			  <div class='row imgData'>	
			    <div class="col-md-8">
				  <div class="form-group">
			       <label for="bannerImage"><?= $_SESSION['lan']['banner_img']?></label>
			     	<input   name="bannerImage" id="bannerImage" class="bannerImage" tabindex="35" type="file">
			      </div>
			      <label  id="error-banner" ><?= $_SESSION['lan']['error_registration']['valid_img']?></label>

				 </div>
				<div class="col-md-4 centerImg">
					<figure>
						<img class="acf-image-image" src="<?php if($bannerImg){echo $bannerImg;} else { echo get_template_directory_uri();?>/assets/images/<?php echo  $_SESSION['lan']['prev_img']; } ?>" alt="">
				   </figure>

				 </div>
			  </div>

			
			  <div class="form-group" style="position:relative;">
				  <label for="cuisine"><?= $_SESSION['lan']['kind_cuision']?></label>
				  <select class="form-control" name="cuisine[]" id="selectCusine" multiple="multiple">
				  <?php
				  $results = $wpdb->get_results("SELECT * FROM $cuisine");
				  
				  foreach($results as $key){
				  	 $status = $key->status;
					  if($status==1){
					  	if($_SESSION['lanCode']=='' || $_SESSION['lanCode']=='es')
						  {	
						    $cuisine = $key->cuisine_name_es;
						  }
						  else
						  {
							$cuisine = $key->cuisine_name;
						  }
						$cusionList = $currInfo['cuisine'];	
						if(in_array($cuisine,$cusionList)){
							echo $selected="selected";
						} else{
							$selected="";
						}
				  	    echo "<option $selected value='$cuisine'> $cuisine</option>";
				  	   }
				  	 }
				  ?>    
				  </select>
				  
				  <label  id="error-cusine" ><?= $_SESSION['lan']['error_registration']['select_cuisine']?>.</label>
				</div>
          <div class="recieve-form">
				<div class="wrap">
					
				<p><?php
				if($_SESSION['lanCode']=='' || $_SESSION['lanCode']=='es')
				 { 
				   echo get_post_meta(167,'green_box_text_es',true);
			     }
			     else
			     {
				   echo get_post_meta(167,'green_box_text_en',true);
			     }
				?>
					
				</p>

				</div>
		   </div>
			 </div>

			 </div>
			 <div class="row">
				 <div class="col-md-12 formbtn">
			    <a id="createNow"><?= $_SESSION['lan']['create_now']?></a>
			  </div>
			 </div>
</div>
</section>




<section id="digital_menu_form2" class="digital_menu_form2">
	<div class="container">
		<div class="errMsgPaymentFail">
	      <?php echo $_SESSION['error'];?>
        </div>
		<div class="row">
				<div class="col-md-6 left">
					<div class="account_information">
						<h3><?= $_SESSION['lan']['account_info']?></h3>
							<div class="form-group">
								<input type="email" name="email" class="form-control" id="email" placeholder="Email" value="<?= $currInfo['email'] ?>">
								<p id="email_exit" style="color:red;display:none;"><?= $_SESSION['lan']['error_registration']['emailExit']?></p>
							</div>
						  
					  </div>
         
		 <div class="form-group">
            <label class="control-label" for="">Payment Method Selection<span class="symbol required"></span></label>
           <select  class="form-control"  name="payment_method" id="payment_method">
			   <option value="">--Select Payment Method---</option>
			   <option <?php if($currInfo['payment_method']=='Credit or debit Card'){echo "selected";}?> value="Credit or debit Card"><?= $_SESSION['lan']['Creditor_debitcard'];?></option>
			   <option <?php if($currInfo['payment_method']=='Paypal'){echo "selected";}?> value="Paypal">Paypal</option>
		   </select>
        </div>

	<!--Start of payment box section-->
		<div id="paymentBox" style="display:none;">			
		 <h3>Enter Your Payment Details</h3>
          <p class="payment-errors"></p>
          

          <div class="form-group">
            <label class="control-label" for="">First Name<span class="symbol required"></span></label>
            <input type="text" id="credit_card_fname" value="<?= $currInfo['credit_card_fname'] ?>" name= 'credit_card_fname' class="form-control" value="<?= $credit_card_name?>">
          </div>
					
		<div class="form-group">
            <label class="control-label" for="">Last Name<span class="symbol required"></span></label>
            <input type="text" id="credit_card_lname" value="<?= $currInfo['credit_card_lname'] ?>" name= 'credit_card_lname' class="form-control" value="<?= $credit_card_lname?>">
          </div>
			
		<div class="form-group">
            <label class="control-label" for="">Card Number <span class="symbol required"></span></label>
            <input type="tel" size="20" id="credit_card_number" value="<?= $currInfo['credit_card_number'] ?>" name= 'credit_card_number' class="form-control" data-stripe="number" >
         </div>

        <div class="form-group">
               <label class="control-label" for="">Expiration Date<span class="symbol required"></span></label>
               <div class="card-det">
                <input type="text" id="exp_month" class="form-control" value="<?= $currInfo['exp_month'] ?>"  size="2" data-stripe="exp_month" name="exp_month" value="<?= $exp_month?>" placeholder='mm'>
                <span> / </span>
                <input type="text" id="exp_year" class="form-control" size="2" value="<?= $currInfo['exp_year'] ?>" data-stripe="exp_year" name="exp_year" value="<?= $exp_year?>" placeholder='yyyy'>
              </div>
        </div>

          <div class="form-group">
             <label class="control-label" for="">CVC<span class="symbol required"></span></label>
              <div class="card-det">
               <input type="password" class="form-control cvv" value="<?= $currInfo['cvc'] ?>" id="cvc"  size="4" data-stripe="cvc" name="cvc" >
             </div>
          </div>
		</div>
	<!--End of payment box section-->	
					  
					  <div class="billing_address">
							<h3><?= $_SESSION['lan']['billing_add']?></h3>
							<div class="form-group">
								<label for="billingAddress"><?= $_SESSION['lan']['address']?></label>
								<input type="text" name="billingAddress" value="<?= $currInfo['billingAddress'] ?>" class="form-control" id="billingAddress" placeholder="<?= $_SESSION['lan']['address']?>">
							</div>
						  <div class="form-group">
							<label for="city"><?= $_SESSION['lan']['city']?></label>
							<input type="text" name="city" class="form-control" value="<?= $currInfo['city'] ?>" id="city" >
						  </div>
						  <div class="form-group">
							<label for="state"><?= $_SESSION['lan']['state']?></label>
							<input type="text" name="state" class="form-control" id="state" value="<?= $currInfo['state'] ?>">
						  </div>
						  <div class="form-group">
							<label for="postal_code"><?= $_SESSION['lan']['postal']?></label>
							<input type="text" name="postalCode" class="form-control" id="postal_code" value="<?= $currInfo['postalCode'] ?>">
						  </div>
					  </div>
					  
					  
				</div>
				<div class="col-md-6 right">
					<div class="order-summary">
						<h4><?= $_SESSION['lan']['order_summary']?>  </h4>
						<ul>

              <input type="hidden"  value="<?php echo get_post_meta(167,'photographs_by_foodyt_tram_price',true);?>" id="photographs_by_foodyt_tram_price_demo">

              <input type="hidden" name="mainPrice" value="<?php echo get_post_meta(167,'digital_menu_price',true);?>" id="mainPrice">
<!--               <input type="hidden" name="photographPrice" value="<?php //echo get_post_meta(167,'photograph',true);?>" id="photographPrice">
 -->              
              <input type="hidden" id="vat" name="vat" value="<?php echo get_post_meta(167,'vat',true);?>" id="vat">
              <input type="hidden" name="photographs_by_foodyt_tram_price" value="0" id="photographs_by_foodyt_tram_price">
              <input type="hidden" name="totalPrice" value="" id="totalPrice">
              
							<li>Base <span><?php echo get_post_meta(167,'digital_menu_price',true);?> €</span></li>
<!-- 							<li>Photograph <span><?php //echo get_post_meta(167,'photograph',true);?> €</span></li>
 -->							<li class="languageLi"><span id="languageCount"></span>  <?= $_SESSION['lan']['lang_added']?><span>&nbsp;€ </span>&nbsp; <span id="languagePrice"></span> </li>
							<li class="beaconLi">Beacon<span><?php echo get_post_meta(167,'beacon_price',true);?> €</span></li>
							  <li class="monthlyReportLi"><?= $_SESSION['lan']['monthly_report'][0]?><span><?php echo get_post_meta(167,'monthly_report_price',true);?> €</span></li>
							  <li class="photographsLi"><?= $_SESSION['lan']['photograph'][0]?><span><?php echo get_post_meta(167,'photographs_by_foodyt_tram_price',true);?> €</span></li>
							
							<li><?= $_SESSION['lan']['Vat']?>(<?php echo get_post_meta(167,'vat',true);?> %)<span><span id="vatPercertage"></span> €</span></li>
							<li class="totalLi">Total<span><span id="totalPriceBottom"></span> € / <?= $_SESSION['lan']['month']?></span></li>
						</ul>
					</div>
					<div class="row">
						 <div class="col-sm-12 recieve-form1">
							<div class="wrap">
						
							<p>

						<?php
						if($_SESSION['lanCode']=='' || $_SESSION['lanCode']=='es')
						 { 
						   echo get_post_meta(167,'green_box_text_second_es',true);
					     }
					     else
					     {
						   echo get_post_meta(167,'green_box_text_second_en',true);
					     }
						?>
						</p>

							</div>
						<div>
							
							<div class="g-recaptcha" data-sitekey="6LfMPzQUAAAAAOdlJU_t5wlWrbIXTfrfN-oytfdP"></div>
						</div>
							<div class="place_order">
							<p style="font-sixe:15px;text-align:center;">By placing my order, I agree with <a href="#">Terms & Conditions</a></p>
							<p id='back_registration'><?= $_SESSION['lan']['back']?></p>
								<input  type="submit" value="<?= $_SESSION['lan']['place_order']?>">
							</div>
						</div>
					</div>
				</div>
			</div>
	</div>
</section>
</form>

<!--------------------------------Start section Paypal form----------------------------------------->
<!--<script type="text/javascript" charset="utf-8">
<script src="https://www.paypalobjects.com/js/external/dg.js" type="text/javascript"></script>
 var dg = new PAYPAL.apps.DGFlow(
    {
      trigger: 'addon_puchase_by_paypal',
      expType: 'instant'
       //PayPal will decide the experience type for the buyer based on his/her 'Remember me on your computer' option.
    });</script>-->
<!--------------------------------End section Paypal form----------------------------------------->




<div id="monthlyReportModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">      
        <button type="button" class="close" data-dismiss="modal">&times;</button>      
     
      <div class="modal-body">
		<figure>
			<img src="<?php echo get_template_directory_uri();?>/assets/images/monthly-report.png" alt=""/>
		</figure>
		<div class="grey-bg">
        <p><?= $_SESSION['lan']['monthly_report'][1]?>
		</p>
		</div>
      </div>
      
    </div>

  </div>
</div>

<div id="photographModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    
        <button type="button" class="close" data-dismiss="modal">&times;</button>
       
   
      <div class="modal-body ">
		<figure><img src="<?php echo get_template_directory_uri();?>/assets/images/photographs.jpg" alt=""/></figure>
        <div class="grey-bg"><p><?= $_SESSION['lan']['photograph'][1]?></p></div>
      </div>
      
    </div>

  </div>
</div>

<?php get_footer();
$error = $_SESSION['error'];
unset($_SESSION['error']);
?>



<script>
var jq = $.noConflict();
jq(document).ready(function(){

	error =0;
  jq("#fileupload,#bannerImage").change(function () {
  		   readURL(this, jq(this).parents('.imgData').find('img'));
        });

	 function readURL(input, $this) {
        if (input.files && input.files[0]) {
        	// console.log(input.files[0]);
        	var imgName = input.files[0].name;
        	var ext = imgName.split(".");
			if(jq.inArray(ext[1], ['gif','png','jpg','jpeg']) == -1) {
			   jq(input).parent().next().show();
			    error =1;
			   }else{ 
			   	jq(input).parent().next().hide();
			   	error =0;

                }

            var reader = new FileReader();
            reader.onload = function (e) {
                $this.attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }


    jq("#c_number,#credit_card_number").mask("9999 9999 9999 9999");    
    jq("#m_number").mask("9999999999");    
    jq("#cvv,#cvc").mask("999");    
    jq("#exp_month").mask("99");    
    jq("#exp_year").mask("9999");    
    jq("#postal_code").mask("99999");  
    jq("#selectCusine,#selectlan").multiselect();
	
  
    jq('#myform').validate({
        rules: {
            restaurantName: {
                required: true
            },
            restaurantDescription: {
                required: true
            },
            address: {
                required: true
            },
            fileupload: {
                required: true
            },
            bannerImage: {
                required: true
            }, 
            selectCusine: {
                required: true
            },
            email: {
                required: true
            },
            mobileNumber: {
                required: true,
                minlength:9,
				maxlength:10
            },
            credit_card_number: {
                required: true
              
            },
            credit_card_fname: {
                required: true
            },
			credit_card_lname: {
                required: true
            },
            month: {
                required: true
            },
			year: {
                required: true
            },
            cvc: {
                required: true,
                minlength:3,
				maxlength:3,
                digits: true
            },
          
            billingAddress: {
                required: false
            },
            city: {
                required: false
            },
            state: {
                required: false
            },
            postalCode: {
                required: false,
                minlength:5,
				maxlength:5,
                digits: true
            },
			payment_method:{
				required: true
			}
        },
         messages:{
		  restaurantName:"<?= $_SESSION['lan']['error_registration']['restaurant_name']?>",
		  restaurantDescription:"<?= $_SESSION['lan']['error_registration']['restaurant_des']?>",
		  email:"<?= $_SESSION['lan']['error_registration']['email']?>",
		  address:"<?= $_SESSION['lan']['error_registration']['address']?>",
		  fileupload:"<?= $_SESSION['lan']['error_registration']['logo_img']?>",
		  bannerImage:"<?= $_SESSION['lan']['error_registration']['banner_img']?>",
		  selectCusine:"<?= $_SESSION['lan']['error_registration']['select_cuisine']?>",
		  mobileNumber:"<?= $_SESSION['lan']['error_registration']['mobile_no']?>",
		  cardNumber:"<?= $_SESSION['lan']['error_registration']['card']?>",
		  cardHolderName:"<?= $_SESSION['lan']['error_registration']['cardHolderName']?>",
		  cvv:"<?= $_SESSION['lan']['error_registration']['cvv']?>"
		  },
        submitHandler: function (form) { // for demo
            return true;
        }

    });

    // programmatically check any element using the `.valid()` method.
    jq('#createNow').on('click', function () {
		if(<?php echo $pageId;?>){
        jq('#restaurantName,#restaurantDescription,#address,#selectCusine,#chekLanguage,#m_number').valid();
		}
		else{
        jq('#restaurantName,#restaurantDescription,#address,#fileupload,#bannerImage,#selectCusine,#chekLanguage,#m_number').valid();
		}
	});
  // programmatically check the entire form using the `.valid()` method.

  
 jq('#btn').click(function(){
	jq('#select option:selected').each(function(){
		alert(jq(this).val());
	});
 });
	jq('body').on('change', '#payment_method', function() {
		var paymentMethod = jq(this).val();
		var siteUrl = jQuery('#siteUrl').val();
		if(paymentMethod=='Credit or debit Card'){
			jq('#myform').attr('action',siteUrl+'/thank-you/');
		    jq('#credit_card_fname').val('');
			jq('#credit_card_lname').val('');
			jq('#credit_card_number').val('');
			jq('#exp_month').val('');
			jq('#exp_year').val('');
			jq('#cvc').val('');
			jq('#paymentBox').show();
		
		}
		else
		{  
			jq('#myform').attr('action',siteUrl+'/thank-you/');
			jq('#paymentBox').hide();
			jq('#credit_card_fname').val('Test');
			jq('#credit_card_lname').val('Test');
			jq('#credit_card_number').val('4242424242424242');
			jq('#exp_month').val(2);
			jq('#exp_year').val(2025);
			jq('#cvc').val(123);

		}
		
		
	});
 
  var photographs_by_foodyt_tram_price=0;
  jq('body').on('change', '#photograph', function() {
  	var photo = jq('#photographs_by_foodyt_tram_price_demo').val();
          if(jq(this).prop('checked'))
         {
           jq('#photographs_by_foodyt_tram_price').val(photo);
           photographs_by_foodyt_tram_price = parseFloat(jq('#photographs_by_foodyt_tram_price').val());
           jq('.photographsLi').show();
         }
         else
         {
          jq('.photographsLi').hide();
          photographs_by_foodyt_tram_price=0;
          jq('#photographs_by_foodyt_tram_price').val(0);
         }
     });
   jq('#createNow').click(function(){
   		   jq('html, body').animate({scrollTop:0}, 'slow');
		   if(jq('#selectCusine').val()!='')
			   {
			   jq('#error-cusine').hide();
			   }
		   	else
		   	   {
		   		jq('#error-cusine').show();
		       }
	   
	   if(jq('#selectlan').val()!='')
			   {
			   jq('#error-chekLanguage').hide();
			   }
		   	else
		   	   {
		   		jq('#error-chekLanguage').show();
		       }
	   

		    if(jq('#restaurantName').val()!=''&&jq('#address').val()!='' && jq('#selectCusine').val()!='' && error==0)
			 {
		         var photo = jq('#photographs_by_foodyt_tram_price_demo').val();
				 if(jq('#photograph').prop('checked'))
				   {
				     jq('#photographs_by_foodyt_tram_price').val(photo);
				     photographs_by_foodyt_tram_price = parseFloat(jq('#photographs_by_foodyt_tram_price').val());
				     jq('.photographsLi').show();
				  }
			if(<?php echo $pageId;?>)
                {  
					jq('#digital_menu_form1').hide();
					jq('#digital_menu_form2').show();
					// var photographPrice = parseFloat($('#photographPrice').val());
					var mainPrice = parseFloat(jq('#mainPrice').val());
					var totalPrice = mainPrice+photographs_by_foodyt_tram_price;
					var vatPercentage = parseFloat(jq('#vat').val());
					var totalVatPrice = ((totalPrice*vatPercentage)/100);
					totalVatPrice = totalVatPrice.toFixed(2);
					totalVatPrice = parseFloat(totalVatPrice);
					jq('#vatPercertage').text(totalVatPrice);
					jq('#totalPrice').val(totalPrice+totalVatPrice);
					jq('#totalPriceBottom').text(totalPrice+totalVatPrice);
				 }
				 else
				 {
					if(jq('#fileupload').val()!='' && jq('#bannerImage').val()!=''){
					jq('#digital_menu_form1').hide();
					jq('#digital_menu_form2').show();
						
					var mainPrice = parseFloat(jq('#mainPrice').val());
					var totalPrice = mainPrice+photographs_by_foodyt_tram_price;
					var vatPercentage = parseFloat(jq('#vat').val());
					var totalVatPrice = ((totalPrice*vatPercentage)/100);
					totalVatPrice = totalVatPrice.toFixed(2);
					totalVatPrice = parseFloat(totalVatPrice);
					jq('#vatPercertage').text(totalVatPrice);
					jq('#totalPrice').val(totalPrice+totalVatPrice);
					jq('#totalPriceBottom').text(totalPrice+totalVatPrice);
					}
				}
			 }
    });
  
   
   jq('#selectCusine').change(function(){
      if(jq(this).val()==''){  	jq('#error-cusine').show();}else{jq('#error-cusine').hide(); 	}
    });
    jq('#back_registration').click(function(){
			     jq('#digital_menu_form1').show(); 	
			     jq('#digital_menu_form2').hide(); 
			     jq('html, body').animate({scrollTop:0}, 'slow');
	 
    });

 
});
</script>

  
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
  <!-- jQuery is used only for this example; it isn't required to use Stripe -->
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

  <!-- New section -->
  <script type="text/javascript">
    // Fill in your publishable key
    Stripe.setPublishableKey('pk_test_9jbBKGfAha5CEoHzVXaZpId6');

    var stripeResponseHandler = function(status, response) {
      var $form = $('#myform');
       console.log(response.error);
      if (response.error) {
        // Show the errors on the form
        $form.find('.payment-errors').text(response.error.message);
        $form.find('button').prop('disabled', false);
		$('#ajaxLoaderImg').hide();
      } else {
		  
		
        // token contains id, last4, and card type
        var token = response.id;
        // Insert the token into the form so it gets submitted to the server
        $form.append($('<input type="hidden" name="stripeToken" />').val(token));
        // and re-submit
		    var email = $('#email').val();
		    var billingAddress = $('#billingAddress').val();
		    var city = $('#city').val();
		    var state = $('#state').val();
		    var postalCode = $('#postalCode').val();
			if(email=='')
			{

			}
			else
			{
				$('#ajaxLoaderImg').show();
			   $form.get(0).submit();
			} 
		  
      }
    };

    jQuery(function($) {
      $('#myform').submit(function(e) {
        var $form = $(this);
        console.log($(this).serialize());

        // Disable the submit button to prevent repeated clicks
        $form.find('button').prop('disabled', true);

        Stripe.card.createToken($form, stripeResponseHandler);

        // Prevent the form from submitting with the default action
        return false;
      });
    });
  </script>

  
	<style type="text/css">
#my_image_upload{height: 48px;
  font-size: 16px;}
/*  #digital_menu_form1{display:none;}
*/ 
 #digital_menu_form2{display:none;}
  .languageLi,.photographsLi,.monthlyReportLi,.beaconLi{display:none;}
  #languageCount{color: #67b024;float:none;}
  #totalPriceBottom{float:none;}
  #createNow
      {
	    background: #f39500;
		cursor: pointer;
		color: #fff;
		border: 0;
		border-radius: 7px;
		font-size: 20px;
		font-family: 'GothamBook';
		padding: 17px 37px;
	  }
 .cvv
    {  /* width: 143px!important;
    	height:42px!important; */
    }
.error,#error-cusine,#error-chekLanguage
    {
	   font-size: 14px!important;
	   color: red!important;
	   margin: 2px!important;
	 }
 #error-cusine,#error-chekLanguage{display:none;}
 .centerImg{
 	height: 110px;
	align-items: center;
	display: flex;
	justify-content: center;
	}
#error-logo,#error-banner{
	font-weight: normal!important;
	display: none;
	color:red;
} 
.payment-errors{
	color:red!important;
		}
.errMsgPaymentFail{
    color: white;
    background: red;
    text-align: center;
}	
.loader-overlay {
    position: fixed;
    background: rgba(0,0,0,0.8);
    left: 0;
    top: 0;
    right: 0;
    bottom: 0;
    z-index: 99999;
}
.a-loader {
    position: absolute;
    top: 43%;
    margin-top: -50px;
    left: 0;
    right: 0;
	width: 30%;
    height: 23%;
    border-radius: 8px;
    background: #fff;
    border: 1px solid #000;
    margin: 0 auto;
}
.a-loader p {
    font-size: 20px;
    padding-top: 30px;
}
		#vatPercertage{float:none;}
</style>
<!-- Start section to if card decline error occure -->
<?php
if($pageId){ ?>
   <script> 
	jQuery(document).ready(function(){
		var payMethod = '<?php echo $currInfo['payment_method']?>';
		
		var siteUrl = jQuery('#siteUrl').val();
		if(payMethod=='Paypal'){
	      jQuery('#paymentBox').hide();
	      jQuery('.errMsgPaymentFail').text('Your paypal Payment has been cancelled.');
		  jQuery('#myform').attr('action',siteUrl+'/thank-you/');
       }
		else
		{ 
	      jQuery('#paymentBox').show();
		  jQuery('#myform').attr('action',siteUrl+'/thank-you/');
		}
	 jQuery('#digital_menu_form2').show(); 	
	 jQuery('#digital_menu_form1').hide(); 
	 jQuery('#fileupload,#bannerImage').attr('required',false); 
	 jQuery('html, body').animate({scrollTop:0}, 'slow');  
	});
 </script>
<?php } ?>

<?php
if($currInfo['photographs_by_foodyt_tram_price']!=0){ ?>
   <script> 
	jQuery(document).ready(function(){
	    jQuery('.photographsLi').show(); 
		if(jQuery('#photograph').prop('checked'))
         {
		   var photo = jQuery('#photographs_by_foodyt_tram_price_demo').val();
           jQuery('#photographs_by_foodyt_tram_price').val(photo);
           photographs_by_foodyt_tram_price = parseFloat(jQuery('#photographs_by_foodyt_tram_price').val());
           jQuery('.photographsLi').show();
         }
		var mainPrice = parseFloat(jQuery('#mainPrice').val());
		var totalPrice = mainPrice+photographs_by_foodyt_tram_price;
		var vatPercentage = parseFloat(jq('#vat').val());
		var totalVatPrice = ((totalPrice*vatPercentage)/100);
		totalVatPrice = totalVatPrice.toFixed(2);
		totalVatPrice = parseFloat(totalVatPrice);
		jq('#vatPercertage').text(totalVatPrice);
		jq('#totalPrice').val(totalPrice+totalVatPrice);
		jq('#totalPriceBottom').text(totalPrice+totalVatPrice);
	});
 </script>
<?php } else{?>
<script> 
	jQuery(document).ready(function(){
	   var mainPrice = parseFloat(jQuery('#mainPrice').val());
		var totalPrice = mainPrice;
		var vatPercentage = parseFloat(jq('#vat').val());
		var totalVatPrice = ((totalPrice*vatPercentage)/100);
		totalVatPrice = totalVatPrice.toFixed(2);
		totalVatPrice = parseFloat(totalVatPrice);
		jq('#vatPercertage').text(totalVatPrice);
		jq('#totalPrice').val(totalPrice+totalVatPrice);
		jq('#totalPriceBottom').text(totalPrice+totalVatPrice);
	});
 </script>
<?php } ?>
<!-- End section to if card decline error occure -->

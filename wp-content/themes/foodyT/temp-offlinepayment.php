<?php
/*
Template Name:offline payment
*/
get_header();

global $wpdb;
$paymentTable = $wpdb->prefix."payment";
$resid = $_REQUEST['rsId'];
$id = $_SESSION['resid'];
$resPayment = $wpdb->get_row("SELECT * FROM $paymentTable where restaurant_id= $resid AND payment_status='active' AND cancel_sub=0 ORDER BY id DESC LIMIT 1");

$date_now = date("Y-m-d"); // this format is string comparable
$expiryDate = $resPayment->expiry_date;
$expiryDate = strtotime($resPayment->expiry_date);
$expiryDate = date('Y-m-d', $expiryDate);

 if($_SESSION['lanCode']=='' || $_SESSION['lanCode']=='es')
 { 
		if ($date_now < $expiryDate) {
			   echo "<h3 style='text-align:center;'>Ya has realizado el pago.</h3>";
			   die;
			}

		if($id==''){
			$_SESSION['resid'] = $resid;
			if($resid==''){
			    echo "<h3 style='text-align:center;'>URL de Incorect, utilice la URL correcta.</h3>";
			die;}
		}
		else {
			if($id!=$resid){
				echo "<h3 style='text-align:center;'>URL de Incorect, utilice la URL correcta.</h3>";
				die;
			}
		}
 }

else {
				 
			if ($date_now < $expiryDate) {
				   echo "<h3 style='text-align:center;'>You’ve already made the payment.</h3>";
				   die;
				}

			if($id==''){
				$_SESSION['resid'] = $resid;
				if($resid==''){
				echo "<h3 style='text-align:center;'>Incorect URL,Please use correct url.</h3>";
				die;}
			}
			else {
				if($id!=$resid){
					echo "<h3 style='text-align:center;'>Incorect URL,Please use correct url.</h3>";
					die;
				}
			}
				 
	 }


$email = get_post_meta($resid,'email',true);
/* start If your card decline of fail to payment*/
$pid = $_SESSION['pid'];
$uid = $_SESSION['userId'];
$currInfo = $_SESSION['currInfo'];
/* End If your card decline of fail to payment*/
?>
<input type="hidden" id="siteUrl" value="<?php echo site_url();?>"><!--To get site url in js -->
<div class="loader-overlay ajaxLoaderImg" id="ajaxLoaderImg" style="display:none;">
        <div class="a-loader" style="text-align: center;">
           <p id="addOnMsgPayment" class="addOnMsgPayment">Please wait, we are processing...</p>
           <img style="width:40px;" src="<?Php echo get_template_directory_uri()?>/assets/images/ajax-loader.gif">
        </div>
 </div>

<form id="offlinePaymentForm" method="post" action="<?php echo site_url(); ?>/offline-payment-thank" enctype="multipart/form-data">
<input type="hidden"  name="pid" value="<?php echo $resid;?>">
	<section class="digital_menu_form2">
	<div class="container">
		<div class="errMsgPaymentFail">
		  <?php echo $_SESSION['error'];?>
		</div>
		
    <div class="row">
	  <div class="col-md-6 left">
				<div class="account_information">
						<h3><?= $_SESSION['lan']['account_info']?></h3>
						<div class="form-group">
							<input readonly type="email" name="email" class="form-control" placeholder="Email" value="<?= $email ?>">
							<p id="email_exit" style="color:red;display:none;"><?= $_SESSION['lan']['error_registration']['emailExit']?></p>
						</div>

				  </div>
					
				<div class="col-sm-6 pop">
					
				   <div class="title"><?= $_SESSION['lan']['monthly_report'][0]?> <a href="#" data-toggle="modal" data-target="#monthlyReportModal" class="beacon-pop"><i class="fa fa-question-circle-o" aria-hidden="true"></i></a></div>
				   <label class="checkbox-inline"><input disabled type="checkbox" checked="" id="monthlyReport"  name="monthlyReport" value="1"><span><?= $_SESSION['lan']['yes_i_want']?></span></label>
					<input type="hidden"  name="monthlyReport" value="1">		 
		     </div>
							   
				 <div class="col-sm-6 pop" >
				  <div class="title"><?= $_SESSION['lan']['photograph'][0]?> <a href="#" data-toggle="modal" data-target="#photographModal" class="beacon-pop"><i class="fa fa-question-circle-o" aria-hidden="true"></i></a></div>
				   <label class="checkbox-inline"><input type="checkbox"  <?php if($currInfo['photographs_by_foodyt_tram_price']!=0){echo "checked";}?> id="photograph" name="photograph" value="<?php echo get_post_meta(167,'photographs_by_foodyt_tram_price',true);?>"><span><?= $_SESSION['lan']['yes_i_want']?></span></label>
				   <div class="price">*<?php echo get_post_meta(167,'photographs_by_foodyt_tram_price',true);?>€ <?= $_SESSION['lan']['addition']?></div>
				</div>	
         
				  <div class="form-group">
					<label class="control-label" for=""><?= $_SESSION['lan']['cardInfo']['payment_method_sele']?><span class="symbol required"></span></label>
				   <select  class="form-control"  name="payment_method" id="payment_method">
					   <option value="">--<?= $_SESSION['lan']['cardInfo']['select_payment_method']?>---</option>
					   <option <?php if($currInfo['payment_method']=='Credit or debit Card'){echo "selected";}?> value="Credit or debit Card"><?= $_SESSION['lan']['Creditor_debitcard'];?></option>
					  <option <?php if($currInfo['payment_method']=='Paypal'){echo "selected";}?> value="Paypal">Paypal</option>
				   </select>
				  </div>

	<!--Start of payment box section-->
		<div id="paymentBox" style="display:none;">			
		 <h3><?= $_SESSION['lan']['cardInfo']['enter_payment_detail']?></h3>
          <p class="payment-errors"></p>
          <div class="form-group">
				<label class="control-label" for=""><?= $_SESSION['lan']['cardInfo']['fname']?><span class="symbol required"></span></label>
				<input type="text" id="credit_card_fname" value="<?= $currInfo['credit_card_fname'] ?>" name= 'credit_card_fname' class="form-control" value="<?= $credit_card_name?>">
			  </div>
					
			  <div class="form-group">
				<label class="control-label" for=""><?= $_SESSION['lan']['cardInfo']['lname']?><span class="symbol required"></span></label>
				<input type="text" id="credit_card_lname" value="<?= $currInfo['credit_card_lname'] ?>" name= 'credit_card_lname' class="form-control" value="<?= $credit_card_lname?>">
			  </div>

			 <div class="form-group">
				<label class="control-label" for=""><?= $_SESSION['lan']['cardInfo']['card_number']?> <span class="symbol required"></span></label>
				<input type="tel" size="20" id="credit_card_number" value="<?= $currInfo['credit_card_number'] ?>" name= 'credit_card_number' class="form-control" data-stripe="number" >
			 </div>

			 <div class="form-group">
				   <label class="control-label" for=""><?= $_SESSION['lan']['cardInfo']['exp_date']?><span class="symbol required"></span></label>
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
							<div class="place_order">
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
    jq("#c_number,#credit_card_number").mask("9999 9999 9999 9999");    
    jq("#m_number").mask("9999999999");    
    jq("#cvv,#cvc").mask("999");    
    jq("#exp_month").mask("99");    
    jq("#exp_year").mask("9999");    
    jq("#postal_code").mask("99999");  


	jq('body').on('change', '#payment_method', function() {
		var paymentMethod = jq(this).val();
		var siteUrl = jQuery('#siteUrl').val();
		if(paymentMethod=='Credit or debit Card'){
			jq('#offlinePaymentForm').attr('action',siteUrl+'/offline-payment-thank/');
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
			jq('#offlinePaymentForm').attr('action',siteUrl+'/offline-payment-thank/');
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
		    var mainPrice = parseFloat(jQuery('#mainPrice').val());
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
            jq('.photographsLi').hide();
            photographs_by_foodyt_tram_price=0;
            jq('#photographs_by_foodyt_tram_price').val(0);
		    var mainPrice = parseFloat(jQuery('#mainPrice').val());
			var totalPrice = mainPrice;
			var vatPercentage = parseFloat(jq('#vat').val());
			var totalVatPrice = ((totalPrice*vatPercentage)/100);
			totalVatPrice = totalVatPrice.toFixed(2);
			totalVatPrice = parseFloat(totalVatPrice);
			jq('#vatPercertage').text(totalVatPrice);
			jq('#totalPrice').val(totalPrice+totalVatPrice);
			jq('#totalPriceBottom').text(totalPrice+totalVatPrice);
         }
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
      var $form = $('#offlinePaymentForm');
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
      $('#offlinePaymentForm').submit(function(e) {
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
if($pid){ ?>
   <script> 
	jQuery(document).ready(function(){
		var payMethod = '<?php echo $currInfo['payment_method']?>';
		var siteUrl = jQuery('#siteUrl').val();
		if(payMethod=='Paypal'){
	      jQuery('#paymentBox').hide();
	      jQuery('.errMsgPaymentFail').text('Your paypal Payment has been cancelled.');
		  jQuery('#offlinePaymentForm').attr('action',siteUrl+'/offline-payment-thank/');
       }
		else
		{ 
	      jQuery('#paymentBox').show();
		  jQuery('#offlinePaymentForm').attr('action',siteUrl+'/offline-payment-thank/');
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

<?php
/*
Template Name:facturacion form page
*/
get_header();?>
<?php
 $uId = get_current_user_id();
 if($_REQUEST['fname']){
     if (isset ($_REQUEST['billing_type'])) {
 	    update_user_meta( $uId, 'billing_type', $_REQUEST['billing_type']);
     }
     if (isset ($_REQUEST['fname'])) { 
 	    update_user_meta( $uId, 'fname',$_REQUEST['fname']);
     }
    if (isset ($_REQUEST['surname'])) { 
 	  update_user_meta( $uId, 'surname',$_REQUEST['surname']);
     }
    if (isset ($_REQUEST['dni'])) { 
 	   update_user_meta( $uId, 'dni',$_REQUEST['dni']);
     }
    if (isset ($_REQUEST['nif'])) { 
 	   update_user_meta( $uId, 'nif',$_REQUEST['nif']);
    }
    if (isset ($_REQUEST['address'])) { 
 	   update_user_meta( $uId, 'address',$_REQUEST['address']);
    }
    if (isset ($_REQUEST['population'])) { 
 	   update_user_meta( $uId, 'population',$_REQUEST['population']);
    }
    if (isset ($_REQUEST['province'])) { 
 	  update_user_meta( $uId, 'province',$_REQUEST['province']);
    }
    if (isset ($_REQUEST['postalcode'])) { 
 	  update_user_meta( $uId, 'postalcode',$_REQUEST['postalcode']);
    }
	 echo "<p class='tax_info_mess'>".$_SESSION['lan']['billing']['sucess']."</p>";
	 
 }
     $billing_type = get_user_meta( $uId, 'billing_type', true);
     $fname = get_user_meta( $uId, 'fname', true);
     $surname = get_user_meta( $uId, 'surname', true);
     $dni = get_user_meta( $uId, 'dni', true);
     $nif = get_user_meta( $uId, 'nif', true);
     $address = get_user_meta( $uId, 'address', true);
     $population = get_user_meta( $uId, 'population', true);
     $province = get_user_meta( $uId, 'province', true);
     $postalcode = get_user_meta( $uId, 'postalcode', true);

?>

<section id="my-account" class="logincredential">
	<div class="container">
    <?php include 'usernotification.php'; ?>
		<div class="row">
			<div class="col-md-3 col-sm-4 col-xs-12 account-menu">
				<h3><?= $_SESSION['lan']['my_account']?></h3>
                <?php
                  if($_SESSION['lanCode']=='' || $_SESSION['lanCode']=='es'){  wp_nav_menu(array('theme_location'=>'sidebar-menu'));}
                  else
                  {
                      wp_nav_menu(array('theme_location'=>'sidebar-menu-english'));
                  }
                  ?>
			</div>
			
			<div class="col-md-9 col-sm-8 col-xs-12 account-details">
			    <h3><?= $_SESSION['lan']['billing']['bill']?></h3>
           <form id="BillingForm" method="post">
            <div class="wrapped">
                      <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="client_name"><?= $_SESSION['lan']['billing']['cus_type']?></label>
                                    <select class="form-control" id="billing_type" name="billing_type" <?php if(!empty($billing_type)){echo "disabled";}?>>
                                        <option <?php if($billing_type=='business'){ echo "selected";} ?> value="business"><?= $_SESSION['lan']['billing']['business']?></option>
                                        <option <?php if($billing_type=='particular'){ echo "selected";} ?> value="particular"><?= $_SESSION['lan']['billing']['particular']?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                            </div>
                        </div>
				    
                     <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="client_name"><?= $_SESSION['lan']['billing']['fname']?></label>
                                    <input type="text" class="form-control" id="fname" name="fname" value="<?= $fname?>" required>
                                </div>
                            </div>
                            
                            <div class="col-md-4 particular" style="display:none;">
                                <div class="form-group">
                                    <label for="client_name"><?= $_SESSION['lan']['billing']['surname']?></label>
                                    <input type="text" class="form-control" id="surname" name="surname" value="<?= $surname?>">
                                </div>
                            </div>
                        
                           <div class="col-md-4 particular" style="display:none;">
                                <div class="form-group">
                                    <label for="client_name">DNI</label>
                                    <input type="text" class="form-control" name="dni" id="dni" value="<?= $dni?>">
                                </div>
                            </div>
                        
                            <div class="col-md-4 customer">
                                <div class="form-group">
                                    <label for="client_name">NIF</label>
                                    <input type="text" class="form-control" name="nif" id="nif" value="<?= $nif?>" required>
                                </div>
                            </div>
                        
				    </div>
				    
				    <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="client_name"><?= $_SESSION['lan']['billing']['address']?></label>
                                    <input type="text" class="form-control" id="address" name="address" value="<?= $address?>" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="client_name"><?= $_SESSION['lan']['billing']['population']?></label>
                                    <input type="text" class="form-control" id="population" name="population" value="<?= $population?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="client_name"><?= $_SESSION['lan']['billing']['province']?></label>
                                    <input type="text" class="form-control" id="province" name="province" value="<?= $province?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="client_name"><?= $_SESSION['lan']['billing']['postalcode']?></label>
                                    <input type="text" class="form-control" id="postalcode" name="postalcode" value="<?= $postalcode?>" maxlength="5">
                                </div>
                            </div>
				    </div>
                    <input type="hidden" name="action" value="">
				    <div class="row">
                            <div class="col-md-12">
                                <input style="cursor: pointer;" type="submit"  name="submit" value="<?= $_SESSION['lan']['billing']['update']?>">
                            </div>
				    </div>
				  </div>
			   </form>
			</div>			
		</div>		
	</div>
</section>
<?php get_footer();?>
<style>
	.error{color:red!important;font-size:16px!important;}
	.tax_info_mess{text-align: center;
    color: green;}
</style>
<!-- Start section to if card decline error occure -->
<?php
if($billing_type=='business'){ ?>
   <script> 
	 jQuery(document).ready(function(){
           jQuery('.particular').hide();  
           jQuery('.customer').show();
		   jQuery('#nif').attr('required',true);  
           jQuery('#dni').attr('required',false);
	});
 </script>
<?php } else if($billing_type=='particular'){ ?>
   <script> 
	 jQuery(document).ready(function(){
           jQuery('.particular').show();  
           jQuery('.customer').hide();  
		   jQuery('#nif').attr('required',false);  
           jQuery('#dni').attr('required',true);
	});
 </script>
<?php } ?>
<!-- End section to if card decline error occure -->

   <script> 
	 jQuery(document).ready(function(){		 
		 jQuery("#postalcode").keypress(function (e) {
			 //if the letter is not digit then display error and don't type anything
			 if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
				//display error message
				 return false;
			}
		   });
	
		 
		 jQuery('body').on('change', '#billing_type', function() {

            var getType = jQuery(this).val();
            if(getType=='business')
            {
                jQuery('.particular').hide();  
                jQuery('.customer').show();  
                jQuery('#nif').attr('required',true);  
                jQuery('#dni').attr('required',false); 
            }
            else
            {
                jQuery('.particular').show();  
                jQuery('.customer').hide();
				jQuery('#nif').attr('required',false);  
                jQuery('#dni').attr('required',true);

            }
        });
		 		 
	});
	   
var js = $.noConflict();   
js(document).ready(function(){	
	   js('#BillingForm').validate({
        rules: {
            address: {
                required: true
            },
            nif: {
                required: true
            }, 
            dni: {
                required: true
            },
            surname: {
                required: true
              
            },
            fname: {
                required: true
            },
			population: {
                required: true
            },
            province: {
                required: true
            },
            postalCode: {
                required: true
            }
        },
         messages:{
		 
		  },
        submitHandler: function (form) { // for demo
            return true;
        }

    });
});
		 
	    
 </script>
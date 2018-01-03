<?php
/*
Template Name:editProfile page
*/
get_header();
?>	
<?php
 global $wpdb;
 $userTable = $wpdb->prefix."users";
 $restaurant_info_table = $wpdb->prefix."restaurant_infos";
 $posttable = $wpdb->prefix."posts";
 $cuisinetable = $wpdb->prefix."cuisine";
 $uId = get_current_user_id();

 /* start to get the page Id from  wp_restaurant_infos table by jai singh*/
 $res = $wpdb->get_row("select * from $restaurant_info_table where user_id = $uId",ARRAY_A);
 $pid = $res['page_id'];
 /* End to get the page Id from  wp_restaurant_infos table by jai singh*/
	$success =0;
	


	
	 if(isset($_REQUEST['submit'])){
	
// echo "<pre>";
// print_r($_FILES);
// print_r($_REQUEST);
	
	    if($_FILES['logo_image']['name']=='')
		 {
		 	unset($_FILES['logo_image']);
		 	$set=1;
		 }
		 elseif($_FILES['banner_image']['name']=='')
		 {
		 	$set=1;
		 	unset($_FILES['banner_image']);
		 }
		 else
		 {
		 	$set=2;
		 }

		  

		 if($set==2){

		 	$i=0;
		 	foreach ($_FILES as $file => $array) {
							      $newupload = insert_attachment($file,$pid);
				 	             
				 	             if($i==0){
				 	             $bannerPostId = get_post_meta( $pid, 'banner_image',true);
								 update_post_meta( $pid, 'banner_image', $newupload );
				 	             wp_delete_post($bannerPostId);		
				 	                 }
				 	                 else
				 	             {
				 	              

				 	             $logoPostId = get_post_meta( $pid, 'logo_image',true);
				 	             	update_post_meta( $pid, 'logo_image', $newupload );
				 	                wp_delete_post($logoPostId);

				 	             }
							  $i++;
							}
							

		 }else{

			  if ($_FILES['logo_image']['name'] ) {
				    	foreach ($_FILES as $file => $array) {
							     $newupload = insert_attachment($file,$pid);
							     $logoPostId = get_post_meta( $pid, 'logo_image',true);
				 	             update_post_meta( $pid, 'logo_image', $newupload );
							     wp_delete_post($logoPostId);	 
							   	}
							 }


				    if ($_FILES['banner_image']['name'] ) {
				    	
				    	
							    foreach ($_FILES as $file => $array) {
							    $newupload1 = insert_attachment($file,$pid);
							    $bannerPostId = get_post_meta( $pid, 'banner_image', true );
							    update_post_meta( $pid, 'banner_image', $newupload1 );
							   	wp_delete_post($bannerPostId);

							   	}

						   }

			}
	


	 /* start to Update the most of information into  wp_restaurant_infos table by jai singh*/
        $updateR_name = $_REQUEST['r_name'];
        $updateDesc = $_REQUEST['restaurantDescription'];
	    $updateAddress = $_REQUEST['address'];
	    $updateCuisine = $_REQUEST['cuisine'];
		 
	    $updateCuisine = implode(',', $updateCuisine);
	    $updateMobileNumber = $_REQUEST['mobile_number'];
	    $hideValue = $_REQUEST['hide_price'];
	 	$wpdb->update( 
					$restaurant_info_table, 
					array( 
						'restaurant_name' => $updateR_name,
						'address' => $updateAddress,
						'cuisine' => $updateCuisine,
						'mobile_number' => $updateMobileNumber,
						'hide_price' => $hideValue
					), 
					array( 'user_id' => $uId ), 
					array( 
						'%s',
						'%s',
						'%s',
						'%s',
						'%d'
					), 
					array( '%d' ) 
				);
	/* End to Update the most of information into  wp_restaurant_infos table by jai singh*/


	/* start to Update the post title by post Id  by jai singh*/
       $my_post = array(
	      'ID'           => $pid,
	      'post_title'   => $updateR_name,
	      'post_content'   => $updateDesc,
	     );
		wp_update_post( $my_post );
	/* End to Update the post title by post Id  by jai singh*/

	/* start toUpdate the postmeta table by post Id  by jai singh*/
	 	update_post_meta( $pid, 'address',$updateAddress); 
	 	update_post_meta( $pid, 'cusine',$updateCuisine); 
	 	update_post_meta( $pid, 'mobilenumber',$updateMobileNumber);
    /* End to Update the postmeta table by post Id  by jai singh*/
    	$success =1;

	 }

	/* start to get the all information from  wp_restaurant_infos table by jai singh*/
		 $res = $wpdb->get_row("select * from $restaurant_info_table where user_id = $uId",ARRAY_A);
		 $restaurant_name = $res['restaurant_name'];
		 $address = $res['address'];
		 $cuisine = $res['cuisine'];
		 $mobile_number = $res['mobile_number'];
		 $pid = $res['page_id'];
		 $cuisineList = explode(',', $cuisine);
		 // echo "<pre>";
		 // print_r($cuisineList);
	/* End to get the all information from  wp_restaurant_infos table by jai singh*/

	    $logoId = get_post_meta( $pid, 'logo_image',true);
	 	$bannerId = get_post_meta( $pid, 'banner_image',true);
         $resultLogo = $wpdb->get_row( "SELECT guid FROM $posttable WHERE ID = $logoId ",ARRAY_A );
         

	    $logoImg = $resultLogo['guid'];
	     $resultBanner = $wpdb->get_row( "SELECT guid FROM $posttable WHERE ID = $bannerId",ARRAY_A );
	     $bannerImg = $resultBanner['guid'];

	     $post_content = get_post($pid); 
		 $desc = $post_content->post_content;

	   $query = "SELECT hide_price,user_id FROM $restaurant_info_table WHERE user_id=" . $uId;
	   $infoArr = $wpdb->get_row($query);
	   $hidePrice = $infoArr->hide_price;
	   if($hidePrice==1){
	   		$pricechecked = 'checked';
	   }else{
	   		$pricechecked = 'unchecked';
	   }
		
	     

?>

<section id="my-account" class="profilePage">
	<div class="container">
        <?php include 'usernotification.php'; ?>
		
		<div class="row">
			<div class="col-md-3 col-sm-4 col-xs-12 account-menu">
				<h3><?= $_SESSION['lan']['my_account']?></h3>
                <?php
		          if($_SESSION['lanCode']=='' || $_SESSION['lanCode']=='es'){  wp_nav_menu(array('theme_location'=>'sidebar-menu'));
		              }
		          else{
		              wp_nav_menu(array('theme_location'=>'sidebar-menu-english'));
		              }
		          ?>

			</div>
			
			<div class="col-md-9 col-sm-8 col-xs-12 account-details">
			      <?php
			      	 if(isset($_REQUEST['r_name'])){
						if($success==1)
						echo "<p style='color:green;text-align:center;'>Your data is successfully updated.</p>";
						else
					    echo "<p style='color:green;text-align:center;'>Your data is not updated.</p>";
				    }		
					?>

			<form method="post" enctype="multipart/form-data" id='editRestaurant'>
				<h3><?= $_SESSION['lan']['edit_res_profile']?></h3>
				<div class="wrapped">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="r_name"><?= $_SESSION['lan']['restaurant_name']?></label>
							<input type="text" class="form-control" id="r_name" name='r_name' value="<?php echo $restaurant_name;?>" required>
						</div>
					</div>


						<div class="col-md-6">
						<div class="form-group">
						  <label for="cuisine"><?= $_SESSION['lan']['kind_cuision']?></label>
						  <select class="form-control" name="cuisine[]" id="selectCusineEdit" multiple="multiple">
						  <?php
						  $results = $wpdb->get_results("SELECT * FROM $cuisinetable");
						  foreach($results as $key){
				  	 $status = $key->status;
					  	if($status==1){
					  		if($_SESSION['lanCode']=='' || $_SESSION['lanCode']=='es'){	$cuisine = $key->cuisine_name_es;}else{$cuisine = $key->cuisine_name;}?>
					  		<option <?php if(in_array($cuisine, $cuisineList)){echo "selected";}?> value="<?php echo $cuisine ;?>"><?php echo $cuisine; ?></option>

				  	   
				  	    <?php
				  	   }
				  	 }
						  ?>    
						  </select>
						  <label  id="error-cusine-edit" ><?= $_SESSION['lan']['error_registration']['select_cuisine']?>.</label>

						</div>
					</div>

					
					
				
				</div>
				


				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="restaurantDescription"><?= $_SESSION['lan']['restaurant_description']?></label>
							<textarea  style="height: 100px;" class="form-control" id="restaurantDescription" name="restaurantDescription" required><?php echo $desc;?></textarea>
						</div>
						</div>
						<div class="col-md-6">
						<div class="form-group">
							<label for="address"><?= $_SESSION['lan']['address']?></label>
							<textarea  style="height: 100px;" class="form-control" id="address" name="address" required><?php echo $address;?></textarea>
						</div>
					</div>
				</div>

					<div class="row">
					<div class="col-md-6">
					  <div class="row imgData">
						<div class="col-md-6">
							<div class="form-group">
								<label for="choose_file"><?= $_SESSION['lan']['banner_img']?></label>
								<input type="file" class="form-control"  name="banner_image" id="banner_image">
							</div>
							<label  id="error-bannerEdit" ><?= $_SESSION['lan']['error_registration']['valid_img']?>.</label>

						</div>
						<div class="col-md-6">
							<img width="100px" class="acf-image-image" src="<?php echo $bannerImg;?>" alt="">
						</div>

					</div>
				<!-- 	<span>Note: Image size should be min 1920*507</span> -->

					</div>
					
					<div class="col-md-6">
					 <div class="row imgData">

					<div class="col-md-6">
						<div class="form-group">
							<label for="choose_file">Logo</label>
							<input type="file" class="form-control" name="logo_image" id="logo_image">
						</div>
						<label  id="error-logoEdit" ><?= $_SESSION['lan']['error_registration']['valid_img']?>.</label>

						</div>
						<div class="col-md-6">
							<img width="100px" class="acf-image-image" src="<?php echo $logoImg;?>" alt="">
						</div>
					  </div>
					  	<!-- <span>Note: Image size should be min 200*50</span> -->

					</div>
				</div>


				<div class="row">
					
					
					<div class="col-md-6">
						<div class="form-group">
							<label for="mobile_number"><?= $_SESSION['lan']['mobile_no']?></label>
							<input type="text" class="form-control" id="mobile_number" name='mobile_number' value="<?php echo $mobile_number;?>" required>
						</div>
					</div>

					<div class="col-md-6">
						 <label><?= $_SESSION['lan']['setting']['hide_price']?>  </label>

						 <input type="hidden"  name="hide_price" value='0'></br>
	              	      <input type="checkbox" <?= $pricechecked?> name="hide_price" value='1'><?= $_SESSION['lan']['setting']['info_hide_price']?> 
					  

					</div>


					
				</div>
				
				<div class="row">
					<div class="col-md-12">
						<input style="cursor: pointer;" type="submit" value="<?= $_SESSION['lan']['update']?>" name="submit" id="profileUpdate">
					</div>
				</div>
				</div>
				</form>
			</div>			
		</div>		
	</div>
</section>

</section>


<?php get_footer();
?>
<script type="text/javascript">
	var jq = $.noConflict();
	  jq("#logo_image,#banner_image").change(function () {
            readURL(this, jq(this).parents('.imgData').find('img'));
        });

	 function readURL(input, $this) {
        if (input.files && input.files[0]) {
        	var imgName = input.files[0].name;
        	var ext = imgName.split(".");
			if(jq.inArray(ext[1], ['gif','png','jpg','jpeg']) == -1) {
			   jq(input).parent().next().show();
			   	// $('#profileUpdate').attr('disabled','true');
			   }else{ 
			   	jq(input).parent().next().hide();
			   	// $('#profileUpdate').attr('enabled','true');
                }
        if(jq('#error-bannerEdit:visible').length != 0 || jq('#error-logoEdit:visible').length != 0)
		       {
		        jq('#profileUpdate').attr('disabled','true');
		        jq('#profileUpdate').css('cursor','inherit');
			   }else
			   { 
			   	jq('#profileUpdate').removeAttr('disabled');
			   	 jq('#profileUpdate').css('cursor','pointer');
               }
				
            var reader = new FileReader();
            reader.onload = function (e) {
            $this.attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
		    
		    jq(document).ready(function () {

		    	 jq('#editRestaurant').validate({
					        rules: {
					            r_name: {
					                required: true
					            },
					            address: {
					                required: true
					            },
					            restaurantDescription: {
					                required: true
					            },
					            mobile_number: {
					                required: true
					            }
					        },
					         messages:{
							  r_name:"<?= $_SESSION['lan']['error_registration']['restaurant_name']?>.",
							  restaurantDescription:"<?= $_SESSION['lan']['error_registration']['restaurant_des']?>.",
							  address:"<?= $_SESSION['lan']['error_registration']['address']?>.",
							  mobile_number:"<?= $_SESSION['lan']['error_registration']['mobile_no']?>."
							  },
					        submitHandler: function (form) { // for demo
					            return true;
					        }
					    });


				
		    		 jq('#error-cusine-edit').hide();
		    		 jq("#mobile_number").mask("9999999999");
		    		 jq("#selectCusineEdit").multiselect();
                     jq('#profileUpdate').click(function(){
					   		   //$('html, body').animate({scrollTop:0}, 'slow');
							   if(jq('#selectCusineEdit').val()!='')
								   {
								   	jq('#error-cusine-edit').hide();
								   	
								   }
							   	else
							   	   {
							   		jq('#error-cusine-edit').show();
							   	
							       }
						    });
                     jq('#selectCusineEdit').change(function(){
						      if(jq(this).val()=='')
						      {  	
						      	jq('#error-cusine-edit').show();	
						      	jq('#profileUpdate').attr('disabled','true');
			                    jq('#profileUpdate').css('cursor','inherit');
			                  }
			                else
			                 {
				                jq('#error-cusine-edit').hide();
				                jq('#profileUpdate').removeAttr('disabled');
					   	        jq('#profileUpdate').css('cursor','pointer');
					   	     }
					    });
					 });
</script>
<!-- <script type="text/javascript">
	jq(function(){
		jq("#selectCusineEdit").multiselect();
	});
   </script> -->

<!-- <script>
$(document).ready(function(){
	
 
});
</script> -->
<style type="text/css">
#error-logoEdit,#error-bannerEdit{
	font-weight: normal!important;
	display: none;
	color:red!important;
	font-size: 14px!important
} 
#error-cusine-edit,.error
    {
	   font-size: 14px!important;
	   color: red!important;
	   margin: 2px!important;
	 }
input[type=file]{
    width:103px;
    color:transparent;
}
</style>
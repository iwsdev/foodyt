<?php
/*
  Template Name:Manage Plan Page
 */
session_start();
get_header();
if(isset($_SESSION['myposteddata'])){
      unset($_SESSION['myposteddata']);
 ?>
        <script type="text/javascript">
              location.reload();
         </script>
 <?php
 }
global $wpdb;
$restaurant_info_table = $wpdb->prefix."restaurant_infos";
$query = "SELECT * FROM $restaurant_info_table WHERE user_id=" . get_current_user_id();
$infoArr = $wpdb->get_results($query);
$postArr = get_post_meta($infoArr[0]->page_id);
?>
<div class="loader-overlay ajaxLoaderImg" id="ajaxLoaderUpdate" style="display:none;">
        <div class="a-loader" style="text-align: center;">
           <p id="addOnMsgPayment" class="addOnMsgPayment">Please wait, we are processing...</p>
           <img style="width:40px;" src="<?Php echo get_template_directory_uri()?>/assets/images/ajax-loader.gif">
        </div>
 </div>
<section id="my-account" class="manageplan">
    <div class="container">
        <p class='cancelSus' style='color:green;display: none;text-align:center;'><?= $_SESSION['lan']['cancel_sub_msg']?>.</p>
        <p class='cancelSus' style='color:green;display: none;text-align:center;'><?= $_SESSION['lan']['u_will_logout']?>...</p>
        <?php include 'usernotification.php'; ?>
        <div class="row">
            <div class="col-md-3 col-sm-4 col-xs-12 account-menu">
                <h3><?= $_SESSION['lan']['my_account']?></h3>
               
         <?php
          if($_SESSION['lanCode']=='' || $_SESSION['lanCode']=='es'){  wp_nav_menu(array('theme_location'=>'sidebar-menu'));}
          else{
              wp_nav_menu(array('theme_location'=>'sidebar-menu-english'));
          }
          ?>
            </div>
            <div class="col-md-9 col-sm-8 col-xs-12 account-details">
                <h3><?= $_SESSION['lan']['current_plan']?> <span><?php echo get_post_meta(167, 'digital_menu_price', true); ?>&euro;</span></h3>
                <div class="menu">
                    <form method="post" name="updateplane" action="<?php echo site_url() ?>/paypal-recurring-payment/expresscheckout.php">
                        <ul>
                            <li>                          
                                <div class="description">
                                    <div class="title">
                                        <h4><?= $_SESSION['lan']['languageText']?> 
                                        <h4>
                                          <?php if ($infoArr[0]->language_price != '' && $infoArr[0]->language_price != 0) { ?>
                                                <span class="price languageprice" price="<?php echo $infoArr[0]->language_price ?>"><?php echo $infoArr[0]->language_price ?>&euro;</span>
                                            <?php } ?>
                                        </h4>
                                        <input type="hidden" name="language_price" value="<?php echo $infoArr[0]->language_price ?>">
                                    </div>
                                    <div class="checkbox">
                                        <label><input type="checkbox" value="Spanish" <?php echo checkSelected($infoArr[0]->language, 'Spanish') ?> class="checklanguage" name="language[]" disabled> <?= $_SESSION['lan']['languageList'][0]?> </label>
                                        <input type="hidden" name="language[]" value="Spanish">
                                    </div>
                                    <div class="checkbox">
                                        <label><input type="checkbox" value="English" <?php echo checkSelected($infoArr[0]->language, 'English') ?> class="checklanguage" name="language[]"> <?= $_SESSION['lan']['languageList'][1]?> </label>
                                    </div>
                                    <div class="checkbox">
                                        <label><input type="checkbox" value="French" <?php echo checkSelected($infoArr[0]->language, 'French') ?> class="checklanguage" name="language[]"> <?= $_SESSION['lan']['languageList'][2]?> </label>
                                    </div>
                                    <div class="checkbox">
                                        <label><input type="checkbox" value="Italian" <?php echo checkSelected($infoArr[0]->language, 'Italian') ?> class="checklanguage" name="language[]"> <?= $_SESSION['lan']['languageList'][3]?> </label>
                                    </div>
                                    <div class="checkbox">
                                        <label><input type="checkbox" value="japanese" <?php echo checkSelected($infoArr[0]->language, 'japanese') ?> class="checklanguage" name="language[]"> <?= $_SESSION['lan']['languageList'][4]?> </label>
                                    </div>
                                </div>
                            </li>
                          
                            <!--<li>                          
                                <div class="description ano">
                                    <div class="title">
                                        <h4><?php //echo $_SESSION['lan']['monthly_report'][0]?> <a href="#" data-toggle="modal" data-target="#monthlyReportModal" class="beacon-pop"><i class="fa fa-question-circle-o" aria-hidden="true"></i></a>
                                            <?php //if ($infoArr[0]->monthly_reportPrice != '' && $infoArr[0]->monthly_reportPrice != 0) { ?>
                                                <span class="price"><?php //echo $infoArr[0]->monthly_reportPrice ?>&euro;</span>
                                            <?php //} ?>
                                        </h4>
                                    </div>
                                    <div class="checkbox">
                                        <label><input type="checkbox" value="<?php //echo get_post_meta(167, 'monthly_report_price', true); ?>" <?php //echo ($infoArr[0]->monthly_reportPrice != '' && $infoArr[0]->monthly_reportPrice != 0) ? 'checked="checked"' : '' ?> name="monthly_reportPrice" class="mycheckplan"> <?php //echo $_SESSION['lan']['yes_i_want']?></label>
                                        <span>*<?php //echo get_post_meta(167, 'monthly_report_price', true); ?>&euro; <?php //echo $_SESSION['lan']['addition']?></span>
                                    </div>                      
                                </div>
                            </li>-->
                            <li>                          
                                <div class="description ano">
                                    <div class="title">
                                        <h4><?= $_SESSION['lan']['photograph'][0]?> <a href="#" data-toggle="modal" data-target="#photographModal" class="beacon-pop"><i class="fa fa-question-circle-o" aria-hidden="true"></i></a>
                                            <?php if ($infoArr[0]->photographs_by_foodyt_tram_price != '' && $infoArr[0]->photographs_by_foodyt_tram_price != 0) { ?>
                                                <span class="price"><?php echo $infoArr[0]->photographs_by_foodyt_tram_price ?>&euro;</span>
                                            <?php } ?>
                                        </h4>
                                    </div>
                                    <div class="checkbox">
                                        <label><input type="checkbox" value="<?php echo get_post_meta(167, 'photographs_by_foodyt_tram_price', true); ?>" <?php echo ($infoArr[0]->photographs_by_foodyt_tram_price != '' && $infoArr[0]->photographs_by_foodyt_tram_price != 0) ? 'checked="checked"' : '' ?> name="photographs_by_foodyt_tram_price" class="mycheckplan"> <?= $_SESSION['lan']['yes_i_want']?></label>
                                        <span>*<?php echo get_post_meta(167, 'photographs_by_foodyt_tram_price', true); ?>&euro; <?= $_SESSION['lan']['addition']?></span>
                                    </div>                      
                                </div>
                            </li>
                            <li>       
                                <input type="hidden" name="Payment_Amount" value="<?php echo $infoArr[0]->total_price ?>" class="myhiddenpaymentinput">
                                <div class="description total">
                                    <?php if ($infoArr[0]->total_price != '' && $infoArr[0]->total_price != 0) { ?>
                                        <div class="title">
                                            <h4>Total <span class="price thetotalprice" totalprice="<?php echo $infoArr[0]->total_price ?>">
                                            <?php echo number_format($infoArr[0]->total_price, 2, '.', '') ?>&euro;</span></h4>
                                            <input type="hidden" name="total_price" value="<?php echo $infoArr[0]->total_price ?>" class="myhiddenpaymentinput">
                                        </div>
                                    <?php } ?>
                                    <div class="buttons">
                                        <?php // echo do_shortcode('[qpp]'); ?>
                                        <?php // echo do_shortcode('[wp_paypal button="subscribe" name="My product" amount="1.00" recurrence="1" period="M" src="1"]');  ?>
                                        <button type="submit" class="update_plan"><?= $_SESSION['lan']['update_plan']?></button>
                                        <!--<a class="update_plan" href="javascript:void(0)" onclick="submit();">Update Plan</a>-->
                                        <a class="cancel_subscription"  id='cancelSubscription'><?= $_SESSION['lan']['cancel_sub']?></a>

                                    </div>                      
                                </div>
                            </li>
                        </ul>
                    </form>
                </div>          
            </div>          
        </div>      
    </div>
</section>
<input type="hidden" name="" id='getUserId' value='<?php echo get_current_user_id(); ?>'>




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


<script>
    $(document).ready(function () {
        $('.mycheckplan').change(function () {
            var langprice = <?php echo get_post_meta(167, 'language_price', true) ?>;
            if ($(this).is(':checked')) {
                if ($(this).hasClass('checklanguage')) {
                    // $('.myhiddenpaymentinput').val(parseFloat($('.myhiddenpaymentinput').val()) + parseFloat(langprice));
                    var hiddenprice15 = parseFloat($('.myhiddenpaymentinput').val()).toFixed(2);
                    var hiddenprice25 = parseFloat(langprice).toFixed(2);
                    var totalhidden5 = parseFloat(parseFloat(hiddenprice15)+parseFloat(hiddenprice25)).toFixed(2);

                    $('.myhiddenpaymentinput').val(totalhidden5);
                    // $('.thetotalprice').text(parseFloat($('.thetotalprice').text()) + parseFloat(langprice));

                    var price15 = parseFloat($('.thetotalprice').text()).toFixed(2);
                    var price25 = parseFloat(langprice).toFixed(2);
                    var totalPrice5 = parseFloat(parseFloat(price15)+parseFloat(price25)).toFixed(2);
                    $('.thetotalprice').text(totalPrice5+ '€');

                } else {
                    // $('.myhiddenpaymentinput').val(parseFloat($('.myhiddenpaymentinput').val()) + parseFloat($(this).val()));
                    var hiddenprice14 = parseFloat($('.myhiddenpaymentinput').val()).toFixed(2);
                    var hiddenprice24 = parseFloat($(this).val()).toFixed(2);
                    var totalhidden4 = parseFloat(parseFloat(hiddenprice14)+parseFloat(hiddenprice24)).toFixed(2);
                   $('.myhiddenpaymentinput').val(totalhidden4);
                    // $('.thetotalprice').text((parseFloat($('.thetotalprice').text()) + parseFloat($(this).val())) + '€');
                    var price12 = parseFloat($('.thetotalprice').text()).toFixed(2);
                    var price22 = parseFloat($(this).val()).toFixed(2);
                    var totalPrice2 = parseFloat(parseFloat(price12)+parseFloat(price22)).toFixed(2);
                    $('.thetotalprice').text(totalPrice2+ '€');
                }

            } else {
                if ($(this).hasClass('checklanguage')) {
                    // $('.myhiddenpaymentinput').val(parseFloat($('.myhiddenpaymentinput').val()) - parseFloat(langprice));

                      var hiddenprice13 = parseFloat($('.myhiddenpaymentinput').val()).toFixed(2);
                      var hiddenprice23 = parseFloat(langprice).toFixed(2);
                      var totalhidden3 = parseFloat(parseFloat(hiddenprice13)-parseFloat(hiddenprice23)).toFixed(2);
                       $('.myhiddenpaymentinput').val(totalhidden3);
                    // $('.thetotalprice').text(parseFloat($('.thetotalprice').text()) - parseFloat(langprice));

                    var price13 = parseFloat($('.thetotalprice').text()).toFixed(2);
                    var price23 = parseFloat(langprice).toFixed(2);;
                    var totalPrice3 = parseFloat(parseFloat(price13)-parseFloat(price23)).toFixed(2);
                    $('.thetotalprice').text(totalPrice3+ '€');

                } else {
                   // $('.myhiddenpaymentinput').val(parseFloat($('.myhiddenpaymentinput').val()) - parseFloat($(this).val()));

                  var hiddenprice1 = parseFloat($('.myhiddenpaymentinput').val()).toFixed(2);
                  var hiddenprice2 = parseFloat($(this).val()).toFixed(2);
                  var totalhidden = parseFloat(parseFloat(hiddenprice1)-parseFloat(hiddenprice2)).toFixed(2);
                   $('.myhiddenpaymentinput').val(totalhidden);

                   //$('.thetotalprice').text((parseFloat($('.thetotalprice').text()) - parseFloat($(this).val())) + '€');
                    var price1 = parseFloat($('.thetotalprice').text()).toFixed(2);
                    var price2 = $(this).val();
                    var totalPrice = parseFloat(parseFloat(price1)-parseFloat(price2)).toFixed(2);
                    // alert(price1);
                    // alert(price2);
                    // alert(totalPrice);
                    $('.thetotalprice').text(totalPrice+ '€');
                }

            }
        });
    });

</script>
<!--</section>-->
<?php

get_footer();
unset($_SESSION['myposteddata']);
unset($_SESSION['successVal']);
?>
<?php
session_start();
/*
Template Name:facturacion detail page
*/       global $wpdb;
         $paymentTable = $wpdb->prefix."payment";
         $restaurant_info_table = $wpdb->prefix."restaurant_infos";
		 require_once(get_template_directory() . '/dompdf/autoload.inc.php');
		 use Dompdf\Dompdf;
		 $dompdf = new Dompdf();
		 //$userId = get_current_user_id();
         $paymentId = $_REQUEST['id'];
         $location = $_REQUEST['location'];
         $userId = $_REQUEST['uid'];
		 $getResult = $wpdb->get_row("SELECT * FROM $paymentTable where id= $paymentId");
         $logopath = get_template_directory() . '/assets/images/foodyT-logo.png'; 
         //$vat = get_post_meta( 167, 'vat', true);
         $vat = $getResult->vat;
		 $amount = $getResult->amount;	        
		 $invoice_no = $getResult->invoice_no;	        
		 $created_date = $getResult->created_date;	        
		 $payment_by = $getResult->payment_by;
		 $amount = $getResult->amount;
		 $vatAmount = (($amount*$vat)/100);
         $totalAmount = $vatAmount+$amount;
         $vatAmount = number_format($vatAmount ,2);
         $totalAmount = number_format($totalAmount ,2);
		 $start_date = $getResult->start_date;
		 $expiry_date = $getResult->expiry_date;
		 $start_date = date('d-m-y',strtotime($start_date));
		 $expiry_date = date('d-m-y',strtotime($expiry_date));
		 $intervalDate = $start_date." a ".$expiry_date;
         $dni = get_user_meta( $userId, 'dni', true);
		 $nif = get_user_meta( $userId, 'nif', true);
         $address = get_user_meta( $userId, 'address', true);
         $population = get_user_meta( $userId, 'population', true);
         $province = get_user_meta( $userId, 'province', true);
         $postalcode = get_user_meta( $userId, 'postalcode', true);
		 $address = $address.",".$population.", ".$province.", ".$postalcode;	

		 $getResult = $wpdb->get_row("SELECT * FROM $restaurant_info_table where user_id= $userId");
         $companyName = $getResult->restaurant_name;
         if($payment_by==1)
			 $paymentMode = "Tarjeta de Credito";
         else if($payment_by==2)
			 $paymentMode = "Paypal";

		if($location=='admin')
		{
           
            $langarr = getArrayOfContent();
			$bill = $langarr['es']['billing']['bill'];
			$billThe = $langarr['es']['pdfinvoice']['billthe'];
			$detail = $langarr['es']['pdfinvoice']['detail'];
			$comp_name = $langarr['es']['pdfinvoice']['comp_name'];
			$direction = $langarr['es']['pdfinvoice']['direction'];
			$invoice_name = $langarr['es']['pdfinvoice']['invoice_no'];
			$date_issue = $langarr['es']['pdfinvoice']['date_issue'];
			$payment_codition = $langarr['es']['pdfinvoice']['payment_codition'];
			$desc = $langarr['es']['pdfinvoice']['desc'];
			$interval = $langarr['es']['pdfinvoice']['interval'];
			$qty = $langarr['es']['pdfinvoice']['qty'];
			$amt = $langarr['es']['pdfinvoice']['amt'];
			$montly_free = $langarr['es']['pdfinvoice']['montly_free'];
			$subtotal = $langarr['es']['pdfinvoice']['subtotal'];
			$amt_in = $langarr['es']['pdfinvoice']['amt_in'];
			$thank_regarding = $langarr['es']['pdfinvoice']['thank_regarding'];
			$artical_note = $langarr['es']['pdfinvoice']['artical_note'];
		}
		else
		{
			$bill = $_SESSION['lan']['billing']['bill'];
			$billThe = $_SESSION['lan']['pdfinvoice']['billthe'];
			$detail = $_SESSION['lan']['pdfinvoice']['detail'];
			$comp_name = $_SESSION['lan']['pdfinvoice']['comp_name'];
			$direction = $_SESSION['lan']['pdfinvoice']['direction'];
			$invoice_name = $_SESSION['lan']['pdfinvoice']['invoice_no'];
			$date_issue = $_SESSION['lan']['pdfinvoice']['date_issue'];
			$payment_codition = $_SESSION['lan']['pdfinvoice']['payment_codition'];
			$desc = $_SESSION['lan']['pdfinvoice']['desc'];
			$interval = $_SESSION['lan']['pdfinvoice']['interval'];
			$qty = $_SESSION['lan']['pdfinvoice']['qty'];
			$amt = $_SESSION['lan']['pdfinvoice']['amt'];
			$montly_free = $_SESSION['lan']['pdfinvoice']['montly_free'];
			$subtotal = $_SESSION['lan']['pdfinvoice']['subtotal'];
			$amt_in = $_SESSION['lan']['pdfinvoice']['amt_in'];
			$thank_regarding = $_SESSION['lan']['pdfinvoice']['thank_regarding'];
			$artical_note = $_SESSION['lan']['pdfinvoice']['artical_note'];
		}
		
         // include autoloader
         // instantiate and use the dompdf class
         $pdfInfo ='<div class="col-md-9 col-sm-8 col-xs-12 account-details">
			    
				<div class="wrapped">				    
						<table id="table1" border="0" colspan="0" rowspan="0" width="100%" style="border-collapase:collapse; ">
							<tr>
								<td style="width:50%"><img src="'.$logopath.'" alt="" /></td>
								<td style="width:50%; float:right">
									<ul align="right" class="add-list" style="list-style:none; margin:0; padding:0; float:right; width:170px">
										<li style="color:#000; line-height:20px; font-size:14px;">Clever Insight GP S.L</li>
										<li style="color:#000; line-height:20px; font-size:14px;">C/Juan de Mata Carriazo 5</li>
										<li style="color:#000; line-height:20px; font-size:14px;">41018</li>
										<li style="color:#000; line-height:20px; font-size:14px;">Sevilla</li>
										<li style="color:#000; line-height:20px; font-size:14px;">NIF: B90284738</li>
									</ul>
								</td>
							</tr>
							<tr>
								<td colspan="2" style="color:#000; font-size:17px; padding:15px 0 25px"><h3>'.$bill.'</h3></td>
							</tr>
						</table>
						
						<table id="table2" border="0" colspan="0" rowspan="0" width="100%" style="border-collapase:collapse; ">
							<tr align="left" style="text-align:left">
								<th style="color:#000; font-size:17px; padding-bottom:15px;text-align:left">'.$billThe.'</th>
								<th style="color:#000; font-size:17px; padding-bottom:15px;text-align:left" colspan="2">'.$detail.'</th>
							</tr>
							<tr>
								<td style="width:45%; ">
									<ul style="list-style:none; margin:0; padding:0">
										<li style="color:#000; line-height:20px; font-size:14px; display:block;">'.$comp_name.' : '.$companyName.'</li>
										<li style="color:#000; line-height:20px; font-size:14px; display:block;">'.$direction.' : '.$address.'</li>
										<li style="color:#000; line-height:20px; font-size:14px; display:block;">NIF : '.$nif.'</li>
									</ul>
								</td>
								<td style="width:30%;">
									<ul style="list-style:none; margin:0; padding:0">
										<li style="color:#000; line-height:20px; font-size:14px; display:block;">'.$invoice_name.':</li>
										<li style="color:#000; line-height:20px; font-size:14px; display:block;">'.$date_issue.':</li>
										<li style="color:#000; line-height:20px; font-size:14px; display:block;">'.$payment_codition.':</li>
									</ul>
								</td>
								<td style="width:25%;">
									<ul style="list-style:none; margin:0; padding:0">
										<li style="color:#000; line-height:20px; font-size:14px; display:block;">'.$invoice_no.'</li>
										<li style="color:#000; line-height:20px; font-size:14px; display:block;">'.$created_date.'</li>
										<li style="color:#000; line-height:20px; font-size:14px; display:block;">'.$paymentMode.'</li>
									</ul>
								</td>
							</tr>
						</table>
                  
                    
                        <table id="table3" border="0" colspan="0" rowspan="0" width="100%" class="fact-table" style="padding:45px 0;border-collapase:collapse; ">
                            
                                <tr bordercolor="00b186" border="1" style="border-bottom:1px solid #00b186; vertical-align:top;">
                                    <th style="width:25%; text-align:left; border-bottom:1px solid #00b186; padding:10px 0">'.$desc.'</th>
                                    <th style="width:25%;text-align:left;border-bottom:1px solid #00b186; padding:10px 0">'.$interval.'</th>
                                    <th style="width:25%;text-align:left;border-bottom:1px solid #00b186; padding:10px 0">'.$qty.' </th>
                                    <th style="width:25%;text-align:right;border-bottom:1px solid #00b186; padding:10px 0">'.$amt.' (&#8364;)</th>
                                </tr>
                           
                         
                                <tr  bordercolor="00b186" border="1" style="border-bottom:1px solid #00b186; vertical-align:top;">
                                    <td style="text-align:left;border-bottom:1px solid #00b186; padding:10px 0">'.$montly_free.'</td>
                                    <td style="text-align:left;border-bottom:1px solid #00b186;padding:10px 0">'.$intervalDate.'</td>
                                    <td style="text-align:left;border-bottom:1px solid #00b186;padding:10px 0">1</td>
                                    <td style="text-align:right;border-bottom:1px solid #00b186;padding:10px 0">'.$amount.' &#8364; </td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="2"> 
                                    	<table width="100%" class="total-row">
                                        	<tr>
                                            	<td>'.$subtotal.' EUR: </td>
                                                <td align="right">'.$amount.' &#8364;</td>
                                            </tr>
                                            <tr>
                                            	<td>*IVA('.$vat.'%):</td>
                                                <td align="right">'.$vatAmount.' &#8364;</td>
                                            </tr>
                                            <tr border="2" bordercolor="00b186" style="border:2px solid #00b186;padding:10px 5px">
                                            	<td style="border:2px solid #00b186; padding:10px 5px; border-right:0"><strong>'.$amt_in.' EUR:</strong></td>
                                                <td style="border:2px solid #00b186; border-left:0;padding:10px 5px;" align="right"><strong>'.$totalAmount.' &#8364;</strong></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                        </table>
                   
				    
						<table id="table4" border="0" colspan="0" rowspan="0" width="100%" class="fact-table" style="border-collapase:collapse; ">
							<tr>
								<td style="width:100%; color:#000; font-size:20px; font-weight:600; line-height:30px; padding:50px 0;">
									'.$thank_regarding.' <a href="mailto:info@foodyt.com">info@foodyt.com</a>
								</td>
							</tr>
                    
					    <tr>
							<td style="color:#000; font-size:17px; font-weight:600; line-height:30px; padding:70px 0 30px">
    						<p>*'.$artical_note.'</p>
							</td>
							</tr>
						</table>
                    
				</div>	    
			</div>';
            $dompdf = new Dompdf();
            $dompdf->loadHtml($pdfInfo);

            // (Optional) Setup the paper size and orientation
            $dompdf->setPaper('A4', 'portrait');

            // Render the HTML as PDF
            $dompdf->render();

            // Output the generated PDF to Browser
            $dompdf->stream($companyName."-".$invoice_no);

            get_footer();
?>
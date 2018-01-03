<?php
/* Template Name:user deactivation cron */
?>
<?php
global $wpdb;
$userTable = $wpdb->prefix."users";
$restaurant_info_table = $wpdb->prefix."restaurant_infos";
$site_url= site_url();
$userInfo = $wpdb->get_results("SELECT ID,user_registered,user_email FROM $userTable WHERE ID!=1",ARRAY_A);

	foreach($userInfo as $userData){
		$now = time(); // or your date as well
		$your_date = strtotime($userData['user_registered']);
		$datediff = $now - $your_date;
		$res = $wpdb->get_row("SELECT * FROM $restaurant_info_table WHERE user_id =".$userData['ID'],ARRAY_A);
		//$status = $getStatus[0]['status'];
		$endDate = strtotime($res['end_date']);
		$datediff = $endDate-$now;
		 $day = floor($datediff / (60 * 60 * 24))."</br>";
		// echo "<pre>";
// print_r($getStatus);
		$free_plan = get_post_meta($res['page_id'],'free_plan',true);
		$free_plan = $free_plan[0];
//die;
		
		


		if($free_plan!='free'){
			
				    if($day<=-2){
						 update_user_meta($userData['ID'],'ja_disable_user',1);
				        	} 
				
					if($day==7){
						    $user_info = get_userdata($userData['ID']);
			                $username = $user_info->user_login;
			                $useremail = $user_info->user_email;
						    $admin_email = get_option( 'admin_email' );
							$to =$useremail;
							$subjects = "Actualización del periodo de pruebas";
							$headers = "From: " . strip_tags($admin_email) . "\r\n";
							$headers .= "MIME-Version: 1.0\r\n";
							$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
							$messages="<html><body>
							        Dear $username,
							        <p><b>Su periodo de pruebas finaliza en 7 días.</b></p>
									<p>Su mes gratis de prueba finaliza en 7 días, esperamos que haya disfrutado de la experiencia. Para continuar usando nuestros servicios, por favor actualice su plan para aprovechar al máximo su carta.</p>
									<p style='margin:1px;'>Saludos Cordiales,</p>
									<img id='whiteLogo' src='$site_url/wp-content/themes/foodyT/assets/images/logo.png' alt=''>
				
				 		   </body>
				 		   </html>";
						 mail($to,$subjects,$messages,$headers);
						 
					} 
					if($day==-2){
					    $user_info = get_userdata($userData['ID']);
			                $username = $user_info->user_login;
			                $useremail = $user_info->user_email;
						    $admin_email = get_option( 'admin_email' );
							$to =$useremail;
							$subjects = "Desactivación de la cuenta de pruebas";
							$headers = "From: " . strip_tags($admin_email) . "\r\n";
							$headers .= "MIME-Version: 1.0\r\n";
							$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
							$messages="<html><body>
							        Estimado $username,
									<p>Su periodo de pruebas ha expirado y no ha actualizado su plan, por lo que su cuenta ha sido desactivada. Para cualquier duda, contacte con el administrador.. </p>
									<p style='margin:1px;'>Saludos Cordiales,</p>
									<img id='whiteLogo' src='$site_url/wp-content/themes/foodyT/assets/images/logo.png' alt=''>
								</body>
				 		   </html>";
				           mail($to,$subjects,$messages,$headers);


							$user_info = get_userdata($userData['ID']);
			                $username = $user_info->user_login;
			                $useremail = $user_info->user_email;
						    $admin_email = get_option( 'admin_email' );
							$to =$admin_email;
							$subjects = "Desactivación del usuario";
							$headers = "From: " . strip_tags($admin_email) . "\r\n";
							$headers .= "MIME-Version: 1.0\r\n";
							$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
							$messages="<html><body>
							        Estimado Administrador,
									<p>El siguiente usuario ha sido desactivado porque no ha actualizado su plan. Por favor, revíselo.</p>
									<p><b>Usuario: </b>$username</p>
									<p style='margin:1px;'>Saludos Cordiales,</p>
									<img id='whiteLogo' src='$site_url/wp-content/themes/foodyT/assets/images/logo.png' alt=''>
				
				 		   </body>
				 		   </html>";
				          mail($to,$subjects,$messages,$headers);

					} 
				}
	       }

?>
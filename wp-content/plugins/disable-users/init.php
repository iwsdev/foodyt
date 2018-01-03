<?php
/**
 * Plugin Name: Disable Users
 * Plugin URI:  http://wordpress.org/extend/disable-users
 * Description: This plugin provides the ability to disable specific user accounts.
 * Version:     1.0.5
 * Author:      Jared Atchison
 * Author URI:  http://jaredatchison.com 
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * @author     Jared Atchison
 * @version    1.0.5
 * @package    JA_DisableUsers
 * @copyright  Copyright (c) 2015, Jared Atchison
 * @link       http://jaredatchison.com
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

final class ja_disable_users {

	/**
	 * Initialize all the things
	 *
	 * @since 1.0.0
	 */
	function __construct() {

		// Actions
		add_action( 'init',                       array( $this, 'load_textdomain'             )        );
		add_action( 'show_user_profile',          array( $this, 'use_profile_field'           )        );
		add_action( 'edit_user_profile',          array( $this, 'use_profile_field'           )        );
		add_action( 'personal_options_update',    array( $this, 'user_profile_field_save'     )        );
		add_action( 'edit_user_profile_update',   array( $this, 'user_profile_field_save'     )        );
		add_action( 'wp_login',                   array( $this, 'user_login'                  ), 10, 2 );
		add_action( 'manage_users_custom_column', array( $this, 'manage_users_column_content' ), 10, 3 );
		add_action( 'admin_footer-users.php',	  array( $this, 'manage_users_css'            )        );
		
		// Filters
		add_filter( 'login_message',              array( $this, 'user_login_message'          )        );
		add_filter( 'manage_users_columns',       array( $this, 'manage_users_columns'	      )        );
	}

	/**
	 * Load the textdomain so we can support other languages
	 *
	 * @since 1.0.0
	 */
	public function load_textdomain() {
		$domain = 'ja_disable_users';
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );
		load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Add the field to user profiles
	 *
	 * @since 1.0.0
	 * @param object $user
	 */
	public function use_profile_field( $user ) {

		// Only show this option to users who can delete other users
		if ( !current_user_can( 'edit_users' ) )
			return;
		?>
		<table class="form-table">
			<tbody>
				<tr>
					<th>
						<label for="ja_disable_user"><?php _e(' User Account Status', 'ja_disable_users' ); ?></label>
					</th>



						<td>
					<?php
						 $checkedStatus = get_the_author_meta( 'ja_disable_user', $user->ID );

						if($checkedStatus==1){
						?>
						<input type="radio" name="ja_disable_user" id="ja_disable_user" value="1" <?php checked( 1, 1 ); ?> /> Disabled
						<?php } else { ?>

						<input type="radio" name="ja_disable_user" id="ja_disable_user" value="1" <?php checked( 1, 0 ); ?> /> Disabled

					   
						 <?php } 


						if($checkedStatus==0){
						?>

						<input type="radio" name="ja_disable_user" id="ja_disable_user" value="0" <?php checked( 1,  1); ?> />Enabled

						<?php } else { ?>

						<input type="radio" name="ja_disable_user" id="ja_disable_user" value="0" <?php checked( 1,  0); ?> />Enabled
						<?php } ?>
						  <!--  <input type="hidden" name="ja_disable_user" value="0"> -->
					

						

						
					</td>
					
				</tr>
			<tbody>
		</table>
		<?php
	}

	/**
	 * Saves the custom field to user meta
	 *
	 * @since 1.0.0
	 * @param int $user_id
	 */
	public function user_profile_field_save( $user_id ) {

		// Only worry about saving this field if the user has access
		if ( !current_user_can( 'edit_users' ) )
			return;
		if ( $_POST['ja_disable_user']== 0 ) 
		{
			    $disabled = 0;
			    $user_info = get_userdata($user_id);
                $username = $user_info->user_login;
                $useremail = $user_info->user_email;
                $pass = $user_info->pass;
			    $admin_email = get_option( 'admin_email' );
				$to =$useremail;
				$subjects = "Email de Aprobación";
				$headers = "From: " . strip_tags($admin_email) . "\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				$messages="<html><body>
				        Estimado $username,
						<p>Su Restaurante ha sido aprovado por el administrador. Ahora puede acceder a su perfil con la contraseña abajo indicada.
						</p>
						<a href='https://www.foodyt.com/login/'>Login</a>
						<table>
							<tr>
								<th style='float:left;'>Usuario: </th>
								<td style='float:left;'>$username </td>
							</tr>
							<tr>
								<th style='float:left;'>Contraseña: </th> 
								<td style='float:left;'>$pass</td>
	                        </tr>
                        </table>

						<p>Por favor, cambie su contraseña después de acceder al panel desde la sección Mi Cuenta.</p>

						<p style='margin:1px;'>Saludos Cordiales,</p>
						<img id='whiteLogo' src='https://www.foodyt.com/wp-content/themes/foodyT/assets/images/logo.png' alt=''>
	
	 		   </body>
	 		   </html>	
	          ";
				 if(mail($to,$subjects,$messages,$headers)){
					 // echo "mail send for Approval";
				 }
			  
			update_user_meta( $user_id, 'ja_disable_user', $disabled );
		}
		 else
		{
		   $disabled = 1;


		     // $disabled = $_POST['ja_disable_user'];
			    $user_info = get_userdata($user_id);
                $username = $user_info->user_login;
                $useremail = $user_info->user_email;
                $pass = $user_info->pass;
			    $admin_email = get_option( 'admin_email' );
				$to =$useremail;
				$subjects = "Email de Rechazo";
				$headers = "From: " . strip_tags($admin_email) . "\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				$messages="<html><body>
				        Estimado $username,
						<p>Su Restaurante ha sido rechazado por el administrador. Por favor, contacte con él para más información, usando los detales siguientes.:

						</p>
						
						<table>
							<tr>
								<th style='float:left;'>Correo electrónico del administrador:</th>
								<td style='float:left;'>$admin_email </td>
							</tr>
							<tr>
								<th style='float:left;'>Teléfono del administrador:</th> 
								<td style='float:left;'>9891586938</td>
	                        </tr>
                        </table>

						
						<p style='margin:1px;'>Saludos Cordiales,</p>
						<img id='whiteLogo' src='https://www.foodyt.com/wp-content/themes/foodyT/assets/images/logo.png' alt=''>
	
	 		   </body>
	 		   </html>	
	          ";
				 if(mail($to,$subjects,$messages,$headers)){
					 // echo "mail send for Rejection";
				 }
       update_user_meta( $user_id, 'ja_disable_user', $disabled );

		}
	 
		//update_user_meta( $user_id, 'ja_disable_user', $disabled );
		//echo "last".get_user_meta( $user_id, 'ja_disable_user', $disabled );

	}

	/**
	 * After login check to see if user account is disabled
	 *
	 * @since 1.0.0
	 * @param string $user_login
	 * @param object $user
	 */
	public function user_login( $user_login, $user = null ) {

		if ( !$user ) {
			$user = get_user_by('login', $user_login);
		}
		if ( !$user ) {
			// not logged in - definitely not disabled
			return;
		}
		// Get user meta
		$disabled = get_user_meta( $user->ID, 'ja_disable_user', true );
		
		// Is the use logging in disabled?
		if ( $disabled == '1' ) {
			// Clear cookies, a.k.a log user out
			wp_clear_auth_cookie();

			// Build login URL and then redirect
			$login_url = site_url( 'wp-login.php', 'login' );
			$login_url = add_query_arg( 'disabled', '1', $login_url );
			wp_redirect( $login_url );
			exit;
		}
	}

	/**
	 * Show a notice to users who try to login and are disabled
	 *
	 * @since 1.0.0
	 * @param string $message
	 * @return string
	 */
	public function user_login_message( $message ) {

		// Show the error message if it seems to be a disabled user
		if ( isset( $_GET['disabled'] ) && $_GET['disabled'] == 1 ) 
			$message =  '<div id="login_error">' . apply_filters( 'ja_disable_users_notice', __( 'Account disabled', 'ja_disable_users' ) ) . '</div>';

		return $message;
	}

	/**
	 * Add custom disabled column to users list
	 *
	 * @since 1.0.3
	 * @param array $defaults
	 * @return array
	 */
	public function manage_users_columns( $defaults ) {

		$defaults['ja_user_disabled'] = __( 'Disabled', 'ja_disable_users' );
		return $defaults;
	}

	/**
	 * Set content of disabled users column
	 *
	 * @since 1.0.3
	 * @param empty $empty
	 * @param string $column_name
	 * @param int $user_ID
	 * @return string
	 */
	public function manage_users_column_content( $empty, $column_name, $user_ID ) {

		if ( $column_name == 'ja_user_disabled' ) {
			if ( get_the_author_meta( 'ja_disable_user', $user_ID )	== 1 ) {
				return __( 'Disabled', 'ja_disable_users' );
			}
		}
	}

	/**
	 * Specifiy the width of our custom column
	 *
	 * @since 1.0.3
 	 */
	public function manage_users_css() {
		echo '<style type="text/css">.column-ja_user_disabled { width: 80px; }</style>';
	}
}
new ja_disable_users();
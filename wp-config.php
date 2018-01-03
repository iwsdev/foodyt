<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'cmsboxco_foodyt_db');

/** MySQL database username */
define('DB_USER', 'cmsboxco_foodyt');

/** MySQL database password */
define('DB_PASSWORD', 'iws123#');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'rJBKbBBIC&[]LyV$wb8-UQq^zX`@(Fc.)x*Dp^Lq.7E^,,/?B@:Rej/!-a$=x(HE');
define('SECURE_AUTH_KEY',  '7AP3e1}Ay+ELJM#x[KM`/)47WE##)mtO|5yD<+Q>{-e]Z1wV(+3eA76TS`gQ.=o0');
define('LOGGED_IN_KEY',    'gfe$uSyfOJDT$W`6k]oW?,Tta`F +V4Z(C_^ap*W1eo;vePz$uT{D#epFsa4@4>i');
define('NONCE_KEY',        'gfW &%>345qs7a@0doA:Sif@*hQL=cDOF&4e? $V>310)4[;(9XYV!mK)uwNh6k=');
define('AUTH_SALT',        '/[,rbYu~-)Xye:X$3Kc|tD=!sd.L=4{^NI:VW8}?oz]WK`>hD}i31M(IR7}k$Mz[');
define('SECURE_AUTH_SALT', '+t]6~P%fKc9=VN6/U$K`8.Z*ehsV1vMG_6E88HK5[B8DwN&saB6EGBY,DF*MPy),');
define('LOGGED_IN_SALT',   'M:me[+h4Virt QpPMU!v[>/joIU)P[>pac?K?+E1i)^^m_6Y<p>3p xO}E^e}@%3');
define('NONCE_SALT',       '8hPu/KaEKH9ibRHI_rJUt;u.v[~t1o>Rn2VPIr6M),>t$%~v@+_?A.D5~:@@q~K5');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'ft_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/*ini_set('log_errors','On');
ini_set('display_errors','Off');
ini_set('error_reporting', E_ALL );
define('WP_DEBUG', false);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);*/

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
//Disable File Edits
define('DISALLOW_FILE_EDIT', true);
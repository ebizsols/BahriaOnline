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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'bahria_wp_hsovt' );

/** MySQL database username */
define( 'DB_USER', 'bahria_wp_ymykm' );

/** MySQL database password */
define( 'DB_PASSWORD', '2!w$5jgoY%NAu102' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost:3306' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

define('DISABLE_WP_CRON', true);

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', '0:WhD8ohqjwA_1jg;JyppJGYV7+%[10R7O1-+o0yJ)U;!-!s6@J;b%HPuKdCjR;j');
define('SECURE_AUTH_KEY', 'w([5e)0*1R1FF)1|TjF|kBz#6q4D%;I85wV7@HK!Y3#6j1-T19UCTg_O0x%irEZ5');
define('LOGGED_IN_KEY', 'Fs@4|5P*uA94~y;T|2ei!:Iv6/q39eXi*Js4IJMs00h#ysA488&(_H+d|@HqM@#~');
define('NONCE_KEY', '!lQ%DPz8CB1!p276M]qhTo0mGL6l97T]gxZ:5#rY|7h3&Kb%~xp-#BEV%a8B9q;]');
define('AUTH_SALT', '*3pJJ_nkm2P5RB%72P&D62Gc~0)Wc40yns~Un@7E0uEwcX08W@1~#m64dV8]lR6T');
define('SECURE_AUTH_SALT', 'r~Ly75961f0St7_q-/33#]-1D4VjS9o+1ljsTz;[45TZr%-:[Wx46#-f_YLBT5L6');
define('LOGGED_IN_SALT', '27-f2)lU73QSSq[iQ|1:I471LfaIarQdMuSlXU4~(r7+(h6g5g!Q94T4&otwD9*6');
define('NONCE_SALT', 's%/3+Wq3:K39GwZGzuBx/-Q11o#04hu2p74r7)304zJ_@Lw:88z#7K7O75hc*|DX');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'ozCi9_';


define('WP_ALLOW_MULTISITE', true);
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
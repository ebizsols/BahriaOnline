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
define( 'DB_NAME', 'bahria_wp_qv7lg' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost:3306' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', '0rUDlylilb%ZZ7tjJYx1;D6Tg5&xu1nXhY6a42p&Q7%9J4;cf1PU-ES]Q2TIOq37');
define('SECURE_AUTH_KEY', 'NoxNwd7(GkQ%+u0lh+sriAeO%v8nCEP:1i_7U[y~v]7B:[H08:_T8-cyrjj~0WVU');
define('LOGGED_IN_KEY', ')11&o449340M_zAHq7t6|sK)7%|XUGvYj]Jw&6z1yemxffw:H!lwTEwMvh%]2VOq');
define('NONCE_KEY', ';2#80(2y92h9TJ4NT5:C6)4R8)yLac!v0f00XGu~rt3[8x0@l@03SKV(LZaVS]p0');
define('AUTH_SALT', '38Lr5]9YMzK~W5)V61@[ywm+v5VG79nbt%!30fFbf0NCyp&!crTVN7vVZ/5_O@a]');
define('SECURE_AUTH_SALT', 'X8NR:06qS_z!w3lf~uc7CWLsLVTL:3R_Ra#oJp5quE2Q6ItxhZXVuxVUDKM90R&R');
define('LOGGED_IN_SALT', '!!7[fd1fLDL-4BHzg8!l:;!iNe/0ps3B/Jp5854fJb*m58i4#2f:2w5U2W6:8bPT');
define('NONCE_SALT', 'D]Y(495|b1&eS8C10D+t9Y/6+z@7v*~(r_w-vI70*9%i72/2e)5~H1pCdUCS&&jv');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'UjKOx5_';


define('WP_ALLOW_MULTISITE', true);
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

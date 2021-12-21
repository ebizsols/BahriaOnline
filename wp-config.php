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
define( 'DB_NAME', 'bahria_wp_bvmfk' );

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
define('AUTH_KEY', 'ycn*x;3ciB5g4698]3@u95-]IjK7Y8xfn3Ze;m41Hgz#3*a*-G#bXjB7tv9p@Q9n');
define('SECURE_AUTH_KEY', '1C4Zie28cj97/9Hv~0X4llc2_!WX(8iAQ2fPMibwN-GtT1P1[z#&;m_5Z(&2CW(a');
define('LOGGED_IN_KEY', '9(*T8n*B0|:!-qI77m3Q2ed40lo2g]F7y:f2/LH|m19LMIC|gB-Mw2ZT)mPA+](*');
define('NONCE_KEY', '_+~!&2;euO~~89DdKZOPb:jZ6!KOeg8:X2aU[@Gm~P2!:8L[@pZ28xV3*[5224|@');
define('AUTH_SALT', 'wio04EtB!EPV1tgI]q8~p/c%8:y7JRx2_zB~&Lq0)J/DN7o/O/9SuF5qg_xK0R!#');
define('SECURE_AUTH_SALT', 'Lef47aj6Y)0xzIV/Jz7m68hy;/t%+Q0G00M6I!5%lXFVV(HkP9z89G6IxJ2TNN[1');
define('LOGGED_IN_SALT', 'w)z;x+HC1uhpV&/B62_RP%*91N6!#;rvrE)0Vi7+328vc;53rR83|l242&C#~Gn6');
define('NONCE_SALT', 'CL(2qG-[E]c:/97S28vE@6Ec84-8Gx20C6)uDIK0)L8hw_uqa222@O!z;z[#Q(tO');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'r7i9CiaQ_';


define('WP_ALLOW_MULTISITE', true);
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
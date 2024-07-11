<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'www_rowin_email' );

/** Database username */
define( 'DB_USER', 'www_rowin_email' );

/** Database password */
define( 'DB_PASSWORD', '2rDXSNZDdj' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'V:Tcy[$o).N`p5`^wFUgm@tR2*tSGDm7o9o WuM5aDZF5L7#yyn>dq`-Yl,ZO#>J' );
define( 'SECURE_AUTH_KEY',  'mc*%-ud$h{zel:L(h3?H8Dv(f=]?I6I+cwt/{Mdt<^${~ +A?k/iOx5$,XHkQE:F' );
define( 'LOGGED_IN_KEY',    'WJT)r;zj|wMi89V3%9Kj~jaF;:Sje.,.AIwjGr(Ol0usOuwiyIfE/iH/{vaZJ#m[' );
define( 'NONCE_KEY',        'Yl~NsSa=$|O I$VY=$__e?$BSMPA+_FBMmau%xP0{Be:_p!#<,d4vKL3r~? gaY]' );
define( 'AUTH_SALT',        'afx$5|Qr62s*VxioKJ+Su {`p!_<7ceM>&}JFB9cMPW 48dKs_qJJ;Kcxjox@T<|' );
define( 'SECURE_AUTH_SALT', '|c/UGR<4$6Wsm!V6Ii9a%zWObq,v:z?h{*bxb[Y:_cypC%`{]<il!66_V0+IxcGF' );
define( 'LOGGED_IN_SALT',   'B*S&/M97*;g9MIEbL^LdLrB$Fjz#c2;fkz%j(d8iz@Mur:a9}HuT8{7H+<oMk<f^' );
define( 'NONCE_SALT',       '6Rmc2h(VY<=%1RS{tk)(o0Gh.@DU(!EGtPs0Nv2u8Bajq)~Sc<tL1YUue3s=#O<H' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

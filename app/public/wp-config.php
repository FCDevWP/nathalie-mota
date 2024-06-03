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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          'gp2%i8RjEk3|ukd9D3?vl/|;TvkyHN>;vI--AK,zWA`_XPin;NU<KK[SNvjvje6v' );
define( 'SECURE_AUTH_KEY',   '9*Q(XfSF6BuH4{]Vw;jz3FW<qF(Y~12QuS#QH$~b~_p5NKH^r56|~E]#p`yq9o$N' );
define( 'LOGGED_IN_KEY',     '`i:4Tf 8v.#+~%7%#eAjKi+w@<{ykIPsz:X[+xylN/Q3`,tG2Rt}Cr)af1M]IUUT' );
define( 'NONCE_KEY',         '7J|6;r&1:00*DKfc1@!<^4ZF3g@iv1fAtT,xR/E(jL}Xr7 -D,|ud0Afa|xn?k^7' );
define( 'AUTH_SALT',         'L@Of<Z};Cu?Q?kgkbMl.1!glDQu<sD[sC<7ymt}87-m+]R`)}W5I-fL:(0VK3Hgy' );
define( 'SECURE_AUTH_SALT',  '.nz8OR~pvK}b_ccC?X-E((px*%rjHe}M%H[t10^<2ba3Cff(z|U;+{1kTl>zznYO' );
define( 'LOGGED_IN_SALT',    '|;DotXvm_&y%9.,BSD3[ UV1(yK=~~~K,G[?s_@VJ1]4abSJ}K(GW^)=OMVIap:@' );
define( 'NONCE_SALT',        'GLgJ>u:oidWs@-gt =D6nO|sRP5u2;Ak&LxzZB|xt4@_Gf&oib#c{L(p]sI[7gYQ' );
define( 'WP_CACHE_KEY_SALT', 'wL@Bc$l7hqVx!:y)>Vzo]qe[9M)/n,f*=^tK]/53YH)4]YideZats7@5gGGIIZ5]' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

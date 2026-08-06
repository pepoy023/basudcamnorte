<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'basudcamnorte' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

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
define( 'AUTH_KEY',         'MSCN)5N-$G];9c;thIYT$Qs26[/Ac}ZwfsRmh{W6K?:l/y*QmEnP[h1HqSd!&6vT' );
define( 'SECURE_AUTH_KEY',  '405O*I5;yYHe1}w&T3L=5uI-e2x`0`-46M-`85#^Wn)d96-E.Z|VWlnlR}wXcqEC' );
define( 'LOGGED_IN_KEY',    'Kh <_:C]fe9{~z4H`}!_OuV%p ar%iw1/oxam_,HWE,Wq~r0>-HRlo416vB,m^UH' );
define( 'NONCE_KEY',        'O(M2-Qta6[GP^Kyh>g|Q]u|}orS!iRs0%!&FgfciQGkHR>>P*l{gmjUh~ec[3o(,' );
define( 'AUTH_SALT',        'S4$>{qF?JNshbMu)&>a|ocVxeuR#CU$Ogh)>zD{puRZ;mzlkN6r:.:x8:L=i{}i`' );
define( 'SECURE_AUTH_SALT', 'dtMlK1E;3Z7vu5cO~h$RH4/~y7~W5G24]eBJ KpIszdB0kH`2a1MaL-*kuAE9 %l' );
define( 'LOGGED_IN_SALT',   '[$~VnZCbgY+NZ+@YYp$]L5e<0l.&O>yG=*geici]!%X`ygadYD<~K9cE:-dic+?[' );
define( 'NONCE_SALT',       'T3St(Nugo>.Q_K+z D-v4.iw`.b7rpx! &w1VLd{;2&M/HHdv7b?IN48S+K^NvC6' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'bcn_';

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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

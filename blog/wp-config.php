<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wp_locname');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'LocnameMasymas');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         '^|?QH:#@oD^<2rqxm` _Re$3qwSgc=|qGsWU SG[H8]=sQ#o Y%$ef+2FZ.&GYI ');
define('SECURE_AUTH_KEY',  'rr0F*ZX&6_~4(0LQ){T|g|vg4c_S,3t|Y>SEaGqpWn^ @I{@Sak>QS5v`#w?(8`d');
define('LOGGED_IN_KEY',    '~!]6+n#JBi-hR<q;SwPA||v9?1+g-ncpLmvT5R3(7QM)EFY3y-7p_y.F1Br&9-]-');
define('NONCE_KEY',        'To]ypc8wvUgwzj-r:&W=fyY_(-.}-J|}b/!RlAx2i=g_9G$eknN`XY}-+*+`CLF0');
define('AUTH_SALT',        'j~9GK.<(7pE&am#z*!JR9hm}zvuD{+cKtJu?1a_EqNMWIn@l|+cMsDyc:4*DQW^0');
define('SECURE_AUTH_SALT', '4|5bx+r7O(5%.PQKG0)p)Q-UW6np^Z0O-Onsu$[Y~|c.EWJ!?H[^W2+_[=|LRg--');
define('LOGGED_IN_SALT',   'Yu =^cpP+Cwcanv~q9psWb7or&>|ofA%<rQgcT=U1Q@4r)3l30jh|xQ@|:JV_V+W');
define('NONCE_SALT',       'iFXva~v.T}Gg~~60@Y EeDd5L-#yFeh;}]Ek+kX*l@B9fHk6feQsXwj&G@bS)~0_');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

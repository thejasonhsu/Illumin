<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         'tuG$t Ju+tkEq7<IR.(+yYl#FZAf{sX4 ep+jq<JRnR7^j%VA(X;db%r[01rj|.k');
define('SECURE_AUTH_KEY',  'Bj|n*Es?rv{vv065{VJ$$eNP1oE-7kn|mD,0+R:6pUSXByM`Qo|Esh.;3K~x*rIY');
define('LOGGED_IN_KEY',    '<AdgDiYrftN4_(r.v.dH-8|: sAc;H+`ktI-<e(Q/!<~hm<K__JETX|5hYr!<4U3');
define('NONCE_KEY',        'w!pB2e<6#|ibwwsO-Yda}KT#U5Gig@fiKKH1-Ot< .=Q<b_O|dF!(p;m5=guZtXc');
define('AUTH_SALT',        '3F8+#]V@h?,eD5y1`/{e~-;#?yg Yr`m>%{q2~#tj7.ok#6M xCX|-D>:}p.9+oM');
define('SECURE_AUTH_SALT', 'G>E{8F7eXfnRvM$.CcAl$N-_~4sBc:b[PD$GC:~=O<Ix<N#>+|tCXePyMW^1=zP-');
define('LOGGED_IN_SALT',   '.[?1|<t1r(7)C81SZHY<{U8c 3xtv;SyHO-7}{$O|S<lRnU] D1P_FQ}y?T}40M-');
define('NONCE_SALT',       '_-C:Y=YL8p0c%j>{O2F~aMH3hQ]*=:w03w2_VSl!R/#)XbC|5u;@R|iZi0LjX-?M');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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

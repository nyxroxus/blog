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
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         'L<bH?re$.$AFG{UDpF(m[^3pjLe7IJl_9Yak97FCc%.0`=]nKL&1g2ix+R}s7dcA');
define('SECURE_AUTH_KEY',  'iCA(9]tx&&F(|Ejt;*iB^;#fGSVO|n7H0%8qL]w)A~F1tnEPWnlU9<D7|G3/@UVA');
define('LOGGED_IN_KEY',    '!D.K+7}t]TKzs_@n$kVg]KZiHCAO0e[=SAS%au$m`O5![IS=fsc9k0<4JtMd.Yb,');
define('NONCE_KEY',        '!s?)-zq`/wK;<G>a1bW5Cy.qmb=@5.K]}n{:Q=v~zmgyrW{~x<3-D<Ij+DR1?)5`');
define('AUTH_SALT',        'nYf?tmX):HvpS$3fI`gZVUso5K8i@1zU+OC@>e&VCcSzZE[J8tb5490mXzikI.aN');
define('SECURE_AUTH_SALT', ':l2uobv&/tw*C,{~:4w1(%@>$56Gj6pdnRKjzcs0#.@ *az7@musIRWX]O O/G,j');
define('LOGGED_IN_SALT',   'gh6^])Bc3/{L$UoRH*nE3%3^2pIgi!so#$1b@kCs^MqpD@I~.epd:o{8)JLXRL,g');
define('NONCE_SALT',       'q<}/yO0NDO)qA0@K4Sj<<y/ymme/g ,p{CHyanKHn*?b[(R;SecKz^g8HC5Tns2i');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

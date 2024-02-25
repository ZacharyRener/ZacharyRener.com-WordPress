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


define('AUTH_KEY',         '1FZSd+xCsqyT3dg5rMFdve3Hv8Xn2mrrAd5Zec5d1huN5NttseuFufClbiTeatgwah0rdoBseq/rPmkkZgA6qw==');
define('SECURE_AUTH_KEY',  'SVEnY7uGQxJBC4BNn0WOt8F1fAEyqjwR5KN56yJsUSdLp9wogQZy/MFvv93TE4hcdX5LaoJGmwQUyl/cYa9Vqw==');
define('LOGGED_IN_KEY',    'D3ug/+zTwEg5bJ0AW5GipaPoM4P/gChyhrMcnvEqJ0EqZdxgsUgKyx5BTl/UBXMOFO6na0ysZlKPWi6VxAQLeg==');
define('NONCE_KEY',        'L2d/nQBuMZ8goGAlug5HryJ26shTGd8SB14KRrlT/WHPEBD5B1c639gvUv1woK8QtRKyCpl61p4aeUFoqwu0QQ==');
define('AUTH_SALT',        'I7ToYC2YHgnfiyZ3V/Sq9HywS87BLse/fT55oMXARLvIqlJ9U1+gE6Men9RFvE2yENw8p9FkqzStUWF28bburw==');
define('SECURE_AUTH_SALT', 'QfWeZE9zoyL7velWPROMS1NV9Qd+CHhF1xsKFtWJ5L6K46R55Vs5bcGay4eHo9Lo0N6gDqSK3dIokYkcWEOMnA==');
define('LOGGED_IN_SALT',   '8d3NdHR+K7FeE2Q3HFe3UAY0xFBSwko9SnXaWcXuSfObS9R7UwZWZBeLRvbd9QE+s5fNXY+0AJ6OBoZbStMIqQ==');
define('NONCE_SALT',       'FgIduSIQIyg21gJbak8wOvYMxRmrX/b3Hc+Sw1tjZy6k/ZCFRLC4QNaFZgmMOlAMd9EWKlwI9E8rcojxp7JaaA==');
define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

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
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         'Ci@KtKDO<v*Yb%q*z:vB~> 8_h%wK5C@-y9a4#oIRJoz)z&HBY>*R%#-;Z(Jid_*');
define('SECURE_AUTH_KEY',  'T 1K67R.|=AJ[9b4juwzTWmXlWCD3#oi<cz%OmBL-Z@xBQ:M+^dZmp8[=Wyt,6tD');
define('LOGGED_IN_KEY',    '!HQQ:H_5u]EpBa[8i8U1zD-v7ukA`SeU(1S`#`W72+A/s}($=fQZ3OQQp`Smj+CI');
define('NONCE_KEY',        '_UQib=$~C:,2piCJ5Xe5k$qD Ham*gEiW`F7e6N(yI+dG<F%MPfXW;yn9cg)pW&X');
define('AUTH_SALT',        ',3tS?,y^qU-dlIO7*2r*G8NDt5Hl=;BPmiaaqK(&|Ps(pZge72F/IE6a5sMzvJ)r');
define('SECURE_AUTH_SALT', '4ctwURTqm&gjmO6;K+n-JjScz2<|aK@m?#89^OxD4V2kj+pQ 9~R/g3`yhvZ9$4s');
define('LOGGED_IN_SALT',   '$-S,V9q[e!Ao>_ 1jA+Gm62a^VO^^^qeLwF0zrMntz?Q|E^#~j<{%@YJ,~*#d1A)');
define('NONCE_SALT',       ':wP0PBs$)vA;6T%[TMQo40(8/?s.%P]}a)#V%m04@@29B32qX3CUSz=Du,8_jD}/');

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

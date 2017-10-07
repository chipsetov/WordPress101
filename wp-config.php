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
define('DB_NAME', 'wordpress101');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '1111');

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
define('AUTH_KEY',         '(bz(/cwRC&A,F@?0GwV@3w5x,/*Y}D<e@JhD}wu2qox {X~0nP$P!eY1h:=vAR$p');
define('SECURE_AUTH_KEY',  'S72x0r)8sr!Keg?%H(7?]MEBJG_kFU+tD0hXGRQk:yj:.Bh$7n]zXdOz$*>^fNf0');
define('LOGGED_IN_KEY',    '7bHkN=,`7zxuI~(S5!GO#OK>C#e@Lh_{JL%ehe]Zu@>8Z!FZ/1BwKb7cI3~fs]Bw');
define('NONCE_KEY',        '~&HtU] OX{Y=CYXLXqTBdaZ,FcV]e0f74<V9^11ymL}d2LHmj~YSux_Ub5ZuqD>b');
define('AUTH_SALT',        't%*<]7Z7/#t_4K_4?W`yp(goCz8qmpyXFW7R{?-Tnx@~~8}.R8RD_.mvb$ac)90X');
define('SECURE_AUTH_SALT', 'N_`+uA._Z _3EE6jwHPePbJa59=W8cbHE^cDm|~im&N0j@=kdeBffSmE`i-}J1`%');
define('LOGGED_IN_SALT',   'n{`Zkl.7GPk$6(pe`ParUf1S0C8/vX>3e3ETgZ.Y/?Zj.WyN3Y4`l#wIWD/[,gqf');
define('NONCE_SALT',       '$-C?m>g,I@p7Tu[0}4F!weMG[2bF-WU:8Zc%ewE,Y;a)]wHpt&1`B%%OREsZmm6m');

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
define('WP_DEBUG', true);
define('WP_DEBUG_DISPLAY', true);
define('WP_DEBUG_LOG', true);


/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

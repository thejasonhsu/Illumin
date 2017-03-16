<?php
# Database Configuration
define( 'DB_NAME', 'wp_viterbiillumin' );
define( 'DB_USER', 'viterbiillumin' );
define( 'DB_PASSWORD', 'oICYFVPkQa1GjC2f6ppR' );
define( 'DB_HOST', '127.0.0.1' );
define( 'DB_HOST_SLAVE', '127.0.0.1' );
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', 'utf8_unicode_ci');
$table_prefix = 'wp_';

# Security Salts, Keys, Etc
define('AUTH_KEY',         '$~f`#xT4m<OK+fccH`-1t7HK:LIi#on ~LG~j2cx~(b5[X?Sy_/lNY(LyeOWNCK<');
define('SECURE_AUTH_KEY',  'OdYa9BLI%ROn$~+u}S_tSY0HF|:n>NA,ek#1i/}po+`?J^S@Xn>I`;nn[-zTz6S&');
define('LOGGED_IN_KEY',    '1c?CMY+!i:-z{Opu}@-#`VrDK-%4: j@jV#EYI.Nk~_EDO3G/7(,?;BGXq@]~X=/');
define('NONCE_KEY',        'IfQC0L,cP@Mb:s]1<e^{+w*|oe)`)K6yH3+[[$f]k+TcG.<u.zB_SI-sy-b=Z5#;');
define('AUTH_SALT',        ';QT^/;l0r,fXWXO@!EgB2z<of>seMkCw6HbL8;<z eXOFu-skL+Df+A5vV$({|3@');
define('SECURE_AUTH_SALT', 'A2HDNZ`sRQ!~s],P.pK|{_z+1v9tRQ-bn`&pg_=z!A/)^%K&UcdQzsF(?]M`& Nr');
define('LOGGED_IN_SALT',   'T#O@<uT{t%@}RA&wU(z_TS$w;7nG97@A!@?,x8VR0A?*|_?LQ+uV,k*R,|MN-A.Z');
define('NONCE_SALT',       'F(+HQ pt%|Z2P#=47i*%t|09VpQN8DarD4(uW]UOT|[}Wj-+<%ZcFlr^Y*o.Xgv$');


# Localized Language Stuff

define( 'WP_CACHE', TRUE );

define( 'WP_AUTO_UPDATE_CORE', false );

define( 'PWP_NAME', 'viterbiillumin' );

define( 'FS_METHOD', 'direct' );

define( 'FS_CHMOD_DIR', 0775 );

define( 'FS_CHMOD_FILE', 0664 );

define( 'PWP_ROOT_DIR', '/nas/wp' );

define( 'WPE_APIKEY', '763cb118669612725bb399c406df59b982d2bbfe' );

define( 'WPE_CLUSTER_ID', '100772' );

define( 'WPE_CLUSTER_TYPE', 'pod' );

define( 'WPE_ISP', true );

define( 'WPE_BPOD', false );

define( 'WPE_RO_FILESYSTEM', false );

define( 'WPE_LARGEFS_BUCKET', 'largefs.wpengine' );

define( 'WPE_SFTP_PORT', 2222 );

define( 'WPE_LBMASTER_IP', '' );

define( 'WPE_CDN_DISABLE_ALLOWED', false );

define( 'DISALLOW_FILE_MODS', FALSE );

define( 'DISALLOW_FILE_EDIT', FALSE );

define( 'DISABLE_WP_CRON', false );

define( 'WPE_FORCE_SSL_LOGIN', false );

define( 'FORCE_SSL_LOGIN', false );

/*SSLSTART*/ if ( isset($_SERVER['HTTP_X_WPE_SSL']) && $_SERVER['HTTP_X_WPE_SSL'] ) $_SERVER['HTTPS'] = 'on'; /*SSLEND*/

define( 'WPE_EXTERNAL_URL', false );

define( 'WP_POST_REVISIONS', FALSE );

define( 'WPE_WHITELABEL', 'wpengine' );

define( 'WP_TURN_OFF_ADMIN_BAR', false );

define( 'WPE_BETA_TESTER', false );

umask(0002);

$wpe_cdn_uris=array ( );

$wpe_no_cdn_uris=array ( );

$wpe_content_regexs=array ( );

$wpe_all_domains=array ( 0 => 'viterbiillumin.wpengine.com', );

$wpe_varnish_servers=array ( 0 => 'pod-100772', );

$wpe_special_ips=array ( 0 => '104.196.18.12', );

$wpe_ec_servers=array ( );

$wpe_largefs=array ( );

$wpe_netdna_domains=array ( );

$wpe_netdna_domains_secure=array ( );

$wpe_netdna_push_domains=array ( );

$wpe_domain_mappings=array ( );

$memcached_servers=array ( 'default' =>  array ( 0 => 'unix:///tmp/memcached.sock', ), );
define('WPLANG','');

# WP Engine ID


# WP Engine Settings






# That's It. Pencils down
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
require_once(ABSPATH . 'wp-settings.php');

$_wpe_preamble_path = null; if(false){}

<?php

$QUICKCACHE_VERSION="v2.1.1rc1";

$QUICKCACHE_DIR = _dirTempCache;

$QUICKCACHE_DB_HOST     = 'localhost';  // Database Server
$QUICKCACHE_DB_DATABASE = 'quickcache'; // Database-name to use
$QUICKCACHE_DB_USERNAME = '';           // Username
$QUICKCACHE_DB_PASSWORD = '';           // Password
$QUICKCACHE_DB_TABLE    = 'CACHEDATA';  // Table that holds the data
$QUICKCACHE_OPTIMIZE    = 1;            // If 'OPTIMIZE TABLE' after garbage

IF ($QUICKCACHE_DB_USERNAME != '') {
  $QUICKCACHE_TYPE = 'mysql'; /* means this is a 'MySQL' type cache */
} else {
  $QUICKCACHE_TYPE = 'file';  /* means this is a 'file' type cache */
}

$QUICKCACHE_TIME         =   _tempoCache; //60*30; // Default number of seconds to cache a page
$QUICKCACHE_DEBUG        =   0;   // Turn debugging on/off
$QUICKCACHE_IGNORE_DOMAIN=   1;   // Ignore domain name in request(single site)
$QUICKCACHE_ON           =   1;   // Turn caching on/off
$QUICKCACHE_USE_GZIP     =   1;   // Whether or not to use GZIP
$QUICKCACHE_POST         =   0;   // Should POST's be cached (default OFF)
$QUICKCACHE_GC           =   1;   // Probability % of garbage collection
$QUICKCACHE_GZIP_LEVEL   =   9;   // GZIPcompressionlevel to use (1=low,9=high)
$QUICKCACHE_CLEANKEYS    =   0;   // Set to 1 to avoid hashing storage-key:

$QUICKCACHE_FILEPREFIX = _prefixo_cache;

if ( isCGI() ) {
  $QUICKCACHE_ISCGI = 1;    // CGI-PHP is running
} else {
  $QUICKCACHE_ISCGI = 0;    // PHP is running as module - definitely not CGI
}

require "quickcache_main.php";
require "type/" . $QUICKCACHE_TYPE . ".php";
quickcache_start();

function isCGI() {
  if (substr(php_sapi_name(), 0, 3) == 'cgi') {
    return true;
  } else {
    return false;
  }
}

?>

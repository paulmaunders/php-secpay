<?

// Define passwords

define('SECPAY_USER', 'secpay');
define('SECPAY_PASSWORD', 'secpay');
define("SECPAY_REMOTE_PASSWORD", "secpay"); 

// Setup include path for Zend Framework

$includePaths = array();

// Specify path to Zend Framework
// Download a copy from http://framework.zend.com/releases/ZendFramework-1.10.3/ZendFramework-1.10.3-minimal.tar.gz

$includePaths[] = '/usr/share/php/ZendFramework-1.10.3-minimal/library';
$includePaths[] = get_include_path();

set_include_path(join(PATH_SEPARATOR, $includePaths));
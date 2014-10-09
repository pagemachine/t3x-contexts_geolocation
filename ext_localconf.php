<?php
/**
 * Geolocation contexts: Frontend configuration
 *
 * PHP version 5
 *
 * @category   TYPO3-Extensions
 * @package    Contexts
 * @subpackage Geolocation
 * @author     Christian Weiske <christian.weiske@netresearch.de>
 * @license    http://opensource.org/licenses/gpl-license GPLv2 or later
 * @link       http://github.com/netresearch/contexts_geolocation
 */
defined('TYPO3_MODE') or die('Access denied.');

if (TYPO3_MODE !== 'BE') {
    // We load that file in ext_tables.php for the backend
    include_once t3lib_extMgm::extPath($_EXTKEY) . 'ext_contexts.php';
}

t3lib_extMgm::addPItoST43(
    $_EXTKEY, 'pi/class.tx_contextsgeolocation_position.php',
    '_position', 'list_type', 0
);

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['contexts_geolocation'] = unserialize($_EXTCONF);

?>

<?php
/**
 * Geolocation contexts: Database table backend configuration
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

if (TYPO3_MODE === 'BE') {
    // All other modes did load it already
    include_once t3lib_extMgm::extPath($_EXTKEY) . 'ext_contexts.php';
}

t3lib_extMgm::addPlugin(
    array(
        'LLL:EXT:contexts_geolocation/Resources/Private/Language/locallang_db.xml:tt_content.list_type_contextsgeolocation_position',
        $_EXTKEY . '_position'
    ),
    'list_type'
);

$LanguagesToContext = array(
    'tx_contexts_geolocation_languages' => array(
        'exclude' => 0,
        'label' => 'Associated Languages',
        'config' => array(
            'type' => 'select',
            'foreign_table' => 'sys_language',
            'minitems' => 0,
            'size' => 10,
            'autoSizeMax' => 30,
            'maxitems' => 9999,
            'multiple' => 0,
        )
    )
);


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_contexts_contexts', $LanguagesToContext);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tx_contexts_contexts', 'tx_contexts_geolocation_languages', '', 'after:alias');

?>

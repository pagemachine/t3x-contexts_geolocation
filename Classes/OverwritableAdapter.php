<?php
/**
 * Part of geolocation context extension.
 *
 * PHP version 5
 *
 * @category   TYPO3-Extensions
 * @package    Contexts
 * @subpackage Geolocation
 * @author     Rico Sonntag <rico.sonntag@netresearch.de>
 * @license    http://opensource.org/licenses/gpl-license GPLv2 or later
 * @link       http://github.com/netresearch/contexts_geolocation
 */

/**
 * Abstract base class for each adapter.
 *
 * @category   TYPO3-Extensions
 * @package    Contexts
 * @subpackage Geolocation
 * @author     Rico Sonntag <rico.sonntag@netresearch.de>
 * @license    http://opensource.org/licenses/gpl-license GPLv2 or later
 * @link       http://github.com/netresearch/contexts_geolocation
 */
abstract class Tx_ContextsGeolocation_OverwritableAdapter extends Tx_Contexts_Geolocation_Adapter
{

    /**
     * Get country code from get parameters, if possible.
     *
     * @param boolean $threeLetterCode TRUE to return 3-letter country code
     *
     * @return string|false Country code or FALSE on failure
     */
    public function getCountryCode($threeLetterCode = false)
    {
       if ($countryCode = $_GET['cn']) {
            return $countryCode;
       }
       return false;
    }

    /**
     * Get two-letter continent code.
     *
     * @return string|false Continent code or FALSE on failure
     */
    public function getContinentCode()
    {
       if ($continentCode = $_GET['con']) {
            return $continentCode;
       }
       return false;
    }


}
?>

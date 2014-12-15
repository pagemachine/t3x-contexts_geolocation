<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2013 Netresearch GmbH & Co. KG <typo3.org@netresearch.de>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * Checks that the country of the user is one of the configured ones.
 *
 * @category   TYPO3-Extensions
 * @package    Contexts
 * @subpackage Geolocation
 * @author     Christian Weiske <christian.weiske@netresearch.de>
 * @license    http://opensource.org/licenses/gpl-license GPLv2 or later
 * @link       http://github.com/netresearch/contexts_geolocation
 */
class Tx_Contexts_Geolocation_Context_Type_Country
    extends Tx_Contexts_Context_Abstract
{

    /**
     * Constructor - set the values from database row.
     *
     * @param array $arRow Database context row
     *
     * @return void
     */
    public function __construct($arRow = array())
    {
        parent::__construct($arRow);

        if (!empty($arRow)) {
            $languages = explode(",",$arRow['tx_contexts_geolocation_languages']);
            foreach ($languages as $languageId) {
                $this->languages[] = $languageId;
            }
        }
    }    


    /**
     * @var array
     */
    protected $languages;

    /**
     * @return array
     */
    public function getLanguages() {
        return $this->languages;
    }

    /**
     * @param array $languages
     * @return void
     */
    public function setLanguages( $languages) {
        $this->languages = $languages;
    }
    
    /**
     * Check if the context is active now.
     *
     * @param array $arDependencies Array of dependent context objects
     *
     * @return boolean True if the context is active, false if not
     */
    public function match(array $arDependencies = array())
    {
        list($bUseMatch, $bMatch) = $this->getMatchFromSession();
        if ($bUseMatch && !$this->overrideValueAvailable()) {
            return $this->invert($bMatch);
        }

        return $this->invert($this->storeInSession(
            $this->matchCountries()
        ));
    }

    /**
     * Detects the current country and matches it against the list
     * of allowed countries
     *
     * @return boolean True if the user's country is in the list of
     *                 allowed countries, false if not
     */
    public function matchCountries()
    {
        try {
            $strCountries = trim($this->getConfValue('field_countries'));

            if ($strCountries == '') {
                //nothing configured? no match.
                return false;
            }

            $geoip = Tx_Contexts_Geolocation_Adapter
                ::getInstance($_SERVER['REMOTE_ADDR']);

            $arCountries = explode(',', $strCountries);
            $strCountry  = $geoip->getCountryCode(true);

            if (($strCountry === false)
                && in_array('*unknown*', $arCountries)
            ) {
                return true;
            }
            if (($strCountry !== false)
                && in_array($strCountry, $arCountries)
            ) {
                return true;
            }
        } catch (Tx_Contexts_Geolocation_Exception $exception) {
        }

        return false;
    }

    /**
     * Returns true if the configured GP variable for this context is present in GP.
     *
     * @return boolean 
     */
    public function overrideValueAvailable() {

        $settings = $this->getExtconfSettings();
        
        if (t3lib_div::_GP($settings['overrideParameters.']['country']) !== NULL) {
            return true;
        }
        return false;
    }

    /**
     * @return array EXTCONF settings for this extension
     */
    protected function getExtconfSettings() {

      return $GLOBALS['TSFE']->TYPO3_CONF_VARS['EXTCONF']['contexts_geolocation'];

    }

}
?>

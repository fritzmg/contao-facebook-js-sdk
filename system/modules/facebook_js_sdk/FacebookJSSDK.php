<?php

/**
 * Contao Open Source CMS
 *
 * simple extension to automatically integrate the Facebook JavaScript SDK in the Contao frontend or backend
 * 
 * @copyright inspiredminds 2015-2017
 * @package   facebook_js_sdk
 * @link      http://www.inspiredminds.at
 * @author    Fritz Michael Gschwantner <fmg@inspiredminds.at>
 * @license   GPL-2.0
 */


use Contao\Config;
use Contao\FrontendTemplate;
use Contao\PageModel;
use Contao\System;


class FacebookJSSDK
{
    /**
     * Enable in backend.
     * @var boolean
     */
    protected static $blnBackend = false;


    /**
     * Static function to enable in back end.
     *
     * @return void
     */
    public static function enableBackend()
    {
        self::$blnBackend = true;
    }


    /**
     * outputFrontendTemplate/outputBackendTemplate Hook
     *
     * @param string $strBuffer
     * @param string $strTemplate
     *
     * @return string
     */
    public function inject($strBuffer, $strTemplate)
    {
        $strAppId = self::getAppId();
        $strAppVersion = self::getAppVersion();

        // check for appId and version in config
        if (!$strAppId || !$strAppVersion)
        {
            return $strBuffer;
        }

        // check if this is the backend and output in backend is not enabled
        if (TL_MODE == 'BE' && !self::$blnBackend)
        {
            return $strBuffer;
        }

        // check frontend integration
        global $objPage;
        if (TL_MODE == 'FE' && $objPage && !PageModel::findById($objPage->rootId)->fb_sdk_frontend)
        {
            return $strBuffer;
        }

        // check for frontend or backend template
        if (stripos($strTemplate, 'fe_') === false && stripos($strTemplate, 'be_main') === false)
        {
            return $strBuffer;
        }

        // check for <body
        if (stripos($strBuffer, '<body') === false)
        {
            return $strBuffer;
        }

        // determine language string
        $lang = $GLOBALS['TL_LANGUAGE'];
        if (strlen($lang) == 2)
        {
            $lang = strtolower($lang) . '_' . strtoupper($lang);
        }
        else
        {
            $lang = str_replace('-', '_', $lang);
        }

        if ($lang == 'en_EN')
        {
            $lang = 'en_US';
        }

        $languages = System::getLanguages();

        if (!isset($languages[$lang]))
        {
            foreach ($languages as $language => $name)
            {
                if (strlen($language) > 2 && substr($lang, 0, 2) == substr($language, 0, 2))
                {
                    $lang = $language;
                    break;
                }
            }
        }

        // create the template
        $objTemplate = new FrontendTemplate('facebook-js-sdk');

        // set data
        $objTemplate->appId = $strAppId;
        $objTemplate->version = $strAppVersion;
        $objTemplate->lang = $lang;

        // search for body and inject template
        $strBuffer = preg_replace("/(<body.*>)/", "$1".$objTemplate->parse(), $strBuffer);

        // return the buffer
        return $strBuffer;
    }


    /**
     * Returns whether or not there is a valid config.
     * @return boolean
     */
    public static function hasValidConfig()
    {
        return (self::getAppId() && self::getAppSecret());
    }


    /**
     * Returns the defined Facebook App ID in the root page or system settings.
     * @return string
     */
    public static function getAppId()
    {
        global $objPage;

        if (TL_MODE == 'FE' && $objPage)
        {
            return PageModel::findById($objPage->rootId)->fb_app_id ?: Config::get('fb_app_id');
        }

        return Config::get('fb_app_id');
    }


    /**
     * Returns the defined Facebook App secret in the root page or system settings.
     * @return string
     */
    public static function getAppSecret()
    {
        global $objPage;

        if (TL_MODE == 'FE' && $objPage)
        {
            return PageModel::findById($objPage->rootId)->fb_app_secret ?: Config::get('fb_app_secret');
        }

        return Config::get('fb_app_secret');
    }


    /**
     * Returns the defined Facebook App API version in the root page or system settings.
     * @return string
     */
    public static function getAppVersion()
    {
        global $objPage;

        if (TL_MODE == 'FE' && $objPage)
        {
            return PageModel::findById($objPage->rootId)->fb_app_version ?: Config::get('fb_app_version');
        }

        return Config::get('fb_app_version');
    }
}

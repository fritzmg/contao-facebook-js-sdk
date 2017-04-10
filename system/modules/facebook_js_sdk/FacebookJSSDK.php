<?php

/**
 * Contao Open Source CMS
 *
 * simple extension to automatically integrate the Facebook JavaScript SDK in the Contao frontend or backend
 * 
 * @copyright inspiredminds 2015
 * @package   facebook_js_sdk
 * @link      http://www.inspiredminds.at
 * @author    Fritz Michael Gschwantner <fmg@inspiredminds.at>
 * @license   GPL-2.0
 */


class FacebookJSSDK
{

    /**
     * Force disable in back end
     * @var boolean
     */
    protected static $blnDisable = false;


    /**
     * Static function to force disable in the back end.
     *
     * @return void
     */
    public static function disable()
    {
        self::$blnDisable = true;
    }


    /**
     * outputFrontendTemplate/outputBackendTemplate Hook
     *
     * @param string $strBuffer
     * @param string $strTemplate
     *
     * @return string
     */
    public function inject( $strBuffer, $strTemplate )
    {
        // check if disabled
        if( self::$blnDisable )
        {
            return $strBuffer;
        }

        // check for appId and version in config
        if( !$GLOBALS['TL_CONFIG']['fb_app_id'] || !$GLOBALS['TL_CONFIG']['fb_app_version'] )
        {
            return $strBuffer;
        }

        // check for frontend or backend template
        if( stripos($strTemplate, 'fe_') === false && stripos($strTemplate, 'be_main') === false )
        {
            return $strBuffer;
        }

        // check for <body
        if( stripos( $strBuffer, '<body') === false )
        {
            return $strBuffer;
        }

        // determine language string
        $lang = $GLOBALS['TL_LANGUAGE'];
        if( strlen( $lang ) == 2 )
            $lang = strtolower( $lang ) . '_' . strtoupper( $lang );
        else
            $lang = str_replace( '-', '_', $lang );

        // create the template
        $objTemplate = new \FrontendTemplate('facebook-js-sdk');

        // set data
        $objTemplate->appId = $GLOBALS['TL_CONFIG']['fb_app_id'];
        $objTemplate->version = $GLOBALS['TL_CONFIG']['fb_app_version'];
        $objTemplate->lang = $lang;

        // search for body and inject template
        $strBuffer = preg_replace( "/(<body.*>)/", "$1".$objTemplate->parse(), $strBuffer );

        // return the buffer
        return $strBuffer;
    }
}

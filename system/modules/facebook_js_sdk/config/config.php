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


/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['outputFrontendTemplate'][] = array( 'FacebookJSSDK', 'inject' );
$GLOBALS['TL_HOOKS']['outputBackendTemplate'][] = array( 'FacebookJSSDK', 'inject' );


/**
 * Default config
 */
$GLOBALS['TL_CONFIG']['fb_app_version'] = 'v2.10';

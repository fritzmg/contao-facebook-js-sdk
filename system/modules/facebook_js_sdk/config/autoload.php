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
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'FacebookJSSDK' => 'system/modules/facebook_js_sdk/FacebookJSSDK.php'
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'facebook-js-sdk' => 'system/modules/facebook_js_sdk/templates'
));

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
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'].= ';{facebook_legend:hide},fb_app_id,fb_app_secret,fb_app_version';


/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_settings']['fields']['fb_app_id'] =  array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_settings']['fb_app_id'],
	'inputType' => 'text',
	'eval'      => array('tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['fb_app_secret'] =  array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_settings']['fb_app_secret'],
	'inputType' => 'text',
	'eval'      => array('tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['fb_app_version'] =  array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_settings']['fb_app_version'],
	'inputType' => 'text',
	'eval'      => array('tl_class'=>'w50')
);

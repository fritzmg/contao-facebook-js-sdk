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

use Contao\CoreBundle\DataContainer\PaletteManipulator;
use Contao\CoreBundle\Exception\PaletteNotFoundException;
use Contao\System;

System::loadLanguageFile('tl_settings');


/**
 * Palettes
 */
(static function () {
	$manipulator = PaletteManipulator::create()
		->addLegend('facebook_legend', 'publish_legend', PaletteManipulator::POSITION_BEFORE, true)
		->addField(
			['fb_app_id', 'fb_app_secret', 'fb_app_version', 'fb_sdk_frontend'], 'facebook_legend',
			PaletteManipulator::POSITION_APPEND
		);

	foreach (['root', 'rootfallback'] as $palette) {
		try {
			$manipulator->applyToPalette($palette, 'tl_page');
		} catch (PaletteNotFoundException $e) {}
	}
})();

/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_page']['fields']['fb_app_id'] = [
	'label'     => &$GLOBALS['TL_LANG']['tl_settings']['fb_app_id'],
	'inputType' => 'text',
	'eval'      => ['tl_class'=>'w50'],
	'sql'       => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_page']['fields']['fb_app_secret'] = [
	'label'     => &$GLOBALS['TL_LANG']['tl_settings']['fb_app_secret'],
	'inputType' => 'text',
	'eval'      => ['tl_class'=>'w50'],
	'sql'       => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_page']['fields']['fb_app_version'] = [
	'label'     => &$GLOBALS['TL_LANG']['tl_settings']['fb_app_version'],
	'inputType' => 'text',
	'eval'      => ['tl_class'=>'w50'],
	'sql'       => "varchar(8) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_page']['fields']['fb_sdk_frontend'] = [
	'label'     => &$GLOBALS['TL_LANG']['tl_page']['fb_sdk_frontend'],
	'inputType' => 'checkbox',
	'eval'      => ['tl_class'=>'w50 m12'],
	'sql'       => "char(1) NOT NULL default ''",
];

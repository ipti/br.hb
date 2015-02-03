<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014
 * @package yii2-grid
 * @version 2.9.0
 */

namespace kartik\grid;

use kartik\base\AssetBundle;
use yii\web\View;

/**
 * Asset bundle for GridView Toggle Data
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class GridToggleDataAsset extends AssetBundle
{
	public function init()
	{
		$this->setSourcePath(__DIR__ . '/assets');
		$this->setupAssets('js', ['js/kv-grid-toggle']);
		parent::init();
	}

}

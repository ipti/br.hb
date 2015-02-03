<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014
 * @package yii2-icons
 * @version 1.3.0
 */

namespace kartik\icons;

/**
 * Asset bundle for Elusive icon set
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class ElusiveAsset extends \kartik\base\AssetBundle
{

    public function init()
    {
        $this->setSourcePath(__DIR__ . '/lib/elusive');
        $this->setupAssets('css', ['css/elusive-webfont']);
        parent::init();
    }

}
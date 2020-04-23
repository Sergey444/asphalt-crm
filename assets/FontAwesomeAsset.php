<?php
/**
 * @link https://fontawesome.com/
 * @copyright © Fonticons, Inc.
 * @license https://fontawesome.com/license
 */

namespace app\assets;

use yii\web\AssetBundle;

class FontAwesomeAsset extends AssetBundle
{
    public $sourcePath = '@bower/font-awesome';
    public $css = [
        'css/all.min.css',
    ];
}
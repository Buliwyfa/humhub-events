<?php

namespace humhub\modules\ponyevents;

use yii\web\AssetBundle;

class Assets extends AssetBundle
{

    public $css = [
        'style.css'
    ];

    public function init()
    {
        $this->sourcePath = dirname(__FILE__) . '/assets';
        parent::init();
    }
}

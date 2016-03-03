<?php

namespace humhub\modules\ponyevents;

use Yii;
use yii\helpers\Url;
use yii\base\Object;

class Events extends Object
{

    public static function onTopMenuInit($event)
    {
        $event->sender->addItem([
            'label' => 'Events',
            'sortOrder' => 500,
            'url' => Url::to(['/ponyevents/events']),
            'icon' => '<i class="fa fa-map-marker"></i>',
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'ponyevents' && Yii::$app->controller->id == 'events')
        ]);
    }

    public static function addEventsPage($event)
    {
        if (Yii::$app->user->isGuest) {
            return;
        }

        $event->sender->view->registerAssetBundle(Assets::className());
    }

}
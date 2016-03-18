<?php

namespace humhub\modules\ponyevents\controllers;

use Yii;
use yii\caching\ApcCache;
use humhub\components\Controller;
use humhub\components\behaviors\AccessControl;

class EventsController extends Controller
{

    public function behaviors()
    {
        return [
            'acl' => [
                'class' => AccessControl::className()
            ]
        ];
    }

    public function actionIndex()
    {
        $cache = new ApcCache();
        $cache->useApcu = true;
        $json = null;

        if ($cache->exists('json')) {
            $json = $cache->get('json');
        } else {
            $response = file_get_contents('http://www.bronies.fr/?/api');
            $json = json_decode($response);

            $cache->add('json', $json, 3600);
        }

        return $this->render('main', ['json' => $json]);
    }

}

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
            $url = 'https://www.bronies.fr/?/api';

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_REFERER, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
            $response = curl_exec($curl);
            curl_close($curl);

            $json = json_decode($response);

            $cache->add('json', $json, 3600);
        }

        return $this->render('main', ['json' => $json]);
    }

}

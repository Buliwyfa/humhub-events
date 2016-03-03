<?php

namespace humhub\modules\ponyevents\libs;

use yii\caching\ApcCache;

class MapBox
{
    private static $token = 'pk.eyJ1IjoicG9ueWNpdHkiLCJhIjoiY2lsOWhiZnBuMDAzdHd5bHpzeTVwOHRkOCJ9.YjaoJJvenqIwo0NSYCuaqw';

    public static function getCoord($address)
    {
        $cache = new ApcCache();
        $cache->useApcu = true;

        $coordinates = null;
        $hash = sha1($address);

        if ($cache->exists($hash)) {
            $coordinates = $cache->get($hash);
        } else {
            $json = file_get_contents('https://api.mapbox.com/geocoding/v5/mapbox.places/' . urlencode($address) . '.json?access_token=' . self::$token);
            $coordinates = json_decode($json)->features[0]->geometry->coordinates;
            $cache->set($hash, $coordinates, 3600);
        }

        return $coordinates;
    }
}
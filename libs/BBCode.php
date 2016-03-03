<?php

namespace humhub\modules\ponyevents\libs;

use yii\caching\ApcCache;

class BBCode
{

    private static $callbacks = [
        'centerToHTML' => '#\[center\](.*?)\[\/center\]#is',
        'boldToHTML' => '#\[b\](.*?)\[\/b\]#is',
        'imgToHTML' => '#\[img\](.*?)\[\/img\]#is',
        'urlToHTML' => '#\[url=(.*?)\](.*?)\[\/url\]#is',
        'underlineToHTML' => '#\[u\](.*?)\[\/u\]#is'
    ];

    private static $string;

    public static function parse($string)
    {
        $cache = new ApcCache();
        $cache->useApcu = true;

        $hash = sha1($string);

        if ($cache->exists($hash)) {
            self::$string = $cache->get($hash);
        } else {
            self::$string = $string;

            foreach (self::$callbacks as $callback => $regex) {
                self::match($regex, [self::class, $callback]);
            }

            $cache->set($hash, self::$string, 3600);
        }

        return self::$string;
    }

    private static function match($regex, array $callback)
    {
        while (preg_match($regex, self::$string))
        {
            self::$string = preg_replace_callback($regex, $callback, self::$string);
        }
    }

    private static function centerToHTML($match)
    {
        return '<div class="centered">' . $match[1] . '</div>';
    }

    private static function boldToHTML($match)
    {
        return '<b>' . $match[1] . '</b>';
    }

    private static function urlToHTML($match)
    {
        return '<a href="' . $match[1] . '">' . $match[2] . '</a>';
    }

    private static function imgToHTML($match)
    {
        return '<img src="' . $match[1] . '"/>';
    }

    private static function underlineToHTML($match)
    {
        return '<span style="text-decoration: underline">' . $match[1] . '</span>';
    }

}
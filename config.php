<?php

namespace humhub\modules\ponyevents;

use humhub\widgets\TopMenu;

return [
    'id' => 'ponyevents',
    'class' => 'humhub\modules\ponyevents\Module',
    'namespace' => 'humhub\modules\ponyevents',
    'events' => [
        [
            'class' => TopMenu::className(),
            'event' => TopMenu::EVENT_INIT,
            'callback' => [
                'humhub\modules\ponyevents\Events',
                'addEventsPage'
            ]
        ],
        [
            'class' => TopMenu::className(),
            'event' => TopMenu::EVENT_INIT,
            'callback' => [
                'humhub\modules\ponyevents\Events',
                'onTopMenuInit'
            ]
        ]
    ]
];

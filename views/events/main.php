<?php
use humhub\modules\ponyevents\libs\BBCode;
use humhub\modules\ponyevents\libs\MapBox;
?>

<script src="https://api.mapbox.com/mapbox.js/v2.3.0/mapbox.js"></script>
<link href="https://api.mapbox.com/mapbox.js/v2.3.0/mapbox.css" rel="stylesheet"/>

<div class="container">
    <div class="row event">
    <?php foreach ($json as $event): ?>
        <div class="col-md-8">
            <div class="panel panel-default main">
                <a href="http://bronies.fr/?/event/<?= $event->id ?>">
                    <h1><?= $event->muName ?></h1>
                </a>

                <hr/>

                <div class="description">
                    <p><?= BBCode::parse($event->description) ?></p>
                </div>

                <hr/>

                <div class="links">
                    <?php if (!empty($event->lien_facebook)): ?>
                        <p><a class="facebook" href="<?= $event->lien_facebook ?>">Lien Facebook <i class="fa fa-facebook"></i></a></p>
                    <?php endif ?>
                    <?php if (!empty($event->lien_site)): ?>
                        <p><a class="website" href="<?= $event->lien_site ?>">Lien du site <i class="fa fa-home"></i></a></p>
                    <?php endif ?>
                    <p>Et faites en profiter vos amis !</p>
                </div>

                <div class="participants">
                    <p><b>Participants : <?= $event->participants ?></b></p>
                </div>

                <em>Créé le <?= \Yii::$app->formatter->asDate($event->date_creation, 'php:l d F à H:i') ?> sur <a href="http://bronies.fr">bronies.fr</a>, ajoutez votre meet-up sur <a style="text-decoration: underline;" href="http://bronies.fr">bronies.fr</a></em>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-default info">
                <img class="banner" src="http://bronies.fr/images/events/<?= $event->banner?>"/>

                <h2>Meet up :</h2>
                <em>Référencé par <?= $event->referencer ?> et organisé par <?= empty($event->organizer) ? 'N.A.' : $event->organizer ?></em>

                <h2>Infos :</h2>
                <em>Du <?= \Yii::$app->formatter->asDate($event->date_event_start, 'php:l d F H:i') ?> au <?= \Yii::$app->formatter->asDate($event->date_event_end, 'php:l d F H:i') ?></em>

                <h2>Coordonnées :</h2>
                <p>Ville : <?= $event->city ?></p>
                <p>Addresse : <?= empty($event->address) ? 'N.A.' : $event->address ?></p>

                <div class="map-container">
                    <div class="mapbox" id="map-<?= $event->id ?>"></div>
                </div>

                <script>
                    <?php $coord = MapBox::getCoord($event->city) ?>

                    L.mapbox.accessToken = 'pk.eyJ1IjoicG9ueWNpdHkiLCJhIjoiY2lsOWhiZnBuMDAzdHd5bHpzeTVwOHRkOCJ9.YjaoJJvenqIwo0NSYCuaqw';
                    var map = L.mapbox.map('map-<?= $event->id ?>', 'mapbox.streets').setView([<?= $coord[1] ?>, <?= $coord[0] ?>], 16);

                    L.mapbox.featureLayer({
                        type: 'Feature',
                        geometry: {
                            type: 'Point',
                            coordinates: [
                                <?= $coord[0] ?>,
                                <?= $coord[1] ?>
                            ]
                        },
                        properties: {
                            'marker-size': 'large',
                            'marker-symbol': 'marker-stroked'
                        }
                    }).addTo(map);
                </script>
            </div>
        </div>
    <?php endforeach ?>
    </div>
</div>


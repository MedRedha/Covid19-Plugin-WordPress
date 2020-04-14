<?php

/**
 * COVID-19 Coronavirus — Live Map & Widgets for WordPress
 * The plugin allows adding statistics table/widgets via shortcode to inform site visitors about changes in the situation about Coronavirus pandemic.
 * Envato Market https://1.envato.market/covid
 *
 * @encoding		UTF-8
 * @copyright		Copyright (C) 2020 NYCreatis (https://1.envato.market/nyc). All rights reserved.
 * @license         Envato License https://1.envato.market/KYbje
 **/

namespace GuzzleHttp\Event;

/**
 * Trait that implements the methods of HasEmitterInterface
 */
trait HasEmitterTrait
{
    /** @var EmitterInterface */
    private $emitter;

    public function getEmitter()
    {
        if (!$this->emitter) {
            $this->emitter = new Emitter();
        }

        return $this->emitter;
    }
}

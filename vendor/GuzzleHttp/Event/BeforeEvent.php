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

use GuzzleHttp\Message\ResponseInterface;

/**
 * Event object emitted before a request is sent.
 *
 * You may change the Response associated with the request using the
 * intercept() method of the event.
 */
class BeforeEvent extends AbstractRequestEvent
{
    /**
     * Intercept the request and associate a response
     *
     * @param ResponseInterface $response Response to set
     */
    public function intercept(ResponseInterface $response)
    {
        $this->getTransaction()->setResponse($response);
        $this->stopPropagation();
        RequestEvents::emitComplete($this->getTransaction());
    }
}

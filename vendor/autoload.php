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

$mapping = [
    'GuzzleHttp\Stream\AppendStream' => __DIR__ . '/GuzzleHttp/Stream/AppendStream.php',
    'GuzzleHttp\Stream\CachingStream' => __DIR__ . '/GuzzleHttp/Stream/CachingStream.php',
    'GuzzleHttp\Stream\Exception\SeekException' => __DIR__ . '/GuzzleHttp/Stream/Exception/SeekException.php',
    'GuzzleHttp\Stream\FnStream' => __DIR__ . '/GuzzleHttp/Stream/FnStream.php',
    'GuzzleHttp\Stream\GuzzleStreamWrapper' => __DIR__ . '/GuzzleHttp/Stream/GuzzleStreamWrapper.php',
    'GuzzleHttp\Stream\InflateStream' => __DIR__ . '/GuzzleHttp/Stream/InflateStream.php',
    'GuzzleHttp\Stream\LazyOpenStream' => __DIR__ . '/GuzzleHttp/Stream/LazyOpenStream.php',
    'GuzzleHttp\Stream\LimitStream' => __DIR__ . '/GuzzleHttp/Stream/LimitStream.php',
    'GuzzleHttp\Stream\MetadataStreamInterface' => __DIR__ . '/GuzzleHttp/Stream/MetadataStreamInterface.php',
    'GuzzleHttp\Stream\NoSeekStream' => __DIR__ . '/GuzzleHttp/Stream/NoSeekStream.php',
    'GuzzleHttp\Stream\Stream' => __DIR__ . '/GuzzleHttp/Stream/Stream.php',
    'GuzzleHttp\Stream\StreamDecoratorTrait' => __DIR__ . '/GuzzleHttp/Stream/StreamDecoratorTrait.php',
    'GuzzleHttp\Stream\StreamInterface' => __DIR__ . '/GuzzleHttp/Stream/StreamInterface.php',
    'GuzzleHttp\Stream\Utils' => __DIR__ . '/GuzzleHttp/Stream/Utils.php',
    'GuzzleHttp\Stream\functions' => __DIR__ . '/GuzzleHttp/Stream/functions.php',
    'GuzzleHttp\Adapter\AdapterInterface' => __DIR__ . '/GuzzleHttp/Adapter/AdapterInterface.php',
    'GuzzleHttp\Adapter\Curl\BatchContext' => __DIR__ . '/GuzzleHttp/Adapter/Curl/BatchContext.php',
    'GuzzleHttp\Adapter\Curl\CurlAdapter' => __DIR__ . '/GuzzleHttp/Adapter/Curl/CurlAdapter.php',
    'GuzzleHttp\Adapter\Curl\CurlFactory' => __DIR__ . '/GuzzleHttp/Adapter/Curl/CurlFactory.php',
    'GuzzleHttp\Adapter\Curl\MultiAdapter' => __DIR__ . '/GuzzleHttp/Adapter/Curl/MultiAdapter.php',
    'GuzzleHttp\Adapter\Curl\RequestMediator' => __DIR__ . '/GuzzleHttp/Adapter/Curl/RequestMediator.php',
    'GuzzleHttp\Adapter\FakeParallelAdapter' => __DIR__ . '/GuzzleHttp/Adapter/FakeParallelAdapter.php',
    'GuzzleHttp\Adapter\MockAdapter' => __DIR__ . '/GuzzleHttp/Adapter/MockAdapter.php',
    'GuzzleHttp\Adapter\ParallelAdapterInterface' => __DIR__ . '/GuzzleHttp/Adapter/ParallelAdapterInterface.php',
    'GuzzleHttp\Adapter\StreamAdapter' => __DIR__ . '/GuzzleHttp/Adapter/StreamAdapter.php',
    'GuzzleHttp\Adapter\StreamingProxyAdapter' => __DIR__ . '/GuzzleHttp/Adapter/StreamingProxyAdapter.php',
    'GuzzleHttp\Adapter\Transaction' => __DIR__ . '/GuzzleHttp/Adapter/Transaction.php',
    'GuzzleHttp\Adapter\TransactionInterface' => __DIR__ . '/GuzzleHttp/Adapter/TransactionInterface.php',
    'GuzzleHttp\Adapter\TransactionIterator' => __DIR__ . '/GuzzleHttp/Adapter/TransactionIterator.php',
    'GuzzleHttp\Client' => __DIR__ . '/GuzzleHttp/Client.php',
    'GuzzleHttp\ClientInterface' => __DIR__ . '/GuzzleHttp/ClientInterface.php',
    'GuzzleHttp\Collection' => __DIR__ . '/GuzzleHttp/Collection.php',
    'GuzzleHttp\Cookie\CookieJar' => __DIR__ . '/GuzzleHttp/Cookie/CookieJar.php',
    'GuzzleHttp\Cookie\CookieJarInterface' => __DIR__ . '/GuzzleHttp/Cookie/CookieJarInterface.php',
    'GuzzleHttp\Cookie\FileCookieJar' => __DIR__ . '/GuzzleHttp/Cookie/FileCookieJar.php',
    'GuzzleHttp\Cookie\SessionCookieJar' => __DIR__ . '/GuzzleHttp/Cookie/SessionCookieJar.php',
    'GuzzleHttp\Cookie\SetCookie' => __DIR__ . '/GuzzleHttp/Cookie/SetCookie.php',
    'GuzzleHttp\Event\AbstractEvent' => __DIR__ . '/GuzzleHttp/Event/AbstractEvent.php',
    'GuzzleHttp\Event\AbstractRequestEvent' => __DIR__ . '/GuzzleHttp/Event/AbstractRequestEvent.php',
    'GuzzleHttp\Event\AbstractTransferEvent' => __DIR__ . '/GuzzleHttp/Event/AbstractTransferEvent.php',
    'GuzzleHttp\Event\BeforeEvent' => __DIR__ . '/GuzzleHttp/Event/BeforeEvent.php',
    'GuzzleHttp\Event\CompleteEvent' => __DIR__ . '/GuzzleHttp/Event/CompleteEvent.php',
    'GuzzleHttp\Event\Emitter' => __DIR__ . '/GuzzleHttp/Event/Emitter.php',
    'GuzzleHttp\Event\EmitterInterface' => __DIR__ . '/GuzzleHttp/Event/EmitterInterface.php',
    'GuzzleHttp\Event\ErrorEvent' => __DIR__ . '/GuzzleHttp/Event/ErrorEvent.php',
    'GuzzleHttp\Event\EventInterface' => __DIR__ . '/GuzzleHttp/Event/EventInterface.php',
    'GuzzleHttp\Event\HasEmitterInterface' => __DIR__ . '/GuzzleHttp/Event/HasEmitterInterface.php',
    'GuzzleHttp\Event\HasEmitterTrait' => __DIR__ . '/GuzzleHttp/Event/HasEmitterTrait.php',
    'GuzzleHttp\Event\HeadersEvent' => __DIR__ . '/GuzzleHttp/Event/HeadersEvent.php',
    'GuzzleHttp\Event\ListenerAttacherTrait' => __DIR__ . '/GuzzleHttp/Event/ListenerAttacherTrait.php',
    'GuzzleHttp\Event\RequestEvents' => __DIR__ . '/GuzzleHttp/Event/RequestEvents.php',
    'GuzzleHttp\Event\SubscriberInterface' => __DIR__ . '/GuzzleHttp/Event/SubscriberInterface.php',
    'GuzzleHttp\Exception\AdapterException' => __DIR__ . '/GuzzleHttp/Exception/AdapterException.php',
    'GuzzleHttp\Exception\BadResponseException' => __DIR__ . '/GuzzleHttp/Exception/BadResponseException.php',
    'GuzzleHttp\Exception\ClientException' => __DIR__ . '/GuzzleHttp/Exception/ClientException.php',
    'GuzzleHttp\Exception\CouldNotRewindStreamException' => __DIR__ . '/GuzzleHttp/Exception/CouldNotRewindStreamException.php',
    'GuzzleHttp\Exception\ParseException' => __DIR__ . '/GuzzleHttp/Exception/ParseException.php',
    'GuzzleHttp\Exception\RequestException' => __DIR__ . '/GuzzleHttp/Exception/RequestException.php',
    'GuzzleHttp\Exception\ServerException' => __DIR__ . '/GuzzleHttp/Exception/ServerException.php',
    'GuzzleHttp\Exception\TooManyRedirectsException' => __DIR__ . '/GuzzleHttp/Exception/TooManyRedirectsException.php',
    'GuzzleHttp\Exception\TransferException' => __DIR__ . '/GuzzleHttp/Exception/TransferException.php',
    'GuzzleHttp\Exception\XmlParseException' => __DIR__ . '/GuzzleHttp/Exception/XmlParseException.php',
    'GuzzleHttp\HasDataTrait' => __DIR__ . '/GuzzleHttp/HasDataTrait.php',
    'GuzzleHttp\Message\AbstractMessage' => __DIR__ . '/GuzzleHttp/Message/AbstractMessage.php',
    'GuzzleHttp\Message\MessageFactory' => __DIR__ . '/GuzzleHttp/Message/MessageFactory.php',
    'GuzzleHttp\Message\MessageFactoryInterface' => __DIR__ . '/GuzzleHttp/Message/MessageFactoryInterface.php',
    'GuzzleHttp\Message\MessageInterface' => __DIR__ . '/GuzzleHttp/Message/MessageInterface.php',
    'GuzzleHttp\Message\MessageParser' => __DIR__ . '/GuzzleHttp/Message/MessageParser.php',
    'GuzzleHttp\Message\Request' => __DIR__ . '/GuzzleHttp/Message/Request.php',
    'GuzzleHttp\Message\RequestInterface' => __DIR__ . '/GuzzleHttp/Message/RequestInterface.php',
    'GuzzleHttp\Message\Response' => __DIR__ . '/GuzzleHttp/Message/Response.php',
    'GuzzleHttp\Message\ResponseInterface' => __DIR__ . '/GuzzleHttp/Message/ResponseInterface.php',
    'GuzzleHttp\Mimetypes' => __DIR__ . '/GuzzleHttp/Mimetypes.php',
    'GuzzleHttp\Post\MultipartBody' => __DIR__ . '/GuzzleHttp/Post/MultipartBody.php',
    'GuzzleHttp\Post\PostBody' => __DIR__ . '/GuzzleHttp/Post/PostBody.php',
    'GuzzleHttp\Post\PostBodyInterface' => __DIR__ . '/GuzzleHttp/Post/PostBodyInterface.php',
    'GuzzleHttp\Post\PostFile' => __DIR__ . '/GuzzleHttp/Post/PostFile.php',
    'GuzzleHttp\Post\PostFileInterface' => __DIR__ . '/GuzzleHttp/Post/PostFileInterface.php',
    'GuzzleHttp\Query' => __DIR__ . '/GuzzleHttp/Query.php',
    'GuzzleHttp\QueryParser' => __DIR__ . '/GuzzleHttp/QueryParser.php',
    'GuzzleHttp\Subscriber\Cookie' => __DIR__ . '/GuzzleHttp/Subscriber/Cookie.php',
    'GuzzleHttp\Subscriber\History' => __DIR__ . '/GuzzleHttp/Subscriber/History.php',
    'GuzzleHttp\Subscriber\HttpError' => __DIR__ . '/GuzzleHttp/Subscriber/HttpError.php',
    'GuzzleHttp\Subscriber\Mock' => __DIR__ . '/GuzzleHttp/Subscriber/Mock.php',
    'GuzzleHttp\Subscriber\Prepare' => __DIR__ . '/GuzzleHttp/Subscriber/Prepare.php',
    'GuzzleHttp\Subscriber\Redirect' => __DIR__ . '/GuzzleHttp/Subscriber/Redirect.php',
    'GuzzleHttp\ToArrayInterface' => __DIR__ . '/GuzzleHttp/ToArrayInterface.php',
    'GuzzleHttp\UriTemplate' => __DIR__ . '/GuzzleHttp/UriTemplate.php',
    'GuzzleHttp\Url' => __DIR__ . '/GuzzleHttp/Url.php',
    'GuzzleHttp\functions' => __DIR__ . '/GuzzleHttp/functions.php',
];

spl_autoload_register(function ($class) use ($mapping) {
    if (isset($mapping[$class])) {
        include $mapping[$class];
    }
}, true);

require __DIR__ . '/GuzzleHttp/functions.php';

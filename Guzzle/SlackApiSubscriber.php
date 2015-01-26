<?php
/**
 * This file is part of the Slack API Bundle, a Symfony bundle for Slack.com
 * Copyright (C) 2015  Tyler Romeo <tylerromeo@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */


namespace CastlePointAnime\SlackApiBundle\Guzzle;

use GuzzleHttp\Command\Event\ProcessEvent;
use GuzzleHttp\Event\HasEmitterInterface;
use GuzzleHttp\Event\SubscriberInterface;

class SlackApiSubscriber implements SubscriberInterface
{
    /**
     * @param HasEmitterInterface $client
     */
    public function subscribe( HasEmitterInterface $client )
    {
        $client->getEmitter()->attach( $this );
    }

    /**
     * {@inheritDoc}
     */
    public function getEvents()
    {
        return [
            'process' => [ 'onProcess' ],
        ];
    }

    /**
     * @internal
     *
     * @param ProcessEvent $event
     */
    public function onProcess( ProcessEvent $event )
    {
        // Decode the JSON response
        $data = '';

        try {
            $data = $event->getResponse()->getBody()->getContents();
            $json = $event->getResponse()->json();
        } catch ( \RuntimeException $e ) {
            // Invalid response; make our own error message
            $json = [
                'ok' => $data === 'ok',
                'error' => $data
            ];
        }

        if (!isset( $json[ 'ok' ] ) || $json[ 'ok' ] === false) {
            throw new SlackApiException( $json[ 'error' ], $event->getTransaction() );
        }
    }
}

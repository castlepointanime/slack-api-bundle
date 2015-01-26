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

namespace CastlePointAnime\SlackApiBundle\Controller;

use CastlePointAnime\SlackApiBundle\Event\HookResponseEvent;
use CastlePointAnime\SlackApiBundle\SlackDispatcher;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class DefaultController
{
    /** @var \CastlePointAnime\SlackApiBundle\SlackDispatcher */
    private $dispatcher;

    private $outgoingTokens;

    private $slashTokens;

    private $logger;

    public function __construct( SlackDispatcher $dispatcher, array $outgoingTokens, array $slashTokens, LoggerInterface $logger )
    {
        $this->dispatcher = $dispatcher;
        $this->outgoingTokens = $outgoingTokens;
        $this->slashTokens = $slashTokens;
        $this->logger = $logger;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke( Request $request )
    {
        $event = new HookResponseEvent();

        $event->team = $request->request->get( 'team_id' );
        $event->channelId = $request->request->get( 'channel_id' );
        $event->channelName = $request->request->get( 'channel_name' );
        $event->timestamp = $request->request->get( 'timestamp' );
        $event->userId = $request->request->get( 'user_id' );
        $event->userName = $request->request->get( 'user_name' );
        $event->text = $request->request->get( 'text' );
        $event->triggerWord = $request->request->get( 'trigger_word' );
        $event->slashCommand = $request->request->get( 'command' );

        $token = $request->request->get( 'token' );

        $this->logger->debug( 'Received message from Slack.', [ 'token' => $token, 'event' => $event ] );

        // Get slash command and/or trigger word
        // Make sure to check token from Slack
        if ($event->slashCommand && !in_array( $token, $this->slashTokens )
            || !$event->slashCommand && !in_array( $token, $this->outgoingTokens )
        ) {
            $this->logger->error( 'Received invalid token from a request.', [ 'token' => $token, 'event' => $event ] );
            throw new AccessDeniedException();
        }

        return $this->dispatcher->dispatchResponse( $event );
    }
}

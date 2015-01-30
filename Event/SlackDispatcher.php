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


namespace CastlePointAnime\SlackApiBundle\Event;

use CastlePointAnime\SlackApiBundle\ModuleDescriptorInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Event dispatcher for managing Slack API modules and sending events
 * to those modules when applicable
 *
 * @package CastlePointAnime\SlackApiBundle\Event
 */
class SlackDispatcher extends EventDispatcher
{
    private $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct( LoggerInterface $logger )
    {
        $this->logger = $logger;
    }

    /**
     * Register a module with the dispatcher
     *
     * Use information from the module descriptor to subscribe the module
     * to the appropriate event names that will be used to send out events.
     *
     * @param ModuleDescriptorInterface $module Descriptor for the module
     * @param int $priority Priority to be passed to EventDispatcher
     */
    public function register( ModuleDescriptorInterface $module, $priority = 0 )
    {
        $this->logger->debug( 'Loading module in Slack registry.', [ 'module' => $module, 'priority' => $priority ] );

        if (( $command = $module->getSlashCommand() )) {
            // Slack webhook will always have / in the command name, so add it if user forgot
            if ( $command[0] !== '/' ) {
                $command = "/$command";
            }
            $this->addListener( "slackapi.command.$command", $module->getCallback(), $priority );
        }
        if (( $trigger = $module->getTriggerWord() )) {
            $this->addListener( "slackapi.trigger.$trigger", $module->getCallback(), $priority );
        }
        if (( $channel = $module->getChannel() )) {
            if ( $channel === true ) {
                // Listen on all channels
                $this->addListener( "slackapi.channel", $module->getCallback(), $priority );
            }
            foreach ( (array)$channel as $name ) {
                // Slack webhook does not include # in channel name, so remove if user has it
                if ($name[ 0 ] === '#') {
                    $name = substr( $name, 1 );
                }
                $this->addListener( "slackapi.channel.$name", $module->getCallback(), $priority );
            }
        }
    }

    /**
     * Dispatch a response from the Slack API
     *
     * Using a provided event triggered by a Slack request, check the
     * information in the request and send out events to the appropriate
     * dispatcher channels.
     *
     * @param HookResponseEvent $event
     */
    public function dispatchResponse( HookResponseEvent $event )
    {
        $this->logger->debug( 'Dispatching Slack event.', [ 'event' => $event ] );

        if ($event->slashCommand) {
            $this->dispatch( "slackapi.command.{$event->slashCommand}", $event );
        } else {
            if ($event->triggerWord) {
                $this->dispatch( "slackapi.trigger.{$event->triggerWord}", $event );
            }
            $this->dispatch( "slackapi.channel", $event );
            $this->dispatch( "slackapi.channel.{$event->channelName}", $event );
            $this->dispatch( "slackapi.channel.{$event->channelId}", $event );
        }
    }
}

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

namespace CastlePointAnime\SlackApiBundle;

use CastlePointAnime\SlackApiBundle\Event\HookResponseEvent;
use CastlePointAnime\SlackApiBundle\Event\SlackDispatcher;

/**
 * A convenience implementation of ModuleDescriptorInterface
 *
 * Simple class with public attributes and getters for the various
 * parts of the module. Useful for using as a Symfony service.
 *
 * @package CastlePointAnime\SlackApiBundle
 */
abstract class ModuleDescriptorService implements ModuleDescriptorInterface
{
    public $channel;

    public $slashCommand;

    public $triggerWord;

    public function getChannel()
    {
        return $this->channel;
    }

    public function getSlashCommand()
    {
        return $this->slashCommand;
    }

    public function getTriggerWord()
    {
        return $this->triggerWord;
    }

    /**
     * @inheritdoc
     */
    public function getCallback()
    {
        return [ $this, 'handle' ];
    }

    /**
     * Handle a Slack hook event
     *
     * To be implemented by developers. The code can read information
     * from the event, send messages into the Slack API, etc. If the
     * you want to send information back to Slack in response to the
     * original request (Slack will sometimes relay this information
     * to the user as a private message), just modify the $event->response.
     *
     * @param HookResponseEvent $event Event describing the information received from Slack
     * @param $eventName String representing the triggered channel
     * @param SlackDispatcher $dispatcher The SlackDispatcher object
     *
     * @return mixed
     */
    abstract public function handle( HookResponseEvent $event, $eventName, SlackDispatcher $dispatcher );
}

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

/**
 * Interface for describing a Slack API modules
 *
 * @package CastlePointAnime\SlackApiBundle
 */
interface ModuleDescriptorInterface
{
    /**
     * Get a channel that the module would like
     * to listen for all messages on
     *
     * @return string
     */
    public function getChannel();

    /**
     * Get a slash command the module would like
     * to react to
     *
     * @return string
     */
    public function getSlashCommand();

    /**
     * Get a trigger words that the module would like
     * to listen for on all channels
     *
     * @return string
     */
    public function getTriggerWord();

    /**
     * Get the function that will be called when an
     * event is applicable
     *
     * The callback will be called with three arguments:
     * the HookResponseEvent event that was triggered, the
     * string name of the channel that was triggered, and
     * the dispatcher object. See Symfony's EventDispatcher
     * documentation for more details.
     *
     * @return callable
     */
    public function getCallback();
}

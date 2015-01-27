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

use GuzzleHttp\Command\Exception\CommandException;

/**
 * Exception thrown when the API returns a non-ok response
 *
 * This can be thrown when either the response received from
 * the API is invalid, or when Slack returns and sets "ok" to
 * false, indicating some failure in the requested operation.
 *
 * @package CastlePointAnime\SlackApiBundle\Guzzle
 */
class SlackApiException extends CommandException
{
}

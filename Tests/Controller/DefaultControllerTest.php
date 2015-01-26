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

namespace CastlePointAnime\SlackApiBundle\Tests\Controller;

use CastlePointAnime\SlackApiBundle\Controller\DefaultController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Tests\Logger;

class DefaultControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testIndex()
    {
        /** @var \PHPUnit_Framework_MockObject_MockObject|\CastlePointAnime\SlackApiBundle\SlackDispatcher $mockDispatcher */
        $mockDispatcher = $this->getMockBuilder( '\CastlePointAnime\SlackApiBundle\SlackDispatcher' )
            ->disableOriginalConstructor()
            ->getMock();

        $mockDispatcher
            ->expects( $this->once() )
            ->method( 'dispatchResponse' )
            ->with( $this->isInstanceOf( '\CastlePointAnime\SlackApiBundle\Event\HookResponseEvent' ) );

        $controller = new DefaultController( $mockDispatcher, [ 'myoutgoingtoken' ], [ 'myslashtoken' ], new Logger() );
        $request = new Request( [], [], [], [], [], [], 'token=myoutgoingtoken' );
        /** @var \Symfony\Component\HttpFoundation\Response $response */
        $response = $controller( $request );

        $this->assertEquals( 200, $response->getStatusCode() );
    }
}

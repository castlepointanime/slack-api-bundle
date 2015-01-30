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


namespace CastlePointAnime\SlackApiBundle\Tests\Event;


use CastlePointAnime\SlackApiBundle\Event\HookResponseEvent;
use CastlePointAnime\SlackApiBundle\Event\SlackDispatcher;
use Symfony\Component\HttpKernel\Tests\Logger;

/**
 * Tests related to the event dispatcher
 *
 * @package CastlePointAnime\SlackApiBundle\Tests\Event
 */
class SlackDispatcherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Get a mock descriptor using the parameters given
     *
     * @param string|null $channel
     * @param string|null $slashCommand
     * @param string|null $triggerWord
     * @param bool $isCalled
     *
     * @return \CastlePointAnime\SlackApiBundle\ModuleDescriptorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockDescriptor( $channel = null, $slashCommand = null, $triggerWord = null, $isCalled = true )
    {
        $mock = $this->getMock( '\CastlePointAnime\SlackApiBundle\ModuleDescriptorInterface' );

        $mock
            ->expects( $this->any() )
            ->method( 'getSlashCommand' )
            ->willReturn( $slashCommand );

        $mock
            ->expects( $this->any() )
            ->method( 'getTriggerWord' )
            ->willReturn( $triggerWord );

        $mock
            ->expects( $this->any() )
            ->method( 'getChannel' )
            ->willReturn( $channel );

        $mock
            ->expects( $this->any() )
            ->method( 'getCallback' )
            ->willReturn( [ $this, $isCalled ? 'callbackTrue' : 'callbackFalse' ] );

        return $mock;
    }

    public function callbackTrue()
    {
        $this->assertTrue( true );
    }

    public function callbackFalse()
    {
        $this->assertTrue( false );
    }

    public function testValidChannel()
    {
        $dispatcher = new SlackDispatcher( new Logger() );
        $dispatcher->register( $this->getMockDescriptor( 'mychannel' ) );

        $event = new HookResponseEvent();
        $event->channelName = 'mychannel';
        $dispatcher->dispatchResponse( $event );
    }

    public function testValidChannelWithPrefix()
    {
        $dispatcher = new SlackDispatcher( new Logger() );
        $dispatcher->register( $this->getMockDescriptor( '#mychannel' ) );

        $event = new HookResponseEvent();
        $event->channelName = 'mychannel';
        $dispatcher->dispatchResponse( $event );
    }

    public function testValidSlashcommand()
    {
        $dispatcher = new SlackDispatcher( new Logger() );
        $dispatcher->register( $this->getMockDescriptor( null, '/mytest' ) );

        $event = new HookResponseEvent();
        $event->slashCommand = '/mytest';
        $dispatcher->dispatchResponse( $event );
    }

    public function testValidSlashcommandWithoutPrefix()
    {
        $dispatcher = new SlackDispatcher( new Logger() );
        $dispatcher->register( $this->getMockDescriptor( null, 'mytest' ) );

        $event = new HookResponseEvent();
        $event->slashCommand = '/mytest';
        $dispatcher->dispatchResponse( $event );
    }

    public function testValidTriggerword()
    {
        $dispatcher = new SlackDispatcher( new Logger() );
        $dispatcher->register( $this->getMockDescriptor( null, null, 'trigger' ) );

        $event = new HookResponseEvent();
        $event->triggerWord = 'trigger';
        $dispatcher->dispatchResponse( $event );
    }

    public function testEmptyDescriptor()
    {
        $dispatcher = new SlackDispatcher( new Logger() );
        $dispatcher->register( $this->getMockDescriptor( null, null, null, false ) );

        $event = new HookResponseEvent();
        $dispatcher->dispatchResponse( $event );
    }

    public function testAllChannels() {
        $dispatcher = new SlackDispatcher( new Logger() );
        $dispatcher->register( $this->getMockDescriptor( true ) );

        $event = new HookResponseEvent();
        $event->channelName = "rlskfjldjfl";
        $dispatcher->dispatchResponse( $event );
    }
}

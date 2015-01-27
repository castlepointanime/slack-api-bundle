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

namespace CastlePointAnime\SlackApiBundle\Tests;

/**
 * Tests related to the ModuleDescriptorService
 *
 * @package CastlePointAnime\SlackApiBundle\Tests
 */
class ModuleDescriptorServiceTest extends \PHPUnit_Framework_TestCase {
    public function testChannel()
    {
        $module = new TestModuleDescriptorService();
        $module->channel = 'mychannel';
        $this->assertSame( 'mychannel', $module->getChannel() );
    }

    public function testSlashcommand()
    {
        $module = new TestModuleDescriptorService();
        $module->slashCommand = 'myslash';
        $this->assertSame( 'myslash', $module->getSlashCommand() );
    }

    public function testTriggerWord()
    {
        $module = new TestModuleDescriptorService();
        $module->triggerWord = 'mytrigger';
        $this->assertSame( 'mytrigger', $module->getTriggerWord() );
    }

    public function testCallback()
    {
        $module = new TestModuleDescriptorService();
        $this->assertSame( [ $module, 'handle' ], $module->getCallback() );
    }
}

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


namespace CastlePointAnime\SlackApiBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class RegistryCompilerPass implements CompilerPassInterface
{
    public function process( ContainerBuilder $container )
    {
        if (!$container->hasDefinition( 'slackapi.registry' )) {
            return;
        }

        $definition = $container->getDefinition( 'slackapi.registry' );

        foreach ($container->findTaggedServiceIds( 'slackapi.module' ) as $id => $tags) {
            foreach ($tags as $attributes) {
                $priority = isset( $attributes[ 'priority' ] ) ? $attributes[ 'priority' ] : 0;

                $definition->addMethodCall(
                    'register',
                    [ new Reference( $id ), $priority ]
                );
            }
        }
    }
}

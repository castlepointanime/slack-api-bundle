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

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class SlackApiExtension extends Extension
{
    public function getNamespace()
    {
        return 'https://schema.castlepointanime.com/dic/slack_api';
    }

    public function getXsdValidationBasePath()
    {
        return __DIR__ . '/../Resources/config/schema';
    }

    /**
     * {@inheritdoc}
     */
    public function load( array $configs, ContainerBuilder $container )
    {
        // Load the service configuration
        $loader = new Loader\XmlFileLoader( $container, new FileLocator( __DIR__ . '/../Resources/config' ) );
        $loader->load( 'services.xml' );

        // Load the configuration
        $configuration = new Configuration();
        $config = $this->processConfiguration( $configuration, $configs );

        // Set config as parameters
        $outgoingTokens = [ ];
        $slashcommandTokens = [ ];
        foreach ($config[ 'tokens' ] as $type => $token) {
            switch ($type) {
                case 'oauth':
                    $container->setParameter( 'slackapi.token.oauth', $token[ 'value' ] );
                    break;

                case 'incoming':
                    $container->setParameter( 'slackapi.token.incoming', $token[ 'value' ] );
                    break;

                case 'slackbot':
                    $container->setParameter( 'slackapi.token.slackbot', $token[ 'value' ] );
                    break;

                case 'outgoing':
                    $outgoingTokens[ ] = $token[ 'value' ];
                    break;

                case 'slashcommand':
                    $slashcommandTokens[ ] = $token[ 'value' ];
                    break;
            }
        }

        $container->setParameter( 'slackapi.team', $config[ 'name' ] );
        $container->setParameter( 'slackapi.token.outgoing', $outgoingTokens );
        $container->setParameter( 'slackapi.token.slashcommand', $slashcommandTokens );
    }
}

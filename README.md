# Slack API Bundle
This project is a [Symfony bundle](http://symfony.com/) for interacting with
the [Slack.com API](https://api.slack.com/). The purpose is to provide an
easy framework for writing bots and other tools that interact with your Slack
team.

Some features this bundle provides:

* A default route (and associated controller) that catches all Slack webhooks
* Dispatcher service that allows services to register and listen for certain webhook events
* [Guzzle Services](https://github.com/guzzle/guzzle-services)-based client for
  the main API
* Handling for outgoing webhooks, incoming webhooks, slash commands, remote
  Slackbot, and the main API (RTM websockets coming soon)

Right now the project is still in development, but is almost ready for release.
However, I'd still recommend taking caution when using this for your team until
the 1.0 is released.

## Installation
The bundle can be installed via [Composer](http://getcomposer.org/) as with any
other Symfony bundle:

    composer require castlepointanime/slack-api-bundle
    
You can also install it manually by cloning this repository and adding a PSR-4
entry to the autoloader, but obviously Composer is a lot easier.

## Use
Documentation is still in the works. In the near future, the following links will
show you how to use this bundle:

* Configuring the Bundle
* Setting up a Slack Module Service (SMS)
* Talking Back to the Slack API

If you have any questions that you think should be answered in the documentation,
file an issue on GitHub.

## Contributing
All contributions are welcome. Just submit a pull request. This project is licensed
under the AGPL, so all submitted code must be licensed under it (or one that is
compatible with it, but that makes legal stuff confusing).

## License
    Copyright (C) 2015  Tyler Romeo <tylerromeo@gmail.com>
    
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.
    
    Foobar is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    
    You should have received a copy of the GNU General Public License
    along with Foobar.  If not, see <http://www.gnu.org/licenses/>.

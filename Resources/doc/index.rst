Slack API Bundle
================

This project is a `Symfony bundle <http://symfony.com/>`__ for
interacting with the `Slack.com API <https://api.slack.com/>`__. The
purpose is to provide an easy framework for writing bots and other tools
that interact with your Slack team.

Some features this bundle provides:

-  A default route (and associated controller) that catches all Slack
   webhooks
-  Dispatcher service that allows services to register and listen for
   certain webhook events
-  `Guzzle Services <https://github.com/guzzle/guzzle-services>`__-based
   client for the main API
-  Handling for outgoing webhooks, incoming webhooks, slash commands,
   remote Slackbot, and the main API (RTM websockets coming soon)

Right now the project is still in development, but is almost ready for
release. However, I'd still recommend taking caution when using this for
your team until the 1.0 is released.

Installation
------------

Step 0: Install Symfony
~~~~~~~~~~~~~~~~~~~~~~~

This program technically can be used without Symfony, since it only depends
on certain components, but obviously if you are making a new project it will
be a lot easier to just use this bundle with the
`Symfony standard edition <http://symfony.com/download>`__.

Step 1: Download the Bundle
~~~~~~~~~~~~~~~~~~~~~~~~~~~

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

.. code:: shell

    $ composer require castlepointanime/slack-api-bundle

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Step 2: Enable the Bundle
~~~~~~~~~~~~~~~~~~~~~~~~~

Then, enable the bundle by adding the following line in the app/AppKernel.php
file of your project:

.. code:: php

    <?php
    // app/AppKernel.php

    // ...
    class AppKernel extends Kernel
    {
        public function registerBundles()
        {
            $bundles = array(
                // ...

                new CastlePointAnime\SlackApiBundle\SlackApiBundle(),
            );

            // ...
        }

        // ...
    }


Use
---

Documentation is still in the works. In the near future, the following
links will show you how to use this bundle:

-  `Configuring the Bundle <configuration.rst>`__
-  `Setting up a Slack Module Service (SMS) <modules.rst>`__
-  `Talking Back to the Slack API <slackapi.rst>`__

If you have any questions that you think should be answered in the
documentation, file an issue on GitHub.

Contributing
------------

All contributions are welcome. Just submit a pull request. This project
is licensed under the AGPL, so all submitted code must be licensed under
it (or one that is compatible with it, but that makes legal stuff
confusing).

License
-------
::

    Copyright (C) 2015  Tyler Romeo <tylerromeo@gmail.com>

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Foobar is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Foobar.  If not, see <http://www.gnu.org/licenses/>.


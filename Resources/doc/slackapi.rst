Sending Messages Back into Slack
================================

Once a webhook has gotten to your bot, it is often necessary to send
messages back, or to otherwise take action using the Slack API. This
can be done with the Slack API service provided by the bundle.

*Note: For sending bot messages, you will need an incoming webhook*
*token registered. For sending remote Slackbot messages, you need*
*a Slackbot token. And finally, for everything else, you need an OAuth*
*token.*

Accessing the API Service
-------------------------

If your bot is already registered as a service in the Symfony container
(in other words, if you used the ModuleDescriptorService described in
the last section), then you might as well take advantage of Symfony's
dependency injection, since you're already using it.

All that you need to do is add a dependency injection for the slackapi.api
service. Taking the example from the previous section and changing it:

.. code:: php

    <?php

    namespace AppBundle;

    use CastlePointAnime\SlackApiBundle\Event\HookResponseEvent;
    use CastlePointAnime\SlackApiBundle\Event\SlackDispatcher;
    use CastlePointAnime\SlackApiBundle\ModuleDescriptorService;

    class MyApiService extends ModuleDescriptorService {
        public function __construct( SlackApiClient $client )
        {
            ...
        }

        public function handle( HookResponseEvent $event, $eventName, SlackDispatcher $dispatcher )
        {
            ...
        }
    }

.. code:: yaml

    ; app/config/services.yml
    services:
      my_api:
        class: AppBundle\MyApiService
        properties:
          ;; Enable one of the following
          ; channel: "general"
          ; slashCommand: "/mytest"
          ; triggerWord: "mytest"
        tags:
          - { name: slackapi.module }
        arguments:
          - "%slackapi.api%"

Then you can do with the client as you wish (for example, saving it to a
private variable and using it in your handle() function).

Using the API by Example
------------------------

Sending an Incoming Webhooks Message
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code:: php

    // Will send to the default channel (configured in Slack)
    $client->sendBotMessage(['text' => 'Hello!']);

    // Send to a specific channel
    $client->sendBotMessage(['text' => 'Hello!', 'channel' => '#spam']);

    // Custom username and icon
    $client->sendBotMessage([
        'text' => 'Hello!',
        'channel' => '#spam',
        'username' => 'MyBot',
        'icon_url' => 'http://...',
    ]);

Sending a Remote Slackbot Message
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code:: php

    // Will send to the default channel (configured in Slack)
    $client->sendSlackbotMessage(['text' => 'Hello!']);

    // Send to a specific channel
    $client->sendSlackbotMessage(['text' => 'Hello!', 'channel' => '#spam']);

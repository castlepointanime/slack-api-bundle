Slack Module Services
=====================

Basic Infrastructure
--------------------

The Life of a Slack Request
~~~~~~~~~~~~~~~~~~~~~~~~~~~

To provide a basic idea of how this bundle works, here is a step
by step process of what happens when Slack sends in a request (this
can be either an outgoing webhook or a slash command):

1.  Slack makes a GET or POST request to the URL endpoint. (There is
    only one URL that you can use for *all* integrations you configure.
    The bundle will handle them all and route them appropriately.)
2.  The request is routed to the bundle's default controller. The
    controller decodes the request.
3.  A HookResponseEvent is sent into the SlackDispatcher via the
    dispatchResponse() function.
4.  The dispatcher looks at the event and dispatches the event on the
    appropriate channels (e.g., slash commands and outgoing webhooks
    are on different channels).
5.  Symfony's internal EventDispatcher, which the SlackDispatcher is
    based on, calls all the registered listeners (in this case, your
    bot).
6.  Your bot handles the request, does what it needs to do, and returns.

The important thing you need to understand here is that steps 1-5 are
all handled automatically by the bundle. **All you need to do is make a**
**listener and register it on the channels you want to hear.**

Listener Channels and Module Descriptors
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

As said above, all you really need to worry about is what channels you
want to listen to. To achieve this, the bundle provides something known
as a "module descriptor". This is an object that, as the name implies,
describes your module.

The descriptor, which must implement the ModuleDescriptorInterface, tells
the bundle what slash command, trigger word, etc. you want to listen on.
Once you have your descriptor ready, just call the register() function
on the SlackDispatcher and it will handle adding your event listener to
the appropriate channels.

*This may sound complicated, but to make things simpler, a complimentary*
*ModuleDescriptorService is provided, which, as the name implies, is a*
*service that provides a module and its descriptor. We'll demonstrate below*
*how to easily use this to make a module.*

Setting Up Your Module Service
------------------------------

Making your own bot (by making a module descriptor) is done via a few
quick steps:

1.  Make a child class that extends the ModuleDescriptorService class,
    and implement the handle() function, which has your bot's logic.
2.  Register your class as a service in the Symfony service container,
    and tag it with the slackapi.module tag.

.. code:: php

    <?php

    namespace AppBundle;

    use CastlePointAnime\SlackApiBundle\Event\HookResponseEvent;
    use CastlePointAnime\SlackApiBundle\ModuleDescriptorService;
    use CastlePointAnime\SlackApiBundle\SlackDispatcher;

    class MyApiService extends ModuleDescriptorService {
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

If you're not familiar with Symfony service tags, don't worry. All you
need to know is that by adding the slackapi.module tag, the Slack API
bundle will detect your service and automatically register it with the
dispatcher.

More Advanced Options
---------------------

Of course, there is no requirement to use ModuleDescriptorService. All
you need is something that implements ModuleDescriptorInterface. This is
useful if you want to change the parameters of the module dynamically
based on certain options. (Note: you can use the slackapi.module service
tag with any module descriptor.)

Also, if you want to override the bundle's default routing of events,
you can implement a custom SlackDispatcher, and override the dispatchResponse()
method in order to change where events are sent. This is useful if you
have your own way of routing messages other than what Slack has built-in
(i.e., trigger words, slash commands, channel names).

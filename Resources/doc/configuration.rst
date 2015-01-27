Configuring the Slack API Bundle
================================

The Slack API bundle only requires two pieces of basic information: the
name of your team, and a token (given to you by Slack) for doing what you
want to do.

Of course, there are different kinds of tokens. Specifically:

*OAuth Token*
    Standard bearer token issued by the Slack API or obtained
    via OAuth 2.0. This allows using the Slack API methods, i.e., creating
    channels, posting messages, etc.
*Incoming Webhooks Token*
    This allows you to send messages into Slack
    as a bot (using a given username and profile image).
*Remote Slackbot Tokens*
    This is similar to incoming webhooks, but
    rather than responding as an arbitrary bot, you respond as Slackbot.
*Outgoing Webhooks Token*
    Unlike the above, this is an outgoing token.
    In other words, it's not a token you give to Slack to verify the
    identity of your bot, it's a token Slack will give to you in order to
    prove Slack is the one sending out the hook. This token is for when
    you set up Slack to notify your bot of any time a message is sent out.
    *Warning: Slack does not discriminate against bots. If your bot uses*
    *the API to post a message into Slack, Slack will send back an outgoing*
    *webhook telling your bot about the message you just posted. This may*
    *cause infinite requests loops if you are not careful.*
*Slash Command Tokens*
    Similar to above (outgoing webhooks), but
    rather than being triggered by a message sent to a channel, it is
    triggered by a user executing a slash command.

You only need to put in the tokens you are going to use. Of course, if you
don't put in a token for a given feature, you won't be able to use that
feature.

Example Configuration
---------------------

1. Add the configuration.
2. Add the routes

YAML
~~~~

.. code:: yaml

    ; app/config/config.yml
    slack_api:
        name: "%my_team_name%"
        tokens:
            oauth: "%my_oauth_token%"
            incoming: "%my_incoming_token%"
            slackbot: "%my_slackbot_token%"
            outgoing: "%my_outgoing_token%"
            slashcommand: "%my_slashcommand_token%"

.. code:: yaml

    ; app/config
    slack_api:
        resource: "@SlackApiBundle/Resources/config/routing.xml"
        prefix:   /

XML
~~~

.. code:: xml

    <!-- app/config/config.xml -->
    <?xml version="1.0" ?>
    <config xmlns="https://schema.castlepointanime.com/dic/slack_api"
            xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
            xsi:schemaLocation="https://schema.castlepointanime.com/dic/slack_api https://schema.castlepointanime.com/dic/slack_api/slack_api-1.0.xsd">
        <team name="%my_team_name%">
            <token type="oauth">%my_oauth_token%</token>
            <token type="incoming">%my_incoming_token%</token>
            <token type="slackbot">%my_slackbot_token%</token>
            <token type="outgoing">%my_outgoing_token%</token>
            <token type="slashcommand">%my_slashcommand_token%</token>
        </team>
    </config>

.. code:: xml

    <?xml version="1.0" encoding="UTF-8" ?>
    <routes xmlns="http://symfony.com/schema/routing"
            xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
            xsi:schemaLocation="http://symfony.com/schema/routing http://symfony.com/schema/routing/routing-1.0.xsd">
        <import resource="@SlackApiBundle/Resources/config/routing.xml" prefix="/" />
    </routes>



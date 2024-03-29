# Discord Commands

Using this library you can build Discord bot commands, process inbound interactions from Discord and respond with messages.

# Table of contents

- [Installation](#installation)
- [Creating Messages](#creating-messages)
  - [Mentioning](#mentioning)
  - [Enriching](#enriching)
  - [Author](#author)
  - [Fields](#fields)
  - [Image](#image)
  - [Thumbnail](#thumbnail)
  - [Footer](#footer)
  - [Components](#components)
    - [Buttons](#buttons)
    - [SelectMenus](#selectmenus)
      - [Role Select Menus](#role-select-menus)
      - [Mentionable Select Menus](#mentionable-select-menus)
      - [Mentionable Select Menus](#mentionable-select-menus)
      - [Channel Select Menus](#channel-select-menus)
    - [Text Input](#text-input)
- [Creating Commands](#creating-commands)
  - [Chat commands](#chat-commands)
- [Handling Command Interactions](#handling-command-interactions)
  - [Request verification](#request-verification)
    - [Laravel middleware](#laravel-middleware)
  - [Responding to Interactions](#responding-to-interactions)
    - [Modals](#modals)

# Installation

```
composer require more-cores/discord-commands
```

# Creating Messages

Creating webhook messages (they have higher rate limits):

```php
$message = new WebhookMessage();
$message->setContent($content);

$embed = new Embed();
$embed->setTitle($title);
$embed->setDescription($description);
$embed->setUrl($url);
$embed->setTimestamp($dateTime);
$embed->setColor($color);
$message->addEmbed($embed);

$message->toJson(); // valid json ready to be sent to Discord via a Webhook
```

Or using standard messaging:

```php
$message = new Message();
$message->setContent($content);
$message->addEmbed($embed);

```

### Mentioning

Both `Message` and `WebhookMessage` offer the ability to mention roles.

```php
// appends the mention to the previously set content.  Setting the content again overrides mentions
$message->mentionRole($roleId);

$message->isRoleMentioned($roleId);
$message->hasMentions();
```

### Enriching

Certain information can be enriched on the Discord side, such as linking to channels and timestamps in the user's local time.

**Linking to a Channel**

```php
use \DiscordCommands\Messages\Message;

$message->setContent('Instead of this channel, go to '.Message::linkChannel(34835835834));
```

**Linking to a Special Channel**

```php
use \DiscordCommands\Messages\Message;
use \DiscordCommands\Messages\GuildNavigation;

$message->setContent('Help find new channels in '.Message::linkInGuild(GuildNavigation::CHANNEL_BROWSER));
```

**Embedding Timestamps**

```php
use \DiscordCommands\Messages\Message;
use \DiscordCommands\Messages\TimestampFormat;

$message->setContent('The contest runs until '.Message::timestamp(time()+6000));

// You can also customize formatting
$message->setContent('The contest runs until '.Message::timestamp(time()+600, TimestampFormat::SHORT_TIME));
```

## Author

```php
// define an embed author using shorthand
$embed->setAuthor($name);

// and optionally specify specific attributes
$embed->setAuthor($name, $url);

// define an embed author by object
$author = new Author();
$author->setName($name);
$embed->setAuthor($author);
```

## Fields

```php
// define an embed video using shorthand
$embed->addField($fieldName, $fieldValue);

// and optionally specify whether it's inline (default to false)
$embed->addField($fieldName, $fieldValue, $inline = true);

// define an embed field by object
$field = new Field();
$field->setName($name);
$field->setValue($value);
$embed->setVideo($field);
```

## Image

```php
$embed->setImageUrl($imageUrl);
```

## Thumbnail

```php
$embed->setThumbnailUrl($thumbnailUrl);
```

## Footer

```php
// define an embed footer using shorthand
$embed->setFooter($text, $iconUrl);

// and optionally specify  specific attributes
$embed->setFooter($urlToImage, $width, $height);

// define an embed thumbnail by object
$thumbnail = new Thumbnail();
$thumbnail->setText($text);
$thumbnail->setUrl($urlToImage);
$embed->setFooter($thumbnail);
```

## Components

### Buttons

Use dedicated classes for each button type.  Because buttons are non-interactive, you'll need to wrap them with an `ActionRow` when adding them to a message.  You can use the shorthand `actionRow()` to accomplish this.

```php
$message->actionRow(new SuccessButton('button-id', 'Approve it'));
$message->actionRow(new DangerButton('button-id', 'Reject it'));
$message->actionRow(new PrimaryButton('button-id', 'Something else'));
$message->actionRow(new SecondaryButton('button-id', 'Something else'));
$message->actionRow(new LinkButton('https://mysite.com', 'My Site'));
```

### SelectMenus

```php
$message->addComponent(new StringSelectMenu($menuId, [
    new Option('Option 1', 'option-1'),
    new Option('Option 2', 'option-2'),
]));
```

#### Role Select Menus

```php
$message->addComponent(new RoleSelectMenu($menuId));
```

#### Mentionable Select Menus

```php
$message->addComponent(new MentionableSelectMenu($menuId));
```

#### Mentionable Select Menus

```php
$message->addComponent(new UserSelectMenu($menuId));
```

#### Channel Select Menus

```php
$message->addComponent(new ChannelSelectMenu($menuId));
```

You can also limit which channel types can be selected

```php
$message->addComponent(new ChannelSelectMenu($menuId, [
    channelTypes: [
        Channel::TYPE_GUILD_TEXT,
        Channel::TYPE_GUILD_VOICE,
    ],
]));
```

### Text Input

```php
$message->addComponent(new ShortInput($fieldId, 'First Name'));
$message->addComponent(new ParagraphInput($fieldId, 'Dating Profile'));
```

# Creating Commands

## Chat commands

To create a chat command, create a class like this:

```php
class MyCommand extends ChatInputCommand
{
    public const NAME = 'my-command';

    public function __construct()
    {
        parent::__construct(
            name: self::NAME,
            description: 'This is executable by the higher ups in the guild',
            availableInDms: false,
            defaultMemberPermissions: [
                Permission::ADMINISTRATOR,
                Permission::MANAGE_GUILD,
            ]
        );
    }
}
```

You can then simply run `(new MyCommand())->jsonSerialize()` to generate the json payload needed to sync your command with Discord.

# Handling Command Interactions

You can use our factory to hydrate objects that represent incoming interactions within Discord.  Here's an example using a Laravel request object:

```php
$factory = new InteractionTypeFactory();
$interaction = $factory->make($request->json('type'), $request->json());
```

## Request verification

Discord requires that you verify the signature of inbound requests from their system.  You'll need to have this in place in order to even configure your interactions endpoint.

You'll need to run `composer require simplito/elliptic-php` to add the necessary dependency, then you can verify the request like this:

```php
$verifier = new SignatureVerifier();

if (!$verifier->verify(
    rawBody: file_get_contents('php://input'),
    publicKey: getenv('DISCORD_BOT_PUBLIC_KEY'),
    signature: $_SERVER['HTTP_X_SIGNATURE_ED25519'],
    timestamp: $_SERVER['HTTP_X_SIGNATURE_TIMESTAMP'],
)) {
    return http_response_code(401);
}

// Everything's good, do the rest here
```

### Laravel middleware

For Laravel applications, we've included a middleware out of the box to assist with this.  You can configure a route in `routes/api.php` and wrap it with our verification middleware:

```php
Route::group([
    'prefix' => 'discord',
    'namespace' => 'Api\Discord',
    'middleware' => LaravelDiscordSignatureVerificationMiddleware::class,
], function () {
    Route::post(
        'webhook/command/interactions',
        'CommandInteractionController@userInteracted'
    );
});
```

Then in your controller, make sure you respond to `Ping` with a `Pong`...

```php
    public function userInteracted(
        Request $request,
        InteractionTypeFactory $interactionTypeFactory
    ) {
        $interaction = $interactionTypeFactory->make($request->json('type'), $request->all());

        if ($interaction instanceof Ping) {
            return new Pong();
        }

        // generate other responses based on the inbound interaction
    }
```

## Responding to Interactions

You can respond to interactions by sending messages, showing modals, etc.  Make sure to give the [Discord docs](https://discord.com/developers/docs/interactions/receiving-and-responding) a read (e.g. your app has 3 seconds to respond to an interaction).

### Modals

To show a modal, you can simply respond to the interaction http request with your modal object:

#### Showing the modal

```php
$modal = new ShowModal(
    id: 'something',
    title: "Add new game/software for voting",
);
$modal->actionRow(
    new ShortInput(
        id: 'field-1',
        label: 'My Field',
    )
);
$modal->actionRow(
    new ShortInput(
        id: 'field-2',
        label: 'My Field 2',
    ),
);
return $modal->jsonSerialize();
```

#### Processing modal feedback

To process processing modal feedback, make sure you're handling `ModalSubmitted` events.

In the below example, `$commandFactory` is not provided by this package, but relates to your domain.  You can customize that process however you'd like.

```php
public function interactions(
    Request $request,
    InteractionTypeFactory $interactionTypeFactory,
    CommandFactory $commandFactory,
) {
    $interaction = $interactionTypeFactory->make($request->json('type'), $request->all());

    if ($interaction instanceof Ping) {
        return new Pong();
    }

    if ($interaction instanceof ModalSubmitted) {
        $command = $commandFactory->makeByModal($interaction->modal()->id());
        return $command->whenSubmitted($interaction, $interaction->modal());
    }

    throw new RuntimeException('Command interaction went unhandled');
}
```

In my case, I like for a single class to contain all the details about what happens on a Command.  So I added a `whenSubmitted` method that looks something like this:

```php
public function whenSubmitted(
    ModalSubmitted $interaction,
    SubmittedModal $modal,
): CommandResponse {
    Log::info('modal submitted', [
        'modal' => $modal->id(),
        'value' => $modal->fieldValue('field-2'),
    ]);

    return new ReplyWithMessage(
        content: "You're all done!",
        onlyVisibleToCommandIssuer: true,
    );
}
```

The key takeaway here is that Discord _requires_ an interaction in response to the modal submission.  So you'll need to respond with something.
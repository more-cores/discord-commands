# Discord Builder

A small library for building Discord messages and commands.

# Installation

```
composer require more-cores/discord-builder
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
$message->mention($roleId);

$message->isMentioned($roleId);
$message->hasMentions();
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

```php
$message->addComponent(new SuccessButton('button-id', 'Approve it'));
$message->addComponent(new DangerButton('button-id', 'Reject it'));
$message->addComponent(new PrimaryButton('button-id', 'Something else'));
$message->addComponent(new SecondaryButton('button-id', 'Something else'));
$message->addComponent(new LinkButton('https://mysite.com', 'My Site'));
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
class Subscribe extends ChatInputCommand
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

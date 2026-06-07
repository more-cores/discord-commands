<?php

namespace DiscordCommands\Messages;

use DiscordCommands\Messages\Components\Types\ActionRow;
use DiscordCommands\Messages\Components\Types\Buttons\PrimaryButton;
use DiscordCommands\Messages\Embed\Embed;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase
{
    private ?Message $message;

    public function setUp(): void
    {
        parent::setUp();

        $this->message = new Message();
    }

    #[Test]
    #[DataProvider('mentionableSpecialRoles')]
    public function canMentionSpecialRoles(Mention $mention)
    {
        $this->assertFalse($this->message->isRoleMentioned($mention));
        $this->assertFalse($this->message->hasMentions());

        $this->message->mentionRole($mention);
        $this->assertEquals($mention->value, $this->message->content());
        $this->assertTrue($this->message->hasMentions());
        $this->assertTrue($this->message->isRoleMentioned($mention));
    }

    public static function mentionableSpecialRoles()
    {
        return [
            [Mention::Here],
            [Mention::Everyone],
        ];
    }

    #[Test]
    public function canMentionRoles()
    {
        $this->assertFalse($this->message->isRoleMentioned(4132));
        $this->assertFalse($this->message->hasMentions());

        $roleId = time();
        $this->message->mentionRole($roleId);
        $this->assertTrue($this->message->hasMentions());
        $this->assertTrue($this->message->isRoleMentioned($roleId));
    }

    #[Test]
    public function canPullMentionedRoles()
    {
        $firstRoleId = time();
        $secondRoleId = $firstRoleId - 4000;
        $this->message->mention($firstRoleId);
        $this->message->mention($secondRoleId);
        $this->assertEquals([
            $firstRoleId,
            $secondRoleId,
        ], $this->message->mentionedRoleIds());
    }

    #[Test]
    public function canProvideContent()
    {
        $this->assertFalse($this->message->hasContent());
        $this->message->setContent($content = uniqid());

        $this->assertTrue($this->message->hasContent());
        $this->assertEquals($content, $this->message->content());

        $this->assertArrayHasKey('content', $this->message->jsonSerialize());
        $this->assertEquals($content, $this->message->jsonSerialize()['content']);
    }

    #[Test]
    public function canAddMultipleEmbeds()
    {
        $this->assertFalse($this->message->hasEmbeds());
        $firstEmbed = new Embed(
            title: $firstEmbedName = uniqid(),
        );
        $this->message->addEmbed($firstEmbed);

        $this->assertTrue($this->message->hasEmbeds());
        $this->assertArrayHasKey('embeds', $this->message->jsonSerialize());
        $this->assertEquals($firstEmbedName, $this->message->jsonSerialize()['embeds'][0]['title']);
    }

    #[Test]
    public function canHydrateEmbeds()
    {
        $this->assertFalse($this->message->hasEmbeds());
        $firstEmbed = new Embed(
            title: $firstEmbedName = uniqid(),
        );
        $this->message->hydrate([
            'embeds' => [
                $firstEmbed->jsonSerialize(),
            ],
        ]);

        $this->assertTrue($this->message->hasEmbeds());
        $this->assertArrayHasKey('embeds', $this->message->jsonSerialize());
        $this->assertEquals($firstEmbedName, $this->message->jsonSerialize()['embeds'][0]['title']);
    }

    #[Test]
    public function canAddComponents()
    {
        $this->assertFalse($this->message->hasComponents());

        $compId = '3j34jsdfl';
        $component = new PrimaryButton($compId);
        $this->message->addComponent($component);
        $this->assertTrue($this->message->hasComponents());
        $this->assertEquals([$component], $this->message->components());

        $json = $this->message->jsonSerialize();
        $this->assertArrayHasKey('components', $json);
        $this->assertEquals($compId, $json['components'][0]['custom_id']);
    }

    #[Test]
    public function linksToResources()
    {
        $channelId = '48348';
        $this->assertEquals(
            '<#'.$channelId.'>',
            Message::linkChannel($channelId)
        );

        $this->assertEquals(
            '<id:'.GuildNavigation::CHANNEL_BROWSER->value.'>',
            Message::linkInGuild(GuildNavigation::CHANNEL_BROWSER)
        );
    }

    #[Test]
    public function embedsCustomEmoji()
    {
        $emojiId = '123848342';
        $this->assertEquals(
            '<:smile:'.$emojiId.'>',
            Message::customEmoji('smile', $emojiId)
        );

        $emojiId = '123848342';
        $this->assertEquals(
            '<a:smile:'.$emojiId.'>',
            Message::customEmoji('smile', $emojiId, true)
        );
    }

    #[Test]
    public function embedsTimestamps()
    {
        $timestamp = time();
        $this->assertEquals(
            '<t:' . $timestamp . '>',
            Message::timestamp($timestamp)
        );

        $this->assertEquals(
            '<t:' . $timestamp . ':' . TimestampFormat::RELATIVE->value . '>',
            Message::timestamp($timestamp, TimestampFormat::RELATIVE)
        );
    }

    #[Test]
    public function hasNoFlagsByDefault()
    {
        $this->assertArrayNotHasKey('flags', $this->message->jsonSerialize());
    }

    #[Test]
    public function canBeSentSilently()
    {
        $this->message->sendSilently();

        $json = $this->message->jsonSerialize();

        $this->assertArrayHasKey('flags', $json);
        if (!(Message::FLAG_SUPPRESS_NOTIFICATIONS & $json['flags'])) {
            $this->assertTrue(false, 'suppress notifications bitwise operator not applied');
        }
    }

    #[Test]
    public function canSuppressEmbeds()
    {
        $this->message->withoutExpandingEmbeds();

        $json = $this->message->jsonSerialize();

        $this->assertArrayHasKey('flags', $json);
        if (!(Message::FLAG_SUPPRESS_EMBEDS & $json['flags'])) {
            $this->assertTrue(false, 'suppress embeds bitwise operator not applied');
        }
    }

    #[Test]
    public function canBeTextToSpeech()
    {
        $this->assertFalse($this->message->isTextToSpeech());
        $this->assertArrayNotHasKey('tts', $this->message->jsonSerialize());

        $this->message->asTextToSpeech();

        $this->assertTrue($this->message->isTextToSpeech());
        $this->assertTrue($this->message->jsonSerialize()['tts']);
    }

    #[Test]
    public function canRestrictAllowedMentions()
    {
        $this->assertFalse($this->message->hasAllowedMentions());
        $this->assertArrayNotHasKey('allowed_mentions', $this->message->jsonSerialize());

        $this->message->setAllowedMentions(AllowedMentions::none());

        $this->assertTrue($this->message->hasAllowedMentions());

        $json = $this->message->jsonSerialize();
        $this->assertArrayHasKey('allowed_mentions', $json);
        $this->assertEquals(['parse' => []], $json['allowed_mentions']);
    }
}

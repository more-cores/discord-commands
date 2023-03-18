<?php

namespace DiscordCommands\Messages;

use DiscordCommands\Messages\Components\Types\ActionRow;
use DiscordCommands\Messages\Components\Types\Buttons\PrimaryButton;
use DiscordCommands\Messages\Embed\Embed;
use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase
{
    private ?Message $message;

    public function setUp(): void
    {
        parent::setUp();

        $this->message = new Message();
    }

    /**
     * @test
     * @dataProvider mentionableSpecialRoles
     */
    public function canMentionSpecialRoles(Mention $mention)
    {
        $this->assertFalse($this->message->isMentioned($mention));
        $this->assertFalse($this->message->hasMentions());

        $this->message->mention($mention);
        $this->assertEquals($mention->value, $this->message->content());
        $this->assertTrue($this->message->hasMentions());
        $this->assertTrue($this->message->isMentioned($mention));
    }

    public static function mentionableSpecialRoles()
    {
        return [
            [Mention::Here],
            [Mention::Everyone],
        ];
    }

    /** @test */
    public function canMentionRoles()
    {
        $this->assertFalse($this->message->isMentioned(4132));
        $this->assertFalse($this->message->hasMentions());

        $roleId = time();
        $this->message->mention($roleId);
        $this->assertTrue($this->message->hasMentions());
        $this->assertTrue($this->message->isMentioned($roleId));
    }

    /** @test */
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

    /** @test */
    public function canProvideContent()
    {
        $this->assertFalse($this->message->hasContent());
        $this->message->setContent($content = uniqid());

        $this->assertTrue($this->message->hasContent());
        $this->assertEquals($content, $this->message->content());

        $this->assertArrayHasKey('content', $this->message->jsonSerialize());
        $this->assertEquals($content, $this->message->jsonSerialize()['content']);
    }

    /** @test */
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

    /** @test */
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

    /** @test */
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

    /** @test */
    public function canAddComponentsAsActionRow()
    {
        $this->assertFalse($this->message->hasComponents());

        $compId = '3j34jsdfl';
        $component = new PrimaryButton($compId);
        $this->message->actionRow($component);
        $this->assertTrue($this->message->hasComponents());

        $components = $this->message->components();
        $this->assertInstanceOf(ActionRow::class, $components[0]);

        $json = $this->message->jsonSerialize();

        $this->assertArrayHasKey('components', $json);
        $this->assertEquals($component->type(), $json['components'][0]['components'][0]['type']);
    }
}

<?php

namespace DiscordCommands\Messages;

use DiscordCommands\Messages\Components\Types\Buttons\PrimaryButton;
use DiscordCommands\Messages\Embed\Embed;
use PHPUnit\Framework\TestCase;

class WebhookMessageTest extends TestCase
{
    private ?WebhookMessage $message;

    public function setUp(): void
    {
        parent::setUp();

        $this->message = new WebhookMessage();
    }

    /** @test */
    public function canMentionRoles()
    {
        $this->assertFalse($this->message->isMentioned(4132));
        $this->assertFalse($this->message->hasMentions());

        $roleId = time();
        $this->message->mention($roleId);
        $this->assertEquals('<@&'.$roleId.'> ', $this->message->content());
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
        $this->assertCount(0, $this->message->embeds());

        $firstEmbed = new Embed(
            title: $firstEmbedName = uniqid(),
        );
        $this->message->addEmbed($firstEmbed);

        $this->assertCount(1, $this->message->embeds());

        $secondEmbed = new Embed(
            title: $secondEmbedName = uniqid(),
        );
        $this->message->addEmbed($secondEmbed);

        $this->assertCount(2, $this->message->embeds());

        $this->assertArrayHasKey('embeds', $this->message->jsonSerialize());
        $this->assertEquals($firstEmbedName, $this->message->jsonSerialize()['embeds'][0]['title']);
        $this->assertEquals($secondEmbedName, $this->message->jsonSerialize()['embeds'][1]['title']);
    }

    /** @test */
    public function canSetEmbeds()
    {
        $this->assertFalse($this->message->hasEmbeds());
        $this->assertCount(0, $this->message->embeds());

        $this->message->setEmbeds([
            new Embed(),
        ]);

        $this->assertTrue($this->message->hasEmbeds());
        $this->assertCount(1, $this->message->embeds());
    }

    /** @test */
    public function canSetThreadName()
    {
        $threadName = '3j34jsdfl';
        $this->message->createThreadWithName($threadName);
        $this->assertEquals($threadName, $this->message->threadNameToCreate());

        $json = $this->message->jsonSerialize();
        $this->assertArrayHasKey('thread_name', $json);
        $this->assertEquals($threadName, $json['thread_name']);
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
}

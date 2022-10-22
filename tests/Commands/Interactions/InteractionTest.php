<?php

namespace DiscordBuilder\Commands\Interactions;

use PHPUnit\Framework\TestCase;

class InteractionTest extends TestCase
{
    /** @test */
    public function serializesInteractions()
    {
        $interactionType = 12848;
        $interaction = new Interaction($interactionType);

        $this->assertEquals($interactionType, $interaction->type());

        $this->assertFalse($interaction->hasId());
        $this->assertFalse($interaction->hasApplicationId());
        $this->assertFalse($interaction->hasToken());
        $this->assertFalse($interaction->hasVersion());
        $this->assertFalse($interaction->hasGuildId());
        $this->assertFalse($interaction->hasChannelId());
        $this->assertFalse($interaction->hasGuildMember());
        $this->assertFalse($interaction->hasUser());

        // Verify fields can be missing when hydrating
        $interaction->hydrate([]);

        $id = 2038585834;
        $version = 12;
        $appId = 12;
        $token = 'sje34lkjdf';
        $guildId = '1223';
        $channelId = '134988';
        $guildMember = ['id' => 12394853];
        $user = ['id' => 986534];
        $interaction->hydrate([
            'id' => $id,
            'applicationId' => $appId,
            'version' => $version,
            'token' => $token,

            'guildId' => $guildId,
            'channelId' => $channelId,
            'member' => $guildMember,
            'user' => $user,
        ]);

        $this->assertTrue($interaction->hasId());
        $this->assertTrue($interaction->hasApplicationId());
        $this->assertTrue($interaction->hasToken());
        $this->assertTrue($interaction->hasVersion());
        $this->assertTrue($interaction->hasGuildId());
        $this->assertTrue($interaction->hasChannelId());
        $this->assertTrue($interaction->hasGuildMember());
        $this->assertTrue($interaction->hasUser());

        $this->assertEquals($id, $interaction->id());
        $this->assertEquals($appId, $interaction->applicationId());
        $this->assertEquals($token, $interaction->token());
        $this->assertEquals($version, $interaction->version());
        $this->assertEquals($guildId, $interaction->guildId());
        $this->assertEquals($channelId, $interaction->channelId());
        $this->assertEquals($guildMember['id'], $interaction->guildMember()['id']);
        $this->assertEquals($user['id'], $interaction->user()['id']);
    }
}

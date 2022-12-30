<?php

namespace DiscordCommands\Commands\Interactions\ExecutionResults;

use PHPUnit\Framework\TestCase;

class CommandResultsTest extends TestCase
{
    /** @test */
    public function hydrates()
    {
        $results = new CommandResults();

        $this->assertFalse($results->hasResolved());
        $this->assertFalse($results->hasOptions());
        $this->assertFalse($results->hasGuildId());
        $this->assertFalse($results->hasTargetId());

        // Verify fields can be missing when hydrating
        $results->hydrate([]);

        $id = 2038585834;
        $name = 'command-name';
        $type = 1;
        $guildId = '1223';
        $targetId = '134988';
        $resolved = ['id' => 12394853];
        $options = [[
            'type' => 986534,
        ]];
        $results->hydrate([
            'id' => $id,
            'name' => $name,
            'type' => $type,

            'guild_id' => $guildId,
            'target_id' => $targetId,
            'resolved' => $resolved,
            'options' => $options,
        ]);

        $this->assertTrue($results->hasResolved());
        $this->assertTrue($results->hasOptions());
        $this->assertTrue($results->hasGuildId());
        $this->assertTrue($results->hasTargetId());

        $this->assertEquals($id, $results->commandId());
        $this->assertEquals($name, $results->commandName());
        $this->assertEquals($type, $results->commandType());
        $this->assertEquals($guildId, $results->guildId());
        $this->assertEquals($targetId, $results->targetId());
        $this->assertEquals($resolved['id'], $results->resolved()['id']);

        $this->assertEquals($options[0]['type'], $results->options()[0]->type());
    }
}

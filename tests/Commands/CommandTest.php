<?php

namespace DiscordBuilder\Commands;

use DiscordBuilder\Commands\Options\Option;
use DiscordBuilder\Permissions\Permission;
use PHPUnit\Framework\TestCase;

class CommandTest extends TestCase
{
    /**
     * @test
     * @dataProvider requiredProperties
     */
    public function verifyRequiredProperties(array $data)
    {
        /*
         * @var string $jsonKey
         * @var string $classProperty
         * @var mixed  $testValue
         */
        extract($data);

        $command = new Command(
            type: time(),
        );

        $setterMethod = 'set'.ucfirst($classProperty);

        $command->$setterMethod($testValue);

        $this->assertEquals($testValue, $command->$classProperty());

        $json = $command->jsonSerialize();

        $this->assertArrayHasKey($jsonKey, $json);
        $this->assertEquals($testValue, $json[$jsonKey]);
    }

    public static function requiredProperties(): \Generator
    {
        yield [
            [
                'jsonKey' => 'name',
                'classProperty' => 'name',
                'testValue' => 'some-name',
            ],
        ];
        yield [
            [
                'jsonKey' => 'description',
                'classProperty' => 'description',
                'testValue' => 'some-description',
            ],
        ];
    }

    /**
     * @test
     * @dataProvider nullableProperties
     */
    public function verifyNullableProperties(array $data)
    {
        /*
         * @var string $jsonKey
         * @var string $classProperty
         * @var mixed  $testValue
         */
        extract($data);

        $command = new Command(
            type: time(),
        );

        $setterMethod = 'set'.ucfirst($classProperty);
        $hasMethod = 'has'.ucfirst($classProperty);

        $this->assertFalse($command->$hasMethod());

        $command->$setterMethod($testValue);

        $this->assertTrue($command->$hasMethod());
        $this->assertEquals($testValue, $command->$classProperty());

        $json = $command->jsonSerialize();

        $this->assertArrayHasKey($jsonKey, $json);
        $this->assertEquals($testValue, $json[$jsonKey]);

        $command->$setterMethod(null);
        $this->assertFalse($command->$hasMethod());
    }

    public static function nullableProperties(): \Generator
    {
        yield [
            [
                'jsonKey' => 'application_id',
                'classProperty' => 'applicationId',
                'testValue' => 'some-snowflake',
            ],
        ];
        yield [
            [
                'jsonKey' => 'default_member_permissions',
                'classProperty' => 'defaultMemberPermissions',
                'testValue' => '123423',
            ],
        ];
        yield [
            [
                'jsonKey' => 'dm_permission',
                'classProperty' => 'availableInDms',
                'testValue' => true,
            ],
        ];
        yield [
            [
                'jsonKey' => 'version',
                'classProperty' => 'version',
                'testValue' => '12354',
            ],
        ];
    }

    /** @test */
    public function verifyIncludesJsonWhenUsingUniquePerGuild()
    {
        $command = new class(type: time()) extends Command {
            use UniquePerGuild;
        };

        $this->assertFalse($command->hasGuildId());
        $command->setGuildId($guildId = 'asdf');
        $this->assertTrue($command->hasGuildId());

        $this->assertEquals($guildId, $command->guildId());

        $json = $command->jsonSerialize();

        $this->assertArrayHasKey('guild_id', $json);
        $this->assertEquals($guildId, $json['guild_id']);
    }

    /** @test */
    public function verifyIncludesJsonWhenHasOptions()
    {
        $command = new class(type: time()) extends Command {
            use HasCommandOptions;
        };

        $option = new Option($optionType = time());

        $this->assertFalse($command->hasOptions());
        $command->addOption($option);
        $this->assertTrue($command->hasOptions());

        $this->assertEquals($optionType, $command->options()[0]->type());

        $json = $command->jsonSerialize();

        $this->assertArrayHasKey('options', $json);
        $this->assertEquals($optionType, $json['options'][0]['type']);
    }

    /** @test */
    public function acceptsArrayForMemberPermissions()
    {
        $command = new class(type: time()) extends Command {};

        $this->assertFalse($command->hasDefaultMemberPermissions());

        $command->setDefaultMemberPermissions(Permission::MANAGE_GUILD);

        $this->assertEquals(Permission::MANAGE_GUILD, $command->defaultMemberPermissions());

        $combinedPermissions = array_sum([
            Permission::MANAGE_GUILD,
            Permission::ADMINISTRATOR,
        ]);
        $command->setDefaultMemberPermissions($combinedPermissions);
        $this->assertEquals($combinedPermissions, $command->defaultMemberPermissions());
    }
}

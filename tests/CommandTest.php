<?php

namespace DiscordBuilder;

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
                'jsonKey' => 'guild_id',
                'classProperty' => 'guildId',
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
                'classProperty' => 'dmPermission',
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
}

<?php

namespace DiscordBuilder\Components\Types;

use DiscordBuilder\Components\Component;
use PHPUnit\Framework\TestCase;

class ActionRowTest extends TestCase
{
    private ?ActionRow $actionRow = null;

    public function setUp(): void
    {
        parent::setUp();

        $this->actionRow = new ActionRow();
    }

    /** @test */
    public function canAddAndProvideComponents()
    {
        $this->assertCount(0, $this->actionRow->components());

        $component = \Mockery::mock(Component::class);
        $this->actionRow->addComponent($component);
        $this->assertCount(1, $this->actionRow->components());
        $this->assertEquals($component, $this->actionRow->components()[0]);

        $componentB = new class(time()) extends Component {

        };
        $this->actionRow->setComponents([$componentB]);
        $this->assertCount(1, $this->actionRow->components());
        $this->assertEquals($componentB, $this->actionRow->components()[0]);

        $json = $this->actionRow->jsonSerialize();
        $this->assertArrayHasKey('components', $json);
        $this->assertEquals($componentB->type(), $json['components'][0]['type']);
    }
}

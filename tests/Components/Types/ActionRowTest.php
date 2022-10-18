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
        $this->assertCount(0, $this->actionRow->getComponents());

        $component = \Mockery::mock(Component::class);
        $this->actionRow->addComponent($component);
        $this->assertCount(1, $this->actionRow->getComponents());
        $this->assertEquals($component, $this->actionRow->getComponents()[0]);

        $componentB = new class(time()) extends Component {

        };
        $this->actionRow->setComponents([$componentB]);
        $this->assertCount(1, $this->actionRow->getComponents());
        $this->assertEquals($componentB, $this->actionRow->getComponents()[0]);

        $json = $this->actionRow->jsonSerialize();
        $this->assertArrayHasKey('components', $json);
        $this->assertEquals($componentB->getType(), $json['components'][0]['type']);
    }
}

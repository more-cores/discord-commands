<?php

namespace DiscordCommands\Messages;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class AllowedMentionsTest extends TestCase
{
    #[Test]
    public function isEmptyByDefault()
    {
        $this->assertEquals([], (new AllowedMentions())->jsonSerialize());
    }

    #[Test]
    public function noneSuppressesEverything()
    {
        $this->assertEquals(
            ['parse' => []],
            AllowedMentions::none()->jsonSerialize()
        );
    }

    #[Test]
    public function canAllowMentionTypes()
    {
        $allowedMentions = new AllowedMentions();
        $allowedMentions->allowEveryone();
        $allowedMentions->allowAllRoles();
        $allowedMentions->allowAllUsers();

        // adding a duplicate does not repeat it
        $allowedMentions->allowEveryone();

        $this->assertEquals(
            ['parse' => ['everyone', 'roles', 'users']],
            $allowedMentions->jsonSerialize()
        );
    }

    #[Test]
    public function canAllowSpecificRolesAndUsers()
    {
        $allowedMentions = new AllowedMentions();
        $allowedMentions->allowRoles(['1', '2']);
        $allowedMentions->allowUsers(['3']);
        $allowedMentions->mentionRepliedUser();

        $this->assertEquals(
            [
                'roles' => ['1', '2'],
                'users' => ['3'],
                'replied_user' => true,
            ],
            $allowedMentions->jsonSerialize()
        );
    }
}

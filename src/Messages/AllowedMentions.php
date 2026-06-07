<?php

namespace DiscordCommands\Messages;

use DiscordCommands\Jsonable;

/**
 * Controls which mentions in a message actually ping.  Without this, mention
 * syntax placed in a message's content notifies by default.  Attach an instance
 * to a message to restrict (or suppress) those notifications.
 *
 * @see https://discord.com/developers/docs/resources/message#allowed-mentions-object
 */
class AllowedMentions extends Jsonable
{
    protected ?array $parse = null;
    protected array $roles = [];
    protected array $users = [];
    protected ?bool $repliedUser = null;

    /**
     * Suppress every mention in the message.
     */
    public static function none(): self
    {
        $allowedMentions = new self();
        $allowedMentions->parse = [];

        return $allowedMentions;
    }

    public function allowEveryone(): void
    {
        $this->addParse('everyone');
    }

    public function allowAllRoles(): void
    {
        $this->addParse('roles');
    }

    public function allowAllUsers(): void
    {
        $this->addParse('users');
    }

    /**
     * Allow only the given role ids to ping.
     *
     * @param string[] $roleIds
     */
    public function allowRoles(array $roleIds): void
    {
        $this->roles = array_merge($this->roles, $roleIds);
    }

    /**
     * Allow only the given user ids to ping.
     *
     * @param string[] $userIds
     */
    public function allowUsers(array $userIds): void
    {
        $this->users = array_merge($this->users, $userIds);
    }

    public function mentionRepliedUser(bool $mention = true): void
    {
        $this->repliedUser = $mention;
    }

    private function addParse(string $type): void
    {
        if ($this->parse === null) {
            $this->parse = [];
        }

        if (!in_array($type, $this->parse, true)) {
            $this->parse[] = $type;
        }
    }

    public function jsonSerialize(): array
    {
        $data = [];

        if ($this->parse !== null) {
            $data['parse'] = $this->parse;
        }

        if (count($this->roles) > 0) {
            $data['roles'] = array_values($this->roles);
        }

        if (count($this->users) > 0) {
            $data['users'] = array_values($this->users);
        }

        if ($this->repliedUser !== null) {
            $data['replied_user'] = $this->repliedUser;
        }

        return $data;
    }
}

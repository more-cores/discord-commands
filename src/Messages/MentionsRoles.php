<?php

namespace DiscordCommands\Messages;

trait MentionsRoles
{
    /**
     * Determine if the given message has mentions
     */
    public function hasMentions(): bool
    {
        return Mention::hasMentions($this->content());
    }

    public function mentionedRoleIds(): array
    {
        preg_match_all('#<@&(.+?)>#', $this->content(), $matches);

        return $matches[1] ?? [];
    }

    public function mentionHere()
    {
        $this->mentionRole(Mention::Here);
    }

    public function mentionEveryone()
    {
        $this->mentionRole(Mention::Everyone);
    }

    /**
     * Mention the given role in the included message
     */
    public function mentionRole(int|Mention $role): void
    {
        if ($role instanceof Mention) {
            $this->content .= $role->value;
        } else {
            $this->content .= Mention::role($role);
        }
    }

    /**
     * @deprecated Use mentionRole() instead
     */
    public function mention(int|Mention $role): void
    {
        $this->mentionRole($role);
    }

    /**
     * @deprecated Use isRoleMentioned() instead
     */
    public function isMentioned(int|Mention $role): bool
    {
        return $this->isRoleMentioned($role);
    }

    public function isRoleMentioned(int|Mention $role): bool
    {
        if ($this->content == null) {
            return false;
        }

        if ($role instanceof Mention) {
            return str_contains($this->content, $role->value);
        }

        return str_contains($this->content, Mention::role($role));
    }
}
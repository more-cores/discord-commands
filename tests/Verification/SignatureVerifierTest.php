<?php

namespace DiscordCommands\Verification;

use Elliptic\EdDSA;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class SignatureVerifierTest extends TestCase
{
    #[Test]
    public function testDefault()
    {
        $verifier = new SignatureVerifier();

        $this->assertInstanceOf(EdDSA::class, $verifier->curve());
    }
}

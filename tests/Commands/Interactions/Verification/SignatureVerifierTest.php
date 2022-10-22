<?php

namespace DiscordBuilder\Commands\Interactions\Responding;

use DiscordBuilder\Commands\Interactions\Verification\SignatureVerifier;
use Elliptic\EdDSA;
use PHPUnit\Framework\TestCase;

class SignatureVerifierTest extends TestCase
{
    /** @test */
    public function testDefault()
    {
        $verifier = new SignatureVerifier();

        $this->assertInstanceOf(EdDSA::class, $verifier->curve());
    }
}

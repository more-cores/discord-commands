<?php

namespace DiscordBuilder\Verification;

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

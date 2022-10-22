<?php

namespace DiscordBuilder\Verification;

class SignatureVerifier
{
    public const CURVE = 'ed25519';

    private $curve = null;

    public function __construct(
        $curveType = null,
    ) {
        if ($curveType !== null) {
            $this->curve = $curveType;
            return;
        }

        if (class_exists('\Elliptic\EdDSA')) {
            $this->curve = new \Elliptic\EdDSA(self::CURVE);
        } else {
            throw new \RuntimeException('The simplito/elliptic-php package is required to verify interactions signatures.');
        }
    }

    public function curve()
    {
        return $this->curve;
    }

    public function verify(
        string $rawBody,
        string $publicKey,
        string $signature,
        string $timestamp,
    ): bool {
        $key = $this->curve->keyFromPublic($publicKey);
        $message = array_merge(
            unpack('C*', $timestamp),
            unpack('C*', $rawBody)
        );
        return $key->verify($message, $signature) == true;
    }
}
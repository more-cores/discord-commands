<?php

namespace DiscordBuilder\Verification;

use Closure;

class LaravelDiscordSignatureVerificationMiddleware
{
    public function __construct(
        private SignatureVerifier $verifier
    ) {}

    protected function botPublicKey()
    {
        return getenv('DISCORD_BOT_PUBLIC_KEY');
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$this->verifier->verify(
            rawBody: $request->getContent(),
            publicKey: $this->botPublicKey(),
            signature: $request->header('x-signature-'.SignatureVerifier::CURVE),
            timestamp: $request->header('x-signature-timestamp'),
        )) {
            return abort(401, 'Invalid request signature');
        }

        return $next($request);
    }
}
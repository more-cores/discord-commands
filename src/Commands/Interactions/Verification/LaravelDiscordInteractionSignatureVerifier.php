<?php

namespace DiscordBuilder\Commands\Interactions\Verification;

use Closure;

class LaravelDiscordInteractionSignatureVerifier
{
    public function __construct(
        private SignatureVerifier $verifier
    ) {}

    protected function getKey()
    {
        return getenv('DISCORD_BOT_KEY');
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
            publicKey: $this->getKey(),
            signature: $request->header('x-signature-'.SignatureVerifier::CURVE),
            timestamp: $request->header('x-signature-timestamp'),
        )) {
            return abort(401, 'Invalid request signature');
        }

        return $next($request);
    }
}
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RevokedToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tokens:revoked';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'revokar tokens';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $tokens = \App\Models\OauthAccessTokens::where('expires_at', '<', now())->Active()->get();
        foreach ($tokens as $token) {
            $token->update(
                [
                    'revoked' => 1,
                ]
            );
            $this->info('Token revokado '.$token->id);
        }
    }
}

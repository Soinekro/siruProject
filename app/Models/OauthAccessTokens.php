<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OauthAccessTokens extends Model
{
    use HasFactory;

    protected $table = 'oauth_access_tokens';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'user_id',
        'client_id',
        'name',
        'scopes',
        'revoked',
        'expires_at',
    ];
    public function ScopeActive($query)
    {
        return $query->where('revoked', 0);
    }

    public function ScopeUser($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }

    public function ScopeNotExpired($query)
    {
        return $query->where('expires_at', '>', now());
    }
}

<?php

namespace Tests\Traits;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

trait UseHeaders
{
  public function getHeadersForUser(User $user): array
  {
    $token = JWTAuth::fromUser($user);
    return [
      'Authorization' => "Bearer $token"
    ];
  }
}

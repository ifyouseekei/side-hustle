<?php

namespace App\GraphQL\Mutations;

use App\Models\User;

use GraphQL\Error\Error;
use Illuminate\Support\Facades\Hash;

final class Login
{
  /**
   * @param  null  $_
   * @param  array{}  $args
   */
  public function __invoke($_, array $args)
  {

    $user = User::where('email', $args['email'])->first();

    if ($user) {
      $passwordIsCorrect = Hash::check($args['password'], $user->password);
    }

    if (empty($passwordIsCorrect)) {
      throw new Error('Invalid credentials');
    }

    $token = $user->createToken('side-hustle-token')->accessToken;
    return $token;
  }
}

<?php

namespace App\Tests\Applications\Api\V1\Auth;

use App\Tests\Applications\Api\V1\V1TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class UpdateProfileTest extends V1TestCase
{
    public function test_can_update_profile ()
    {
        $user = factory(\App\Domains\Users\User::class)->create();

        $user_updated = $user->toArray();
        $user_updated['name'] =  'Name Updated';
        $user_updated['email'] =  'email@updated.com';
        $user_updated['address'] =  'New Avenue';

        $this->callAPIWithToken('PUT', 'me/update', JWTAuth::fromUser($user), $user_updated);

        $this->assertResponseOk();
        $this->notSeeInDatabase('users', array_except($user->toArray(), ['password', 'password_confirmation']));
        $this->seeInDatabase('users', array_except($user_updated, ['password', 'password_confirmation']));
    }
}
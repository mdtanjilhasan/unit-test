<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;


class UserExistsTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_exists()
    {
        $user = User::factory(1)->create(['email' => 'tanjil@axilweb.com']);
        $this->assertEquals('tanjil@axilweb.com', $user->first()->email);
    }
}

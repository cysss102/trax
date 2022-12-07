<?php

namespace Tests;

use App\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function actingUser(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
    }

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
    }
}

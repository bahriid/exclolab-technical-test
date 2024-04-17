<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    /**
     * Test Success Regsiter
     */
    public function test_success_register(): void
    {
        $user = User::first();

        $response = $this->actingAs($user)->post('/api/logout');

        $response->assertStatus(200);
    }

}

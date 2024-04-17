<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * Test Success Login
     */
    public function test_success_login(): void
    {
        $response = $this->post('/api/login',[
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200);
    }

    /**
     * Test Failed Login
     */
    public function test_failed_login(): void
    {
        $response = $this->post('/api/login',[
            'email' => 'test@example.com',
//            'password' => 'password',
        ]);

        $response->assertStatus(302);
    }
}

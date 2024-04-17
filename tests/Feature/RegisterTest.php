<?php

namespace Tests\Feature;

use Tests\TestCase;

class RegisterTest extends TestCase
{
    /**
     * Test Success Regsiter
     */
    public function test_success_register(): void
    {
        $response = $this->post('/api/register',[
            'email' => 'test5@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'name' => 'test',
        ]);

        $response->assertStatus(200);
    }

    /**
     * Test Failed Regsiter
     */
    public function test_failed_register(): void
    {
        $response = $this->post('/api/register',[
            'email' => 'test5@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
//            'name' => 'test',
        ]);

        $response->assertStatus(302);
    }
}

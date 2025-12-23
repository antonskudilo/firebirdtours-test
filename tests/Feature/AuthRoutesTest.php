<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function testLoginFormAccessibleForGuests(): void
    {
        $response = $this->get(route('login.form'));
        $response->assertStatus(200);
        $response->assertViewIs('pages.auth.login');
    }
}

<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AdminAuthorizationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;
    public function test_super_admin_can_access_users_page(): void
    {
        $superAdmin = User::factory()->create([
            'firstName'         => 'ahmed',
            'lastName'          => 'mohassen',
            'email'             => 'ah@ah.ah',
            'email_verified_at' => now(),
            'password'          => bcrypt('Mm123456@'),
            'role'              => 'superAdmin',
            'terms_accepted'    => true,
            'status'            => 'active',
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        $this->actingAs($superAdmin);

        $response = $this->get('/users');

        $response->assertOk();
    }
    public function test_admin_can_access_users_page(): void
    {
        $admin = User::factory()->create([
            'firstName'         => 'ahmed',
            'lastName'          => 'mohassen',
            'email'             => 'ah@ah.ah',
            'email_verified_at' => now(),
            'password'          => bcrypt('Mm123456@'),
            'role'              => 'admin',
            'terms_accepted'    => true,
            'status'            => 'active',
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        $this->actingAs($admin);

        $response = $this->get('/users');

        $response->assertOk();
    }
    public function test_doctor_cannot_access_users_page(): void
    {
        $doctor = User::factory()->create([
            'firstName'         => 'ahmed',
            'lastName'          => 'mohassen',
            'email'             => 'ah@ah.ah',
            'email_verified_at' => now(),
            'password'          => bcrypt('Mm123456@'),
            'role'              => 'doctor',
            'terms_accepted'    => true,
            'status'            => 'active',
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        $this->actingAs($doctor);

        $response = $this->get('/users');

        $response->assertForbidden();
    }
    public function test_guest_cannot_access_users_page(): void
    {
        $response = $this->get('/users');
        $response->assertForbidden();
    }
    public function test_unknown_role_cannot_access_admin_page(): void
    {
        $unknown = User::factory()->make([
            'firstName'         => 'ahmed',
            'lastName'          => 'mohassen',
            'email'             => 'nutritionist@healthifyme.com',
            'role'              => 'nutritionist',
            'status'            => 'active',
            'terms_accepted'    => true,
            'password'          => bcrypt('Mm123456@'),
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        $this->actingAs($unknown);

        $response = $this->get('/users');

        $response->assertForbidden();
    }
}

<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_from_admin_pages(): void
    {
        $this->get('/admin')->assertRedirect('/login');
        $this->get('/admin/otziv')->assertRedirect('/login');
        $this->get('/admin/products')->assertRedirect('/login');
        $this->get('/orders/export')->assertRedirect('/login');
    }

    public function test_guest_cannot_change_order_status(): void
    {
        $this->post('/status/1')->assertRedirect('/login');
    }

    public function test_authenticated_user_can_access_admin(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/admin')->assertOk();
        $this->actingAs($user)->get('/admin/products')->assertOk();
    }
}

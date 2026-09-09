<?php

namespace Tests\Feature\Security;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_admin_area(): void
    {
        $this->get(route('security.test.admin'))
            ->assertRedirect(route('login'));
    }

    public function test_guest_cannot_access_sales_area(): void
    {
        $this->get(route('security.test.sales'))
            ->assertRedirect(route('login'));
    }

    public function test_guest_cannot_access_stock_area(): void
    {
        $this->get(route('security.test.stock'))
            ->assertRedirect(route('login'));
    }

    public function test_admin_can_access_admin_area(): void
    {
        $user = User::factory()->admin()->create();

        $this->actingAs($user)
            ->get(route('security.test.admin'))
            ->assertOk()
            ->assertSee('admin-area');
    }

    public function test_sales_user_cannot_access_admin_area(): void
    {
        $user = User::factory()->sales()->create();

        $this->actingAs($user)
            ->get(route('security.test.admin'))
            ->assertForbidden();
    }

    public function test_stock_user_cannot_access_admin_area(): void
    {
        $user = User::factory()->stock()->create();

        $this->actingAs($user)
            ->get(route('security.test.admin'))
            ->assertForbidden();
    }

    public function test_sales_user_can_access_sales_area(): void
    {
        $user = User::factory()->sales()->create();

        $this->actingAs($user)
            ->get(route('security.test.sales'))
            ->assertOk()
            ->assertSee('sales-area');
    }

    public function test_admin_can_access_sales_area(): void
    {
        $user = User::factory()->admin()->create();

        $this->actingAs($user)
            ->get(route('security.test.sales'))
            ->assertOk()
            ->assertSee('sales-area');
    }

    public function test_stock_user_cannot_access_sales_area(): void
    {
        $user = User::factory()->stock()->create();

        $this->actingAs($user)
            ->get(route('security.test.sales'))
            ->assertForbidden();
    }

    public function test_stock_user_can_access_stock_area(): void
    {
        $user = User::factory()->stock()->create();

        $this->actingAs($user)
            ->get(route('security.test.stock'))
            ->assertOk()
            ->assertSee('stock-area');
    }

    public function test_admin_can_access_stock_area(): void
    {
        $user = User::factory()->admin()->create();

        $this->actingAs($user)
            ->get(route('security.test.stock'))
            ->assertOk()
            ->assertSee('stock-area');
    }

    public function test_sales_user_cannot_access_stock_area(): void
    {
        $user = User::factory()->sales()->create();

        $this->actingAs($user)
            ->get(route('security.test.stock'))
            ->assertForbidden();
    }

    public function test_inactive_admin_cannot_access_admin_area(): void
    {
        $user = User::factory()
            ->admin()
            ->inactive()
            ->create();

        $this->actingAs($user)
            ->get(route('security.test.admin'))
            ->assertForbidden();
    }

    public function test_inactive_sales_user_cannot_access_sales_area(): void
    {
        $user = User::factory()
            ->sales()
            ->inactive()
            ->create();

        $this->actingAs($user)
            ->get(route('security.test.sales'))
            ->assertForbidden();
    }

    public function test_inactive_stock_user_cannot_access_stock_area(): void
    {
        $user = User::factory()
            ->stock()
            ->inactive()
            ->create();

        $this->actingAs($user)
            ->get(route('security.test.stock'))
            ->assertForbidden();
    }

    public function test_invalid_role_does_not_grant_access(): void
    {
        $user = User::factory()->create();

        $user->forceFill([
            'role' => 'superadmin',
        ])->save();

        $this->actingAs($user)
            ->get(route('security.test.admin'))
            ->assertForbidden();
    }

    public function test_user_role_can_be_resolved_as_a_user_role_enum(): void
    {
        $user = User::factory()->admin()->create();

        $this->assertSame(UserRole::ADMIN, $user->roleEnum());
    }
}

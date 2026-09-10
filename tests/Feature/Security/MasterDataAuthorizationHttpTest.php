<?php

namespace Tests\Feature\Security;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MasterDataAuthorizationHttpTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_categories(): void
    {
        $this->get(route('admin.categories.index'))
            ->assertRedirect(route('login'));
    }

    public function test_stock_user_can_access_categories(): void
    {
        $user = User::factory()->stock()->create();

        $this->actingAs($user)
            ->get(route('admin.categories.index'))
            ->assertOk()
            ->assertSee('category-management');
    }

    public function test_sales_user_cannot_access_categories(): void
    {
        $user = User::factory()->sales()->create();

        $this->actingAs($user)
            ->get(route('admin.categories.index'))
            ->assertForbidden();
    }

    public function test_stock_user_can_access_suppliers(): void
    {
        $user = User::factory()->stock()->create();

        $this->actingAs($user)
            ->get(route('admin.suppliers.index'))
            ->assertOk()
            ->assertSee('supplier-management');
    }

    public function test_sales_user_cannot_access_suppliers(): void
    {
        $user = User::factory()->sales()->create();

        $this->actingAs($user)
            ->get(route('admin.suppliers.index'))
            ->assertForbidden();
    }

    public function test_stock_user_can_access_products(): void
    {
        $user = User::factory()->stock()->create();

        $this->actingAs($user)
            ->get(route('admin.products.index'))
            ->assertOk()
            ->assertSee('Product catalog');
    }

    public function test_sales_user_cannot_access_products(): void
    {
        $user = User::factory()->sales()->create();

        $this->actingAs($user)
            ->get(route('admin.products.index'))
            ->assertForbidden();
    }

    public function test_sales_user_can_access_customers(): void
    {
        $user = User::factory()->sales()->create();

        $this->actingAs($user)
            ->get(route('admin.customers.index'))
            ->assertOk()
            ->assertSee('customer-management');
    }

    public function test_stock_user_cannot_access_customers(): void
    {
        $user = User::factory()->stock()->create();

        $this->actingAs($user)
            ->get(route('admin.customers.index'))
            ->assertForbidden();
    }

    public function test_admin_can_access_all_master_data_areas(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get(route('admin.categories.index'))
            ->assertOk();

        $this->actingAs($admin)
            ->get(route('admin.suppliers.index'))
            ->assertOk();

        $this->actingAs($admin)
            ->get(route('admin.products.index'))
            ->assertOk();

        $this->actingAs($admin)
            ->get(route('admin.customers.index'))
            ->assertOk();
    }

    public function test_inactive_stock_user_cannot_access_stock_master_data(): void
    {
        $user = User::factory()
            ->stock()
            ->inactive()
            ->create();

        $this->actingAs($user)
            ->get(route('admin.categories.index'))
            ->assertForbidden();

        $this->actingAs($user)
            ->get(route('admin.suppliers.index'))
            ->assertForbidden();

        $this->actingAs($user)
            ->get(route('admin.products.index'))
            ->assertForbidden();
    }

    public function test_inactive_sales_user_cannot_access_customers(): void
    {
        $user = User::factory()
            ->sales()
            ->inactive()
            ->create();

        $this->actingAs($user)
            ->get(route('admin.customers.index'))
            ->assertForbidden();
    }
}

<?php

namespace Tests\Feature\Security;

use App\Models\Purchase;
use App\Models\User;
use App\Services\PurchaseService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchaseAuthorizationHttpTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_purchase_area(): void
    {
        $this->get(route('admin.purchases.index'))
            ->assertRedirect(route('login'));
    }

    public function test_admin_can_access_purchase_area(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get(route('admin.purchases.index'))
            ->assertOk()
            ->assertSee('purchase-management');
    }

    public function test_stock_user_can_access_purchase_area(): void
    {
        $stock = User::factory()->stock()->create();

        $this->actingAs($stock)
            ->get(route('admin.purchases.index'))
            ->assertOk()
            ->assertSee('purchase-management');
    }

    public function test_sales_user_cannot_access_purchase_area(): void
    {
        $sales = User::factory()->sales()->create();

        $this->actingAs($sales)
            ->get(route('admin.purchases.index'))
            ->assertForbidden();
    }

    public function test_inactive_stock_user_cannot_access_purchase_area(): void
    {
        $stock = User::factory()
            ->stock()
            ->inactive()
            ->create();

        $this->actingAs($stock)
            ->get(route('admin.purchases.index'))
            ->assertForbidden();
    }

    public function test_sales_user_cannot_cancel_a_purchase(): void
    {
        $sales = User::factory()->sales()->create();
        $purchase = Purchase::factory()->create();

        $this->actingAs($sales)
            ->post(route(
                'admin.purchases.cancel',
                $purchase
            ))
            ->assertForbidden();
    }

    public function test_stock_user_can_reach_purchase_cancellation_authorization_boundary(): void
    {
        $stock = User::factory()->stock()->create();
        $purchase = Purchase::factory()->create([
            'status' => 'completed',
        ]);

        $this->mock(PurchaseService::class, function ($mock) use ($purchase, $stock): void {
            $mock->shouldReceive('cancel')
                ->once()
                ->withArgs(
                    function (
                        Purchase $receivedPurchase,
                        User $receivedActor,
                    ) use ($purchase, $stock): bool {
                        return $receivedPurchase->is($purchase)
                            && $receivedActor->is($stock);
                    }
                )
                ->andReturn($purchase);
        });

        $this->actingAs($stock)
            ->post(route(
                'admin.purchases.cancel',
                $purchase
            ))
            ->assertRedirect(
                route('admin.purchases.index')
            );
    }
}

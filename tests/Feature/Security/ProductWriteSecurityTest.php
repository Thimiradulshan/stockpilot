<?php

namespace Tests\Feature\Security;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductWriteSecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_create_a_product(): void
    {
        $category = Category::factory()->create();

        $this->post(route('admin.products.store'), [
            'category_id' => $category->id,
            'name' => 'Test Product',
            'sku' => 'SKU-001',
            'cost_price' => '100.00',
            'selling_price' => '150.00',
            'reorder_level' => '10.000',
        ])->assertRedirect(route('login'));
    }

    public function test_sales_user_cannot_create_a_product(): void
    {
        $user = User::factory()->sales()->create();
        $category = Category::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.products.store'), [
                'category_id' => $category->id,
                'name' => 'Test Product',
                'sku' => 'SKU-002',
                'cost_price' => '100.00',
                'selling_price' => '150.00',
                'reorder_level' => '10.000',
            ])
            ->assertForbidden();
    }

    public function test_stock_user_can_create_a_valid_product(): void
    {
        $user = User::factory()->stock()->create();
        $category = Category::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.products.store'), [
                'category_id' => $category->id,
                'name' => 'Test Product',
                'sku' => 'SKU-003',
                'cost_price' => '100.00',
                'selling_price' => '150.00',
                'reorder_level' => '10.000',
            ])
            ->assertRedirect(route('admin.products.index'));

        $product = Product::query()
            ->where('sku', 'SKU-003')
            ->firstOrFail();

        $this->assertSame('0.000', (string) $product->quantity);
        $this->assertSame('active', $product->status);
    }

    public function test_admin_can_create_a_valid_product(): void
    {
        $user = User::factory()->admin()->create();
        $category = Category::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.products.store'), [
                'category_id' => $category->id,
                'name' => 'Admin Product',
                'sku' => 'SKU-004',
                'cost_price' => '200.00',
                'selling_price' => '250.00',
                'reorder_level' => '20.000',
            ])
            ->assertRedirect(route('admin.products.index'));

        $this->assertDatabaseHas('products', [
            'sku' => 'SKU-004',
            'name' => 'Admin Product',
            'quantity' => '0.000',
            'status' => 'active',
        ]);
    }

    public function test_quantity_cannot_be_supplied_during_product_creation(): void
    {
        $user = User::factory()->stock()->create();
        $category = Category::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.products.store'), [
                'category_id' => $category->id,
                'name' => 'Tampered Product',
                'sku' => 'SKU-005',
                'cost_price' => '100.00',
                'selling_price' => '150.00',
                'reorder_level' => '10.000',
                'quantity' => '999999.000',
            ])
            ->assertRedirect(route('admin.products.index'));

        $product = Product::query()
            ->where('sku', 'SKU-005')
            ->firstOrFail();

        $this->assertSame('0.000', (string) $product->quantity);
    }

    public function test_status_cannot_be_supplied_during_product_creation(): void
    {
        $user = User::factory()->stock()->create();
        $category = Category::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.products.store'), [
                'category_id' => $category->id,
                'name' => 'Status Tampered Product',
                'sku' => 'SKU-006',
                'cost_price' => '100.00',
                'selling_price' => '150.00',
                'reorder_level' => '10.000',
                'status' => 'inactive',
            ])
            ->assertRedirect(route('admin.products.index'));

        $product = Product::query()
            ->where('sku', 'SKU-006')
            ->firstOrFail();

        $this->assertSame('active', $product->status);
    }

    public function test_negative_cost_price_is_rejected(): void
    {
        $user = User::factory()->stock()->create();
        $category = Category::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.products.store'), [
                'category_id' => $category->id,
                'name' => 'Invalid Cost',
                'sku' => 'SKU-007',
                'cost_price' => '-1.00',
                'selling_price' => '150.00',
                'reorder_level' => '10.000',
            ])
            ->assertSessionHasErrors('cost_price');

        $this->assertDatabaseMissing('products', [
            'sku' => 'SKU-007',
        ]);
    }

    public function test_negative_selling_price_is_rejected(): void
    {
        $user = User::factory()->stock()->create();
        $category = Category::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.products.store'), [
                'category_id' => $category->id,
                'name' => 'Invalid Selling Price',
                'sku' => 'SKU-008',
                'cost_price' => '100.00',
                'selling_price' => '-1.00',
                'reorder_level' => '10.000',
            ])
            ->assertSessionHasErrors('selling_price');

        $this->assertDatabaseMissing('products', [
            'sku' => 'SKU-008',
        ]);
    }

    public function test_negative_reorder_level_is_rejected(): void
    {
        $user = User::factory()->stock()->create();
        $category = Category::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.products.store'), [
                'category_id' => $category->id,
                'name' => 'Invalid Reorder Level',
                'sku' => 'SKU-009',
                'cost_price' => '100.00',
                'selling_price' => '150.00',
                'reorder_level' => '-1.000',
            ])
            ->assertSessionHasErrors('reorder_level');

        $this->assertDatabaseMissing('products', [
            'sku' => 'SKU-009',
        ]);
    }

    public function test_invalid_category_is_rejected(): void
    {
        $user = User::factory()->stock()->create();

        $this->actingAs($user)
            ->post(route('admin.products.store'), [
                'category_id' => 999999,
                'name' => 'Invalid Category',
                'sku' => 'SKU-010',
                'cost_price' => '100.00',
                'selling_price' => '150.00',
                'reorder_level' => '10.000',
            ])
            ->assertSessionHasErrors('category_id');

        $this->assertDatabaseMissing('products', [
            'sku' => 'SKU-010',
        ]);
    }

    public function test_duplicate_sku_is_rejected(): void
    {
        $user = User::factory()->stock()->create();
        $category = Category::factory()->create();

        Product::factory()->create([
            'category_id' => $category->id,
            'sku' => 'SKU-011',
        ]);

        $this->actingAs($user)
            ->post(route('admin.products.store'), [
                'category_id' => $category->id,
                'name' => 'Duplicate SKU',
                'sku' => 'SKU-011',
                'cost_price' => '100.00',
                'selling_price' => '150.00',
                'reorder_level' => '10.000',
            ])
            ->assertSessionHasErrors('sku');
    }

    public function test_quantity_cannot_be_changed_during_product_update(): void
    {
        $user = User::factory()->stock()->create();
        $product = Product::factory()
            ->withQuantity(25)
            ->create();

        $this->actingAs($user)
            ->patch(route('admin.products.update', $product), [
                'category_id' => $product->category_id,
                'name' => 'Updated Product',
                'sku' => $product->sku,
                'cost_price' => '300.00',
                'selling_price' => '400.00',
                'reorder_level' => '5.000',
                'quantity' => '999999.000',
            ])
            ->assertRedirect(route('admin.products.index'));

        $product->refresh();

        $this->assertSame('25.000', (string) $product->quantity);
        $this->assertSame('Updated Product', $product->name);
    }

    public function test_status_cannot_be_changed_during_product_update(): void
    {
        $user = User::factory()->stock()->create();
        $product = Product::factory()->create([
            'status' => 'active',
        ]);

        $this->actingAs($user)
            ->patch(route('admin.products.update', $product), [
                'category_id' => $product->category_id,
                'name' => $product->name,
                'sku' => $product->sku,
                'cost_price' => '300.00',
                'selling_price' => '400.00',
                'reorder_level' => '5.000',
                'status' => 'inactive',
            ])
            ->assertRedirect(route('admin.products.index'));

        $product->refresh();

        $this->assertSame('active', $product->status);
    }
}

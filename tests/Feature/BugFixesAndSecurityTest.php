<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Table;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class BugFixesAndSecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_cart_session_is_isolated_per_table_uuid()
    {
        $table1 = Table::create(['table_number' => 'T1', 'uuid' => Str::uuid()->toString()]);
        $table2 = Table::create(['table_number' => 'T2', 'uuid' => Str::uuid()->toString()]);
        $menu = Menu::create(['name' => 'Kopi Pempek', 'price' => 15000, 'category' => 'Minuman', 'is_available' => 1]);

        $this->post(route('order.addToCart', $table1->uuid), [
            'menu_id' => $menu->id,
            'quantity' => 2
        ]);

        $this->get(route('order.index', $table1->uuid))
            ->assertSee('Kopi Pempek');

        $this->get(route('order.checkout', $table2->uuid))
            ->assertSee('Keranjang Anda kosong');
    }

    public function test_update_cart_item_validates_max_quantity()
    {
        $table = Table::create(['table_number' => 'T1', 'uuid' => Str::uuid()->toString()]);
        $menu = Menu::create(['name' => 'Pempek Kapal Selam', 'price' => 20000, 'category' => 'Makanan', 'is_available' => 1]);

        $response = $this->postJson(route('order.updateCartItem', $table->uuid), [
            'menu_id' => $menu->id,
            'quantity' => 150
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['quantity']);
    }

    public function test_cannot_delete_occupied_table()
    {
        $user = User::factory()->create();
        $table = Table::create(['table_number' => 'T10', 'uuid' => Str::uuid()->toString(), 'status' => 'occupied']);

        $response = $this->actingAs($user)->delete(route('tables.destroy', $table->id));

        $response->assertRedirect(route('tables.index'))
            ->assertSessionHas('error');

        $this->assertDatabaseHas('tables', ['id' => $table->id, 'status' => 'occupied']);
    }

    public function test_deleting_order_preserves_occupied_status_if_other_active_orders_exist()
    {
        $user = User::factory()->create();
        $table = Table::create(['table_number' => 'T15', 'uuid' => Str::uuid()->toString(), 'status' => 'occupied']);
        
        $order1 = Order::create([
            'table_id' => $table->id,
            'total_amount' => 30000,
            'payment_method' => 'Cash',
            'customer_name' => 'Cust 1',
            'floor' => 'Lantai 1',
            'order_status' => 'pending',
            'payment_status' => 'pending'
        ]);

        $order2 = Order::create([
            'table_id' => $table->id,
            'total_amount' => 45000,
            'payment_method' => 'Cash',
            'customer_name' => 'Cust 2',
            'floor' => 'Lantai 1',
            'order_status' => 'cooking',
            'payment_status' => 'pending'
        ]);

        $this->actingAs($user)->delete(route('orders.destroy', $order1->id));

        $this->assertDatabaseMissing('orders', ['id' => $order1->id]);
        $this->assertDatabaseHas('tables', ['id' => $table->id, 'status' => 'occupied']);
    }

    public function test_place_order_validates_dynamic_payment_methods()
    {
        $table = Table::create(['table_number' => 'T5', 'uuid' => Str::uuid()->toString()]);
        $pm = PaymentMethod::create(['name' => 'QRIS BCA', 'type' => 'qris', 'is_active' => true]);
        $menu = Menu::create(['name' => 'Tekwan', 'price' => 18000, 'category' => 'Makanan', 'is_available' => 1]);

        $this->post(route('order.addToCart', $table->uuid), [
            'menu_id' => $menu->id,
            'quantity' => 1
        ]);

        $response = $this->post(route('order.placeOrder', $table->uuid), [
            'customer_name' => 'Budi',
            'payment_method_id' => $pm->id,
            'floor' => 'Lantai 1'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('orders', [
            'table_id' => $table->id,
            'customer_name' => 'Budi',
            'payment_method' => 'QRIS BCA'
        ]);
    }

    public function test_security_headers_are_present_in_responses()
    {
        $response = $this->get('/');

        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN')
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('X-XSS-Protection', '1; mode=block')
            ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
    }
}

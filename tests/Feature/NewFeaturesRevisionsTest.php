<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\Order;
use App\Models\Rating;
use App\Models\Table;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewFeaturesRevisionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_check_live_order_status_and_waiter_name()
    {
        $table = Table::create(['table_number' => '99', 'uuid' => (string) \Illuminate\Support\Str::uuid(), 'status' => 'occupied']);
        $order = Order::create([
            'table_id' => $table->id,
            'total_amount' => 50000,
            'payment_method' => 'Cash',
            'payment_status' => 'pending',
            'order_status' => 'served',
            'customer_name' => 'Budi',
            'waiter_name' => 'Wira Augie',
            'floor' => 'Lantai 1'
        ]);

        $response = $this->getJson(route('order.checkStatus', ['uuid' => $table->uuid, 'order' => $order->id]));

        $response->assertStatus(200);
        $response->assertJson([
            'order_id' => $order->id,
            'order_status' => 'served',
            'waiter_name' => 'Wira Augie',
        ]);
    }

    public function test_customer_can_submit_rating_for_food_table_and_waiter()
    {
        $table = Table::create(['table_number' => '98', 'uuid' => (string) \Illuminate\Support\Str::uuid(), 'status' => 'occupied']);
        $order = Order::create([
            'table_id' => $table->id,
            'total_amount' => 35000,
            'payment_method' => 'QRIS',
            'payment_status' => 'paid',
            'order_status' => 'completed',
            'customer_name' => 'Ais',
            'waiter_name' => 'Wira Augie',
            'floor' => 'Lantai 1'
        ]);

        $response = $this->post(route('order.rate', ['uuid' => $table->uuid, 'order' => $order->id]), [
            'food_rating' => 5,
            'table_rating' => 5,
            'waiter_rating' => 5,
            'is_favorite_table' => '1',
            'review' => 'Makanannya lezat sekali!',
            'waiter_review' => 'Pelayanan mas Wira ramah dan cepat.'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('ratings', [
            'order_id' => $order->id,
            'table_id' => $table->id,
            'food_rating' => 5,
            'table_rating' => 5,
            'waiter_rating' => 5,
            'is_favorite_table' => 1,
            'waiter_name' => 'Wira Augie',
            'review' => 'Makanannya lezat sekali!',
        ]);

        $this->assertEquals(5.0, $table->fresh()->average_rating);
        $this->assertEquals(1, $table->fresh()->favorites_count);
    }

    public function test_unavailable_menu_cannot_be_added_to_cart()
    {
        $table = Table::create(['table_number' => '97', 'uuid' => (string) \Illuminate\Support\Str::uuid(), 'status' => 'available']);
        $unavailableMenu = Menu::create([
            'name' => 'Menu Habis Test',
            'price' => 25000,
            'category' => 'Makanan',
            'is_available' => false,
        ]);

        $response = $this->postJson(route('order.addToCart', ['uuid' => $table->uuid]), [
            'menu_id' => $unavailableMenu->id,
            'quantity' => 1
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'success' => false
        ]);
    }

    public function test_admin_or_kitchen_can_update_status_and_assign_waiter()
    {
        $admin = User::create([
            'name' => 'Admin Test',
            'email' => 'admin_test@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        $table = Table::create(['table_number' => '96', 'uuid' => (string) \Illuminate\Support\Str::uuid(), 'status' => 'occupied']);
        $order = Order::create([
            'table_id' => $table->id,
            'total_amount' => 45000,
            'payment_method' => 'Cash',
            'payment_status' => 'pending',
            'order_status' => 'cooking',
            'customer_name' => 'Siti',
            'floor' => 'Lantai 1'
        ]);

        $response = $this->actingAs($admin)->put(route('orders.updateStatus', $order->id), [
            'order_status' => 'served',
            'waiter_name' => 'Wira Augie'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'order_status' => 'served',
            'waiter_name' => 'Wira Augie'
        ]);
    }
}

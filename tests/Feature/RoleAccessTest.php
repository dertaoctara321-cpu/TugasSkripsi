<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Table;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $dapur;
    protected User $kasir;
    protected User $owner;
    protected Table $table;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
        $this->dapur = User::factory()->dapur()->create();
        $this->kasir = User::factory()->kasir()->create();
        $this->owner = User::factory()->owner()->create();

        $this->table = Table::create([
            'table_number' => '1',
            'uuid' => 'test-table-uuid-12345',
            'status' => 'available',
        ]);
    }

    public function test_customer_can_access_menu_without_login(): void
    {
        $response = $this->get(route('order.index', $this->table->uuid));
        $response->assertStatus(200);
    }

    public function test_admin_can_access_all_admin_routes(): void
    {
        $this->actingAs($this->admin);

        $this->get(route('admin.dashboard'))->assertStatus(200);
        $this->get(route('admin.reports'))->assertStatus(200);
        $this->get(route('orders.index'))->assertStatus(200);
        $this->get(route('menus.index'))->assertStatus(200);
        $this->get(route('tables.index'))->assertStatus(200);
        $this->get(route('payment-methods.index'))->assertStatus(200);
        $this->get(route('users.index'))->assertStatus(200);
    }

    public function test_dapur_can_access_orders_but_blocked_from_master_and_reports(): void
    {
        $this->actingAs($this->dapur);

        // Can access orders
        $this->get(route('orders.index'))->assertStatus(200);

        // Blocked from dashboard and reports -> redirects to orders.index with error
        $this->get(route('admin.dashboard'))->assertRedirect(route('orders.index'));
        $this->get(route('admin.reports'))->assertRedirect(route('orders.index'));

        // Blocked from master data & users
        $this->get(route('menus.index'))->assertRedirect(route('orders.index'));
        $this->get(route('users.index'))->assertRedirect(route('orders.index'));
    }

    public function test_kasir_can_access_orders_and_tables_but_blocked_from_master(): void
    {
        $this->actingAs($this->kasir);

        // Can access orders & tables monitoring
        $this->get(route('orders.index'))->assertStatus(200);
        $this->get(route('tables.index'))->assertStatus(200);

        // Blocked from dashboard, reports, menus, users, create table
        $this->get(route('admin.dashboard'))->assertRedirect(route('orders.index'));
        $this->get(route('admin.reports'))->assertRedirect(route('orders.index'));
        $this->get(route('menus.index'))->assertRedirect(route('orders.index'));
        $this->get(route('users.index'))->assertRedirect(route('orders.index'));
        $this->get(route('tables.create'))->assertRedirect(route('orders.index'));
    }

    public function test_owner_can_access_dashboard_and_reports_but_blocked_from_master(): void
    {
        $this->actingAs($this->owner);

        // Can access dashboard, reports, orders
        $this->get(route('admin.dashboard'))->assertStatus(200);
        $this->get(route('admin.reports'))->assertStatus(200);
        $this->get(route('orders.index'))->assertStatus(200);

        // Blocked from master data and users -> redirects to admin.dashboard
        $this->get(route('menus.index'))->assertRedirect(route('admin.dashboard'));
        $this->get(route('users.index'))->assertRedirect(route('admin.dashboard'));
    }

    public function test_dapur_can_update_order_status(): void
    {
        $this->actingAs($this->dapur);

        $order = Order::create([
            'table_id' => $this->table->id,
            'customer_name' => 'John Doe',
            'order_status' => 'pending',
            'payment_status' => 'pending',
            'total_amount' => 50000,
        ]);

        $response = $this->put(route('orders.updateStatus', $order->id), [
            'order_status' => 'cooking',
        ]);

        $response->assertSessionHas('success');
        $this->assertEquals('cooking', $order->fresh()->order_status);
    }

    public function test_kasir_can_verify_payment(): void
    {
        $this->actingAs($this->kasir);

        $order = Order::create([
            'table_id' => $this->table->id,
            'customer_name' => 'Jane Doe',
            'order_status' => 'served',
            'payment_status' => 'pending',
            'total_amount' => 75000,
        ]);

        $response = $this->put(route('orders.verifyPayment', $order->id));

        $response->assertSessionHas('success');
        $this->assertEquals('paid', $order->fresh()->payment_status);
    }

    public function test_admin_can_create_new_staff_user(): void
    {
        $this->actingAs($this->admin);

        $response = $this->post(route('users.store'), [
            'name' => 'Staf Baru Kasir',
            'email' => 'kasirbaru@gmail.com',
            'role' => 'kasir',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseHas('users', [
            'email' => 'kasirbaru@gmail.com',
            'role' => 'kasir',
        ]);
    }
}

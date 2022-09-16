<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Order;

class AppTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */

    protected function setUp() : void
    {
        parent::setUp();

        Product::factory(3)->create(); // 3 products for each test
    }

    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_can_add_product_to_cart()
    {
        $response = $this->get('/cart/1');
        $product = Product::find(1);

        $response->assertStatus(200);
        $response->assertSeeText($product->name);
    }

    public function test_new_customer_creation()
    {
        $product = Product::find(1);
        $email = 'etiennez0r@gmail.com';

        $response = $this->post('/customers', [
            'product_id' => $product->id,
            'customer_name' => 'Etienne Gomez',
            'customer_email' => $email,
        ]);

        $response->assertRedirect('/orders/create');

        $customer = Customer::find(1);

        $this->assertEquals($email, $customer->customer_email);
    }

    public function test_review_cart()
    {
        $product = Product::find(1);
        $email = 'etiennez0r@gmail.com';

        $response = $this->post('/customers', [
            'product_id' => $product->id,
            'customer_name' => 'Etienne Gomez',
            'customer_email' => $email,
        ]);

        // new user buying redirects to order confirmation screen
        $response->assertRedirect('/orders/create');

        $response = $this->get('/orders/create');

        $customer = Customer::find(1);

        $response->assertSeeText($product->product_name);
        $response->assertSeeText($customer->customer_name);
    }

    public function test_new_order_redirects_to_payments_processor()
    {
        $customer = new Customer;

        $customer->customer_name = 'Etienne Gomez';
        $customer->customer_email = 'etiennez0r@gmail.com';

        $customer->save();

        $response = $this->post('orders', [
                                'product_id' => 1,
                                'customer_id' => $customer->id
                            ]);

        $response->assertRedirectContains('https://checkout-co.placetopay.dev/session/');
        $order = Order::find(1);
        $this->assertEquals('CREATED', $order->status);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customerId = session('customer_id');
        $orders = [];
        $customer = null;

        if (url()->current() == url()->route('orders.all'))
            // all orders route
            $orders = Order::all();
        else if ($customerId) {
            $orders = Order::where('customer_id', '=', $customerId)->get();
            $customer = Customer::find($customerId);
        }
        
        return view('orders.index', compact('orders', 'customer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customerId = session('customer_id');
        $productId = session('product_id');

        if ($customerId && $productId) {
            $product = Product::findOrFail($productId);
            $customer = Customer::findOrFail($customerId);

            return view('orders.create', compact('product', 'customer'));
        } else
            abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = Product::findOrFail($request->get('product_id'));
        $customer = Customer::findOrFail($request->get('customer_id'));

        $order = new Order;

        $order->customer_id = $customer->id;
        $order->product_id = $product->id;
        $order->order_total = $product->price;
        $order->status = ORDER_CREATED;

        $order->save();

        try {
            $response = $this->placeToPayRequest($customer, $product, $order);

            if ($response->isSuccessful()) {
                $processUrl = $response->processUrl();
                $requestId = $response->requestId();
                
                $order->process_url = $processUrl;
                $order->request_id = $requestId;
                $order->save();
    
                return redirect()->away($processUrl);
            } else {
                return redirect("/orders/$order->id")->withErrors("Ocurrio un error conectando con el procesador de pagos: ". $response->status()->message());
            }
        } catch (\Exception $e) {
            return redirect("/orders/$order->id")->withErrors("Ocurrio un error inesperado..");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        if (in_array($order->status, [ORDER_PENDING, ORDER_CREATED]) && $order->request_id) {
            // the user has a payment request pending
            // so we try to query the result from our payment processor

            $response = $this->placeToPayQuery($order->request_id);

            if ($response->isSuccessful()) {
                if ($response->status()->isApproved()) {
                    $order->status = ORDER_PAYED;
                } else {
                    $order->reject_reason = $response->status()->message();

                    if ($response->status()->isRejected()) {
                        $order->status = ORDER_REJECTED;
                    } else if ($response->status()->isError()) {
                        $order->status = ORDER_ERROR;
                    } else {
                        $order->status = $response->status()->status();
                    }
                }

                $order->save();
            }
        }
        
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOrderRequest  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $order->status = ORDER_CREATED;
        $order->save();

        try {
            $response = $this->placeToPayRequest($order->customer, $order->product, $order);

            if ($response->isSuccessful()) {
                $processUrl = $response->processUrl();
                $requestId = $response->requestId();
                
                $order->process_url = $processUrl;
                $order->request_id = $requestId;
                $order->save();
    
                return redirect()->away($processUrl);
            } else {
                return redirect("/orders/$order->id")->withErrors("Ocurrio un error conectando con el procesador de pagos: ". $response->status()->message());
            }
        } catch (\Exception $e) {
            return redirect("/orders/$order->id")->withErrors("Ocurrio un error inesperado..");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    protected function placeToPay() : \Dnetix\Redirection\PlacetoPay
    {
        return new \Dnetix\Redirection\PlacetoPay([
            'login' => PLACE_TO_PAY_LOGIN, // Provided by PlacetoPay
            'tranKey' => PLACE_TO_PAY_SECRET, // Provided by PlacetoPay
            'baseUrl' => PLACE_TO_PAY_BASE_URL,
            'timeout' => 10, // (optional) 15 by default
        ]);
    }

    protected function placeToPayQuery($requestId) : \Dnetix\Redirection\Message\RedirectInformation
    {
        $placetopay = $this->placeToPay();

        return $placetopay->query($requestId);
    }

    protected function placeToPayRequest(Customer $customer, Product $product, Order $order) : \Dnetix\Redirection\Message\RedirectResponse
    {
        $placetopay = $this->placeToPay();

        $request = [
            'payment' => [
                'reference' => $order->id,
                'description' => $product->name,
                'amount' => [
                    'currency' => 'USD',
                    'total' => $order->order_total,
                ],
            ],
            // 'payer' => [
            //     'name' => $customer->customer_name,
            //     'email' => $customer->customer_email,
            // ],
            'buyer' => [
                'name' => $customer->customer_name,
                'email' => $customer->customer_email,
            ],
            'expiration' => date('c', strtotime('+2 days')),
            'returnUrl' => \URL::to('/') . "/orders/$order->id",
            'ipAddress' => '127.0.0.1',
            'userAgent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36',
        ];

        return $placetopay->request($request);
    }
}

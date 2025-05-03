<?php

namespace App\Http\Controllers\Backends;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use PDF;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!auth()->user()->can('sale_report.view')) {
            abort(403, 'Unauthorized action.');
        }

        $products = Product::all();
        $customers = Customer::all();
        $query = Order::with('customer', 'details.brand', 'details.product', 'deletedCustomer');

        // Date range filter
        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->date_from)->startOfDay(),
                Carbon::parse($request->date_to)->endOfDay(),
            ]);
        }

        // Customer filter
        if ($request->filled('customer_id') && $request->customer_id !== "") {
            $query->where('customer_id', $request->customer_id);
        }

        // Order type filter
        if ($request->filled('order_type') && $request->order_type !== "") {
            $query->where('order_type', $request->order_type);
        }

        // Payment status filter
        if ($request->filled('payment_status') && $request->payment_status !== "") {
            $query->where('payment_status', $request->payment_status);
        }

        // Payment method filter
        if ($request->filled('payment_method') && $request->payment_method !== "") {
            $query->where('payment_method', $request->payment_method);
        }

        $orders = $query->latest('id')->get();

        if ($request->ajax()) {
            return view('backends.order._table', compact('orders'))->render();
        }

        return view('backends.order.index', compact('orders', 'products', 'customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!auth()->user()->can('sale_report.view')) {
            abort(403, 'Unauthorized action.');
        }

        $order = Order::with('customer', 'details.brand', 'details.product')->findOrFail($id);
        return view('backends.order.partial.order_detail', compact('order'));
    }

    /**
     * Show the form for editing the address of the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function editAddress()
    {
        if (!auth()->user()->can('sale_report.edit')) {
            abort(403, 'Unauthorized action.');
        }

        return view('backends.order.partial.modal_edit_address');
    }

    /**
     * Update the payment status of the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePaymentStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->payment_status = $request->payment_status === 'true' ? 'paid' : 'unpaid';
        $order->save();

        return response()->json([
            'success' => true,
            'new_status' => $order->payment_status
        ]);
    }

    /**
     * Update the order status of the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateOrderStatus(Request $request, $id)
    {
        $data = $request->validate([
            'order_status' => 'required|string',
        ]);

        $order = Order::findOrFail($id);

        // Only act if the status is different
        if ($order->order_status !== $data['order_status']) {
            $order->order_status = $data['order_status'];
            $order->save();

            // Record the change in the history table
            $order->statusHistories()->create([
                'status' => $data['order_status'],
            ]);
        }

        // Return success
        return response()->json([
            'success'    => true,
            'new_status' => $order->order_status,
            // optional: include entire tracking back to the client
            // 'tracking'   => $order->statusHistories->map(fn($h) => [
            //     'status'    => $h->status,
            //     'timestamp' => $h->updated_at->format('Y-m-d H:i:s'),
            // ])->values(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function invoicePdf($id)
    {
        if (!auth()->user()->can('sale_report.view')) {
            abort(403, 'Unauthorized action.');
        }

        $order = Order::with('customer', 'details.brand', 'details.product')->findOrFail($id);
        $invoiceRef = $order->invoice_ref ?? 'order-' . $id;

        return view('backends.order.partial.invoice_pdf', compact('order'));
    }
}

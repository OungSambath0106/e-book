<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->invoice_ref }}</title>
    @php
        $setting = \App\Models\BusinessSetting::all();
        $data['fav_icon'] = @$setting->where('type', 'fav_icon')->first()->value ?? '';
        $data['email'] = @$setting->where('type', 'email')->first()->value ?? '';
    @endphp
    <link rel="icon" type="image/x-icon" href="
        @if ($data['fav_icon'] && file_exists('uploads/business_settings/' . $data['fav_icon']))
            {{ asset('uploads/business_settings/' . $data['fav_icon']) }}
        @else
            {{ asset('uploads/image/default.png') }}
        @endif">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        :root {
            --primary-color: #2563eb;
            --primary-light: #dbeafe;
            --secondary-color: #64748b;
            --text-color: #1e293b;
            --light-text: #64748b;
            --border-color: #e2e8f0;
            --background-color: #f8fafc;
            --success-color: #10b981;
            --success-bg: #d1fae5;
            --danger-color: #ef4444;
            --danger-bg: #fee2e2;
            --spacing-xs: 5px;
            --spacing-sm: 10px;
            --spacing-md: 20px;
            --spacing-lg: 30px;
            --box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --border-radius: 8px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            line-height: 1.5;
            color: var(--text-color);
            background: var(--background-color);
            margin: 0;
            padding: 0;
        }

        .invoice-box {
            max-width: 800px;
            margin: 20px auto;
            padding: var(--spacing-lg);
            background-color: #fff;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--spacing-lg);
            padding-bottom: var(--spacing-md);
            border-bottom: 1px solid var(--border-color);
        }

        .company-logo {
            display: flex;
            align-items: center;
        }

        .company-logo h1 {
            font-size: 32px;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0;
            letter-spacing: -0.5px;
        }

        .invoice-id {
            font-size: 14px;
            color: var(--secondary-color);
            margin-top: var(--spacing-xs);
        }

        .invoice-meta {
            text-align: right;
        }

        .invoice-meta div {
            margin-bottom: 5px;
            color: var(--light-text);
        }

        .section-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: var(--spacing-sm);
            color: var(--primary-color);
        }

        .customer-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: var(--spacing-lg);
            padding: var(--spacing-md);
            background-color: var(--background-color);
            border-radius: var(--border-radius);
        }

        .customer-details div {
            flex: 1;
        }

        .customer-info div {
            margin-bottom: 3px;
            color: var(--light-text);
        }

        .customer-info div strong {
            color: var(--text-color);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: var(--spacing-lg);
            border-radius: var(--border-radius);
            overflow: hidden;
        }

        thead {
            background-color: var(--primary-color);
            color: white;
        }

        th {
            text-align: left;
            padding: 12px 15px;
            font-weight: 500;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 12px 15px;
            border-bottom: 1px solid var(--border-color);
            vertical-align: top;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        tbody tr:nth-child(even) {
            background-color: var(--background-color);
        }

        .product-row {
            display: flex;
            align-items: center;
        }

        .product-info {
            margin-left: 15px;
        }

        .product-info div {
            margin-bottom: 3px;
        }

        .product-info div:first-child {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .product-info div:not(:first-child) {
            font-size: 13px;
            color: var(--light-text);
        }

        .totals {
            display: flex;
            justify-content: flex-end;
            margin-top: var(--spacing-lg);
        }

        .totals table {
            width: 350px;
            margin-bottom: 0;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .totals table td {
            padding: 10px 15px;
            border-bottom: 1px solid var(--border-color);
        }

        .totals table td:first-child {
            color: var(--light-text);
        }

        .totals table td:last-child {
            text-align: right;
            font-weight: 500;
        }

        .totals table tr:last-child {
            background-color: var(--primary-color);
        }

        .totals table tr:last-child td {
            color: white;
            font-weight: 600;
            padding: 12px 15px;
            border-bottom: none;
        }

        .status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status.unpaid {
            background-color: var(--danger-bg);
            color: var(--danger-color);
        }

        .status.paid {
            background-color: var(--success-bg);
            color: var(--success-color);
        }

        .footer {
            margin-top: var(--spacing-lg);
            padding-top: var(--spacing-md);
            border-top: 1px solid var(--border-color);
            text-align: center;
            color: var(--light-text);
            font-size: 13px;
        }

        .footer p {
            margin-bottom: 5px;
        }

        .action-buttons {
            display: flex;
            justify-content: flex-end;
            margin: 20px 0;
            gap: 10px;
        }

        .action-buttons button {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            transition: background-color 0.2s;
        }

        .action-buttons button:hover {
            background-color: #1d4ed8;
        }

        .action-buttons button svg {
            margin-right: 5px;
        }

        @media print {
            .action-buttons {
                display: none;
            }

            .invoice-box {
                margin: 0;
                padding: 20px;
                box-shadow: none;
                border: none;
            }

            body {
                background: white;
            }

            /* Fix for print color issue */
            thead {
                background-color: var(--primary-color) !important;
                color: white !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            tbody tr:nth-child(even) {
                background-color: var(--background-color) !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .totals table tr:last-child {
                background-color: var(--primary-color) !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .totals table tr:last-child td {
                color: white !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .status.unpaid {
                background-color: var(--danger-bg) !important;
                color: var(--danger-color) !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .status.paid {
                background-color: var(--success-bg) !important;
                color: var(--success-color) !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .customer-details {
                background-color: var(--background-color) !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        #pdf-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid var(--primary-color);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin-bottom: 15px;
        }

        .loader-text {
            color: var(--secondary-color);
            font-weight: 500;
        }
    </style>
</head>

<body>
    <div class="invoice-box" id="invoice-container">
        <div class="invoice-header">
            <div class="company-logo">
                <div>
                    <h1>INVOICE</h1>
                    <div class="invoice-id" id="orderId">Order #{{ $order->invoice_ref }}</div>
                </div>
            </div>
            <div class="invoice-meta">
                <div>Date: {{ $order->created_at->format('d M, Y, h:i A') }}</div>
                <div>Order Type: {{ ucwords(str_replace('_', ' ', $order->order_type)) }}</div>
                <div>Payment Status: <span
                        class="status {{ strtolower($order->payment_status) }}">{{ $order->payment_status }}</span>
                </div>
            </div>
        </div>

        <div class="customer-details">
            <div class="customer-info">
                <div class="section-title">Customer Details</div>
                <div><strong>Name:</strong> {{ $order->customer->name }}</div>
                <div><strong>Contact:</strong> {{ $order->customer->phone ?? '' }}</div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width: 50%;">ITEM DETAILS</th>
                    <th>ITEM PRICE</th>
                    <th>ITEM DISCOUNT</th>
                    <th>TOTAL PRICE</th>
                </tr>
            </thead>
            <tbody id="orderItems">
                @forelse($order->details ?? [] as $index => $item)
                    <tr>
                        <td>
                            <div class="product-row">
                                <div class="product-info">
                                    <div>{{ $item->product->name }}</div>
                                    <div>Qty: {{ $item->product_qty }}</div>
                                    <div>Size: {{ $item->product_size }}</div>
                                    <div>Unit price: ${{ number_format($item->product_price, 2) }}</div>
                                </div>
                            </div>
                        </td>
                        <td> $ {{ number_format($item->product_price * $item->product_qty, 2) }} </td>
                        @php
                            $discount_percent = (($item->product_price * $item->discount) / 100) * $item->product_qty;
                            $discount_amount = $item->discount * $item->product_qty;
                        @endphp
                        <td>
                            @if ($item->discount_type == 'percent')
                                $ {{ number_format($discount_percent, 2) }}
                            @else
                                $ {{ number_format($discount_amount, 2) }}
                            @endif
                        </td>
                        <td>
                            @if ($item->discount_type == 'percent')
                                $
                                {{ number_format($item->product_price * $item->product_qty - $discount_percent, 2) }}
                            @else
                                $ {{ number_format($item->product_price * $item->product_qty - $discount_amount, 2) }}
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 30px;">No items found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="totals">
            <table>
                <tr>
                    <td>Item price:</td>
                    <td align="right" id="itemPrice"> $ {{ number_format($order->order_amount, 2) }} </td>
                </tr>
                <tr>
                    <td>Item Discount:</td>
                    <td align="right" id="itemDiscount"> - $ {{ number_format($order->discount_amount, 2) }} </td>
                </tr>
                <tr>
                    <td>Sub Total:</td>
                    <td align="right" id="subTotal"> $
                        {{ number_format($order->order_amount - $order->discount_amount, 2) }} </td>
                </tr>
                <tr>
                    <td>Delivery Fee:</td>
                    <td align="right" id="deliveryFee"> $ {{ number_format($order->delivery_fee, 2) }} </td>
                </tr>
                <tr>
                    <td>Total:</td>
                    <td align="right" id="total"> $ {{ number_format($order->final_total, 2) }} </td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <p>Thank you and have a great day!</p>
            <p>Questions? Contact us at <span style="color: var(--primary-color);">{{ $data['email'] }}</span></p>
        </div>
    </div>

    <div class="action-buttons" style="justify-content: center;">
        <button id="printButton" onclick="window.print();">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="6 9 6 2 18 2 18 9"></polyline>
                <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                <rect x="6" y="14" width="12" height="8"></rect>
            </svg>
            Print
        </button>
        <button id="downloadPdfButton" class="print-invoice-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                <polyline points="7 10 12 15 17 10"></polyline>
                <line x1="12" y1="15" x2="12" y2="3"></line>
            </svg>
            Download PDF
        </button>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelector('.print-invoice-btn').addEventListener('click', generatePDF);
        });

        function generatePDF() {
            showLoader();

            const orderId = document.getElementById('orderId').textContent.replace('Order #', '');
            const element = document.getElementById('invoice-container');

            // Fixed: Adjusted the positioning for PDF generation
            html2canvas(element, {
                scale: 2,
                useCORS: true,
                allowTaint: true,
                logging: false
            }).then(function(canvas) {
                const imgData = canvas.toDataURL('image/png');

                const {
                    jsPDF
                } = window.jspdf;
                const pdf = new jsPDF('p', 'mm', 'a4');

                const pdfWidth = pdf.internal.pageSize.getWidth();
                const pdfHeight = pdf.internal.pageSize.getHeight();
                const imgWidth = canvas.width;
                const imgHeight = canvas.height;
                const ratio = Math.min(pdfWidth / imgWidth, pdfHeight / imgHeight);
                const imgX = (pdfWidth - imgWidth * ratio) / 2;
                // Fixed: Reduced the top margin to fix excessive space
                const imgY = 10;

                pdf.addImage(imgData, 'PNG', imgX, imgY, imgWidth * ratio, imgHeight * ratio);
                pdf.save(`Invoice-${orderId}.pdf`);

                hideLoader();
            });
        }

        function showLoader() {
            const loader = document.createElement('div');
            loader.id = 'pdf-loader';
            loader.innerHTML = '<div class="spinner"></div><div class="loader-text">Generating PDF...</div>';
            document.body.appendChild(loader);
        }

        function hideLoader() {
            const loader = document.getElementById('pdf-loader');
            if (loader) {
                document.body.removeChild(loader);
            }
        }
    </script>
</body>

</html>

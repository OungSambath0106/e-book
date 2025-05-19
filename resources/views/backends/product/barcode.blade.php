@extends('backends.layouts.admin')
@section('page_title', __('Generate Barcode'))
@section('contents')
    @php
        $setting = \App\Models\BusinessSetting::all();
        $data['company_name'] = @$setting->where('type', 'company_name')->first()->value ?? '';
    @endphp
    <style>
        .barcodea4 {
            width: 8.3in;
            height: 11.5in;
            overflow: hidden;
            page-break-after: always;
            display: block;
            border: 1px solid #ccc;
            margin: 10px auto;
            padding: 0.185in;
        }
        .barcodea4 .barcode-item {
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding: 10px 14px;
            overflow: hidden;
            text-align: center;
            border: 1px dotted #ccc;
            font-size: 12px;
            line-height: 14px;
            text-transform: uppercase;
            float: left;
            margin-right: 5px;
            margin-bottom: 8px;
            width: 2.48in;
            height: 1.535in;
            margin-left: 0.079in;
        }
        .barcode_site {
            font-size: 14px;
            display: block;
            font-weight: bold;
        }
        .barcode_name,
        .barcode_price {
            display: block;
        }
        .barcode_image div {
            font-size: 0;
            position: relative;
            width: 136px;
            height: 30px;
            margin-left: auto;
            margin-right: auto;
        }
        .barcode_code {
            display: block;
            font-weight: bold;
        }
        .show-div {
            display: block;
        }
    </style>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h5 class="mb-0 ml-2">Generate Barcode</h5>
                    </div>

                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="code" class="form-label">Code</label>
                            </div>
                            <div class="col-md-3">
                                <label for="name" class="form-label">Name</label>
                            </div>
                            <div class="col-md-3">
                                <label for="quantity" class="form-label">Quantity</label>
                            </div>
                            <div class="col-md-4">
                                <label for="action" class="form-label">Action</label>
                            </div>
                        </div>

                        <!-- Barcode Form -->
                        <form id="barcodeForm">
                            <div class="row">
                                <div class="col-md-2">
                                    <span>{{ $product_barcode }}</span>
                                </div>
                                <div class="col-md-3">
                                    <span>{{ $product->name }}</span>
                                </div>
                                <div class="col-md-3">
                                    <div class="position-relative">
                                        <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" max="270" style="padding: 0.3rem 0.75rem;" required>
                                        <div class="text-danger small mt-1">Maximum quantity 270</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn bg-gradient-primary btn-sm">Generate barcode</button>
                                        <button type="button" id="resetBtn" class="btn bg-gradient-danger btn-sm">Reset</button>
                                        <button type="button" id="printBtn" class="btn bg-gradient-secondary btn-sm">Print</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="printarea" class="show-div py-3">
        <div class="barcodea4" id="barcodea4">
            <!-- Barcode Item -->
        </div>
    </div>
@endsection
@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('barcodeForm');
            const barCodea4 = document.getElementById('barcodea4');
            const quantityInput = document.getElementById('quantity');
            const resetBtn = document.getElementById('resetBtn');
            const printBtn = document.getElementById('printBtn');

            function generateBarcodes(qty = 1) {
                const maxQty = 270;
                const maxHeight = 1200; // 11.7 inches in pixels (approx. at 96dpi)

                if (qty > maxQty) {
                    alert('Maximum quantity is 270');
                    return;
                }

                const printArea = document.getElementById('printarea');
                printArea.innerHTML = ''; // Clear previous

                // Create first container
                let currentContainer = document.createElement('div');
                currentContainer.classList.add('barcodea4');
                printArea.appendChild(currentContainer);

                // Template for a single barcode
                const template = `
                    <div class="barcode-item">
                        <div class="barcode_site text-capitalize">{{ $data['company_name'] }}</div>
                        <div class="barcode_name text-capitalize">{{ $product->name }}</div>
                        <div class="barcode_price text-capitalize">${{ number_format($product->price, 2) }}</div>
                        <div class="barcode_image">{!! $barcode !!}</div>
                        <div class="barcode_code text-capitalize">Code : {{ $product_barcode }}</div>
                    </div>
                `;

                for (let i = 0; i < qty; i++) {
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = template.trim();
                    const barcodeItem = tempDiv.firstElementChild;

                    currentContainer.appendChild(barcodeItem);

                    // Check height after adding
                    if (currentContainer.scrollHeight > maxHeight) {
                        currentContainer.removeChild(barcodeItem); // remove overflow item

                        // Start a new page
                        currentContainer = document.createElement('div');
                        currentContainer.classList.add('barcodea4');
                        printArea.appendChild(currentContainer);
                        currentContainer.appendChild(barcodeItem); // add to new page
                    }
                }
            }

            // Form submit event
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                const qty = parseInt(quantityInput.value);
                generateBarcodes(qty);
            });

            // Reset button event
            resetBtn.addEventListener('click', function () {
                quantityInput.value = 1;
                generateBarcodes(1);
            });

            // Print button event
            printBtn.addEventListener('click', function () {
                const printContents = document.getElementById('printarea').innerHTML;
                const printWindow = window.open('', '', 'width=900,height=650');
                printWindow.document.write(printContents);
                printWindow.document.close();
            });

            // Initial render of 1 barcode
            generateBarcodes(1);
        });
    </script>
    <script>
        document.getElementById("printBtn").addEventListener("click", function () {
            // Get the content you want to print
            const printContents = document.getElementById("printarea").innerHTML;

            // Create a new window
            const printWindow = window.open("", "", "width=800,height=600");

            // Get all CSS <link> and <style> tags
            let styles = '';
            document.querySelectorAll('link[rel="stylesheet"], style').forEach((styleTag) => {
                styles += styleTag.outerHTML;
            });

            // Write content to the new window
            printWindow.document.write(`
                <html>
                    <head>
                        <title>Print</title>
                        ${styles}
                    </head>
                    <body>
                        ${printContents}
                        <script>
                            window.onload = function () {
                                window.print();
                                window.close();
                            };
                        <\/script>
                    </body>
                </html>
            `);

            printWindow.document.close(); // Close the document to finish loading
        });
    </script>
@endpush
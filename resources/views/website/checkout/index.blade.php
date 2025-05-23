@extends('website.master')
@section('page_title', __('Checkout Page'))
@section('content')
    <style>
        .progress-navbar {
            display: flex;
            justify-content: center;
            padding-top: 100px;
            flex-direction: row !important;
            margin-bottom: 1.5rem;
            gap: 2rem;
        }

        .progress-step {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            background: white;
            border: 2px solid #e5e7eb;
            transition: all 0.3s;
        }

        .progress-step.active {
            background: #6366f1;
            color: white;
            border-color: #6366f1;
        }

        .progress-step.completed {
            background: #10b981;
            color: white;
            border-color: #10b981;
        }

        .page {
            display: none;
            background: white;
            border-radius: 12px;
            margin: 2rem;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .page.active {
            display: block;
        }

        .page-title {
            font-size: 1.5rem !important;
            margin-bottom: 1.25rem !important;
            color: #1f2937;
        }

        .cart-item {
            display: flex;
            gap: 1rem;
            margin: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            align-items: center;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .book-image {
            width: 80px;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .book-details {
            flex: 1;
        }

        .book-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #1f2937;
        }

        .book-author {
            color: #6b7280;
            margin-bottom: 0.5rem;
        }

        .book-format {
            font-size: 0.9rem;
            color: #9ca3af;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 1rem 0 1.5rem;
        }

        .qty-btn {
            width: 32px;
            height: 32px;
            border: 1px solid #d1d5db;
            background: white;
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .qty-btn:hover {
            background: #f3f4f6;
        }

        .qty-input {
            width: 90px;
            text-align: center;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 0.2rem;
        }

        .price-section {
            text-align: right;
            min-width: 120px;
        }

        .current-price {
            font-size: 1.2rem;
            font-weight: 600;
            color: #6366f1;
        }

        .original-price {
            font-size: 0.9rem;
            color: #9ca3af;
            text-decoration: line-through;
        }

        .remove-btn {
            position: absolute;
            top: 0;
            right: 0;
            background: #ef4444;
            color: white;
            border: none;
            padding: 0.5rem 0.7rem;
            font-size: 0.7rem;
            border-radius: 50%;
            cursor: pointer;
            transition: background 0.2s;
        }

        .remove-btn:hover {
            background: #dc2626;
        }

        .cart-summary {
            background: #f9fafb;
            padding: 2rem;
            border-radius: 8px;
            margin-top: 2rem;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .summary-row.total {
            font-size: 1.2rem;
            font-weight: 600;
            border-top: 1px solid #d1d5db;
            padding-top: 1rem;
            margin-top: 1rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #374151;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.2s;
        }

        .form-input:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .btn-group .btn {
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-group .btn-primary {
            background: #6366f1;
            color: white;
        }

        .btn-group .btn-primary:hover {
            background: #5856eb;
        }

        .btn-group .btn-secondary {
            background: white;
            color: #6b7280;
            border: 1px solid #d1d5db;
        }

        .btn-group {
            display: flex;
            gap: 1rem;
            justify-content: space-between;
            margin-top: 2rem;
        }

        .payment-methods {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .payment-method {
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 1.5rem;
            cursor: pointer;
            transition: all 0.2s;
            text-align: center;
        }

        .payment-method:hover {
            border-color: #6366f1;
        }

        .payment-method.selected {
            border-color: #6366f1;
            background: #f0f4ff;
        }

        .payment-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .security-info {
            background: #f0f9ff;
            border: 1px solid #0ea5e9;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .order-success {
            text-align: center;
            padding: 3rem;
        }

        .success-icon {
            font-size: 4rem;
            color: #10b981;
            margin-bottom: 1rem;
        }

        .success-title {
            font-size: 2rem;
            color: #1f2937;
            margin-bottom: 1rem;
        }

        .success-message {
            color: #6b7280;
            margin-bottom: 2rem;
        }

        .order-details {
            background: #f9fafb;
            border-radius: 8px;
            padding: 1.5rem;
            margin: 2rem 0;
            text-align: left;
        }

        .address-tabs {
            display: flex;
            margin-bottom: 2rem;
            background: #f3f4f6;
            border-radius: 8px;
            padding: 4px;
        }

        .address-tab {
            flex: 1;
            padding: 0.75rem 1rem;
            border: none;
            background: transparent;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
            font-weight: 500;
            color: #6b7280;
        }

        .address-tab.active {
            background: white;
            color: #1f2937;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .address-section {
            display: none;
        }

        .address-section.active {
            display: block;
        }

        .saved-addresses {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .saved-address {
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 1.5rem;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            gap: 1rem;
            align-items: flex-start;
        }

        .saved-address:hover {
            border-color: #6366f1;
        }

        .saved-address.selected {
            border-color: #6366f1;
            background: #f0f4ff;
        }

        .address-radio {
            margin-top: 0.25rem;
        }

        .address-radio input[type="radio"] {
            width: 18px;
            height: 18px;
            accent-color: #6366f1;
        }

        .address-details {
            flex: 1;
        }

        .address-label {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }

        .address-name {
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .address-text {
            color: #6b7280;
            line-height: 1.5;
            margin-bottom: 0.5rem;
        }

        .address-contact {
            font-size: 0.9rem;
            color: #9ca3af;
        }

        .address-actions {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .edit-address-btn,
        .delete-address-btn {
            padding: 0.5rem 0.75rem;
            border: 1px solid #d1d5db;
            background: white;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.85rem;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .edit-address-btn:hover {
            background: #f3f4f6;
            border-color: #6366f1;
            color: #6366f1;
        }

        .delete-address-btn:hover {
            background: #fef2f2;
            border-color: #ef4444;
            color: #ef4444;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            font-weight: 500;
            color: #374151;
        }

        .checkbox-label input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #6366f1;
        }

        .address-label-container {
            display: flex;
            gap: 0.5rem;
        }

        .address-label-btn {
            padding: 0.5rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            color: #6b7280;
            transition: all 0.2s;
        }

        .address-label-btn:hover {
            background: #f3f4f6;
            border-color: #6366f1;
            color: #6366f1;
        }

        .address-label-btn.active {
            background: #f3f4f6;
            border-color: #6366f1;
            color: #6366f1;
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .progress-bar {
                flex-direction: column;
                align-items: center;
                gap: 1rem;
            }

            .cart-item {
                flex-direction: column;
                text-align: center;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .btn-group {
                flex-direction: column;
            }

            .payment-methods {
                grid-template-columns: 1fr;
            }

            .address-tabs {
                flex-direction: column;
                gap: 4px;
            }

            .saved-address {
                flex-direction: column;
                text-align: center;
            }

            .address-actions {
                flex-direction: row;
                justify-content: center;
                margin-top: 1rem;
            }
        }
    </style>
    <div class="container">
        <!-- Progress Bar -->
        <div class="progress-navbar">
            <div class="progress-step active" id="step1">
                <span>🛒</span>
                <span>Cart</span>
            </div>
            <div class="progress-step" id="step2">
                <span>📍</span>
                <span>Address</span>
            </div>
            <div class="progress-step" id="step3">
                <span>💳</span>
                <span>Payment</span>
            </div>
            <div class="progress-step" id="step4">
                <span>✅</span>
                <span>Complete</span>
            </div>
        </div>

        <!-- Page 1: Cart -->
        @include('website.checkout.partials.cart_page')

        <!-- Page 2: Address -->
        @include('website.checkout.partials.address_page')

        <!-- Page 3: Payment -->
        @include('website.checkout.partials.payment_page')

        <!-- Page 4: Order Complete -->
        @include('website.checkout.partials.checkout_page')
    </div>
@endsection
@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            let currentStep = 1;
            let cart = @json($cart);

            const scrollTop = () => window.scrollTo(0, 0);

            const switchStep = (next) => {
                const prevStep = currentStep;
                currentStep += next;
                if (currentStep < 1 || currentStep > 4) {
                    currentStep = prevStep;
                    return;
                }
                document.getElementById(`page${prevStep}`).classList.remove('active');
                document.getElementById(`step${prevStep}`).classList.remove('active');
                if (next > 0) document.getElementById(`step${prevStep}`).classList.add('completed');
                else document.getElementById(`step${prevStep}`).classList.remove('completed');
                document.getElementById(`page${currentStep}`).classList.add('active');
                document.getElementById(`step${currentStep}`).classList.add('active');
                scrollTop();
            };

            window.nextStep = () => switchStep(1);
            window.previousStep = () => switchStep(-1);

            window.updateQuantity = (id, change) => {
                const input = document.getElementById(`qty${id}`);
                let newQty = parseInt(input.value);

                if (change !== 0) {
                    newQty += change;
                }

                if (newQty < 1) {
                    newQty = 1;
                }

                input.value = newQty;

                // 🔄 Update local cart quantity
                const cartItem = cart.find(item => item.product_id === id);
                if (cartItem) {
                    cartItem.quantity = newQty;
                }

                // 🔁 Recalculate immediately
                updateCartSummary();

                // 📨 Update backend
                fetch('{{ route('cart.update-quantity') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        product_id: id,
                        quantity: newQty
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        alert('Failed to update quantity.');
                    } else {
                        if (data.cart_count !== undefined) {
                            document.getElementById('cart-count').textContent = data.cart_count;
                        }
                    }
                });
            };

            window.removeItem = (id) => {
                // Remove item from the frontend cart array
                cart = cart.filter(i => i.id !== id);

                // Remove the DOM element for the cart item
                document.querySelector(`.cart-item[data-id="${id}"]`)?.remove();

                // Update summary values (subtotal, total, etc.)
                updateCartSummary();

                // If cart is now empty, update the cart summary HTML
                if (cart.length === 0) {
                    document.querySelector('.cart-summary').innerHTML = `
                        <div class="summary-row m-0 justify-content-center">
                            <span>No items in cart.</span>
                        </div>
                    `;
                    document.querySelector('.btn-group .btn-primary').disabled = true;
                }

                // Send request to backend to remove item from database
                fetch('{{ route('cart.remove-item') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ id: id })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification(data.message);
                        // Update navbar cart count
                        if (data.cart_count !== undefined) {
                            document.getElementById('cart-count').textContent = data.cart_count;
                        }
                    } else {
                        showNotification(data.message);
                    }
                });
            };

            const updateCartSummary = () => {
                let subtotal = 0, discount = 0, total = 0;
                cart.forEach(({ price, quantity, promotions }) => {
                    subtotal += price * quantity;
                    promotions.forEach(({ percent, amount, discount_type }) => {
                        if (discount_type === 'percent') {
                            discount += (price * (percent / 100)) * quantity;
                        } else {
                            discount += amount * quantity;
                        }
                    });
                });
                total = subtotal - discount;
                document.getElementById('subtotal').textContent = `$${subtotal.toFixed(2)}`;
                document.getElementById('discount').textContent = `- $${discount.toFixed(2)}`;
                document.getElementById('total').textContent = `$ ${total.toFixed(2)}`;
            };

            window.selectPayment = (method) => {
                document.querySelectorAll('.payment-method').forEach(el => el.classList.remove('selected'));
                method.closest('.payment-method')?.classList.add('selected');
            };

            window.goHome = () => window.location.href = "{{ route('shop') }}";
            window.downloadBooks = () => alert('Download links have been sent to your email!');

            document.addEventListener('input', (e) => {
                const target = e.target;
                if (target.placeholder === '1234 5678 9012 3456') {
                    target.value = target.value.replace(/\D/g, '').replace(/(.{4})/g, '$1 ').trim().slice(0, 19);
                }
                if (target.placeholder === 'MM/YY') {
                    let value = target.value.replace(/\D/g, '').slice(0, 4);
                    if (value.length > 2) value = value.slice(0, 2) + '/' + value.slice(2);
                    target.value = value;
                }
            });

            window.showNotification = (message) => {
                const notification = document.createElement('div');
                notification.style.position = 'fixed';
                notification.style.top = '80px';
                notification.style.right = '20px';
                notification.style.backgroundColor = '#ef4444';
                notification.style.color = 'white';
                notification.style.padding = '15px 20px';
                notification.style.borderRadius = '5px';
                notification.style.boxShadow = '0 5px 15px rgba(0,0,0,0.1)';
                notification.style.zIndex = '1001';
                notification.style.transform = 'translateX(120%)';
                notification.style.transition = 'transform 0.3s ease';
                notification.innerHTML = '<i class="fas fa-exclamation-triangle"></i> ' + message;

                document.body.appendChild(notification);

                // Show notification
                setTimeout(() => {
                    notification.style.transform = 'translateX(0)';
                }, 100);

                // Hide and remove notification
                setTimeout(() => {
                    notification.style.transform = 'translateX(120%)';
                    setTimeout(() => {
                        document.body.removeChild(notification);
                    }, 300);
                }, 3000);
            }

            updateCartSummary();
        });
    </script>

    <!-- Address Selection Tabs -->
    <script>
        function switchAddressTab(tab) {
            const existingTab = document.getElementById('existing-address-tab');
            const newTab = document.getElementById('add-new-address-tab');
            const existingSection = document.getElementById('existing-address-section');
            const newSection = document.getElementById('new-address-section');

            if (tab === 'existing') {
                existingTab.classList.add('active');
                newTab.classList.remove('active');
                existingSection.classList.add('active');
                newSection.classList.remove('active');
            } else if (tab === 'new') {
                existingTab.classList.remove('active');
                newTab.classList.add('active');
                existingSection.classList.remove('active');
                newSection.classList.add('active');
            }
        }
    </script>

    <!-- Address Selection -->
    <script>
        // Function to handle address selection
        function selectAddress(id) {
            // Remove 'selected' class from all saved-address elements
            document.querySelectorAll('.saved-address').forEach(function(address) {
                address.classList.remove('selected');
                address.querySelector('input[type="radio"]').checked = false;
            });

            // Add 'selected' class to the selected address
            const selectedAddress = document.querySelector('.saved-address input[value="' + id + '"]').closest('.saved-address');
            selectedAddress.classList.add('selected');
            selectedAddress.querySelector('input[type="radio"]').checked = true;
        }

        // Optional: Add this to initialize selection based on checked radio when page loads
        window.addEventListener('DOMContentLoaded', function() {
            const checkedInput = document.querySelector('.saved-address input[type="radio"]:checked');
            if (checkedInput) {
                checkedInput.closest('.saved-address').classList.add('selected');
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addressLabelButtons = document.querySelectorAll('.address-label-btn');
            addressLabelButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove 'active' class from all buttons
                    addressLabelButtons.forEach(btn => btn.classList.remove('active'));
                    // Add 'active' class to the clicked button
                    button.classList.add('active');
                });
            });
        });
    </script>
@endpush

<div>
    <div class="checkout-page">
        <div>
            {{-- STEPS --}}
            <div class="checkout-steps">
                <div class="checkout-step {{ $step >= 1 ? ($step > 1 ? 'done' : 'active') : '' }}">
                    <div class="step-num">{{ $step > 1 ? '✓' : '1' }}</div> Delivery Info
                </div>
                <div class="checkout-step {{ $step >= 2 ? ($step > 2 ? 'done' : 'active') : '' }}">
                    <div class="step-num">{{ $step > 2 ? '✓' : '2' }}</div> Payment
                </div>
                <div class="checkout-step {{ $step === 3 ? 'active' : '' }}">
                    <div class="step-num">3</div> Review
                </div>
            </div>

            {{-- STEP 1: DELIVERY --}}
            @if($step === 1)
            <div class="checkout-card">
                <h3><i class="fas fa-map-marker-alt" style="color:var(--orange);margin-right:8px"></i>Delivery Address</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" wire:model="firstName" placeholder="John">
                        @error('firstName')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" wire:model="lastName" placeholder="Doe">
                        @error('lastName')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="tel" wire:model="phone" placeholder="+234 800 000 0000">
                    @error('phone')<span class="field-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label>Street Address</label>
                    <input type="text" wire:model="address" placeholder="12 Wuse Zone 4, Abuja">
                    @error('address')<span class="field-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>City</label>
                        <input type="text" wire:model="city" placeholder="Abuja">
                        @error('city')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>State</label>
                        <select wire:model="state">
                            @foreach($nigerianStates as $s)
                                <option value="{{ $s }}">{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>Delivery Notes (optional)</label>
                    <textarea wire:model="notes" placeholder="e.g. Leave at gate, call when nearby" rows="2"></textarea>
                </div>
            </div>
            <button class="btn-primary" style="width:auto;padding:14px 36px" wire:click="goToStep2">
                Continue to Payment <i class="fas fa-arrow-right"></i>
            </button>
            @endif

            {{-- STEP 2: PAYMENT --}}
            @if($step === 2)
            <div class="checkout-card">
                <h3><i class="fas fa-credit-card" style="color:var(--orange);margin-right:8px"></i>Payment Method</h3>

                <div class="payment-method {{ $paymentMethod === 'pod' ? 'active' : '' }}"
                     wire:click="$set('paymentMethod','pod')">
                    <input type="radio" @checked($paymentMethod==='pod')>
                    <div class="payment-method-info">
                        <h4>Pay on Delivery</h4>
                        <p>Cash when your order arrives</p>
                    </div>
                    <i class="fas fa-money-bill-wave"></i>
                </div>       

                <div class="payment-method {{ $paymentMethod === 'transfer' ? 'active' : '' }}"
                     wire:click="$set('paymentMethod','transfer')">
                    <input type="radio" @checked($paymentMethod==='transfer')>
                    <div class="payment-method-info">
                        <h4>Bank Transfer</h4>
                        <p>Pay via online banking</p>
                    </div>
                    <i class="fas fa-university"></i>
                </div>

                @if($paymentMethod === 'transfer')
                <div style="background:var(--bg);border-radius:10px;padding:16px;margin-top:8px">
                    <p style="font-size:13px;color:var(--gray);margin-bottom:8px">Transfer to this account:</p>
                    <p style="font-weight:700">Moniepoint MFB</p>
                    <p style="font-weight:700">Eleghesons Fashion - Design</p>
                    <p style="font-size:24px;font-family:'Syne',sans-serif;font-weight:800;color:var(--orange)">5045517990</p>
                    <p style="font-size:13px;color:var(--gray)">Sort Code: 058 · Amount: ₦{{ number_format($this->total(), 2) }}</p>
                </div>
                @endif
            </div>
            <div style="display:flex;gap:12px">
                <button class="btn-secondary" wire:click="goBack"><i class="fas fa-arrow-left"></i> Back</button>
                <button class="btn-primary" style="width:auto;padding:14px 36px" wire:click="goToStep3">
                    Review Order <i class="fas fa-arrow-right"></i>
                </button>
            </div>
            @endif

            {{-- STEP 3: REVIEW --}}
            @if($step === 3)
            <div class="checkout-card">
                <h3><i class="fas fa-clipboard-check" style="color:var(--orange);margin-right:8px"></i>Order Review</h3>

                <div style="background:var(--bg);border-radius:10px;padding:16px;margin-bottom:14px">
                    <h4 style="font-size:12px;font-weight:700;color:var(--gray);margin-bottom:8px;text-transform:uppercase;letter-spacing:.5px">Delivery Address</h4>
                    <p style="font-weight:600">{{ $firstName }} {{ $lastName }}</p>
                    <p style="font-size:13.5px;color:var(--gray)">{{ $address }}, {{ $city }}, {{ $state }}</p>
                    <p style="font-size:13.5px;color:var(--gray)">{{ $phone }}</p>
                </div>

                <div style="background:var(--bg);border-radius:10px;padding:16px;margin-bottom:14px">
                    <h4 style="font-size:12px;font-weight:700;color:var(--gray);margin-bottom:4px;text-transform:uppercase;letter-spacing:.5px">Payment Method</h4>
                    {{-- <p style="font-weight:600">
                        @match($paymentMethod)
                            'pod' => 'Pay on Delivery',
                            'card' => 'Debit / Credit Card',
                            'transfer' => 'Bank Transfer',
                            default => ucfirst($paymentMethod)
                        @endmatch
                    </p> --}}

                    <p style="font-weight:600">
                        @if($paymentMethod === 'pod')
                            Pay on Delivery
                        @elseif($paymentMethod === 'card')
                            Debit / Credit Card
                        @elseif($paymentMethod === 'transfer')
                            Bank Transfer
                        @else
                            {{ ucfirst($paymentMethod) }}
                        @endif
                    </p>
                </div>

                @foreach($cart as $item)
                <div class="receipt-item">
                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" style="width:52px;height:52px;object-fit:cover;border-radius:8px">
                    <div class="receipt-item-info">
                        <h4>{{ $item['name'] }}</h4>
                        <p>@if($item['size'])Size: {{ $item['size'] }} · @endif Qty: {{ $item['qty'] }}</p>
                    </div>
                    <div class="receipt-item-price">₦{{ number_format($item['price'] * $item['qty'], 2) }}</div>
                </div>
                @endforeach

                <div class="receipt-totals" style="margin-top:12px">
                    <div class="summary-row"><span>Subtotal</span><span>₦{{ number_format($this->subtotal(), 2) }}</span></div>
                    <div class="summary-row"><span>Delivery</span><span>{{ $this->deliveryFee() == 0 ? 'FREE' : '₦'.number_format($this->deliveryFee(), 2) }}</span></div>
                    @if($discount > 0)
                    <div class="summary-row"><span>Discount</span><span style="color:var(--green)">-₦{{ number_format($discount, 2) }}</span></div>
                    @endif
                    <div class="summary-row total"><span>Total</span><span>₦{{ number_format($this->total(), 2) }}</span></div>
                </div>
            </div>

            <div style="display:flex;gap:12px">
                <button class="btn-secondary" wire:click="goBack"><i class="fas fa-arrow-left"></i> Back</button>
                <button class="btn-primary" style="flex:1" wire:click="placeOrder" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="placeOrder"><i class="fas fa-check-circle"></i> Place Order</span>
                    <span wire:loading wire:target="placeOrder"><i class="fas fa-spinner fa-spin"></i> Placing Order…</span>
                </button>
            </div>
            @endif
        </div>

        {{-- ORDER SUMMARY SIDEBAR --}}
        <div>
            <div class="cart-summary" style="position:sticky;top:80px">
                <h3>Order Summary</h3>
                <div style="margin-bottom:16px;border-bottom:1px solid var(--border);padding-bottom:16px">
                    @foreach($cart as $item)
                        <div style="display:flex;justify-content:space-between;font-size:13px;margin-bottom:8px">
                            <span>{{ $item['name'] }} ×{{ $item['qty'] }}</span>
                            <strong>₦{{ number_format($item['price'] * $item['qty'], 2) }}</strong>
                        </div>
                    @endforeach
                </div>
                <div class="summary-row"><span>Subtotal</span><span>₦{{ number_format($this->subtotal(), 2) }}</span></div>
                <div class="summary-row"><span>Delivery</span><span>{{ $this->deliveryFee() == 0 ? 'FREE' : '₦'.number_format($this->deliveryFee(), 2) }}</span></div>
                @if($discount > 0)
                <div class="summary-row"><span>Discount</span><span style="color:var(--green)">-₦{{ number_format($discount, 2) }}</span></div>
                @endif
                <div class="summary-row total"><span>Total</span><span>₦{{ number_format($this->total(), 2) }}</span></div>
                <div style="margin-top:14px;background:var(--bg);border-radius:8px;padding:12px;font-size:13px;color:var(--gray)">
                    <i class="fas fa-shield-alt" style="color:var(--green);margin-right:6px"></i>
                    100% secure & encrypted checkout
                </div>
            </div>
        </div>
    </div>
</div>

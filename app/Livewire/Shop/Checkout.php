<?php

namespace App\Livewire\Shop;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Checkout extends Component
{
    public int $step = 1;

    // Delivery
    public string $firstName = '';
    public string $lastName  = '';
    public string $phone     = '';
    public string $address   = '';
    public string $city      = '';
    public string $state     = 'Abuja FCT';
    public string $notes     = '';

    // Payment
    public string $paymentMethod = 'pod';

    public array $cart = [];
    public float $discount = 0;
    public ?string $couponCode = null;

    public array $nigerianStates = [
        'Abuja FCT','Abia','Adamawa','Akwa Ibom','Anambra','Bauchi',
        'Bayelsa','Benue','Borno','Cross River','Delta','Ebonyi',
        'Edo','Ekiti','Enugu','Gombe','Imo','Jigawa','Kaduna','Kano',
        'Katsina','Kebbi','Kogi','Kwara','Lagos','Nasarawa','Niger',
        'Ogun','Ondo','Osun','Oyo','Plateau','Rivers','Sokoto',
        'Taraba','Yobe','Zamfara',
    ];

    protected function rules(): array
    {
        return [
            'firstName'     => 'required|string|max:100',
            'lastName'      => 'required|string|max:100',
            'phone'         => 'required|string|max:20',
            'address'       => 'required|string|max:255',
            'city'          => 'required|string|max:100',
            'state'         => 'required|string',
            'paymentMethod' => 'required|in:pod,transfer',
        ];
    }

    public function mount()
    {
        $this->cart       = session('cart', []);
        $this->discount   = session('discount', 0);
        $this->couponCode = session('coupon_code');

        // Pre-fill from default address
        $user = auth()->user();
        if ($address = $user->defaultAddress()) {
            $this->firstName = $address->first_name;
            $this->lastName  = $address->last_name;
            $this->phone     = $address->phone;
            $this->address   = $address->address_line;
            $this->city      = $address->city;
            $this->state     = $address->state;
        } else {
            $this->firstName = explode(' ', $user->name)[0] ?? '';
            $this->lastName  = explode(' ', $user->name)[1] ?? '';
            $this->phone     = $user->phone ?? '';
        }
    }

    public function goToStep2()
    {
        $this->validateOnly('firstName');
        $this->validateOnly('lastName');
        $this->validateOnly('phone');
        $this->validateOnly('address');
        $this->validateOnly('city');
        $this->validateOnly('state');
        $this->step = 2;
    }

    public function goToStep3()
    {
        $this->validateOnly('paymentMethod');
        $this->step = 3;
    }

    public function goBack()
    {
        $this->step = max(1, $this->step - 1);
    }

    public function placeOrder()
    {
        $this->validate();

        if (empty($this->cart)) {
            session()->flash('error', 'Your cart is empty.');
            return redirect()->route('cart');
        }

        DB::transaction(function () {
            $subtotal    = $this->subtotal();
            $deliveryFee = $this->deliveryFee();
            $total       = max(0, $subtotal + $deliveryFee - $this->discount);

            $order = Order::create([
                'user_id'          => auth()->id(),
                'order_number'     => Order::generateOrderNumber(),
                'status'           => 'processing',
                'payment_method'   => $this->paymentMethod,
                'payment_status'   => $this->paymentMethod === 'pod' ? 'unpaid' : 'unpaid',
                'subtotal'         => $subtotal,
                'delivery_fee'     => $deliveryFee,
                'discount'         => $this->discount,
                'total'            => $total,
                'coupon_code'      => $this->couponCode,
                'shipping_name'    => $this->firstName . ' ' . $this->lastName,
                'shipping_phone'   => $this->phone,
                'shipping_address' => $this->address,
                'shipping_city'    => $this->city,
                'shipping_state'   => $this->state,
                'shipping_notes'   => $this->notes,
            ]);

            foreach ($this->cart as $item) {
                OrderItem::create([
                    'order_id'      => $order->id,
                    'product_id'    => $item['id'],
                    'product_name'  => $item['name'],
                    'product_image' => $item['image'],
                    'size'          => $item['size'],
                    'color'         => $item['color'],
                    'quantity'      => $item['qty'],
                    'price'         => $item['price'],
                    'subtotal'      => $item['price'] * $item['qty'],
                ]);

                // Decrement stock
                Product::where('id', $item['id'])->decrement('stock', $item['qty']);
            }

            // Clear cart and coupon from session
            session()->forget(['cart', 'discount', 'coupon_code']);

            session(['last_order_id' => $order->id]);
        });

        return redirect()->route('order.receipt', session('last_order_id'));
    }

    public function subtotal(): float
    {
        return array_reduce($this->cart, fn($carry, $item) => $carry + ($item['price'] * $item['qty']), 0);
    }

    public function deliveryFee(): float
    {
        return $this->subtotal() >= 25000 ? 0 : 1500;
    }

    public function total(): float
    {
        return max(0, $this->subtotal() + $this->deliveryFee() - $this->discount);
    }

    public function render()
    {
        return view('livewire.shop.checkout');
    }
}

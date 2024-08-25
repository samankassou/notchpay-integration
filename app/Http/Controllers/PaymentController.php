<?php

namespace App\Http\Controllers;

use NotchPay\Payment;
use NotchPay\NotchPay;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use NotchPay\Exceptions\ApiException;

class PaymentController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Product $product): RedirectResponse
    {
        NotchPay::setApiKey(config('services.notchpay.public_key'));

        try {
            $payload = Payment::initialize([
                'amount' => $product->price,
                'email' => Auth::user()->email,
                'name' => Auth::user()->name,
                'currency' => 'XAF',
                'reference' => Auth::id() . '-' . uniqid(),
                'callback' => route('notchpay-callback'),
                'description' => $product->description,
            ]);

            return redirect($payload->authorization_url);
        } catch (ApiException $e) {
            session()->flash('error', __('Impossible de procéder au paiement, veuillez recommencer plus tard. Merci'));

            return back();
        }
    }
}

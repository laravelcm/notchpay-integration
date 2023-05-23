<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use NotchPay\NotchPay;

class PaymentController extends Controller
{
    public function __invoke(Product $product): RedirectResponse
    {
        $notchPay = new NotchPay('sb.LudOJsz7kuivrDHaW86KCiKPYCXGc8HL');

        try {
            $payload = $notchPay->payment->initialize([
                'amount' => $product->price,
                'email' => Auth::user()->email,
                'name' => Auth::user()->name,
                'currency' => 'XAF',
                'reference' => Auth::id() . '-' . uniqid(),
                'callback' => route('notchpay-callback'),
                'description' => $product->description,
            ]);

            return redirect($payload->authorization_url);
        } catch (NotchPay\Exception\ApiException $e) {
            session()->flash('error', __('Impossible de procéder au paiement, veuillez recommencer plus tard. Merci'));

            return back();
        }
    }
}

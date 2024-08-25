<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use NotchPay\NotchPay;
use NotchPay\Payment;

class NotchPayCallBackController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // @ToDO Mis a jour de la commande dans votre base de données
        NotchPay::setApiKey(config('services.notchpay.public_key'));
        $verifyTransaction = Payment::verify($request->get('reference'));

        if ($verifyTransaction->transaction->status === 'canceled') {
            session()->flash('error', __('Votre achat a été annulé veuillez relancer si vous souhaitez payer votre produit, Merci.'));
        } else {
            // @ToDO Envoie de mail de remerciement pour l'achat' de l'utilisateur qui est dans la base de données

            session()->flash('status', __('Votre achat a été effectué avec succès, Merci pour votre confiance.'));
        }


        return redirect(route('dashboard'));
    }
}

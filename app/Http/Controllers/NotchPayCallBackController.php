<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NotchPayCallBackController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        // @ToDO Mis a jour de la commande dans votre base de données

        if ($request->get('status') === 'canceled') {
            session()->flash('error', __('Votre achat a été annulé veuillez relancer si vous souhaitez payer votre produit, Merci.'));
        } else {
            // @ToDO Envoie de mail de remerciement pour l'achat' l'utilisateur est dans la base de données

            session()->flash('status', __('Votre achat a été effectué avec succès, Merci pour votre confiance.'));
        }


        return redirect(route('dashboard'));
    }
}

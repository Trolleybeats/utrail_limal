<?php

namespace App\Http\Controllers;

use App\Mail\PaiementReussi;
use App\Models\Membre;
use App\Models\Versement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $secret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent(
                $request->getContent(),
                $request->header('Stripe-Signature'),
                $secret
            );
        } catch (SignatureVerificationException $e) {
            Log::warning('Stripe webhook: invalid signature', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Invalid signature'], 400);
        } catch (\UnexpectedValueException $e) {
            Log::warning('Stripe webhook: invalid payload', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Invalid payload'], 400);
        }

        $paymentIntentId = $event->data->object->id ?? null;

        if (!$paymentIntentId) {
            return response()->json(['error' => 'Missing payment intent id'], 400);
        }

        match ($event->type) {
            'payment_intent.succeeded'       => $this->handleSucceeded($paymentIntentId),
            'payment_intent.payment_failed'  => $this->handleFailed($paymentIntentId),
            default                          => null,
        };

        return response()->json(['status' => 'ok']);
    }

    private function handleSucceeded(string $paymentIntentId): void
    {
        // Mode échelonné : le PI appartient à un versement
        $versement = Versement::where('stripe_payment_intent_id', $paymentIntentId)->first();

        if ($versement) {
            if ($versement->statut !== 'succeeded') {
                $versement->update(['statut' => 'succeeded']);
            }

            $membre = $versement->membre;

            $allPaid = $membre->versements()->where('statut', '!=', 'succeeded')->doesntExist();
            if ($allPaid && $membre->payment_status !== 'succeeded') {
                $membre->update(['payment_status' => 'succeeded']);
                Mail::to($membre->participant->email)->send(new PaiementReussi($membre));
            }

            return;
        }

        // Mode immédiat : le PI appartient directement au membre
        $membre = Membre::where('stripe_payment_intent_id', $paymentIntentId)->first();

        if ($membre && $membre->payment_status !== 'succeeded') {
            $membre->update(['payment_status' => 'succeeded']);
            Mail::to($membre->participant->email)->send(new PaiementReussi($membre));
        }
    }

    private function handleFailed(string $paymentIntentId): void
    {
        // Mode échelonné
        $versement = Versement::where('stripe_payment_intent_id', $paymentIntentId)->first();

        if ($versement) {
            $versement->update(['statut' => 'failed']);
            return;
        }

        // Mode immédiat
        $membre = Membre::where('stripe_payment_intent_id', $paymentIntentId)->first();

        if ($membre && $membre->payment_status !== 'succeeded') {
            $membre->update(['payment_status' => 'failed']);
        }
    }
}

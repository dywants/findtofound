<?php

namespace App\Services;

use AmrShawky\LaravelCurrency\Facade\Currency;
use App\Models\Payment;
use App\Models\Thefound;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;
use PayPalCheckoutSdk\Payments\AuthorizationsCaptureRequest;
use PayPalCheckoutSdk\Payments\AuthorizationsGetRequest;
use Psr\Http\Message\ServerRequestInterface;

class PaypalPayment
{
    public function __construct(readonly private string $clientId, readonly private string $clientSecret, readonly private bool $sandbox)
    {}

    public function ui(Thefound $cart): string
    {
        $clientId = env('PAYPAL_CLIENT_ID');
        $total = $cart->amount / 659;
        $currency = env('PAYPAL_CURRENCY', 'EUR');

        return <<<HTML
    <script src="https://www.paypal.com/sdk/js?client-id={$clientId}&currency={$currency}&intent=authorize"></script>
    <div id="paypal-button-container"></div>
    <script>
      paypal.Buttons({
        // Sets up the transaction when a payment button is clicked
        createOrder: (data, actions) => {
          return actions.order.create({
            intent: 'AUTHORIZE',
            purchase_units: [{
              amount: {
                currency_code: '{$currency}',
                value: '{$total}' // Can also reference a variable or function
              }
            }]
          })
        },
        // Finalize the transaction after payer approval
        onApprove: (data, actions) => {
          return actions.order.authorize().then(function(orderData) {
            // Successful authorization! For dev/demo purposes:
            console.log('Authorization result', orderData, JSON.stringify(orderData, null, 2));
            const transaction = orderData.purchase_units[0].payments.authorizations[0];
            alert(`Transaction \${transaction.status}: \${transaction.id}\n\nSee console for all available details`);
            // When ready to go live, remove the alert and show a success message within this page. For example:
            // const element = document.getElementById('paypal-button-container');
            // element.innerHTML = '<h3>Thank you for your payment!</h3>';
          })
        }
      }).render('#paypal-button-container')
    </script>
HTML;

    }

    /**
     * @throws \PayPalHttp\HttpException
     * @throws \PayPalHttp\IOException
     * @throws PaymentAmountMissmatchException
     */
    public function handle(ServerRequestInterface $request, $cart)
    {
        if ($this->sandbox){
            $environment = new SandboxEnvironment($this->clientId, $this->clientSecret);
        }else{
            $environment = new ProductionEnvironment($this->clientId, $this->clientSecret);
        }

        $client = new PaypalHttpClient($environment);

        $authorizationId = $request->getParsedBody()['authorizationId']; // capture de l'authorisation
//        $authorizationId = $request->getQueryParams()['authorizationId']; // capture de l'authorisation
        $sourcePayment = $request->getParsedBody()['sourcePayment'];

        $request = new AuthorizationsGetRequest($authorizationId);

        $authorizationResponse = $client->execute($request);

        $amount_paypal = $authorizationResponse->result->amount->value;

        // On peut récupérer l'Order créé par le bouton
        $orderId = $authorizationResponse->result->supplementary_data->related_ids->order_id;
        $request = new OrdersGetRequest($orderId);
        $orderResponse = $client->execute($request);

        // Capturer le paiement
        $request = new AuthorizationsCaptureRequest($authorizationId);
        $response = $client->execute($request);

        // Sauvegarder les informations de l'utilisateur
        if ($response->result->status !== 'COMPLETED') {
            throw new \Exception();
        }

        Payment::create([
            'orderId' => $orderId,
            'user_payer_id' => $cart->user_id,
            'thefind_id' => $cart->thefind_id,
            'amount' => $amount_paypal,
            'currency' => $orderResponse->result->purchase_units[0]->amount->currency_code,
            'payment_status' => $response->result->status,
            'type_piece' => $orderResponse->result->purchase_units[0]->items[0]->description,
            'paymentSource' => $sourcePayment
        ]);
    }
}

<?php

namespace App\Services;

use AmrShawky\LaravelCurrency\Facade\Currency;
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
        $currency = env('PAYPAL_CURRENCY');

        return <<<HTML
    <script src="https://www.paypal.com/sdk/js?client-id={$clientId}&currency={$currency}"></script>
    <div id="paypal-button-container"></div>
    <script>
      paypal.Buttons({
        // Sets up the transaction when a payment button is clicked
        createOrder: (data, actions) => {
          return actions.order.create({
            purchase_units: [{
              amount: {
                value: {$total} // Can also reference a variable or function
              }
            }]
          })
        },
        // Finalize the transaction after payer approval
        onApprove: (data, actions) => {
          return actions.order.capture().then(function(orderData) {
            // Successful capture! For dev/demo purposes:
            console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
            const transaction = orderData.purchase_units[0].payments.captures[0];
            alert(`Transaction \${transaction.status}: \${transaction.id}\n\nSee console for all available details`);
            // When ready to go live, remove the alert and show a success message within this page. For example:
            // const element = document.getElementById('paypal-button-container');
            // element.innerHTML = '<h3>Thank you for your payment!</h3>';
            // Or go to another URL:  actions.redirect('thank_you.html');
          });
        }
      }).render('#paypal-button-container');
    </script>
HTML;

    }

    /**
     * @throws \PayPalHttp\HttpException
     * @throws \PayPalHttp\IOException
     * @throws PaymentAmountMissmatchException
     */
    public function handle(ServerRequestInterface $request, Thefound $cart): void
    {
        if ($this->sandbox){
            $environment = new SandboxEnvironment($this->clientId, $this->clientSecret);
        }else{
            $environment = new ProductionEnvironment($this->clientId, $this->clientSecret);
        }

        dd($request);

        $client = new PaypalHttpClient($environment);
        dd($client);
        $authorizationId = $request->getParsedBody()['authorizationId']; // capture de l'authorisation
//        $authorizationId = $request->getQueryParams()['authorizationId']; // capture de l'authorisation
        $request = new AuthorizationsGetRequest($authorizationId);
        $authorizationResponse = $client->execute($request);

        $amount_paypal = $authorizationResponse->result->amount->value;

        $amount = Currency::convert()
            ->from('EUR')
            ->to('XAF')
            ->amount($amount_paypal)
            ->round(2)
            ->get();

        if($amount !==  $cart->amount){
            throw new PaymentAmountMissmatchException($amount, $cart->amount);
        }

        // On peut récupérer l'Order créé par le bouton
        $orderId = $authorizationResponse->result->supplementary_data->related_ids->order_id;
        $request = new OrdersGetRequest($orderId);
        $orderResponse = $client->execute($request);

        // Capturer le paiement
        $request = new AuthorizationsCaptureRequest($authorizationId);
        $response = $client->execute($request);

        // Sauvegarder les informations de l'utilisateur

        if ($response->result->status() !== 'COMPLETED') {
            throw new \Exception();
        }
    }
}

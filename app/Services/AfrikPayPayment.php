<?php

namespace App\Services;
use App\Models\AfrikpayToken;
use App\Models\Payment;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\NoReturn;

class AfrikPayPayment
{
    /**
     * @param string $accountId
     * @param string $clientSecret
     * @param bool $sandbox
     */
    public function __construct(readonly private string $accountId, readonly private string $clientSecret, readonly private bool $sandbox)
    {}

    /**
     * @throws \Exception
     */
    public function handle(Request $request, $cart, $provider): \Illuminate\Http\RedirectResponse
    {
        if ($this->sandbox){
            $url = config('afrikpay.sandboxUrl');
        }else{
            $url = config('afrikpay.productionUrl');
        }

        $store = env('AFRIKPAY_STORE');

        $code = "";
        $purchaseref = "";
//        $amount = $cart->amount;
        $amount = 100;
        $phone = $cart->user->profile->phone_number;
        $queryToken = AfrikpayToken::latest('created_at')->first();

        $token = $queryToken->token_key;

        $hash = hash_hmac("sha256", $store . $provider .$phone . $amount . $purchaseref . $code , $this->clientSecret, false);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
              "provider": "'.$provider.'",
              "reference": "'.$phone.'",
              "amount": '.$amount.',
              "purchaseref": "",
              "store": "'.$store.'",
              "hash": "'.$hash.'",
              "code": "",
              "description": "Paiement provenant de findtofound pour la piece de type:'.$cart->thefind->piece->name.'",
              "notifurl": "",
              "accepturl": "",
              "cancelurl": "",
              "declineurl": ""
            }',
            CURLOPT_HTTPHEADER => array(
                "accountId: $this->accountId",
                "Authorization: Bearer $token",
                "Content-Type: application/json"
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $array = json_decode($response, true);

        $reponsePayment = collect($array);

        if ($reponsePayment['message'] === "success"){
            Payment::create([
                'order_id' => $reponsePayment['result']['paymentref'],
                'user_payer_id' => $cart->user_id,
                'thefind_id' => $cart->thefind_id,
                'amount' => $reponsePayment['result']['amount'],
                'currency' => "Fcfa",
                'payment_status' => "COMPLETED",
                'type_piece' => $cart->thefind->piece->name,
                'paymentSource' => "Afrikpay"
            ]);
        }else{
            throw new \Exception("Oouf, erreur de paiement veuillez recommencer plutard!");
        }
    }


    public function setToken(): void
    {
        $client = new Client();
        $headers = [
            'accountId' => '8qsxr77nat072xp64w2615bq3h0wme00',
            'Content-Type' => 'application/json'
        ];
        $body = '{
          "username": "dywants",
          "password": "Y7Pm6mV3"
        }';
        $request = new Request((array)'POST', (array)'https://api.afrikpay.com/account/generate/token', $headers, (array)$body);
        $res = $client->sendAsync($request)->wait();
        echo $res->getBody();

    }
}

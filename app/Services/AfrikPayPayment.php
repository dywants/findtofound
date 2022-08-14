<?php

namespace App\Services;
use App\Models\Payment;
use Illuminate\Http\Request;

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

        $reference = config('afrikpay.references');
        $store = env('AFRIKPAY_STORE');
        $code = "";
        $purchaseref = "";
        $amount = $cart->amount;
        $phone = $cart->user->profile->phone_number;

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
                'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2NTgyMjMzMDIsImV4cCI6MTY1ODIyNjkwMiwicm9sZXMiOiJST0xFX0RFViIsInVzZXJuYW1lIjoiSm9obiBuYW1lIn0.vyEDRp1ROktNvloWSL0iMuKhTnuhn_V3LlqQC4fJSx0Q1MtOUfayVNklzs9-ijeEJcLhVQoMdcEFj142nsRmAtcpUDGwyaDzdk5RN-hFZM0qx3nBPNGZzBxzDuL5WGVooSC-C2HS-28sjJQe3M3Bb5j3OuxOPegjg-R2g6EfSHBzgss2uQ0PqRQytUGgbYsyn7FOvxaCbXoWYP9IHwpX3zDNwdGXfGeLJMcgQbUBNrRGa7itkGl9G2YFmT3ISxzIHbGZ2t2vae_rQYsDHJ1pmJrTlxWndmYGr8lQxb9U1WVSJ4gCty0obyFD2JFZjVDQnbX3JTmsmPdnuk0poiqdVg',
                'Content-Type: application/json'
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
//        echo $response;
    }
}

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
        $store = config('afrikpay.store');
        $code = "";
        $purchaseref = "";
        $amount = $cart->amount;
        $phone = $cart->user->profile->phone_number;

        $hash = hash_hmac("sha256", "AFC9160" . $provider .$reference . $amount . $purchaseref . $code , $this->clientSecret, false);

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
              "reference": "'.$reference.'",
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
                'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2NTc5MDUzNzEsImV4cCI6MTY1NzkwODk3MSwicm9sZXMiOiJST0xFX0RFViIsInVzZXJuYW1lIjoiSm9obiBuYW1lIn0.iYlUeRKXxCgcNzodbRbVOiKdbcgG5zL7sjRsqE7S3OPtTXm0f0qJa-paGHcLmgkLMRt66MdWDkeOB-i9wMYIuiNqmPPyGCnzDq5cg7om21aF6s8xk7UbK5Q0JWETj60aoOeoeNx8rYCiD2V7gLjhWOXQIM1o9Z4OJoBaoQ7Whi5HVlZ3R2iJ6_lMifFUCi2x0nzfmYndtXEFAJ-eHpsDLwjtuWYUAftcD6cVrDFvNxso-FQAT8E1YSsyPuoSfPbLqKxvVcCSMLddnNxtkUoTLNzZmf5_tDhJTy6iF2RxgU3OprQcA56RSWdI2nYnSr3GaNfkJtEeMpJ_x5Kn28zDaA',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $array = json_decode($response, true);

        $reponsePayment = collect($array);

        if ($reponsePayment['message'] === "success"){
            Payment::create([
                'orderId' => $reponsePayment['result']['transactionid'],
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

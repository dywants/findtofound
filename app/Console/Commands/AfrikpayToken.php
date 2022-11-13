<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AfrikpayToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'afrikpay:token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Commande permettant de lancer la requête de generation du token';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $username = env('AFRIKPAY_USERNAME');
        $password = env('AFRIKPAY_PASSWORD');
        $accountId = env('AFRIKPAY_ACCOUNT_ID');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.afrikpay.com/account/generate/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
            "username" : "'.$username.'",
            "password" : "'.$password.'"
            }',
            CURLOPT_HTTPHEADER => array(
                "accountId: $accountId",
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $array = json_decode($response, true);

        if ($array['message'] === "success" && $array['code'] === 200){
            $token = \App\Models\AfrikpayToken::latest('created_at')->first();

            if (!isset($token)){
                \App\Models\AfrikpayToken::create([
                    'token_key' => $array['content']['token'],
                    'code' =>  $array['code']
                ]);
            }

            $token->update([
                'token_key' => $array['content']['token'],
            ]);

        }else{
            info("error de generation de token");
        }

        return 0;
    }
}

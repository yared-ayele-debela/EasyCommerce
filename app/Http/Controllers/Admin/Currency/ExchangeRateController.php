<?php

namespace App\Http\Controllers\Admin\Currency;

use App\Http\Controllers\Controller;
use App\Models\Currencies;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ExchangeRateController extends Controller
{
    private $apiKey = 'cur_live_E7AMr20GbBK4AiZrmUtpPhYhUzrVQldtBNA64Mwj';

    public function getExchangeRate()
    {
        $client = new Client();
        $response = $client->get("https://currencyapi.com/api/v3/latest?apikey={$this->apiKey}&base_currency=ETB");
        $data = json_decode($response->getBody(), true);

        // dd($data['data']);


        $currenciesToStore = Currencies::pluck('code')->toArray();
        foreach ($currenciesToStore as $currencyCode) {
            if (isset($data['data'][$currencyCode])) {
                $currencyValues[$currencyCode] = $data['data'][$currencyCode]['value'];
            }
        }

        // // Display the fetched currency values
        // dd($currencyValues);
        foreach ($currencyValues as $currencyCode => $value) {
            Currencies::updateOrCreate(
                ['code' => $currencyCode],
                ['exchange_rate' => $value]
            );
        }

        return response()->json(['success' => true, 'message' => 'Exchange rates updated successfully']);

    }
}

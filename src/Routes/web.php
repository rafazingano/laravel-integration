<?php

use GuzzleHttp\Client;
use Illuminate\Support\LazyCollection;

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['web', 'auth'])
    ->namespace('ConfrariaWeb\Integration\Controllers')
    ->group(function () {
        Route::resource('integrations', 'IntegrationController');

        Route::get('integrations/tests/jsongunter', function () {
            $url = 'https://www.meridienclube.com.br/sinc-bases/associados-list?token=intra2SGM&environment=production&function=retrieve';
            //dd($url);
            $r = LazyCollection::make(function () use ($url) {
                $limit = 100; //Quantidade de registros
                $offset = 0; //Inicia deste registro
                $client = new Client();
                $continua = true;
                while ($continua) {
                    $url_m = $url . '&limit=' . $offset . ',' . $limit;
                    print_r($url_m . '<hr>');
                    $response = $client->request('GET', $url_m);
                    $lines = collect(json_decode($response->getBody(), true));
                    //dd($getContents->count());
                    $offset = $offset + $limit;
                    $continua = ($lines->count() > 0);
                    //dd($continua);
                    foreach($lines as $line) {
                        yield $line;
                    }
                }
            })
                ->map(function ($line) {
                    return $line;
                })
                ->each(function ($lines) {
                    return $lines;
                });

            //dd($r->all());
        });

    });

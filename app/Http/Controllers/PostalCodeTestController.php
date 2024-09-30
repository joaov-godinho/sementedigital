<?php

namespace App\Http\Controllers;

use App\Services\PostalCode\PostalCodeService;
use Illuminate\Http\Request;

class PostalCodeTestController extends Controller
{
    protected PostalCodeService $postalCodeService;

    public function __construct(PostalCodeService $postalCodeService)
    {
        $this->postalCodeService = $postalCodeService;
    }

    public function test(Request $request)
    {
        $cep = $request->input('cep', '89560-000'); // CEP padrão para teste

        $city = $this->postalCodeService->getCityFromPostalCode($cep);

        if (empty($city)) {
            return response()->json(['error' => 'CEP inválido ou não encontrado.'], 404);
        }

        return response()->json(['cep' => $cep, 'city' => $city], 200);
    }
}

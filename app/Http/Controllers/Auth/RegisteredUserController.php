<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\PostalCode\PostalCodeService; // Adicione esta linha
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    protected PostalCodeService $postalCodeService;

    public function __construct(PostalCodeService $postalCodeService)
    {
        $this->postalCodeService = $postalCodeService;
    }

    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validação dos dados de entrada
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'postal_code' => ['required', 'string', 'max:10', 'regex:/^\d{5}-?\d{3}$/'], // Adicionada validação de formato
        ]);

        // Obter o CEP do request
        $postalCode = $request->postal_code;

        // Consultar a cidade correspondente ao CEP
        $cityName = $this->postalCodeService->getCityFromPostalCode($postalCode);

        // Verificar se a cidade foi encontrada
        if (empty($cityName)) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['postal_code' => 'CEP inválido ou não encontrado.']);
        }

        // Criar o usuário com os dados fornecidos e a cidade obtida
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'postal_code' => $postalCode,
            'city' => $cityName,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('/', absolute: false));
    }
}

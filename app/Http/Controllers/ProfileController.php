<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Services\PostalCode\PostalCodeService; // Certifique-se de importar o serviço

class ProfileController extends Controller
{
    protected $postalCodeService;

    public function __construct(PostalCodeService $postalCodeService)
    {
        $this->postalCodeService = $postalCodeService; // Injetar o serviço de consulta de CEP
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Obter o CEP do request
        $postalCode = $request->postal_code;

        // Consultar o nome da cidade usando o PostalCodeService
        $cityName = $this->postalCodeService->getCityFromPostalCode($postalCode);

        // Verificar se a cidade foi encontrada
        if (empty($cityName)) {
            return Redirect::back()
                ->withInput()
                ->withErrors(['postal_code' => 'CEP inválido ou não encontrado.']);
        }

        // Preencher os dados do usuário com os dados validados e a cidade obtida
        $user = $request->user();
        $user->fill($request->validated());
        $user->city = $cityName; // Atualizar o nome da cidade

        // Se o email foi alterado, desmarcar a verificação
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

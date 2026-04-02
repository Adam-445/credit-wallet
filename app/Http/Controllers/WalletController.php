<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class WalletController extends Controller
{
    public function index()
    {
        return response()->json(['solde' => auth()->user()->solde]);
    }

    public function spend(Request $request)
    {
        $request->validate(['montant' => 'required|integer|min:10']);

        $user = auth()->user();
        $montant = $request->montant;

        if ($user->solde < $montant) {
            throw ValidationException::withMessages([
                'montant' => ['Solde insuffisant'],
            ]);
        }

        $user->solde -= $montant;
        $user->save();

        return response()->json(['solde' => $user->solde]);
    }
}

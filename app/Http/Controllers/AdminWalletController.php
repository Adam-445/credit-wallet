<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class AdminWalletController extends Controller
{
    public function credit(User $user, Request $request)
    {
        $request->validate(['montant' => 'required|integer|min:1']);

        $user->solde += $request->montant;
        $user->save();

        return response()->json(['solde' => $user->solde]);
    }

    public function debit(User $user, Request $request)
    {
        $request->validate(['montant' => 'required|integer|min:1']);

        $montant = $request->montant;

        if ($user->solde < $montant) {
            throw ValidationException::withMessages(['montant' => ['Solde insuffisant pour ce debit']]);
        }

        $user->solde -= $montant;
        $user->save();

        return response()->json(['solde' => $user->solde]);
    }
}

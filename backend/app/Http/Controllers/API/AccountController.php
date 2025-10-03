<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $accounts = Account::all();
        return response()->json($accounts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'balance' => 'numeric',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $account = Account::create($validatedData);
        return response()->json($account, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $account): JsonResponse
    {
        return response()->json($account);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Account $account): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'type' => 'string|max:255',
            'balance' => 'numeric',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $account->update($validatedData);
        return response()->json($account);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account): JsonResponse
    {
        $account->delete();
        return response()->json(null, 204);
    }
}
<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $transactions = Transaction::with(['account', 'category'])->get();
        return response()->json($transactions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'category_id' => 'required|exists:financial_categories,id',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
            'transaction_date' => 'required|date',
            'type' => 'required|in:income,expense'
        ]);

        $transaction = Transaction::create($validatedData);
        return response()->json($transaction, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction): JsonResponse
    {
        $transaction->load(['account', 'category']);
        return response()->json($transaction);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction): JsonResponse
    {
        $validatedData = $request->validate([
            'account_id' => 'exists:accounts,id',
            'category_id' => 'exists:financial_categories,id',
            'amount' => 'numeric',
            'description' => 'nullable|string',
            'transaction_date' => 'date',
            'type' => 'in:income,expense'
        ]);

        $transaction->update($validatedData);
        return response()->json($transaction);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction): JsonResponse
    {
        $transaction->delete();
        return response()->json(null, 204);
    }

    /**
     * Get dashboard summary data.
     */
    public function summary(Request $request): JsonResponse
    {
        $totalIncome = Transaction::where('type', 'income')->sum('amount');
        $totalExpense = Transaction::where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        return response()->json([
            'total_income' => $totalIncome,
            'total_expense' => $totalExpense,
            'balance' => $balance
        ]);
    }
}
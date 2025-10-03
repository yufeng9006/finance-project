<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $budgets = Budget::with('category')->get();
        return response()->json($budgets);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'category_id' => 'required|exists:financial_categories,id',
            'amount' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'description' => 'nullable|string'
        ]);

        $budget = Budget::create($validatedData);
        return response()->json($budget, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Budget $budget): JsonResponse
    {
        $budget->load('category');
        return response()->json($budget);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Budget $budget): JsonResponse
    {
        $validatedData = $request->validate([
            'category_id' => 'exists:financial_categories,id',
            'amount' => 'numeric',
            'start_date' => 'date',
            'end_date' => 'date',
            'description' => 'nullable|string'
        ]);

        $budget->update($validatedData);
        return response()->json($budget);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Budget $budget): JsonResponse
    {
        $budget->delete();
        return response()->json(null, 204);
    }
}
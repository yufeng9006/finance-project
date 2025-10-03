<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $accounts = Account::where('is_active', true)->get();
        return $this->success($accounts, '账户列表获取成功');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'balance' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->error('数据验证失败', 422, $validator->errors());
        }

        $account = Account::create($request->all());
        return $this->success($account, '账户创建成功', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $account = Account::find($id);

        if (!$account) {
            return $this->error('账户不存在', 404);
        }

        return $this->success($account, '账户详情获取成功');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $account = Account::find($id);

        if (!$account) {
            return $this->error('账户不存在', 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'type' => 'string|max:255',
            'balance' => 'numeric|min:0',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return $this->error('数据验证失败', 422, $validator->errors());
        }

        $account->update($request->all());
        return $this->success($account, '账户更新成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $account = Account::find($id);

        if (!$account) {
            return $this->error('账户不存在', 404);
        }

        $account->delete();
        return $this->success(null, '账户删除成功');
    }

    /**
     * 获取账户余额
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function balance($id)
    {
        $account = Account::find($id);

        if (!$account) {
            return $this->error('账户不存在', 404);
        }

        return $this->success([
            'account_id' => $account->id,
            'balance' => $account->balance,
        ], '账户余额获取成功');
    }
}
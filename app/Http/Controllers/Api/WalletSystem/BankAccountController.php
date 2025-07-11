<?php

namespace App\Http\Controllers\Api\WalletSystem;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\TableRequest;
use App\Http\Requests\FindLikeRequest;
use App\Http\Requests\wallet_system\BankAccountRequest;
use App\Http\Requests\wallet_system\BankAccountRequestEdit;
use App\Http\Requests\MassiveUsersRequest;

// Models
use App\Models\BankAccount;

class BankAccountController extends Controller
{
	public function index(TableRequest $request) 
	{
		$search = urldecode($request->search);

		$perPage = $request->per_page;
		
		$bank_accounts = BankAccount::where('n_account', 'like', '%'.$search.'%')
			->orWhere('name', 'like', '%'.$search.'%')
			->paginate($perPage);
		
		return response()->json([
			'data' => $bank_accounts->items(),
			'totalRows' => $bank_accounts->total(),
		], 200);
	}
	
	public function findLike(FindLikeRequest $request) 
	{
		$search = urldecode($request->search);
		
		$bankAccounts = BankAccount::where('name', 'like', "%$search%")
			->limit(15)
			->get();
		
		return response()->json($bankAccounts, 200);
	}
	
  public function create(BankAccountRequest $request) 
	{
		$bankAccount = BankAccount::create($request->toArray());
		
		if ($bankAccount) {
			$payload = [
				'n_account' => $request->n_account,
				'name' => $request->name,
			];
			
			$request->user()->logs()->create([
				'action' => "Cuenta bancaria creada",
				'payload' => $payload,
				'type' => 'gedure'
			]);
			
			return response()->json([
				'msg' => "Cuenta bancaria agregada",
			], 200);
		}else {
			return response()->json([
				'msg' => "No se pudo agregar la cuenta bancaria",
			], 400);
		}
	}
	
	public function edit(BankAccountRequestEdit $request, BankAccount $bank_account)
	{
		$bank_account->update($request->toArray());
		
		$payload = [
			'n_account' => $request->n_account,
			'name' => $request->name,
		];

		$request->user()->logs()->create([
			'action' => "Cuenta bancaria actualizada",
			'payload' => $payload,
			'type' => 'gedure'
		]);
		
		return response()->json([
			'msg' => "Cuenta bancaria actualizada",
		], 200);
	}
	
	public function destroy(BankAccount $bank_account, $massive = false)
	{
		$bank_account->delete();
		
		if (!$massive) {
			$payload = [
				'n_account' => $bank_account->n_account,
				'name' => $bank_account->name,
			];

			request()->user()->logs()->create([
				'action' => "Cuenta bancaria eliminada",
				'payload' => $payload,
				'type' => 'gedure'
			]);
		}
		
		return response()->json([
			'msg' => "Cuenta bancaria eliminada",
		], 200);
	}
	
	public function destroyMassive(MassiveUsersRequest $request) {
		$ids = json_decode(urldecode($request->ids));
		$bank_accounts = BankAccount::whereIn('id', $ids)->get();
		
		$i=0;
		$accounts=[];
		foreach($bank_accounts as $bank_account) {
			$accounts[$i]= [
				'name' => $bank_account->name,
				'account' => $bank_account->n_account,
			];
			$this->destroy($bank_account, true);
			$i++;
		}
		
		if (!$i) {
			return response()->json([
				'msg' => "No se ha eliminado ninguna cuenta bancaria",
			], 200);
		}
		
		$payload = [
			'count' => $i,
			'accounts' => $accounts,
		];

		$request->user()->logs()->create([
			'action' => "Cuentas bancarias eliminadas masivamente",
			'payload' => $payload,
			'type' => 'gedure'
		]);
		
		return response()->json([
			'msg' => "$i cuenta(s) bancaria(s) eliminada(s)",
		], 200);
	}
}


/*
// 1. Excluir el filtro
BankAccount::withoutGlobalScope('school')->get();

// 2. Para superadmins ver todo
if (auth()->user()->isSuperAdmin()) {
    return BankAccount::all(); // Sin filtro
}
*/
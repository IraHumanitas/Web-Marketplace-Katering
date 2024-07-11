<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Merchant;
use App\Models\Menu;

class MerchantController extends Controller
{
    //
    public function dashboard()
    {
        return view('merchant.dashboard');
    }

    public function show()
    {
        $merchant = auth()->user()->merchant; // Mendapatkan data merchant yang terkait dengan user yang sedang login

        return view('merchant.merchant', compact('merchant'));
    }

    public function update(Request $request)
    {
        $merchant = auth()->user()->merchant;

        $request->validate([
            'company_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'contact_number' => 'required|string|max:20',
            'description' => 'nullable|string',
        ]);

        $merchant->update($request->only([
            'company_name',
            'address',
            'city',
            'state',
            'postal_code',
            'contact_number',
            'description',
        ]));

        return redirect()->route('merchant.profile')->with('success', 'Profil merchant berhasil diperbarui.');
    }


    // Untuk Customerrr
    public function index()
    {
        $merchants = Merchant::all();

        return view('customer.belanja.merchant', compact('merchants'));
    }

    public function showMenus($merchantId)
    {
        $merchant = Merchant::findOrFail($merchantId);
        $menus = Menu::where('merchant_id', $merchantId)->get();

        return view('menus.index', compact('merchant', 'menus'));
    }

    // public function users()
    // {
    //     $users = User::with('roles')->where('role','!=',1)->get();
    //     return view('super-admin.users', compact('users'));
    // }

    // public function manageRole()
    // {
    //     $users = User::where('role','!=',1)->get();
    //     $roles = Role::all();
    //     return view('super-admin.manage-role', compact(['users','roles']));
    // }

    // public function updateRole(Request $request)
    // {
    //     User::where('id', $request->user_id)->update([
    //         'role' => $request->role_id
    //     ]);
    //     return redirect()->back();
    // }

}

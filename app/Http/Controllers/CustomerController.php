<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    //
    public function dashboard()
    {
        $user = User::all();
        $customer = Customer::all();

        return view('customer.dashboard', compact('user', 'customer'));
    }

    public function show()
    {
        $customer = auth()->user()->customer; // Mendapatkan data customer yang terkait dengan user yang sedang login

        return view('customer.profile', compact('customer'));
    }

    public function update(Request $request)
    {
        $customer = auth()->user()->customer;

        $request->validate([
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048', // max 2MB
        ]);

        // Handle upload gambar jika ada
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('image'), $fileName);
            $customer->photo = $fileName;
        }

        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->save();

        return redirect()->route('customer.profile')->with('success', 'Profil berhasil diperbarui.');
    }
    
}

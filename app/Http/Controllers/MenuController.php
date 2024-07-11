<?php
namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Merchant;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        return view('merchant.menu.index', compact('menus'));
    }

    public function create(Request $request)
    {
        $menus = Menu::all();
        return view('merchant.menu.add', compact('menus'));
    }


    public function store(Request $request)
    {
        // Validasi data sebelum menyimpan ke database
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|max:2048', // max 2MB
            'price' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'category' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama menu harus diisi.',
            'name.string' => 'Nama menu harus berupa teks.',
            'name.max' => 'Nama menu tidak boleh lebih dari :max karakter.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'photo.image' => 'Foto harus berupa file gambar.',
            'photo.max' => 'Ukuran foto tidak boleh lebih dari :max KB.',
            'price.required' => 'Harga harus diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga tidak boleh kurang dari :min.',
            'stok.required' => 'Stok harus diisi.',
            'stok.integer' => 'Stok harus berupa angka bulat.',
            'stok.min' => 'Stok tidak boleh kurang dari :min.',
            'category.required' => 'Kategori harus diisi.',
            'category.string' => 'Kategori harus berupa teks.',
            'category.max' => 'Kategori tidak boleh lebih dari :max karakter.',
        ]);
    
        // Ambil user yang sedang login menggunakan Auth facade
        $user = Auth::user();
    
        // Pastikan user memiliki entri di Merchant
        if (!$user->merchant) {
            return redirect()->back()->with('error', 'Anda belum terdaftar sebagai merchant.');
        }
    
        // Ambil ID merchant dari user yang sedang login
        $id_merchant = $user->merchant->id;
    
        // Buat instance Menu
        $menu = new Menu();
        $menu->name = $request->name;
        $menu->description = $request->description;
        
        // Handle upload gambar jika ada
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('image'), $fileName);
            $menu->photo = $fileName;
        }
    
        $menu->price = $request->price;
        $menu->stok = $request->stok;
        $menu->category = $request->category;
        $menu->id_merchant = $id_merchant; // Set id_merchant yang sesuai
        $menu->save();
    
        return redirect()->route('menus.index')->with('success', 'Menu berhasil ditambahkan.');
    }
    
    public function edit($id)
    {
        $menu = Menu::findOrFail($id); // Mendapatkan menu berdasarkan ID
        return view('merchant.menu.edit', compact('menu'));
    }

    // Metode untuk menghapus menu
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id); // Mendapatkan menu berdasarkan ID
        $menu->delete();

        return redirect()->route('merchant.menu.index')->with('success', 'Menu berhasil dihapus.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|max:2048', // max 2MB
            'price' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'category' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama menu harus diisi.',
            'name.string' => 'Nama menu harus berupa teks.',
            'name.max' => 'Nama menu tidak boleh lebih dari :max karakter.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'photo.image' => 'Foto harus berupa file gambar.',
            'photo.max' => 'Ukuran foto tidak boleh lebih dari :max KB.',
            'price.required' => 'Harga harus diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga tidak boleh kurang dari :min.',
            'stok.required' => 'Stok harus diisi.',
            'stok.integer' => 'Stok harus berupa angka bulat.',
            'stok.min' => 'Stok tidak boleh kurang dari :min.',
            'category.required' => 'Kategori harus diisi.',
            'category.string' => 'Kategori harus berupa teks.',
            'category.max' => 'Kategori tidak boleh lebih dari :max karakter.',
        ]);

        $menu = Menu::findOrFail($id); // Mendapatkan menu berdasarkan ID

        $menu->name = $request->name;
        $menu->description = $request->description;
        $menu->price = $request->price;
        $menu->stok = $request->stok;
        $menu->category = $request->category;

        // Handle upload gambar jika ada
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('image'), $fileName);
            $menu->photo = $fileName;
        }

        $menu->save();

        return redirect()->route('merchant.menu.index')->with('success', 'Menu berhasil diupdate.');
    }

    public function search(Request $request)
    {
        $search = $request->get('search');

        $menus = Menu::where('name', 'like', '%'.$search.'%')
                    ->orWhere('category', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%'.$search.'%')
                    ->orderBy('name')
                    ->paginate(10);

        return view('merchant.menu.index', compact('menus'));
    }


    // Untuk Customer Belanjaa
    public function showMenus($merchantId)
    {
        $merchant = Merchant::findOrFail($merchantId);
        $menus = Menu::where('id_merchant', $merchantId)->get();

        return view('customer.belanja.menu', compact('merchant', 'menus'));
    }

}

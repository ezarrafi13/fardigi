<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Order;

class AkunController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user   = Auth::user();
        $orders = Order::where('user_id', $user->id)->latest()->get();

        return view('akun.index', compact('user', 'orders'));
    }

    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'fullname'     => 'required|string|max:100',
            'email'        => 'required|email|unique:users,email,' . $user->id,
            'phone'        => 'required|string|max:20',
            'address'      => 'nullable|string',
            'city'         => 'nullable|string|max:100',
            'zip'          => 'nullable|string|max:20',
            'new_password' => 'nullable|string|min:6',
        ]);

        $data = [
            'name'     => $request->fullname,
            'fullname' => $request->fullname,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'address'  => $request->address,
            'city'     => $request->city,
            'zip'      => $request->zip,
        ];

        if ($request->filled('new_password')) {
            $data['password'] = Hash::make($request->new_password);
        }

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}

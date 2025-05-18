<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('front.user.profile-edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'contact' => 'nullable|string|max:20',
            'photo' => 'nullable|image|max:2048',
            'org_logo' => 'nullable|image|max:2048',
        ]);

        $user->fill($validated);

        if ($request->hasFile('photo')) {
            $user->photo = $this->storeImage($request->file('photo'), 'users/photos', $user->photo);
        }

        if ($request->hasFile('org_logo')) {
            $user->org_logo = $this->storeImage($request->file('org_logo'), 'users/logos', $user->org_logo);
        }

        $user->save();

        return redirect()->back()->with('status', 'Profile updated successfully.');
    }

    private function storeImage($file, $path, $oldFile = null)
    {
        if ($oldFile && Storage::disk('public')->exists($oldFile)) {
            Storage::disk('public')->delete($oldFile);
        }

        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        return $file->storeAs($path, $filename, 'public');
    }
}

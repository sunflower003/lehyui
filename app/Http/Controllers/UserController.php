<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Hiển thị trang profile settings.
     */
   public function settings()
{
    $user = Auth::user();
    $user->avatar_path = ($user->avatar === 'avatar_default.jpg' || $user->avatar === null)
        ? asset('img/avatar_default.jpg')
        : asset('storage/avatars/' . $user->avatar);

    $headerCategories = \App\Models\Category::orderBy('created_at')->limit(5)->get();

    return view('pages.profile_settings', compact('user', 'headerCategories'));
}


    /**
     * Cập nhật username (nếu đang dùng tab General).
     */
    public function updateGeneral(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
        ]);

        $user->username = $request->username;
        $user->save();

        return back()
            ->with('success', 'Update username successfully.')
            ->with('active_tab', 'profile_general');
    }

    /**
     * Cập nhật ảnh đại diện và tên (Edit Profile tab).
     */
    public function updateInfo(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
        ]);

        $user->username = $request->username;

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = uniqid() . '.' . $avatar->getClientOriginalExtension();
            $avatar->storeAs('public/avatars', $avatarName);

            if ($user->avatar && $user->avatar !== 'avatar_default.jpg') {
                Storage::delete('public/avatars/' . $user->avatar);
            }

            $user->avatar = $avatarName;
        }

        $user->save();

        return redirect()->route('profile.settings')
            ->with('success', 'Update Profile Avatar successfully.')
            ->with('active_tab', 'profile_edit');
    }

    /**
     * Cập nhật mật khẩu ở tab Password.
     */
    public function updatePassword(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ], [
            'new_password.confirmed' => 'Confirm password does not match.',
            'new_password.min' => 'Password must be at least 6 characters.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('active_tab', 'profile_password');
        }

        if (!Hash::check($request->old_password, $user->password)) {
            return back()
                ->with('error', 'Old password is incorrect.')
                ->with('active_tab', 'profile_password');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()
            ->with('success', 'Change password successfully.')
            ->with('active_tab', 'profile_password');
    }


    /**
     * Xoá tài khoản người dùng.
     */
    public function deleteAccount(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'password' => 'required',
        ]);

        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Password is incorrect.');
        }

        if ($user->avatar && $user->avatar !== 'avatar_default.jpg') {
            Storage::delete('public/avatars/' . $user->avatar);
        }

        Auth::logout();
        $user->delete();

        return redirect()->route('home')->with('success', 'Your account has been deleted successfully.');
    }

    public function adminIndex(Request $request)
    {
        $query = User::query();

        // Tìm kiếm theo tên
        if ($request->filled('search')) {
            $query->where('username', 'like', '%' . $request->search . '%');
        }

        // Lọc giới tính
        if ($request->filled('sex') && in_array($request->sex, ['male', 'female'])) {
            $query->where('sex', $request->sex);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(5)->appends($request->query());
        return view('admin_dashboard.users.index', compact('users'));
    }

    public function adminEdit(User $user)
    {
        return view('admin_dashboard.users.edit', compact('user'));
    }

    public function adminUpdate(Request $request, User $user)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'sex' => 'required|in:male,female',
            'role' => 'required|in:admin,user',
        ]);
        $user->username = $request->username;
        $user->sex = $request->sex;
        $user->role = $request->role;
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function adminDestroy(User $user)
    {
        if (auth()->id() == $user->id) {
            return back()->with('error', 'You cannot delete your own account.');
        }
        $user->delete();
        return back()->with('success', 'Deleted user successfully.');
    }

}

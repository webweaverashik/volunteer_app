<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('loginActivities')->get();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // -------------------------------
        // Validation
        // -------------------------------
        $validated = $request->validate([
            'user_name_add' => ['required', 'string', 'max:255'],
            'email_add'     => ['required', 'email', 'max:255', 'unique:users,email'],
        ]);

        DB::beginTransaction();

        try {
            // -------------------------------
            // Create User
            // -------------------------------
            $user = User::create([
                'name'      => $validated['user_name_add'],
                'email'     => $validated['email_add'],
                'password'  => Hash::make('1234@#'),
                'is_active' => true,
            ]);

            DB::commit();

            return response()->json(
                [
                    'success'  => true,
                    'message'  => 'ইউজার সফলভাবে তৈরি হয়েছে।',
                    'redirect' => route('users.index'),
                ],
                201,
            );
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json(
                [
                    'success' => false,
                    'message' => 'ইউজার তৈরি করতে সমস্যা হয়েছে।',
                    'error'   => config('app.debug') ? $e->getMessage() : null,
                ],
                500,
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response()->json([
            'success' => true,
            'data'    => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
            ],
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.users.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // -------------------------------
        // Validation
        // -------------------------------
        $validated = $request->validate([
            'user_name_edit' => ['required', 'string', 'max:255'],
            'email_edit'     => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
        ]);

        DB::beginTransaction();

        try {
            // -------------------------------
            // Update User
            // -------------------------------
            $user->update([
                'name'  => $validated['user_name_edit'],
                'email' => $validated['email_edit'],
            ]);

            DB::commit();

            return response()->json([
                'success'  => true,
                'message'  => 'ইউজার সফলভাবে আপডেট হয়েছে।',
                'redirect' => route('users.index'),
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json(
                [
                    'success' => false,
                    'message' => 'ইউজার আপডেট করতে সমস্যা হয়েছে।',
                    'error'   => config('app.debug') ? $e->getMessage() : null,
                ],
                500,
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    // User Profile
    public function profile()
    {
        $user            = User::find(auth()->user()->id);
        $loginActivities = $user->loginActivities()->latest()->get();

        return view('admin.users.profile', compact('user', 'loginActivities'));
    }

    /*
     * Update user personal profile
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $rules = [
            'name'  => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ];

        // Remove uniqueness rule if value didn't change (optional but nice)
        if ($request->email === $user->email) {
            unset($rules['email']);
        }

        $validated = $request->validate($rules);

        $user->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'প্রোফাইল সফলভাবে আপডেট করা হয়েছে।',
        ]);
    }

    /**
     * Toggle active and inactive users
     */
    public function toggleActive(Request $request)
    {
        $user = User::find($request->user_id);

        if (! $user) {
            return response()->json(['success' => false, 'message' => 'Error. Please, contact support.']);
        }

        $user->is_active = $request->is_active;
        $user->save();

        return response()->json(['success' => true, 'message' => 'User activation status updated.']);
    }

    /**
     * Reset user password
     */
    public function userPasswordReset(Request $request, User $user)
    {
        $request->validate([
            'new_password' => 'required|string|min:8',
        ]);

        if (! $user) {
            return response()->json(['success' => false, 'message' => 'User not found.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['success' => true]);
    }
}

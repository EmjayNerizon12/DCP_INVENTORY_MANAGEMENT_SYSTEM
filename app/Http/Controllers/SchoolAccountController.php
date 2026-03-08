<?php

namespace App\Http\Controllers;

use App\Models\SchoolUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SchoolAccountController extends Controller
{
    public function index()
    {
        return view('SchoolSide.Account.index');
    }

    public function showAccounts()
    {
        $keyword = trim((string) request()->query('query', ''));
        $perPage = (int) request()->query('per_page', 6);
        $perPage = $perPage > 0 && $perPage <= 50 ? $perPage : 6;

        $query = SchoolUser::query()
            ->whereNotNull('school_users.pk_school_id')
            ->join('schools', 'schools.pk_school_id', '=', 'school_users.pk_school_id')
            ->orderBy('schools.SchoolName', 'asc')
            ->select([
                'school_users.id as user_id',
                'school_users.pk_school_id',
                'school_users.username as user_username',
                'school_users.default_password',
                'school_users.last_login',
                'schools.SchoolID',
                'schools.SchoolName',
                'schools.SchoolLevel',
                'schools.SchoolEmailAddress',
                'schools.image_path',
            ]);

        if ($keyword !== '') {
            $query->where(function ($q) use ($keyword) {
                $q->where('schools.SchoolID', 'like', "%{$keyword}%")
                    ->orWhere('schools.SchoolName', 'like', "%{$keyword}%")
                    ->orWhere('schools.SchoolLevel', 'like', "%{$keyword}%")
                    ->orWhere('schools.SchoolEmailAddress', 'like', "%{$keyword}%")
                    ->orWhere('school_users.username', 'like', "%{$keyword}%")
                    ->orWhere('school_users.default_password', 'like', "%{$keyword}%");
            });
        }

        // Printable list: fetch all rows (no pagination) when `all=1`.
        if (request()->boolean('all')) {
            return response()->json([
                'success' => true,
                'data' => $query->get(),
            ]);
        }

        $results = $query->paginate($perPage)->withQueryString();

        return response()->json([
            'data' => $results->items(),
            'pagination' => [
                'current_page' => $results->currentPage(),
                'last_page' => $results->lastPage(),
                'per_page' => $results->perPage(),
                'total' => $results->total(),
                'from' => $results->firstItem(),
                'to' => $results->lastItem(),
            ],
        ]);
    }

    public function change_password(Request $request)
    {
        $request->validate([

            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);
        $user = Auth::guard('school')->user()->school->schoolUser;
        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        } elseif ($request->current_password === $request->new_password) {
            return back()->withErrors(['new_password' => 'New password cannot be the same as the current password.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->password_changed_at = now();
        $user->save();

        return back()->with('success', 'Password changed successfully.');
    }

    public function reset_password(Request $request)
    {

        $request->validate([
            'id' => 'required',

        ]);

        $school_user = SchoolUser::find($request->id);

        if (! $school_user) {
            return back()->withErrors(['id' => 'User not found.']);
        }

        $school_user->update([
            'password' => Hash::make($school_user->default_password),
            'password_changed_at' => now(),
        ]);

        return back()->with('success', 'Password reset successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\SchoolCoordinates;
use App\Models\SchoolUser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function updateSchoolDetails(Request $request)
    {
        $user = auth()->guard('school')->user();

        if (! $user || ! $user->pk_school_id) {
            return redirect()->back()->with('error', 'No school found for this account.');
        }

        $validated = $request->validate([

            'Region' => 'required|string|max:100',
            'Division' => 'required|string|max:100',
            'District' => 'required|string|max:100',
            'Province' => 'nullable|string|max:100',
            'CityMunicipality' => 'nullable|string|max:100',
            'SchoolContactNumber' => 'nullable|string|max:50',
            'SchoolContactNumber2' => 'nullable|string|max:50',
            'SchoolTelNumber' => 'nullable|string|max:50',
            'SchoolEmailAddress' => 'nullable|email|max:255',
            'SchoolAddress' => 'nullable|string',

        ]);

        try {

            $school = School::where('pk_school_id', $user->pk_school_id)->first();
            if (! $school) {
                return redirect()->back()->with('error', 'No school found for this account.');
            }
            $school->update($validated);

            return redirect()->back()->with('success', 'School details updated successfully.');
        } catch (Exception $e) {
            Log::error('School update error: '.$e->getMessage());

            return redirect()->back()->with('error', 'Update failed: '.$e->getMessage());
        }
    }

    public function updateAdminDetails(Request $request)
    {
        $user = auth()->guard('school')->user();
        if (! $user || ! $user->school) {
            return redirect()->back()->with('error', 'No school found for this account.');
        }
        $validated = $request->validate([
            'admin_position' => 'nullable|string|max:255',
            'admin_email' => 'nullable|email|max:255',
            'admin_mobile_no' => 'nullable|string|max:50',
            'admin_staff_email' => 'nullable|email|max:255',
            'admin_staff_mobile_no' => 'nullable|string|max:50',

        ]);
        try {
            $user->school->update($validated);

            return redirect()->back()->with('success', 'Admin details updated successfully.');
        } catch (Exception $e) {
            Log::error('Admin details update error: '.$e->getMessage());

            return redirect()->back()->with('error', 'Update failed: '.$e->getMessage());
        }
    }

    public function updateSchoolCoordinates(Request $request)
    {
        $user = Auth::guard('school')->user();

        if (! $user || ! $user->pk_school_id) {
            return redirect()->back()->with('error', 'No school found for this account.');
        }

        $validated = $request->validate([

            'is_considered_remote' => 'required|boolean',
            'uacs' => 'nullable|string|max:50',
        ]);

        try {
            $schoolCoordinates = SchoolCoordinates::where('pk_school_id', $user->school->pk_school_id)->first();

            if ($schoolCoordinates) {
                $schoolCoordinates->update($validated);
            }

            return redirect()->back()->with('success', 'School coordinates updated successfully.');
        } catch (Exception $e) {
            Log::error('School coordinates update error: '.$e->getMessage());

            return redirect()->back()->with('error', 'Update failed: '.$e->getMessage());
        }
    }

    public function upload_school_logo(Request $request)
    {
        $user = Auth::guard('school')->user();

        $validated = $request->validate([
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        try {
            if ($request->hasFile('image_path')) {
                $image = $request->file('image_path');
                $imageName = uniqid('logo_').'.'.$image->getClientOriginalExtension();
                $image->move(base_path('school-logo'), $imageName);
                $validated['image_path'] = $imageName;
            }
            $school = School::where('pk_school_id', $user->pk_school_id)->first();
            if (! $school) {
                return redirect()->back()->with('error', 'No school found for this account.');
            }
            $school->update($validated);

            return redirect()->back()->with('success', 'Logo has been updated successfully.');
        } catch (Exception $e) {
            Log::error('School update error: '.$e->getMessage());

            return redirect()->back()->with('error', 'Update failed: '.$e->getMessage());
        }
    }

    public function updateSchoolOfficials(Request $request)
    {
        $user = auth()->guard('school')->user();
        if (! $user || ! $user->school) {
            return redirect()->back()->with('error', 'No school found for this account.');
        }
        $validated = $request->validate([
            'PrincipalName' => 'nullable|string|max:255',
            'PrincipalContact' => 'nullable|string|max:50',
            'PrincipalEmail' => 'nullable|email|max:255',
            'ICTName' => 'nullable|string|max:255',
            'ICTContact' => 'nullable|string|max:50',
            'ICTEmail' => 'nullable|email|max:255',
            'CustodianName' => 'nullable|string|max:255',
            'CustodianContact' => 'nullable|string|max:50',
            'CustodianEmail' => 'nullable|email|max:255',
        ]);
        $user->school->update($validated);

        return redirect()->back()->with('success', 'School officials updated successfully.');
    }

    public function account()
    {
        $adminUser = SchoolUser::whereNull('pk_school_id')->first();

        return view('AdminSide.Account.index', compact('adminUser'));
    }

    public function change_username(Request $request)
    {
        $adminUser = SchoolUser::whereNull('pk_school_id')->first();

        if (! $adminUser) {
            return back()->with('error', 'Admin account not found.');
        }

        $validated = $request->validate([
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('school_users', 'username')->ignore($adminUser->id),
            ],
        ]);

        if ($validated['username'] === $adminUser->username) {
            return back()->withErrors(['username' => 'New username cannot be the same as the current username.']);
        }

        $adminUser->update([
            'username' => $validated['username'],
        ]);

        return back()->with('success', 'Username changed successfully.');
    }

    public function change_password(Request $request)
    {
        $request->validate([

            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = SchoolUser::whereNull('pk_school_id')->first();

        if (! $user) {
            return back()->with('error', 'Admin account not found.');
        }

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
}

<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\SchoolCoordinates;
use App\Models\SchoolData;
use App\Models\SchoolUser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SchoolDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function uploadSchoolImage(Request $request)
    {
        $validated = $request->validate([
            'school_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        // return response()->json([
        //     'success' => true,
        //     'data' =>  $request->school_image,
        // ]);
        if ($request->hasFile('school_image')) {
            $image = $request->file('school_image');
            $imageName = uniqid('logo_').'.'.$image->getClientOriginalExtension();
            $image->move(public_path('school-logo'), $imageName);
            $validated['image_path'] = $imageName;
        }
        $school_id = Auth::guard('school')->user()->school->pk_school_id;
        $school_data = School::where('pk_school_id', $school_id)
            ->first();
        $school_data->update([
            'image_path' => $validated['image_path'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'School image uploaded successfully!',
            'image' => asset('school-logo/'.$imageName),
        ]);
    }

    public function insertNonTeaching(Request $request)
    {
        $validated = $request->validate([
            'total_no_teaching' => 'required|integer|min:0',
            'classroom_with_tv' => 'required|integer|min:0',
            'has_network_admin' => 'nullable|int',
            'has_bandwidth' => 'nullable|int',
        ]);
        $school_id = Auth::guard('school')->user()->school->pk_school_id;
        $school_data = School::where('pk_school_id', $school_id)
            ->first();
        $school_data->update([
            'total_no_teaching' => $validated['total_no_teaching'],
            'classroom_with_tv' => $validated['classroom_with_tv'],
            'has_network_admin' => $validated['has_network_admin'],
            'has_bandwidth' => $validated['has_bandwidth'],
        ]);

        if ($school_data) {
            return back()->with('success', 'Additional Information submitted successfully!');
        } else {
            return back()->with('error', 'Additional Information not submitted successfully!');
        }

        return back()->with('success', 'Additional Information submitted successfully!');
    }

    public function store_data(Request $request)
    {
        $validated = $request->validate([
            'pk_school_id' => 'required|string',
            'GradeLevelID' => 'required|string',
            'RegisteredLearners' => 'required|integer|min:0',
            'Teachers' => 'required|integer|min:0',
            'Sections' => 'required|integer|min:0',
            'Classrooms' => 'required|integer|min:0',

        ]);

        // Save to SchoolData model (make sure you have this model and table)
        SchoolData::create($validated);

        return back()->with('success', 'School data submitted successfully!');
    }

    public function updateSchoolDataForm(Request $request)
    {
        try {

            $result = SchoolData::where('ID', $request->pk)->first();
            if ($result) {
                $result->update([
                    'RegisteredLearners' => $request->RegisteredLearners,
                    'Teachers' => $request->Teachers,
                    'Sections' => $request->Sections,
                    'Classrooms' => $request->Classrooms,
                ]);
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'School Data updated successfully');
    }

    public function delete_school_data(int $id)
    {
        try {

            $result = SchoolData::where('ID', $id)->first();
            if ($result) {
                $result->delete();
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'School Data deleted successfully');
    }

    public function index(Request $request)
    {
        $query = School::query()
            ->join('school_users', 'schools.pk_school_id', '=', 'school_users.pk_school_id')
            ->select('schools.*', 'school_users.username as user_username');
        if ($request->has('pk_school_id')) {
            $query->where('schools.pk_school_id', $request->input('pk_school_id'));
        }
        $query->orderBy('schools.SchoolName', 'asc');
        $schools = $query->paginate(6)->withQueryString();
        $schools_c = $query->get();
        $schools_count = $schools_c->count();

        return view('AdminSide.School.index')->with('schools', $schools)
            ->with('schools_count', $schools_count);
    }

    public function search_school(Request $request)
    {
        $keyword = trim((string) $request->query('query', ''));
        $perPage = (int) $request->query('per_page', 6);
        $perPage = $perPage > 0 && $perPage <= 50 ? $perPage : 6;

        $query = School::with('schoolUser:pk_school_id,last_login')
            ->orderBy('SchoolName', 'asc');

        if ($keyword !== '') {
            $query->where(function ($q) use ($keyword) {
                $q->where('SchoolID', 'like', "%{$keyword}%")
                    ->orWhere('SchoolName', 'like', "%{$keyword}%")
                    ->orWhere('SchoolLevel', 'like', "%{$keyword}%")
                    ->orWhere('PrincipalName', 'like', "%{$keyword}%")
                    ->orWhere('SchoolEmailAddress', 'like', "%{$keyword}%")
                    ->orWhere('SchoolContactNumber', 'like', "%{$keyword}%");
            });
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

    public function updateSchool(Request $request, $id)
    {
        $request->validate([
            'SchoolID' => 'required|string|max:50',
            'SchoolName' => 'required|string|max:255',
            'SchoolLevel' => 'required|string|max:50',
            'SchoolEmailAddress' => 'required|email',
        ]);

        $school = School::findOrFail($id);

        $school->SchoolID = $request->input('SchoolID');
        $school->SchoolName = $request->input('SchoolName');
        $school->SchoolLevel = $request->input('SchoolLevel');
        $school->SchoolEmailAddress = $request->input('SchoolEmailAddress');

        $school->save();

        return back()->with('success', 'School updated successfully!');
    }

    public function user()
    {
        // This method is intentionally left empty.
        $query = School::query()
            ->join('school_users', 'schools.pk_school_id', '=', 'school_users.pk_school_id')
            ->select('schools.*', 'school_users.username as user_username', 'school_users.password as password', 'school_users.default_password as default_password', 'school_users.id as user_id')
            ->orderBy('schools.schoolName', 'asc');
        if (request()->has('pk_school_id')) {
            $query->where('schools.pk_school_id', request()->input('pk_school_id'));
        }
        $users = $query->paginate(6)->withQueryString();

        return view('AdminSide.School.user')->with('users', $users);
    }

    public function search(Request $request)
    {
        $query = School::query()
            ->join('school_users', 'schools.pk_school_id', '=', 'school_users.pk_school_id')
            ->select(
                'schools.*',
                'school_users.username as user_username',
                'school_users.default_password as default_password',
                'school_users.id as user_id'
            )->orderBy('schools.schoolName', 'asc');

        if ($request->has('query')) {
            $search = $request->query('query');
            $query->where(function ($q) use ($search) {
                $q->where('schools.SchoolName', 'like', "%{$search}%")
                    ->orWhere('schools.SchoolLevel', 'like', "%{$search}%")
                    ->orWhere('school_users.username', 'like', "%{$search}%")
                    ->orWhere('schools.SchoolID', 'like', "%{$search}%")
                    ->orWhere('school_users.default_password', 'like', "%{$search}%");
            });
        }

        $users = $query->get();

        return response()->json($users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'SchoolID' => 'required|string|max:255',
            'SchoolName' => 'required|string|max:255',
            'SchoolLevel' => 'required|string|max:255',
            'SchoolEmailAddress' => 'required|email|max:255',
            'Latitude' => 'required|numeric',
            'Longitude' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ]);
        }

        $validated = $validator->validated();

        // Save the school (pk_school_id will be auto-incremented)
        $school = School::create($validated);

        // Save coordinates using pk_school_id as FK
        SchoolCoordinates::create([
            'pk_school_id' => $school->pk_school_id, // FK to schools
            'Latitude' => $validated['Latitude'],
            'Longitude' => $validated['Longitude'],
        ]);

        // Create a school user using pk_school_id as FK
        $password = $validated['SchoolID'].'-'.substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 6);
        SchoolUser::create([
            'pk_school_id' => $school->pk_school_id,
            'username' => $validated['SchoolEmailAddress'],
            'default_password' => $password,
            'password' => bcrypt($password),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'School created successfully!',
            'school' => $school,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($SchoolID)
    {
        $school = School::where('pk_school_id', $SchoolID)->firstOrFail();

        return view('AdminSide.School.show', compact('school'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function updateAllDetails(Request $request)
    {
        $user = Auth::guard('school')->user();

        if (! $user || ! $user->pk_school_id) {
            return redirect()->back()->with('error', 'No school found for this account.');
        }

        $validated = $request->validate([
            // School Details
            'Region' => 'nullable|string|max:100',
            'Division' => 'nullable|string|max:100',
            'District' => 'nullable|string|max:100',
            'Province' => 'nullable|string|max:100',
            'CityMunicipality' => 'nullable|string|max:100',
            'SchoolContactNumber' => 'nullable|string|max:50',
            'SchoolContactNumber2' => 'nullable|string|max:50',
            'SchoolTelNumber' => 'nullable|string|max:50',
            'SchoolEmailAddress' => 'nullable|email|max:255',
            'SchoolAddress' => 'nullable|string',
            // Coordinates
            'is_considered_remote' => 'nullable|boolean',
            'uacs' => 'nullable|string|max:50',
            // Admin Details
            'admin_position' => 'nullable|string|max:255',
            'admin_email' => 'nullable|email|max:255',
            'admin_mobile_no' => 'nullable|string|max:50',
            'admin_staff_email' => 'nullable|email|max:255',
            'admin_staff_mobile_no' => 'nullable|string|max:50',
            // Non-Teaching
            'total_no_teaching' => 'nullable|integer|min:0',
            'classroom_with_tv' => 'nullable|integer|min:0',
            'has_network_admin' => 'nullable|integer',
            'has_bandwidth' => 'nullable|integer',
        ]);

        try {
            $school = School::where('pk_school_id', $user->pk_school_id)->first();

            if (! $school) {
                return redirect()->back()->with('error', 'No school found.');
            }

            // Update school details
            $school->update($validated);

            // Update coordinates if provided
            if (isset($validated['is_considered_remote']) || isset($validated['uacs'])) {
                $coordinates = SchoolCoordinates::where('pk_school_id', $user->pk_school_id)->first();
                if ($coordinates) {
                    $coordinates->update([
                        'is_considered_remote' => $validated['is_considered_remote'] ?? $coordinates->is_considered_remote,
                        'uacs' => $validated['uacs'] ?? $coordinates->uacs,
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'School details updated successfully.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => true,
                'message' => 'Something went wrong, please try again later.',
                'errors' => $e->getMessage(),
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => true,
                'message' => 'Validation Failed.',
                'errors' => $e->errors(),
            ]);
        }
    }

    public function destroy(string $id)
    {
        $school = School::findOrFail($id);
        $school->delete();

        // Optionally, delete the associated coordinates and user
        SchoolCoordinates::where('pk_school_id', $id)->delete();
        $schoolUser = $school->schoolUser;
        if ($schoolUser) {
            $schoolUser->delete();
        }

        Log::info("School with ID: $id has been deleted.");

        return response()->json([
            'success' => true,
            'message' => 'School deleted successfully!',
        ]);
    }
}

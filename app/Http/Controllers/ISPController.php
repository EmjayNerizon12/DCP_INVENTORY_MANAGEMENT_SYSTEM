<?php

namespace App\Http\Controllers;

use App\Models\ISP\ISPAreaAvailable;
use App\Models\ISP\ISPAreaDetails;
use App\Models\ISP\ISPConnectionType;
use App\Models\ISP\ISPDetails;
use App\Models\ISP\ISPInternetQuality;
use App\Models\ISP\ISPList;
use Exception;
use Illuminate\Http\Request;

class ISPController extends Controller
{
    public function indexISPList()
    {
        $ISPList = ISPList::all();
        $ISPConnectionType = ISPConnectionType::all();
        $ISPArea = ISPAreaAvailable::all();
        $ISPInternetQ = ISPInternetQuality::all();

        return view('AdminSide.ISP.index', compact('ISPList', 'ISPInternetQ', 'ISPArea', 'ISPConnectionType'));
    }

    public function storeISPList(Request $request)
    {
        $validated = $request->validate([
            'isp_name' => 'string|required',
        ]);
        try {
            $isp_create = ISPList::create([
                'name' => $validated['isp_name'],
            ]);

            return redirect()->route('isp.index.list')->with('success', 'New Internet Service Provider has been added.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Oops there was problem with your request.'.$e);
        }
    }

    public function storeConnectionType(Request $request)
    {
        $validated = $request->validate([
            'isp_connection_name' => 'string|required',
        ]);
        try {
            $isp_create = ISPConnectionType::create([
                'name' => $validated['isp_connection_name'],
            ]);

            return redirect()->route('isp.index.list')->with('success', 'New ISP Connection Type has been added.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Oops there was problem with your request.'.$e);
        }
    }

    public function storeArea(Request $request)
    {
        $validated = $request->validate([
            'isp_area_name' => 'string|required',
        ]);
        try {
            $isp_create = ISPAreaAvailable::create([
                'name' => $validated['isp_area_name'],
            ]);

            return redirect()->route('isp.index.list')->with('success', 'New ISP Area has been added.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Oops there was problem with your request.'.$e);
        }
    }

    public function storeISPQuality(Request $request)
    {
        $validated = $request->validate([
            'isp_quality' => 'string|required',
        ]);
        try {
            $isp_create = ISPInternetQuality::create([
                'name' => $validated['isp_quality'],
            ]);

            return redirect()->route('isp.index.list')->with('success', 'New ISP Quality has been added.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Oops there was problem with your request.'.$e);
        }
    }

    public function updateISPList(Request $request)
    {
        $validated = $request->validate([
            'isp_name' => 'required|string',
            'isp_list_id' => 'required|integer',
        ]);

        try {
            $list = ISPList::findOrFail($validated['isp_list_id']);
            $list->update([
                'name' => $validated['isp_name'],
            ]);

            return redirect()->back()->with('success', 'The Internet Service Provider has been updated.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Oops, there was unexpected error in your request'.$e);
        }
    }

    public function updateConnectionType(Request $request)
    {
        $validated = $request->validate([
            'isp_connection_type_id' => 'required|integer',
            'isp_connection_type_name' => 'required|string',
        ]);

        try {
            $list = ISPConnectionType::findOrFail($validated['isp_connection_type_id']);
            $list->update([
                'name' => $validated['isp_connection_type_name'],
            ]);

            return redirect()->back()->with('success', 'The ISP Connection type has been updated.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Oops, there was unexpected error in your request'.$e);
        }
    }

    public function updateISPQuality(Request $request)
    {
        $validated = $request->validate([
            'isp_quality_id' => 'required|integer',
            'isp_quality_name' => 'required|string',
        ]);

        try {
            $list = ISPInternetQuality::findOrFail($validated['isp_quality_id']);
            $list->update([
                'name' => $validated['isp_quality_name'],
            ]);

            return redirect()->back()->with('success', 'The ISP Quality has been updated.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Oops, there was unexpected error in your request'.$e);
        }
    }

    public function updateArea(Request $request)
    {
        $validated = $request->validate([
            'isp_area_id' => 'required|integer',
            'isp_area_name' => 'required|string',
        ]);

        try {
            $list = ISPAreaAvailable::findOrFail($validated['isp_area_id']);
            $list->update([
                'name' => $validated['isp_area_name'],
            ]);

            return redirect()->back()->with('success', 'The ISP Area has been updated.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Oops, there was unexpected error in your request'.$e);
        }
    }

    public function deleteISPList(int $isp_list_id)
    {

        try {
            $deleteConn = ISPList::findOrFail($isp_list_id);
            $deleteConn->delete();

            return response()->json(['message' => 'ISP deleted successfully']);
        } catch (Exception $e) {

            return response()->json(['message' => 'Oops.. Deleting this object has been failed']);
        }
    }

    public function deleteConnectionType(int $isp_connection_id)
    {

        try {
            $deleteConn = ISPConnectionType::findOrFail($isp_connection_id);
            $deleteConn->delete();

            return response()->json(['message' => 'The connection type has been deleted']);
        } catch (Exception $e) {
            return response()->json(['message' => 'Oops.. Deleting this object has been failed']);
        }
    }

    public function deleteISPQuality(int $isp_quality_id)
    {

        try {
            $deleteConn = ISPInternetQuality::findOrFail($isp_quality_id);
            $deleteConn->delete();

            return response()->json(['message' => 'The ISP Quality has been deleted']);
        } catch (Exception $e) {
            return response()->json(['message' => 'Oops.. Deleting this object has been failed']);
        }
    }

    public function deleteArea(int $isp_area_id)
    {

        try {
            $deleteArea = ISPAreaDetails::findOrFail($isp_area_id);
            $deleteArea->delete();

            return response()->json(['message' => 'The ISP Area has been deleted']);
        } catch (Exception $e) {
            return response()->json(['message' => 'Oops.. Deleting this object has been failed']);
        }
    }

    public function show()
    {
        $isp_content = ISPDetails::with([
            'ispList',
            'ispConnectionType',
            'ispInternetQuality',
            'school',
            'ispPurpose',
            'ispAreaDetails',
            'ispSpeedTest',
        ])
            ->join('schools', 'isp_details.school_id', '=', 'schools.pk_school_id')
            ->orderBy('schools.SchoolName', 'asc')->get()->groupBy('school_id');

        return view('AdminSide.ISP.show', compact('isp_content'));
        dd($isp_content);
    }

    /*************  ✨ Windsurf Command ⭐  *************/
    /**
     * Search for ISP details based on school name
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Exception
     */
    /*******  164fd6ed-aa56-4020-aa0a-0b1cccb3d0a8  *******/
    public function search(Request $request)
    {
        try {
            $search = $request->input('query');
            $isp_content = ISPDetails::with([
                'ispList',
                'ispConnectionType',
                'ispInternetQuality',
                'school',
                'ispPurpose',
                'ispAreaDetails.ispAreaAvailable',
                'ispSpeedTest',
            ])->whereHas('school', function ($q) use ($search) {
                $q->where('SchoolName', 'like', "%{$search}%");
            })->join('schools', 'isp_details.school_id', '=', 'schools.pk_school_id')
                ->orderBy('schools.SchoolName', 'asc')->get()->groupBy('school_id');

            return response()->json($isp_content);
        } catch (Exception $e) {
        }
    }
}

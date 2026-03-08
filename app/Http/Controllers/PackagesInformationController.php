<?php

namespace App\Http\Controllers;

use App\Models\DCPPackageContent;
use App\Models\DCPPackageTypes;

class PackagesInformationController extends Controller
{
    public function index(int $id)
    {
        if ($id) {
            $packageTypes = DCPPackageTypes::where('pk_dcp_package_types_id', $id)->get();
            $packageContent = collect();

            foreach ($packageTypes as $packageType) {
                // Get contents for this package type
                $contents = DCPPackageContent::where('dcp_package_types_id', $packageType->pk_dcp_package_types_id)->get();
                $packageContent->push([
                    'package_name' => $packageType->name,
                    'contents' => $contents,
                ]);
            }
        } elseif ($id === 0) {
            $packageTypes = DCPPackageTypes::all();
            $packageContent = collect();

            foreach ($packageTypes as $packageType) {
                // Get contents for this package type
                $contents = DCPPackageContent::where('dcp_package_types_id', $packageType->pk_dcp_package_types_id)->get();
                $packageContent->push([
                    'package_name' => $packageType->name,
                    'contents' => $contents,
                ]);
            }
        }

        return view('SchoolSide.PackagesInformation', compact('packageContent'));
    }
}

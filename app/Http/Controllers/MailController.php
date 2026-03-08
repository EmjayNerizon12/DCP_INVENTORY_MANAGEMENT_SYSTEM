<?php

namespace App\Http\Controllers;

use App\Mail\SampleMail;
use App\Models\School;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendEmail(int $id)
    {
        try {
            $school = School::findOrFail($id);
            $school_user = $school->schoolUser; // Assuming there's a relationship defined

            $details = [
                'name' => $school->SchoolName,
                'message' => 'Please review your SDO DCP Inventory updates. Visit the portal and submit any required reports.',
                'password' => $school_user->default_password ?? 'No password set',
            ];

            Mail::to($school->SchoolEmailAddress)->send(new SampleMail($details));

            return redirect()->back()->with('success', 'Email sent successfully to '.$school->SchoolEmailAddress);
        } catch (\Exception $e) {
            Log::error('Mail exception: '.$e->getMessage());

            return redirect()->back()->with('error', 'Exception occurred while sending email. Check log.');
        }
    }
}

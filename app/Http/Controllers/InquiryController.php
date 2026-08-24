<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inquiry;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminInquiryNotification;

class InquiryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'journey' => 'nullable|string|max:255',
            'message' => 'nullable|string',
        ]);

        $inquiry = Inquiry::create($validated);

        try {
            Mail::to(config('mail.from.address'))->send(new AdminInquiryNotification($inquiry));
        } catch (\Exception $e) {
            // Log the error or ignore it if mail is not configured yet
            \Log::error('Mail could not be sent: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Thank you — your question has been received. A Solvive specialist will reply by email within one business day.');
    }
}

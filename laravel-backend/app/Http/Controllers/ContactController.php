<?php
// app/Http/Controllers/ContactController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'first_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            'message' => 'required|string',
        ]);

        // Send email with the contact information
        Mail::raw("You have a new contact form submission from {$request->first_name}.\n\n" .
                        "Email: {$request->email}\n" .
                        "Phone: {$request->phone_number}\n\n" .
                        "Message:\n{$request->message}", function ($message) {
            $message->to('hongducct23@gmail.com')
                    ->subject('New Contact Form Submission');
        });

        // Return a response to the client
        return response()->json(['message' => 'Thông tin liên hệ đã được gửi đi'], 200);
    }
}

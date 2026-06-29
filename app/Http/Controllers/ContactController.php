<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        // Honeypot check: If the hidden field is filled, it's a bot.
        // Return a fake success message to fool the bot into thinking it succeeded.
        if (!empty($request->website_url)) {
            return back()->with('success', __('Pesan Anda berhasil terkirim! Kami akan segera menghubungi Anda.'));
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
            'website_url' => 'nullable|string', // allow the field but it should be empty
        ]);

        ContactMessage::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'is_read' => false,
        ]);

        return back()->with('success', __('Pesan Anda berhasil terkirim! Kami akan segera menghubungi Anda.'));
    }
}

<?php

namespace App\Http\Controllers;

use Mail;
use Illuminate\Http\Request;

class MailController extends Controller
{
    public function send(Request $request) {

        Mail::send('email.template', [], function($message) {
            // Set the receiver and subject of the mail.
            $message->to(env('SEND_EMAIL_TO'), 'Asad Shiekh')->subject('1st Task Done');
            // Set the sender
            $message->from(env('MAIL_USERNAME'),env('EMAIL_SUBJECT'));
        });

        return response()->json('email sent successfully', 200);
    }
}

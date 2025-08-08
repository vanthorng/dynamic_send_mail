<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailConfiguration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\DynamicEmail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class EmailConfigurationController extends Controller
{
    //
    // ========== [ Create email configuration ] ==========
    public function createConfiguration(Request $request)
    {
        $configuration = EmailConfiguration::create([
            "user_id"      => Auth::user()->id,
            "driver"       => $request->driver,
            "host"         => $request->hostName,
            "port"         => $request->port,
            "encryption"   => $request->encryption,
            "user_name"    => $request->userName,
            "password"     => $request->password,
            "sender_name"  => $request->senderName,
            "sender_email" => $request->senderEmail,
        ]);

        if (!is_null($configuration)) {
            return back()->with("success", "Email configuration created.");
        } else {
            return back()->with("failed", "Email configuration not created.");
        }
    }

    public function composeEmail()
    {
        return view("email");
    }
    // public function sendEmail(Request $request)
    // {
    //     $toEmail = $request->emailAddress;
    //     $data = [
    //         "message" => $request->message
    //     ];

    //     // Pass dynamic message to mail class
    //     Mail::to($toEmail)->send(new DynamicEmail($data));

    //     if (Mail::failures() != 0) {
    //         return back()->with("success", "E-mail sent successfully!");
    //     } else {
    //         return back()->with("failed", "E-mail not sent!");
    //     }
    // }

    // ========= [ Send email ] Work On .env ========= 

    // public function sendEmail(Request $request)
    // {
    //     $toEmail = $request->emailAddress;
    //     $data = [
    //         "message" => $request->message
    //     ];

    //     try {
    //         Mail::to($toEmail)->send(new DynamicEmail($data));
    //         Log::info("E-mail sent successfully to $toEmail");
    //         return back()->with("success", "E-mail sent successfully!");
    //     } catch (\Exception $e) {
    //         return back()->with("failed", "E-mail not sent! Error: " . $e->getMessage());
    //     }
    // }

    // ========= [ Send email ] dynamic from database =========
    public function sendEmail(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'emailAddress' => 'required|email',   // Ensure email is valid
            'message'      => 'required|string',   // Ensure message is not empty
        ]);
    
        // Get the email configuration for the authenticated user
        $userId = Auth::user()->id;
        $configuration = EmailConfiguration::where("user_id", $userId)->first();
    
        if ($configuration) {
            // Dynamically set the mail configuration based on the logged-in user
            $mailConfig = [
                'driver'     => $configuration->driver,  // Should be 'smtp'
                'host'       => $configuration->host,
                'port'       => $configuration->port,
                'username'   => $configuration->user_name,
                'password'   => $configuration->password,
                'encryption' => $configuration->encryption,
                'from'       => [
                    'address' => $configuration->sender_email,
                    'name'    => $configuration->sender_name,
                ],
            ];
    
            // Log the mail configuration for debugging
            Log::info('Mail Configuration:', $mailConfig);
    
            // Set the dynamic configuration in Laravel's mailer settings
            Config::set('mail.mailers.smtp', [
                'transport'  => $mailConfig['driver'],  // Ensure driver is used here, e.g., 'smtp'
                'host'       => $mailConfig['host'],
                'port'       => $mailConfig['port'],
                'username'   => $mailConfig['username'],
                'password'   => $mailConfig['password'],
                'encryption' => $mailConfig['encryption'],
                'from'       => $mailConfig['from'],
            ]);
    
            // Send the email
            try {
                Mail::to($request->emailAddress)->send(new DynamicEmail([
                    "message" => $request->message
                ]));
    
                Log::info("E-mail sent successfully to {$request->emailAddress}");
                return back()->with("success", "E-mail sent successfully!");
            } catch (\Exception $e) {
                // Log the error message for debugging
                Log::error("Error sending email: {$e->getMessage()}");
    
                return back()->with("failed", "E-mail not sent! Error: " . $e->getMessage());
            }
        } else {
            return back()->with("failed", "No email configuration found for the user.");
        }
    }
}

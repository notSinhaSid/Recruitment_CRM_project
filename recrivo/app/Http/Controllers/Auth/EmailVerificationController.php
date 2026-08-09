<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;

class EmailVerificationController extends Controller
{
    public function notice(): View|RedirectResponse
    {
        if (auth()->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        return view('auth.verify-email');
    }

    public function verify(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        $request->fulfill();

        return redirect()->route('dashboard')->with('success', 'Email verified successfully.');
    }

    public function resend(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        $key = 'verify-email-resend:' . $request->user()->id;

        if (RateLimiter::tooManyAttempts($key, 3)) {
            return back()->with('error', 'Too many attempts. Please wait a minute before trying again.');
        }

        RateLimiter::hit($key, 60);

        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'Verification link sent.');
    }
}

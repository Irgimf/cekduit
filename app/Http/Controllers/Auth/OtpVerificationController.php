<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OtpVerificationController extends Controller
{
    public function show(): View|RedirectResponse
    {
        if (auth()->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        return view('auth.verify-otp');
    }

    public function verify(Request $request): RedirectResponse
    {
        $request->validate([
            'otp_code' => ['required', 'string', 'size:6'],
        ]);

        $user = $request->user();

        if (! $user->isOtpValid($request->otp_code)) {
            return back()->withErrors(['otp_code' => 'Kode OTP salah atau sudah expired.']);
        }

        $user->forceFill(['email_verified_at' => now()])->save();
        $user->clearOtp();

        return redirect()->route('dashboard')->with('success', 'Email berhasil diverifikasi!');
    }

    public function resend(Request $request): RedirectResponse
    {
        $request->user()->generateAndSendOtp('verifikasi akun');

        return back()->with('status', 'Kode OTP baru sudah dikirim ke email kamu.');
    }
}
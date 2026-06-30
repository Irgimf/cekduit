<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OtpVerificationController extends Controller
{
    public function show(Request $request): View|RedirectResponse
    {
        if (auth()->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        $lastSent = $request->session()->get('otp_last_sent_at');
        $cooldownSeconds = 0;

        if ($lastSent) {
            $elapsed = now()->diffInSeconds($lastSent, false);
            $cooldownSeconds = max(0, 60 + $elapsed);
        }

        return view('auth.verify-otp', compact('cooldownSeconds'));
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
        $request->session()->forget('otp_last_sent_at');

        return redirect()->route('dashboard')->with('success', 'Email berhasil diverifikasi!');
    }

    public function resend(Request $request): RedirectResponse
    {
        $lastSent = $request->session()->get('otp_last_sent_at');

        if ($lastSent && now()->diffInSeconds($lastSent, false) > -60) {
            return back()->withErrors(['otp_code' => 'Harap tunggu 60 detik sebelum kirim ulang.']);
        }

        $request->user()->generateAndSendOtp('verifikasi akun');
        $request->session()->put('otp_last_sent_at', now());

        return back()->with('status', 'Kode OTP baru sudah dikirim ke email kamu.');
    }
}
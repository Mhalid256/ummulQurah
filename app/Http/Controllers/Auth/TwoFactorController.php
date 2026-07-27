<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PragmaRX\Google2FAQRCode\Google2FA;

class TwoFactorController extends Controller
{
    protected Google2FA $google2fa;

    public function __construct()
    {
        $this->google2fa = new Google2FA();
    }

    /** Settings screen: enable/disable 2FA */
    public function show()
    {
        $user = auth()->user();

        $qrCodeUrl = null;
        if (! $user->hasTwoFactorEnabled()) {
            if (! $user->two_factor_secret) {
                $user->forceFill(['two_factor_secret' => encrypt($this->google2fa->generateSecretKey())])->save();
            }
            $secret = decrypt($user->two_factor_secret);
            $qrCodeUrl = $this->google2fa->getQRCodeInline(
                config('app.name'),
                $user->email,
                $secret
            );
        }

        return view('auth.two-factor-settings', compact('user', 'qrCodeUrl'));
    }

    /** Confirm the code shown by the authenticator app to enable 2FA */
    public function confirm(Request $request)
    {
        $request->validate(['code' => 'required|digits:6']);

        $user = auth()->user();
        $valid = $this->google2fa->verifyKey(decrypt($user->two_factor_secret), $request->code);

        if (! $valid) {
            return back()->withErrors(['code' => 'Invalid authentication code.']);
        }

        $recoveryCodes = collect(range(1, 8))->map(fn () => strtoupper(bin2hex(random_bytes(4))))->all();

        $user->forceFill([
            'two_factor_confirmed_at' => now(),
            'two_factor_recovery_codes' => encrypt(json_encode($recoveryCodes)),
        ])->save();

        return redirect()->route('admin.two-factor.show')->with('recovery_codes', $recoveryCodes)
            ->with('success', 'Two-factor authentication has been enabled.');
    }

    public function disable()
    {
        auth()->user()->forceFill([
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ])->save();

        return back()->with('success', 'Two-factor authentication has been disabled.');
    }

    /** Login-time challenge, shown after password auth if 2FA is enabled */
    public function showChallenge()
    {
        return view('auth.two-factor-challenge');
    }

    public function verifyChallenge(Request $request)
    {
        $request->validate(['code' => 'required|string']);
        $user = auth()->user();

        $isValidTotp = $this->google2fa->verifyKey(decrypt($user->two_factor_secret), $request->code);
        $isValidRecovery = false;

        if (! $isValidTotp && $user->two_factor_recovery_codes) {
            $codes = json_decode(decrypt($user->two_factor_recovery_codes), true);
            $isValidRecovery = in_array(strtoupper($request->code), $codes, true);
        }

        if (! $isValidTotp && ! $isValidRecovery) {
            return back()->withErrors(['code' => 'Invalid authentication code.']);
        }

        $request->session()->put('two_factor_verified', true);

        return redirect()->intended(route('admin.dashboard'));
    }
}
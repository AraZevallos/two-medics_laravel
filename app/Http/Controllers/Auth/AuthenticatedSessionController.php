<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Services\Mail\MailService;
use App\Mail\OneTimePassword;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Str;


// Use the Mailgun class from mailgun/mailgun-php v4.2
use Mailgun\Mailgun;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the login page.
     */
    public function create(Request $request): Response
    {
        return Inertia::render('auth/Login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('courses.index', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function validEmail(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);
        Log::info('request', [
            'email' => $request->email,
        ]);

        $user = User::where('email', $request->email)->first();


        if ($user) {
            $newPassword = strtolower(Str::random(6));
            Log::info('newPassword', [
                'newPassword' => $newPassword,
            ]);
            $user->password = Hash::make($newPassword);
            $user->save();

            MailService::to($user->email)->send(new OneTimePassword($user->name, $newPassword));

            return redirect()->route('login')->with('isValidEmail', true);
        } else return redirect()->route('login')->withErrors(['email' => 'No existe un usuario con ese correo electrónico']);
    }
}

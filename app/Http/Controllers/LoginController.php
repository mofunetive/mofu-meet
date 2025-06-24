<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['require']
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('meet');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function exchangeCode(string $code)
    {
        $API_ENDPOINT = 'https://discord.com/api/v10/oauth2/token';

        $CLIENT_ID = config('services.discord.client_id');
        $CLIENT_SECRET = config('services.discord.client_secret');
        $REDIRECT_URI = config('services.discord.redirect');

        $data = [
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $REDIRECT_URI,
        ];

        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];

        $response = Http::asForm()
            ->withHeaders($headers)
            ->withBasicAuth($CLIENT_ID, $CLIENT_SECRET)
            ->post($API_ENDPOINT, $data);

        if (!$response->ok()) {
            throw new \Exception('Failed to exchange code: ' . $response->body());
        }

        return $response->json();
    }

    public function discordAuth(Request $request): RedirectResponse
    {
        $code = $request->query('code');

        if (!$code) {
            return redirect('/')->with('error', 'Authorization code not found.');
        }

        try {
            $tokenData = $this->exchangeCode($code);

            $accessToken = $tokenData['access_token'];

            $discordUserResponse = Http::withToken($accessToken)
                ->get('https://discord.com/api/users/@me');

            if (!$discordUserResponse->ok()) {
                return redirect('/')->with('error', 'Failed to get user info from Discord');
            }

            $discordUser = $discordUserResponse->json();

            $user = User::updateOrCreate(
                ['discord_id' => $discordUser['id']],
                [
                    'name' => $discordUser['username'],
                    'email' => $discordUser['email'] ?? null,
                    'avatar' => $discordUser['avatar'] ?? null,
                ]
            );

            Auth::login($user);

            return redirect('/');
        } catch (\Exception $e) {
            return redirect('/')->with('error', $e->getMessage());
        }
    }
}

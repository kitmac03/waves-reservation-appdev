<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ManagerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $userId = Auth::id();

        if ($userId) {
            // Attempt to find the admin by their ID
            $user = \App\Models\Admin::find($userId);

            // Debug: Log if the user is found or not
            if ($user) {
                Log::info('Authenticated admin user found:', ['name' => $user->name]);
            } else {
                Log::warning('Admin user not found with ID: ' . $userId);
                return redirect()->route('login');
            }
        } else {
            return redirect()->route('login');  // Redirect if not an admin or manager
        }

        if ($user && ($user->role === 'Manager')) {
            return $next($request);  // Allow the request to continue if the user is an admin or manager
        } else {
            return redirect()->route('login');  // Redirect if not an admin or manager
        }
    }
}

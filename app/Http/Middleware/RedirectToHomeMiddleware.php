<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectToHomeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $role = $request->user()->role;
        if ($role == 'manager') {
            return redirect()->route('manager.home');
        } elseif ($role == 'admin') {
            return redirect()->route('admin.home');
        } elseif ($role == 'kitchen_staff') {
            return redirect()->route('kitchen_staff.home');
        } elseif ($role == 'staff') {
            return redirect()->route('staff.home');
        } 
        
        return $next($request);
    }
}

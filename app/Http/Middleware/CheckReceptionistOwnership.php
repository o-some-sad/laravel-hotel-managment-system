<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckReceptionistOwnership
{
    
          public function handle(Request $request, Closure $next): Response
          {
            
                    if (!Auth::check()) {
                              abort(403);
                          }

                    $user = $request->route('user');
                      
                    if (!$user || $user->created_by !== Auth::id()) {
                              abort(403);
                    }
                      
                    return $next($request);
          }
}

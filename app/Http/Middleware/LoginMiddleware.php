<?php

namespace App\Http\Middleware;

use Closure;

class LoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $authMethod, $dest = "/")
    {
        // Act dependent on the auth method
        /*
        * -> "redirect": redirect user to /$dest if authenticated
        * -> "allow": only allow user if authenticated (or session variable is present for userid)
        * -> ...
        */
        if(($authMethod == 'redirect' && $this->hasSession('userid') === True) || ($authMethod == 'allow' && $this->hasSession('userid') === False)) {
            // Return a 404 response
            die(view('errors.404'));
        }

        return $next($request);
    }



    // Return whether a session variable is set
    protected function hasSession($sessId) {
        return session()->has($sessId);
    }
}

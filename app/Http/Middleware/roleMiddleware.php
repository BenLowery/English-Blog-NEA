<?php

namespace App\Http\Middleware;

use Closure;
use App\BenLowery\Database as db;
class roleMiddleware {
    public function __construct() {
        $this->db = new db;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        /* Using a defensive programming paradigm */

        // if session isn't set, this is the only check for student roles
        if(!session()->has('userid')) {
            abort(404);
        }
        // If admin we need to check the person is an admin
        if ($role === "admin") {
            // Only allow users logged in as admin
            if(!$this->db->isadmin()) {
                abort(404);
            } 
        }
        return $next($request);
    }
}

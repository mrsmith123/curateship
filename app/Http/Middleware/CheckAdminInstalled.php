<?php

namespace App\Http\Middleware;

use Closure;

class CheckAdminInstalled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * 
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        # If the installed log file does not exist
        # redirect to the requirements installation step.
        if (!file_exists(storage_path('installed'))) {
            # Redirect to the final installation step
            return redirect()->route('LaravelInstaller::requirements');
        }

        # If the admin_installed log file exists
        if (file_exists(storage_path('admin_installed'))) {
            # We will abort the request with a "not found" response
            return abort(404);
        }

        # Otherwise, continue with the request
        return $next($request);
    }
}

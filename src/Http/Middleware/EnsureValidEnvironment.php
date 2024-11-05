<?php

namespace CArena\EloquentStalker\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureValidEnvironment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $environmentsInOrderFromMostImportant = ['production', 'testing', 'local'];

        if (!in_array(app()['env'], $environmentsInOrderFromMostImportant) ) {
            abort(404);
        }

        $currentEnv = app()['env'];
        $maxEnv = config('eloquent-stalker.max_env');

        /**
         * Itero desde el mayor env hasta el menor. En cada uno verifico si coincide con el
         * máximo env del paquete. Si es así se continúa, sino se aborta
         */
        foreach ($environmentsInOrderFromMostImportant as $environment) {
            if ($currentEnv === $environment) {
                if ($currentEnv === $maxEnv) {
                    break;
                }
                abort(404);
            }
        }

        return $next($request);
    }
}

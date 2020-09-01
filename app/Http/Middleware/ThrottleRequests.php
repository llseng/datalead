<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Controllers\Controller;

class ThrottleRequests extends \Illuminate\Routing\Middleware\ThrottleRequests
{

    /**
     * 重构 handle
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  int|string  $maxAttempts
     * @param  float|int  $decayMinutes
     * @return mixed
     */
    public function handle($request, Closure $next, $maxAttempts = 60, $decayMinutes = 1)
    {
        $key = $this->resolveRequestSignature($request);

        $maxAttempts = $this->resolveMaxAttempts($request, $maxAttempts);

        if ($this->limiter->tooManyAttempts($key, $maxAttempts, $decayMinutes)) {
            return $this->buildException($key, $maxAttempts);
        }

        $this->limiter->hit($key, $decayMinutes);

        $response = $next($request);

        return $this->addHeaders(
            $response, $maxAttempts,
            $this->calculateRemainingAttempts($key, $maxAttempts)
        );
    }

    /**
     * 返回 [code 401] JSON
     *
     * @param  string  $key
     * @param  int  $maxAttempts
     * @return Response
     */
    protected function buildException($key, $maxAttempts)
    {
        $retryAfter = $this->getTimeUntilNextRetry($key);

        $response = \response()->json( Controller::jsonRes( 401, "Access denied" ) );

        return $this->addHeaders( 
            $response, 
            $maxAttempts, 
            $this->calculateRemainingAttempts($key, $maxAttempts, $retryAfter), 
            $retryAfter 
        );
    }
}

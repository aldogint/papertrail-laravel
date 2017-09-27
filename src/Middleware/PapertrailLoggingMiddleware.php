<?php

namespace PapertrailLaravel\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
//use Log;

class PapertrailLoggingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    public function terminate ($request, $response)
    {
        $url = $request->path();
        $status = $response->status();
        $method = $request->method();
        $log = [
            'request' => [
                'header' => $request->header(),
                'body' => $request->all()
            ],
        ];

        if(env('PAPERTRAIL_LOG_RESPONSE'))
            $log['response'] = [
                'body' => $response->content(),
            ];

        if($status >= 500) return Log::error('['.$status.'] '.$method.' '.$url.' '.\GuzzleHttp\json_encode($log));
        elseif ($status >=400)Log::warning('['.$status.'] '.$method.' '.$url.' '.\GuzzleHttp\json_encode($log));
        else Log::info('['.$status.'] '.$method.' '.$url.' '.\GuzzleHttp\json_encode($log));
    }
}
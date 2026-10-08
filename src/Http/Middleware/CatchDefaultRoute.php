<?php

namespace Orchestra\Workbench\Http\Middleware;

use Closure;
use WpStarter\Support\Facades\Response;
use Orchestra\Workbench\Workbench;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CatchDefaultRoute
{
    /**
     * Handle an incoming request.
     *
     * @param  \WpStarter\Http\Request  $request
     * @param  \Closure(\WpStarter\Http\Request):(mixed)  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $workbench = Workbench::config();

        if ($request->decodedPath() === '/' && ! \is_null($workbench['user']) && \is_null($request->user())) {
            return ws_redirect('/_workbench');
        }

        $response = $next($request);

        if ($request->decodedPath() !== '/') {
            return $response;
        }

        if (property_exists($response, 'exception') && ! \is_null($response->exception) && $response->exception instanceof NotFoundHttpException) {
            if ($workbench['start'] !== '/') {
                return ws_redirect($workbench['start']);
            } elseif (
                ($workbench['install'] === true && $workbench['welcome'] !== false)
                || ($workbench['install'] === false && $workbench['welcome'] === true)
            ) {
                return Response::view('welcome');
            }
        }

        return $response;
    }
}

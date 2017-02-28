<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\Debug\Exception\FatalErrorException;

use App\Services\Alert;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        $user = auth()->user();
        $path = $request->path();
        if ($exception instanceof AuthorizationException && $user) {
            Alert::slack('Warning: '.$user->username.' was denied access to /'.$path.'.');
        } elseif ($exception instanceof NotFoundHttpException) {
            Alert::slack('Warning: /'.$path.' was not found.');
        } elseif ($exception instanceof FatalErrorException) {
            Alert::slack('Emergency: '.$exception->getMessage());
            return response()->view('errors.500', ['path' => $path], 500);
        } elseif ($exception instanceof MethodNotAllowedHttpException) {
            Alert::slack('Warning: Method "'.$request->method().'" not allowed at '.$path.'.');
            return response()->view('errors.500', ['path' => $path], 500);
        } elseif ($exception instanceof QueryException) {
            Alert::slack('Emergency: QueryException at /'.$path.'.');
            return response()->view('errors.500', ['path' => $path], 500);
        }

        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }
}

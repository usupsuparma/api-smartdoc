<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use App\Traits\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use League\Flysystem\Sftp\ConnectionErrorException;
use Illuminate\Contracts\Encryption\DecryptException;

class Handler extends ExceptionHandler
{
    use ApiResponse;
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
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
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($exception, $request);
        }
        
        if ($exception instanceof ModelNotFoundException) {
            $modelName = class_basename(str_replace('Model', '', $exception->getModel()));
            
            return $this->errorResponse("Does not exists any data {$modelName} with the specified identificator.", 404);
        }
        
        if ($exception instanceof HttpException) {
            if ($exception->getStatusCode() === 403) {
                return $this->errorResponse('Forbiden Access.', 403);
            }
            
            return $this->errorResponse('The specified URL cannot be found.', 404);
        }
        
        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse('The specified method for the request is invalid.', 405);
        }
        
        if ($exception instanceof AuthenticationException) {
            return $this->unauthenticated($exception, $request);
        }
        
        if ($exception instanceof AuthorizationException) {
            return $this->errorResponse($exception->getMessages(), 403);
        }
        
        if ($exception instanceof ConnectionErrorException) {
            return $this->errorResponse('Error Connection to FTP server', 500);
        }
        
        if ($exception instanceof DecryptException) {
            return $this->errorResponse('Failed render hash .', 500);
        }
        
        if(env('APP_DEBUG')) {
            return parent::render($request, $exception);
        }
        
        return $this->errorResponse('Unexpected Exeption. Try Later', 500);
    
    }
    
    protected function unauthenticated(AuthenticationException $exception, $request)
    {
        return $this->errorResponse('Unauthenticated', 401);
    }
    
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $errors = $e->validator->errors()->getMessages();
        
        return $this->errorResponse($errors, 422);
    }
}

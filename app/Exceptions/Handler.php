<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Laravel\Passport\Exceptions\MissingScopeException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

			//Not Found Exception
			$this->renderable(function (NotFoundHttpException $e) {
				$code = $e->getStatusCode();
				$message = Response::$statusTexts[$code];
				return $this->errorResponse($message, $code);
			});

			//Http Exception
			$this->renderable(function (HttpException $e) {
				$code = $e->getStatusCode();
				$message = Response::$statusTexts[$code];
				return $this->errorResponse($message, $code);
			});
			

			//Model Not found Exception
			$this->renderable(function (ModelNotFoundException $e) {
				$model = strtolower(class_basename($e->getModel()));
				return $this->errorResponse("Does not exist any instance of { $model } with the given id", Response::HTTP_NOT_FOUND);
			});

			//Authorization Exception
			$this->renderable(function (AuthorizationException $e) {
				return $this->errorResponse($e->getMessage(), Response::HTTP_FORBIDDEN);
			});

			//Authentication Exception
			$this->renderable(function (AuthenticationException $e) {
				return $this->errorResponse($e->getMessage(), Response::HTTP_UNAUTHORIZED);
			});

			//Validation Exception
			$this->renderable(function (ValidationException $e) {

				$errors = $e->validator->errors()->getMessages();

				return $this->errorResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
			});

			//Missing Scope Exception
			$this->renderable(function (MissingScopeException $e) {

				$error = $e->getMessage();
				return $this->errorResponse($error, Response::HTTP_UNAUTHORIZED);
			});

			//Query Exception
			$this->renderable(function (QueryException $e) {

				$error = $e->getMessage();
				return $this->errorResponse($error, Response::HTTP_INTERNAL_SERVER_ERROR);
			});
    }
}

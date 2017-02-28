<?php

Route::get('/', 'HomeController@index');

Route::get('/questions', 'QuestionsController@index');
Route::get('/questions/create', 'QuestionsController@create');
Route::get('/questions/{question}/{slug?}', 'QuestionsController@show');
Route::delete('/questions/{question}', 'QuestionsController@destroy');
Route::put('/questions/{question}', 'QuestionsController@update');
Route::post('/questions', 'QuestionsController@store');

Route::post('/answers', 'AnswersController@store');
Route::delete('/answers/{answer}', 'AnswersController@destroy');
Route::put('/answers/{answer}', 'AnswersController@update');

Route::post('/comments', 'CommentsController@store');
Route::delete('/comments/{comment}', 'CommentsController@destroy');
Route::put('/comments/{comment}', 'CommentsController@update');

Route::get('/account', 'AccountController@show');
Route::post('/account/change-email', 'AccountController@changeEmail');
Route::post('/account/change-password', 'AccountController@changePassword');
Route::post('/account/deactivate-account', 'AccountController@deactivateAccount');

Route::get('/email', 'EmailController@create');
Route::post('/email', 'EmailController@send');
Route::get('/email-sent', 'EmailController@sent');

Route::get('/users', 'UsersController@index');
Route::patch('/users/{user}', 'UsersController@update');

Route::get('/login', 'SessionsController@create')->name('login');
Route::post('/login', 'SessionsController@store');
Route::get('/logout', 'SessionsController@destroy');

Route::get('/signup', 'RegistrationController@create');
Route::post('/signup', 'RegistrationController@store');

Route::get('/password-reset', 'PasswordRecoveryController@create');
Route::post('/password-reset', 'PasswordRecoveryController@store');
Route::get('/check-email', 'PasswordRecoveryController@check');
Route::get('/password-reset/{email}/{key}', 'PasswordRecoveryController@resetForm');
Route::post('/password-reset/{user}', 'PasswordRecoveryController@reset');

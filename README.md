

## Laravel boilerplat with Clean Services code structure

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:


## Code flow starting point
 - routes/api.php is our starting point

### For v1 :

Route::post('v1/user', 'UserController@create');
Route::get('v1/user/{$id}', 'UserController@get');

### For v2 (clean code) :

Route::post('v2/user', 'User\CreateController');
Route::get('v2/user/{$id}', 'User\GetController');


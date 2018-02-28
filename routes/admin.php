<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'PageController@adminHomeView');
Route::get('/home', 'PageController@adminHomeView');

Route::resource('/content', 'CRUD\ContentController');
Route::resource('/menu_category', 'CRUD\MenuCategoryController');
Route::resource('/menu', 'CRUD\MenuController');
Route::resource('/thumbnail', 'CRUD\ThumbnailController');


Route::get('/slides/multiple_upload', 'CRUD\SlideController@multipleUploadView');
Route::post('/slides/multiple_upload', 'CRUD\SlideController@multipleUpload')->name('slides/multiple_upload.store');
Route::get('/slides/multiple_upload_generate_thumbnail', 'CRUD\SlideController@generateSlideThumbnail');
Route::post('/slides/generate_slide_thumbnail', 'CRUD\SlideController@generateSlideThumbnail');
Route::post('/delete_image/{col_name}/{row_id}', 'CRUD\SlideController@deleteImage');//post: model_path
Route::resource('/slides', 'CRUD\SlideController');
Route::get('/select_slide', 'CRUD\SlideController@iframeSelectSlide');


Route::resource('/galleries', 'CRUD\GalleryController');
Route::get('/gallery_slide/{gallery_id}', 'CRUD\GalleryController@gallerySlide');
Route::post('/add_slide_to_gallery', 'CRUD\GalleryController@addSlide');


Route::get('/categories/{type}/create', 'CRUD\CategoryController@create_category');
Route::get('/categories/{type}', 'CRUD\CategoryController@list_category');
Route::get('/menu/create/{category_id}', 'CRUD\MenuController@createMenuItem');
Route::post('/attach_content', 'CRUD\MenuController@attachContent');
Route::post('/detach_content', 'CRUD\MenuController@detachContent');
Route::resource('/categories', 'CRUD\CategoryController');


//KÉP MŰVELETEK
Route::get('/crop_image/{id}/{field}/{model_name}', 'CRUD\ThumbnailController@cropImage');
Route::get('/crop_modal/{id}/{field}/{prefix}/{model_name}', 'CRUD\ThumbnailController@cropModalView');
Route::post('/make_crop/{model_name}', 'CRUD\ThumbnailController@crop');
Route::post('/generate_thumbnail_sizes', 'CRUD\ThumbnailController@generateThumbnailSizes');


//Index Page
Route::get('/index_page', 'IndexController@edit');
Route::post('/index_page', 'IndexController@update');
Route::post('/new_index_page_element', 'IndexController@store');
Route::post('/delete_index_page_element', 'IndexController@delete');
Route::get('/change_index_edit_lang', 'IndexController@changeIndexEditLang');


Route::get('/edit_translations', 'SystemController@translations');
Route::post('/edit_translations', 'SystemController@translations');
<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/admin','PusatKontrol@loginAdmin')->name('loginadmin');
Route::post('/admin-auth','PusatKontrol@authAdmin')->name('authadmin');
Route::get('/{rand}/admin/{kantor}','PusatKontrol@admin')->name('admin');
Route::get('/{rand}/tambah-employee','PusatKontrol@inputEmployee')->name('inputemployee');

Route::get('/updateAdminCalls/{idOffice}/{idEmployee}','PusatKontrol@updateAdminCall')->name('updateadmincall');

Route::get('/{rand}/assign-desk','PusatKontrol@assignDesk')->name('inputtodesk');

Route::get('/Qhwhgkfjdghd7rghetn3oth98dgrejrt83t9ersejhtnp9ruskgldfngoufda75ewftu3t8owt4bv8t47vv49tybv47ty947trvg8vtb947r92vqpyt2vnoh4nt9rwy9r8awyauthv24y082yqv8ytuwt2u4yrv028y2867c32rv4764r264r238c4o2t7573t5t548t53873t5b3twc5w7t5bc495c2q8y524985yc4975cy9475yc95y79475y38ct4753857t357ctc48c5t3485t485t485ct3485ct413u9crgjfkngdjfewhrgeuyrtejhf82374ut5kth87fgy8f7gb2kbi74g74t8sdkfbdnbviw4y472viu2bv73ytv3yv9y938jgvffoweir98ry7b65vt6tbv3v963932b98v5b3895743n07357t3tyv397t4yn9vy3ty397tyvn5397vnty3w97vyn3595nty39tyv39nyt39vty3v9ty59y7v09ty320v09537tyv235790tyv320ty93yv49jheuoweoierowierouiewqoprywrqo7r3yq237238r7vr72t7r4279rc2yr8723yr7cy23fiwhc9823rh7c4yt854tiv3t7twc4r49fuhf87ecub34it7e78guerhg94vn3ty47tvn34y9f37h93r8nv948398ruv934tn3yt3vtknv98d982398594765rigbsdkv8743iujn7yv8r7e34jtkbgfi7fy97r3jk5b3iuthr87gygjehto3ith983t98ger9/edit-employee/{id}','PusatKontrol@editEmployee')->name('editemployee');

Route::patch('/update-employee/{id}','PusatKontrol@updateEmployee')->name('updateemployee');
Route::get('/{rand}/tambah-office','PusatKontrol@inputOffice')->name('inputoffice');
Route::post('/create-office','PusatKontrol@createOffice')->name('createoffice');
Route::post('/create-employee','PusatKontrol@createEmployee')->name('createemployee');
Route::patch('/admin-call','PusatKontrol@adminCall')->name('admincall');
Route::patch('/admin-call-ajax','PusatKontrol@adminCallAjax')->name('admincallajax');
Route::patch('{rand}/admin-update/{kantor}','PusatKontrol@updateCapacity')->name('updatecapacity');

Route::get('/','PusatKontrol@getUser')->name('getuser');
Route::get('/user/{kantor}','PusatKontrol@user')->name('user');
Route::patch('/user-call','PusatKontrol@userCall')->name('usercall');

Route::delete('/delete-employee/{id}','PusatKontrol@deletEmployee')->name('deleteEmployee');
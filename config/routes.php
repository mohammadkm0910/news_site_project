<?php

use Core\Router\Route;

Route::get("admin", "Admin@index");
Route::get("admin/list-user", "Admin@listUser");
Route::get("admin/comment-manger", "Admin@commentManger");
Route::get("admin/switch-user/{id}", "Admin@switchUser");
Route::get("admin/switch-status-comment/{id}", "Admin@switchStatusComment");
Route::get("admin/show-comment/{id}", "Admin@showComment");
Route::get("admin/edit-comment/{id}", "Admin@editComment");
Route::post("admin/update-comment/{id}", "Admin@updateComment");
Route::get("admin/seen-all-comment", "Admin@seenAllComment");
Route::get("admin/destroy-comment/{id}", "Admin@destroyComment");
Route::post("admin/search", "Admin@search");

Route::get("admin/groups", "AdminGroups@index");
Route::get("admin/groups/create", "AdminGroups@create");
Route::post("admin/groups/store", "AdminGroups@store");
Route::get("admin/groups/edit/{id}", "AdminGroups@edit");
Route::post("admin/groups/update/{id}", "AdminGroups@update");
Route::get("admin/groups/show/{id}", "AdminGroups@show");
Route::get("admin/groups/destroy/{id}", "AdminGroups@destroy");

Route::get("admin/news", "AdminNews@index");
Route::get("admin/news/create", "AdminNews@create");
Route::post("admin/news/store", "AdminNews@store");
Route::get("admin/news/edit/{id}", "AdminNews@edit");
Route::post("admin/news/update/{id}", "AdminNews@update");
Route::get("admin/news/show/{id}", "AdminNews@show");
Route::get("admin/news/destroy/{id}", "AdminNews@destroy");

Route::get("","Home@index");
Route::get("home","Home@index");
Route::get("home/show/{id}/{title}", "Home@show");
Route::post("home/comment-store/{id}", "Home@commentStore");
Route::get("home/group/{id}/{title}", "Home@group");
Route::get("home/news", "Home@news");
Route::get("home/search", "Home@search");

Route::get("register", "Auth@register");
Route::post("register/store", "Auth@store");
Route::get("login", "Auth@login");
Route::post("check-login", "Auth@checkLogin");
Route::get("logout", "Auth@logout");
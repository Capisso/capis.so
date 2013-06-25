<?php

Route::any(
    '/create',
    array(
        'before' => 'auth.basic',
        'do' => function () {
            $url = Input::get('url');
            $alias = Input::get('alias');
            $validator = Validator::make(
                compact('url', 'alias'),
                array('url' => 'required|url', 'alias' => 'unique:urls')
            );

            if ($validator->fails()) {
                return Response::json(array('error' => $validator->messages()->first()), 400);
            } else {
                if (empty($alias)) {
                    $alias = Capisso\URL::alias();
                }
                $url = Capisso\URL::create(array('user_id' => Auth::user()->id, 'alias' => $alias, 'url' => $url));
                if ($url) {
                    return Response::json($url, 201);
                } else {
                    return Response::json(array('error' => 'An error occurred while shortening the URL.'), 500);
                }
            }
        }
    )
);

Route::get(
    '/{alias}',
    function ($alias) {
        $url = Capisso\URL::where('alias', '=', $alias)->first();

        if ($url == false) {
            App::abort(404);
        } else {
            return Redirect::to($url->url, 302);
        }
    }
);
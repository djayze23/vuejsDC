<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

class CommentsController extends Controller
{

	public function index($url)
	{
		$comments = Comment::where('url', base64_decode($url))
        ->whereNull('respond_to_id')
        ->paginate(3);

        return $comments;
	}

    public function store()
    {
    	request()->validate([

    		'name' => ['required'],
            'body' => ['required'],
            'url' => ['required'],
    	]);

    	// Insertion dans la base de données:
    	// utilisation du modèle comment
    	return Comment::create([

    		'respond_to_id' => request('respond_to_id'),
            'name' => request('name'),
    		'url' => request('url'),
    		'body' => request('body'),
    	])->setRelation('children', collect());
    }
}

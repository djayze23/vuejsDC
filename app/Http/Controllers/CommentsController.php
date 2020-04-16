<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

class CommentsController extends Controller
{

	public function index()
	{
		return view('welcome');
	}

    public function store()
    {
    	request()->validate([

    		'content' => ['required'],
    	]);

    	// Insertion dans la base de données:
    	// utilisation du modèle comment
    	Comment::create([

    		'name' => 'David',
    		'url' => 'url',
    		'body' => request('content'),
    	]);
    	
    	return 'Votre commentaire a été ajouté !';
    }
}

<?php

namespace App\Controllers;

use App\Models\User;


class DashBoardController extends BaseController
{

	protected  $data;
	public function __construct()
	{
	    $user= new user();
		$this->data=[];
		$this->data['tags'] = [];		
		$this->data['title'] = '';
		$this->data['seo_title'] = '';
		$this->data['seo_desc'] = '';
		$this->data['posts'] = [];
		$this->data['title'] = '';
		helper(['utils', 'form','menu']);
	}

	public function index()
	{
		$this->data['tags'] = [];
		$post = new user();
		$this->data['title'] = 'Latest Posts';
		$this->data['seo_title'] = 'Home';
		$this->data['seo_desc'] = '';
		$this->data['posts'] =  $post->get_posts_nested(10, 0);
		$this->data['title'] = '';

		$this->data['latest_posts'] = $post->get_posts_nested(5, 0);
		
		$featured_tags = 'featured';
		$tags = explode(' ', $featured_tags);
		$featured_posts= $post->whereIn('tags', $tags)->asObject()->findAll();

		
		// Fetch the posts as objects
		$this->data['featured_posts'] = $featured_posts;
		
		helper('menu');
		return view('templates/header', $this->data) .
			view('pages/home', $this->data) .
			view('templates/footer');
	}







}
<?php

namespace App\Http\Controllers\PostController;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class Index extends Controller
{
    public function index(){
        return view('posts.index');
    }

    public function getData(){

        $posts =Post::all();

        return DataTables::of($posts)
            ->editColumn('content', function(Post $post) {
                return substr($post->content, 0, 80) . '...';
            })
            ->editColumn('created_at', function(Post $post) {
                return $post->created_at->format('d-m-Y');
            })
            ->addColumn('image', function ($row) {
                return"<img src='/imgs/no-image.jpg' class='datatable-image'>";
            })
            ->addColumn('actions', function ($row) {
                $html = "<div class='d-inline-flex'>";
                $html .= "<a href=".route('posts.update', $row->id)." class='btn btn-outline-success btn-sm me-1'><i class='bi bi-pencil-fill'></i></a>";
                $html .= "<button data-id='".$row->id."' type='button' class='btn btn-outline-danger btn-sm delete-confirmation' data-bs-toggle='modal' data-bs-target='#delete-confirmation'><i class='bi bi-trash-fill'></i></button>";
                $html .= "</div>";
                return $html;
            })
            ->rawColumns(['image', 'actions'])
            ->toJson();

    }
}


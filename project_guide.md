# Laravel Posts App - Step-by-Step Project Guide

## Overview
This is a Laravel-based web application for managing posts. It includes features like creating, reading, updating, deleting posts (CRUD), searching posts, and user association. The app uses Bootstrap for styling and follows MVC architecture.

## Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js and npm (for frontend assets)
- MySQL or another database supported by Laravel

## Step 1: Project Setup

### 1.1 Install Laravel
```bash
composer create-project laravel/laravel posts-app
cd posts-app
```

### 1.2 Configure Environment
- Copy `.env.example` to `.env`
- Set up database credentials in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=posts_app
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 1.3 Generate Application Key
```bash
php artisan key:generate
```

## Step 2: Database Setup

### 2.1 Create Migrations
Create the posts table migration:
```bash
php artisan make:migration create_posts_table
```

Edit `database/migrations/XXXX_XX_XX_XXXXXX_create_posts_table.php`:
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->foreignId('user_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
```

### 2.2 Run Migrations
```bash
php artisan migrate
```

## Step 3: Models

### 3.1 Create Post Model
```bash
php artisan make:model Post
```

Edit `app/Models/Post.php`:
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
```

### 3.2 Create Factories for Seeding
```bash
php artisan make:factory PostFactory
```

Edit `database/factories/PostFactory.php`:
```php
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            "title" => $this->faker->sentence,
            "description" => $this->faker->paragraph(6),
            "user_id" => rand(1, 2)
        ];
    }
}
```

## Step 4: Controllers

### 4.1 Create PostController
```bash
php artisan make:controller PostController
```

Edit `app/Http/Controllers/PostController.php`:
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $query = Post::with('user');

        if (request('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $posts = $query->paginate();
        return view("posts.index", ["posts" => $posts]);
    }

    public function home()
    {
        $posts = Post::where('user_id', auth()->id())->with('user')->paginate();
        return view("dashboard", ["posts" => $posts]);
    }

    public function create()
    {
        return view("posts.create");
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'min:3'],
            'description' => ['required', 'string', 'max:1500'],
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->user_id = auth()->id();
        $post->published = 1;
        $post->save();
        return redirect('/dashboard')->with('success', 'Post Added Successfully');
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view("posts.show", ["post" => $post]);
    }

    public function search(Request $request)
    {
        $q = $request->q;
        $posts = Post::where('description', 'like', '%' . $q . '%')->get();
        return view('posts.search', ['posts' => $posts]);
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view("posts.edit", ["post" => $post]);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'min:3'],
            'description' => ['required', 'string', 'max:1500'],
        ]);

        $post = Post::findOrFail($id);
        if ($post->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        $post->title = $request->title;
        $post->description = $request->description;
        $post->save();

        return redirect('posts')->with("success", "Post Updated Successfully");
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if ($post->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        $post->delete();
        return back()->with("success", "Post Deleted Successfully");
    }
}
```

## Step 5: Authentication Setup

Install Laravel Breeze for authentication:
```bash
composer require laravel/breeze --dev
php artisan breeze:install
npm install && npm run build
php artisan migrate
```

Laravel Breeze provides authentication scaffolding, including login, registration, password reset, and email verification. After installation, you can access authentication routes like `/login`, `/register`, etc. The PostController methods (store, update, destroy) now use `auth()->id()` to associate posts with the logged-in user, and protected routes require authentication via middleware.

## Step 6: Routes

Edit `routes/web.php`:
```php
<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Protect Posts CRUD operations (requires any logged-in user)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [PostController::class, 'home'])->name('dashboard');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
});

// Existing public routes
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/search', [PostController::class, 'search'])->name('posts.search');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

// Redirect root to posts index
Route::get('/', function () {
    return redirect('/posts');
});

// Admin Routes (requires 'auth' AND 'admin' privilege)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
});

// Breeze auth routes
require __DIR__.'/auth.php';
```

The `routes/auth.php` file is included via Breeze and contains authentication routes like login, register, etc.

## Step 7: Views

### 6.1 Create Layout
Create `resources/views/layout/app.blade.php`:
```html
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Posts App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">Posts App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('posts') }}">Posts</a>
                    </li>
                </ul>
                <form class="d-flex" action="{{ url('posts/search') }}" method="GET" role="search">
                    <input class="form-control me-2" name="q" type="search" placeholder="Search" aria-label="Search"/>
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            @yield('content')
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
```

### 6.2 Home View
Create `resources/views/home.blade.php`:
```html
@extends('layout.app')
@section('content')
<div class="col-12">
    <h1 class="p-3 border text-center mt-3">All Posts</h1>
</div>
@foreach ($posts as $post)
<div class="col-12">
    <div class="card">
        <div class="card-header">
            {{ $post->user->name }} - {{ $post->created_at->format('Y-n-d') }}
        </div>
        <div class="card-body">
            <h5 class="card-title">{{ $post->title }}</h5>
            <p class="card-text">{{ \Str::limit($post->description, 50) }}.</p>
            <a href="{{ url('posts/' . $post->id) }}" class="btn btn-primary">Show Post</a>
        </div>
    </div>
</div>
@endforeach
<div>
    {{ $posts->links() }}
</div>
@endsection
```

### 6.3 Posts Index View
Create `resources/views/posts/index.blade.php`:
```html
@extends('layout.app')
@section('content')
<div class="col-12">
    <a href="{{ url('posts/create') }}" class="btn btn-sm btn-primary float-start mb-2">Add New Post</a>
    <div class="clearfix"></div>
    <h1 class="p-3 border text-center mt-3">All Posts</h1>
</div>
@if (session()->get('success') != null)
<h3 class="text-success my-2">{{ session()->get('success') }}</h3>
@endif
<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Description</th>
            <th>Writer</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($posts as $post)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $post->title }}</td>
            <td>{{ $post->description }}</td>
            <td>{{ $post->user->name }}</td>
            <td>
                <a href="{{ url('posts/' . $post->id . '/edit') }}" class="btn btn-info">Edit</a>
            </td>
            <td>
                <form action="{{ url('posts/' . $post->id) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <input type="submit" value="Delete" class="btn btn-danger">
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div>
    {{ $posts->links() }}
</div>
@endsection
```

### 6.4 Create Post View
Create `resources/views/posts/create.blade.php`:
```html
@extends('layout.app')
@section('content')
<div class="col-12">
    <h1 class="p-3 text-center mt-3">Create New Post</h1>
</div>
<div class="col-8 mx-auto">
    <form action="{{ url('posts') }}" method="POST" class="form border p-3">
        @csrf
        @if ($errors->any())
        <div class="alert alert-danger p-1">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if (session()->get('success') != null)
        <h3 class="text-success my-2">{{ session()->get('success') }}</h3>
        @endif
        <div class="mb-3">
            <label for="">Post Title</label>
            <input type="text" class="form-control" value="{{ old('title') }}" name="title">
        </div>
        <div class="mb-3">
            <label for="">Post Description</label>
            <textarea class="form-control" name="description" rows="7">{{ old('description') }}</textarea>
        </div>
        <div class="mb-3">
            <input type="submit" class="form-control bg-success" value="Save">
        </div>
    </form>
</div>
@endsection
```

### 6.5 Edit Post View
Create `resources/views/posts/edit.blade.php`:
```html
@extends('layout.app')
@section('content')
<div class="col-12">
    <h1 class="p-3 text-center mt-3">Edit Post Info</h1>
</div>
<div class="col-8 mx-auto">
    <form action="{{ url('posts/' . $post->id) }}" method="POST" class="form border p-3">
        @method('PUT')
        @csrf
        @if ($errors->any())
        <div class="alert alert-danger p-1">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="mb-3">
            <label for="">Post Title</label>
            <input type="text" value="{{ $post->title }}" class="form-control" name="title">
        </div>
        <div class="mb-3">
            <label for="">Post Description</label>
            <textarea class="form-control" name="description" rows="7">{{ $post->description }}</textarea>
        </div>
        <div class="mb-3">
            <label for="">Writer</label>
            <select name="user_id" class="form-control">
                <option value="1">Mostafa</option>
                <option value="2">Ali</option>
            </select>
        </div>
        <div class="mb-3">
            <input type="submit" class="form-control bg-success" value="Save">
        </div>
    </form>
</div>
@endsection
```

### 6.6 Show Post View
Create `resources/views/posts/show.blade.php`:
```html
@extends('layout.app')
@section('content')
<div class="col-12">
    <h1 class="p-3 border text-center mt-3">{{ $post->title }}</h1>
</div>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            {{ $post->user->name }} - {{ $post->created_at->format('Y-n-d') }}
        </div>
        <div class="card-body">
            <h5 class="card-title">{{ $post->title }}</h5>
            <p class="card-text">{{ $post->description }}.</p>
        </div>
    </div>
</div>
@endsection
```

### 6.7 Search Results View
Create `resources/views/posts/search.blade.php`:
```html
@extends('layout.app')
@section('content')
<div class="col-12">
    <h1 class="p-3 border text-center mt-3">Search Results</h1>
</div>
@foreach ($posts as $post)
<div class="col-12">
    <div class="card">
        <div class="card-header">
            {{ $post->user->name }} - {{ $post->created_at->format('Y-n-d') }}
        </div>
        <div class="card-body">
            <h5 class="card-title">{{ $post->title }}</h5>
            <p class="card-text">{{ \Str::limit($post->description, 50) }}.</p>
            <a href="{{ url('posts/' . $post->id) }}" class="btn btn-primary">Show Post</a>
        </div>
    </div>
</div>
@endforeach
@endsection
```

### 6.8 Dashboard View
Create `resources/views/dashboard.blade.php`:
```html
@extends('layout.app')
@section('content')
<div class="col-12">
    <a href="{{ url('posts/create') }}" class="btn btn-sm btn-primary float-start mb-2">Create New Post</a>
    <div class="clearfix"></div>
    <h1 class="p-3 border text-center mt-3">My Posts</h1>
</div>
@if (session()->get('success') != null)
<h3 class="text-success my-2">{{ session()->get('success') }}</h3>
@endif
<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Description</th>
            <th>Created At</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($posts as $post)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $post->title }}</td>
            <td>{{ \Str::limit($post->description, 50) }}</td>
            <td>{{ $post->created_at->format('Y-n-d') }}</td>
            <td>
                <a href="{{ url('posts/' . $post->id . '/edit') }}" class="btn btn-info">Edit</a>
            </td>
            <td>
                <form action="{{ url('posts/' . $post->id) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <input type="submit" value="Delete" class="btn btn-danger">
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div>
    {{ $posts->links() }}
</div>
@endsection
```

## Step 8: Seeding the Database

Edit `database/seeders/DatabaseSeeder.php`:
```php
<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        \App\Models\Post::factory()->count(100)->create();
    }
}
```

Run the seeder:
```bash
php artisan db:seed
```

## Step 9: Install Frontend Dependencies

```bash
npm install
npm run build
```

## Step 9: Run the Application

```bash
php artisan serve
```

Visit `http://127.0.0.1:8000` to see your Posts App!

## Features Implemented

1. **Home Page**: Displays all posts with pagination
2. **Posts Management**: CRUD operations for posts
3. **Search Functionality**: Search posts by description
4. **User Association**: Posts are linked to users
5. **Responsive Design**: Bootstrap-based UI
6. **Validation**: Form validation for creating and updating posts
7. **Flash Messages**: Success messages for user actions
8. **Admin Panel**: Admin dashboard for privileged users

## Additional Notes

- The `routes/auth.php` file contains all authentication routes provided by Laravel Breeze, including login, register, password reset, email verification, etc.
- The `AdminController` is implemented to handle admin dashboard access.
- Admin functionality includes an `is_admin` boolean column in the users table, `IsAdmin` middleware to protect admin routes, and a gate in `AuthServiceProvider` to check admin privileges.
- To assign admin privileges to a user, set the `is_admin` field to `true` (1) in the database.
- The dashboard view shows only the authenticated user's own posts, while the posts index displays all posts publicly.
- Ensure all migrations are run, including those for users, posts, and the admin column addition.
- The application uses Laravel Breeze for authentication scaffolding.

## Key Concepts Learned

- Laravel MVC Architecture
- Routing and Controllers
- Eloquent ORM and Relationships
- Blade Templating
- Form Validation
- Database Migrations and Seeders
- Pagination
- Bootstrap Integration

This guide provides a complete step-by-step walkthrough of building a Laravel posts application with full CRUD functionality.

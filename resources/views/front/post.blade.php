<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>posts</title>
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
        integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link>
    <link rel="stylesheet" href="{{ asset('assets/css/posts.css') }}">
</head>

<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-center row">
            <div class="col-md-8">
                <div class="d-flex flex-column comment-section">
                    <div class="bg-white p-2">
                        @foreach ($posts as $post)
                            <div class="d-flex flex-row user-info">
                                <div class="d-flex flex-column justify-content-start ml-2"><span
                                        class="d-block font-weight-bold name">{{ $post->title }}</span><span
                                        class="date text-black-50">Shared publicly - {{ $post->created_at }}</span>
                                </div>
                            </div>

                            <div class="mt-2 pl-2">
                                <p class="comment-text font-weight-bold">{{ $post->content }}</p>
                            </div>
                            <hr>
                            <div class="m-1">
                                All Comments
                                @foreach ($post->comments as $comment)
                                    <div>
                                        <p class="comment-text"> {{ $comment->content }} </p>
                                    </div>
                                @endforeach

                            </div>
                            <hr>
                            {{-- comments section --}}
                            <div class="bg-light p-2">
                                <form action="{{ route('front.posts.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                    <div class="d-flex flex-row align-items-start">
                                        <textarea class="form-control ml-1 shadow-none textarea" name="comment_content"></textarea>
                                    </div>
                                    <div class="mt-2 text-right">
                                        <button class="btn btn-primary btn-sm shadow-none" type="submit">Post
                                            comment</button>

                                    </div>
                                </form>

                            </div>
                        @endforeach





                    </div>
                </div>
            </div>
        </div>
</body>

</html>

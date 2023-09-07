@extends('layouts.frontend.app')

@section('title')
    {{ $movie->title }}
@endsection

@push('css')


    <link href="{{ asset('frontend') }}/single-post-2/css/styles.css" rel="stylesheet">

    <link href="{{ asset('frontend') }}/single-post-2/css/responsive.css" rel="stylesheet">

    <link href="{{ asset('backend/cloudinary_palyer/cld-video-player.min.css') }}" rel="stylesheet">

    <script src="{{ asset('backend/cloudinary_palyer/cloudinary-core-shrinkwrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('backend/cloudinary_palyer/cld-video-player.min.js') }}"type="text/javascript"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>

    <style>
        .favorite_posts{
            color: blue;
        }

        .social-btn-sp #social-links {
            margin: 0 auto;
            max-width: 500px;
        }
        .social-btn-sp #social-links ul li {
            display: inline-block;
        }
        .social-btn-sp #social-links ul li a {
            padding: 15px;
            border: 1px solid #ccc;
            margin: 1px;
            font-size: 30px;
        }
        #social-links{
            display: inline-table;
        }
        #social-links ul li{
            display: inline;
        }
        #social-links ul li a{
            padding: 5px;
            border: 1px solid #ccc;
            margin: 1px;
            font-size: 15px;
            background: #e3e3ea;
        }
    </style>
@endpush

@section('content')

    <div class="center-text">
        <img style="max-height: 400px; max-width: 1600px" src="{{ url('backend/upload/video/'.$movie->image) }}" class="img-fluid" alt="Responsive image">
    </div><!-- slider -->

    <section class="post-area">
        <div class="container">

            <div class="row">

                <div class="col-lg-1 col-md-0"></div>
                <div class="col-lg-10 col-md-12">

                    <div class="main-post">

                        <div class="post-top-area">

                            <h5 class="pre-title">
                                <a style="color: blue" href="{{ url('/') }}"><u><i>Home</i></u></a>
                                @if($movie->category)
                                    @if($movie->subcategory == null)
                                        <i> / <a style="color: blue" href="{{ route('videos',[$movie->category->id, $movie->category->slug]) }}"><u>{{ $movie->category->name }}</u></a></i>
                                     @else
                                        <i> / <a style="color: blue" href="{{ route('subcategory',[$movie->category->id, $movie->category->slug]) }}"><u>{{ $movie->category->name }}</u></a></i>
                                     @endif
                                @endif
                                @if($movie->subcategory)
                                    @if($movie->sub_subcategory == null)
                                        <i> / <a style="color: blue" href="{{ route('videos.subcategory',[$movie->subcategory->id, $movie->subcategory->slug]) }}"><u>{{ $movie->subcategory->name }}</u></a></i>
                                     @else
                                        <i> / <a style="color: blue" href="{{ route('sub.subcategory', [$movie->subcategory->id, $movie->subcategory->slug]) }}"><u>{{ $movie->subcategory->name }}</u></a></i>
                                    @endif
                                @endif
                                @if($movie->sub_subcategory)
                                    <i> / <a style="color: blue" href="{{ route('videos.sub.subcategory',[$movie->sub_subcategory->id, $movie->sub_subcategory->slug]) }}"><u>{{ $movie->sub_subcategory->name }}</u></a></i>
                                @endif
                            </h5>

                            <h3 class="title"><a href="javascript:void(0)">
                                    <b>{{ $movie->title }}</b>
                                </a>
                                </h3>

                            <div class="post-info">

                                <div class="left-area">
                                    <a class="avatar" href="javascript:void(0)"><img src="{{ asset('frontend') }}/images/avatar-1-120x120.jpg" alt="Profile Image"></a>
                                </div>

                                <div class="middle-area">
                                    <a class="name" href="javascript:void(0)"><b>Rony Islam</b></a>
                                    <h6 class="date">on {{ $movie->created_at }}</h6>
                                </div>

                            </div><!-- post-info -->

                           </div><!-- post-top-area -->

                        <div class="post-bottom-area">

                            <div class="para">{!! $movie->description !!}</div>

                            <div class="text-center">
                                <video
                                    id="example-player"
                                    controls
                                    width="320px"
                                    class="cld-video-player cld-video-player-skin-dark"
                                    data-cld-public-id="{{ $movie->video_public_id }}">
                                </video>
                            </div>

                            <ul class="tags">
                                @foreach($categories as $category)
                                <li>
                                    @if($category->subcategories->count() != 0)
                                        <a href="{{ route('subcategory',[$category->id,$category->slug]) }}">{{ $category->name }}</a>
                                    @else
                                        <a href="{{ route('videos',[$category->id,$category->slug]) }}">{{ $category->name }}</a>
                                    @endif
                                </li>
                                @endforeach
                            </ul>

                            <div class="post-icons-area">
                                <ul class="post-icons">
                                    <li><a href="{{ route('user.favorite', $movie->id) }}"><i class="ion-heart {{ Auth::check() && Auth::user()->FavoritePosts->where('movie_id', $movie->id)->count() != 0 ? 'favorite_posts' : ''  }}"></i>{{ $movie->favorites->count() }}</a></li>
                                    <li><a href="javascript:void(0)"><i class="ion-chatbubble"></i>{{ $comment_count }}</a></li>
                                    <li><a href="javascript:void(0)"><i class="ion-eye"></i>{{ $movie->view_count }}</a></li>
                                </ul>

                                <ul class="icons">
                                    <li>SHARE : </li>
                                    {!! $shareButtons !!}
                                </ul>
                            </div>


                        </div><!-- post-bottom-area -->

                    </div><!-- main-post -->
                </div><!-- col-lg-8 col-md-12 -->
            </div><!-- row -->
        </div><!-- container -->
    </section><!-- post-area -->


    <section class="recomended-area section">
        <div class="container">
            <div class="row">

                @php
                if ($movie->sub_subcategory != null){
                    $related_posts = \App\Models\Movie::with('favorites', 'comment_count')->where(['sub_subcategory_id' => $movie->sub_subcategory_id, 'video_status' => 'Complete', 'active_status' => 1])->where('id', '!=', $movie->id)->get();
                }elseif ($movie->subcategory != null){
                    $related_posts = \App\Models\Movie::with('favorites', 'comment_count')->where(['subcategory_id' => $movie->subcategory_id, 'video_status' => 'Complete', 'active_status' => 1])->where('id', '!=', $movie->id)->get();
                }else{
                    $related_posts = \App\Models\Movie::with('favorites', 'comment_count')->where(['category_id' => $movie->category_id, 'video_status' => 'Complete', 'active_status' => 1])->where('id', '!=', $movie->id)->get();
                }
                @endphp

                @foreach($related_posts as $post)
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100">
                        <div class="single-post post-style-1">

                            <div class="blog-image"><img src="{{ url('backend/upload/video/'.$post->image) }}" alt="Blog Image"></div>

                            <a class="avatar" href="#"><img src="{{ asset('frontend') }}/images/icons8-team-355979.jpg" alt="Profile Image"></a>

                            <div class="blog-info">

                                <h4 class="title"><a href="{{ route('video.details',[$post->id, $post->slug]) }}"><b>{{ $post->title }}</b></a></h4>

                                <ul class="post-footer">
                                    <li><a href="{{ route('user.favorite', $post->id) }}"><i class="ion-heart
                                     <?php
                                            foreach ($post->favorites as $favorite){
                                            if ($favorite->user_id == isset(Auth::user()->id)){ ?>
                                                favorite_posts
                                            <?php }
                                            }
                                            ?>
                                                "></i>{{ $post->favorites->count() }}</a></li>
                                    <li><a href="#"><i class="ion-chatbubble"></i>{{ $post->comment_count->count() }}</a></li>
                                    <li><a href="#"><i class="ion-eye"></i>{{ $post->view_count }}</a></li>
                                </ul>

                            </div><!-- blog-info -->
                        </div><!-- single-post -->
                    </div><!-- card -->
                </div><!-- col-md-6 col-sm-12 -->
                @endforeach

            </div><!-- row -->

        </div><!-- container -->
    </section>

    <section class="comment-section center-text">
        <div class="container">
            <h4><b>POST COMMENT</b></h4>
            <div class="row">

                <div class="col-lg-2 col-md-0"></div>

                <div class="col-lg-8 col-md-12">
                    <div class="comment-form">
                        @if(Auth::check())
                            <form  action="{{ route('user.comment.store', $movie->id) }}" method="post">
                                @csrf
                                <div class="col-sm-12">
                                    <textarea name="comment" rows="2" required class="text-area-messge form-control" placeholder="Enter your comment" aria-required="true" aria-invalid="false"></textarea >
                                    <span style="color: red">{{ $errors->has('comment') ? $errors->first('comment') : '' }}</span>
                                </div><!-- col-sm-12 -->
                                <div class="col-sm-12">
                                    <button class="submit-btn" type="submit" id="form-submit"><b>POST COMMENT</b></button>
                                </div><!-- col-sm-12 -->
                            </form>
                        @else
                            <p>For post a new comment. You need to login first. <a style="color: blue" href="{{ route('login') }}"><i><u>Login</u></i></a></p>
                        @endif

                    </div><!-- comment-form -->

                    <h4><b>COMMENTS({{ $comment_count }})</b></h4>

                    <div class="commnets-area text-left">
                        @forelse($movie->comments as $comment)
                        <div class="comment">

                            <div class="post-info">

                                <div class="left-area">
                                    <a class="avatar" href="javascript:void(0)"><img src="{{  url('backend/upload/users/'.$comment->user->image) }}" alt="{{ $comment->user->name }}"></a>
                                </div>

                                <div class="middle-area">
                                    <a class="name" href="javascript:void(0)"><b>{{ $comment->user->name }}</b></a>
                                    <h6 class="date">on {{ $comment->created_at }}</h6>
                                </div>

                                <div class="right-area">
                                    <button class="btn-reply text-uppercase" id="reply-btn" onclick="showReplyForm('{{$comment->id}}','{{$comment->user->name}}')">reply</button>
                                </div>

                            </div><!-- post-info -->

                            <div>{{$comment->comment }}</div><br>

                            <div class="col-md-10 offset-1">
                                @if($comment->replies->count() > 0)
                                    @foreach ($comment->replies as $reply)


                                        <div class="post-info">

                                            <div class="left-area">
                                                <a class="avatar" href="javascript:void(0)"><img src="{{  url('backend/upload/users/'.$reply->user->image) }}" alt="{{ $comment->user->name }}"></a>
                                            </div>

                                            <div class="middle-area">
                                                <a class="name" href="javascript:void(0)"><b>{{ $reply->user->name }}</b></a>
                                                <h6 class="date">on {{ $reply->created_at }}</h6>
                                            </div>

                                            <div class="right-area">
                                                <button class="btn-reply text-uppercase" id="reply2-btn" onclick="showReply2Form('{{$reply->id}}','{{$reply->user->name}}')">reply</button>
                                            </div>

                                        </div><!-- post-info -->

                                        <p>{{$reply->comment }}</p>

                                        <br>
                                        <!-- Reply2 filed -->
                                        <div style="display: none" class="reply2" id="reply2-form-{{$reply->id}}">
                                            <form  action="{{ route('user.comment.reply.store', [$movie->id, $comment->id]) }}" method="post">
                                                @csrf
                                                <div class="col-sm-12">
                                                    <textarea name="comment" id="reply2-form-{{$reply->id}}-text" rows="2" required class="form-control" placeholder="Enter your reply" aria-required="true" aria-invalid="false"></textarea >
                                                    <span style="color: red">{{ $errors->has('comment') ? $errors->first('comment') : '' }}</span>
                                                </div><!-- col-sm-12 -->
                                                <div class="col-sm-12">
                                                    <button class="btn btn-sm btn-info" type="submit" id="form-submit"><b>Reply</b></button>
                                                </div><!-- col-sm-12 -->
                                            </form>
                                        </div>
                                    @endforeach
                                @endif

                                <!-- Reply filed -->
                                <div style="display: none" class="reply1" id="reply-form-{{$comment->id}}">
                                    <form  action="{{ route('user.comment.reply.store', [$movie->id, $comment->id]) }}" method="post">
                                        @csrf
                                        <div class="col-sm-12">
                                            <textarea name="comment" id="reply-form-{{$comment->id}}-text" rows="2" required class="form-control" placeholder="Enter your reply" aria-required="true" aria-invalid="false"></textarea >
                                            <span style="color: red">{{ $errors->has('comment') ? $errors->first('comment') : '' }}</span>
                                        </div><!-- col-sm-12 -->
                                        <div class="col-sm-12">
                                            <button class="btn btn-sm btn-info" type="submit" id="form-submit"><b>Reply</b></button>
                                        </div><!-- col-sm-12 -->
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                            <div class="comment">

                                <div class="post-info">

                                    <div class="middle-area">
                                      <b>Comment not found :(</b>
                                    </div>
                                </div><!-- post-info -->


                            </div>
                        @endforelse
{{--                        <a class="more-comment-btn" href="#"><b>VIEW MORE COMMENTS</b></a>--}}

                </div><!-- col-lg-8 col-md-12 -->

            </div><!-- row -->

        </div><!-- container -->
    </section>


@endsection

@push('js')
    <!-- cloudinary show video </body> -->
    <script>
        var cld = cloudinary.Cloudinary.new({ cloud_name: 'rony-islam' });
        var player = cld.videoPlayer('example-player');
    </script>

    <script>
        function showReplyForm(comment_id, user_name) {
            var x = document.getElementById('reply-form-'+comment_id);
            var input = document.getElementById('reply-form-'+comment_id+'-text');

            if (x.style.display === "none") {
                $('.reply1').hide();
                x.style.display = "block";
                input.innerText='@'+user_name+' ';
                $('.reply2').hide();
            } else {
                x.style.display = "none";
            }
        }

        function showReply2Form(comment_id, user_name) {
            var x = document.getElementById('reply2-form-'+comment_id);
            var input = document.getElementById('reply2-form-'+comment_id+'-text');

            if (x.style.display === "none") {
                $('.reply2').hide();
                x.style.display = "block";
                input.innerText='@'+user_name+' ';
                $('.reply1').hide();
            } else {
                x.style.display = "none";
            }

        }
    </script>


@endpush

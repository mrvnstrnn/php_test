@extends('layouts.app')

@section('content')

        <div class="container">
            <h1 class="mt-4">{{ $user->name }}</h1>
            <h4 class="mt-4">{{ $user->email }}</h4>
    
            <div class="post_lists">
                @forelse ($posts as $post)
                    <div class="row justify-content-center mt-3">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-dark text-white">
                                    {{ $post->name }}<br>
                                    <small>{{ date('M d, Y', strtotime($post->created_at)); }} at {{ date('h:m:s', strtotime($post->created_at)); }}</small>
                                </div>
                
                                <div class="card-body">
                                    <h4 class="card-title">{{ $post->title }}</h4>
                                    <p class="card-text">{{ $post->paragraph }}</p>
                                </div>

                                <div class="card-footer">
                                    <button type="button" class="btn btn-primary" onclick="approve_reject({{ $post->id }}, 'approve')">Approve</button>
                                    <button type="button" class="btn btn-danger" onclick="approve_reject({{ $post->id }}, 'reject')">Reject</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="card p-5">
                                <h3 class="text-center">Post not yet available.</h3>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
@endsection

@section('scripts')
    <script>
        function approve_reject (id, action){
            $(this).attr("disabled");
            $(this).text("Processing...");
            $.ajax({
                url: "{{ route('approve_reject') }}",
                method: "POST",
                data: {
                    action : action,
                    id : id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (resp) {
                    
                    if (!resp.error) {
                        alert(resp.message);
                        $(".post_lists").load(location.href + " .post_lists");
                    } else {
                        alert(resp.message);
                    }
                    $(".post_status").removeAttr("disabled");
                    $(".post_status").text("Post");
                },
                error: function (resp) {
                    alert(resp);
                }
            })
        }
    </script>
@show
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-dark text-white">{{ __('My Component') }}</div>

            <div class="card-body">
                <form id="post_status_form">

                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control">
                        <small id="title-error" class="text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label for="paragraph">Paragraph</label>
                        <textarea name="paragraph" id="paragraph" cols="30" rows="10" class="form-control"></textarea>
                        <small id="paragraph-error" class="text-danger"></small>
                    </div>

                    <button type="button" class="btn btn-primary mt-2" onclick="post_status()">Post</button>
                </form>
            </div>
        </div>
    </div>
</div>

<h1 class="text-center mt-4">Approved Posts</h1>

<div class="post_lists">
    @forelse ($posts as $post)
        <div class="row justify-content-center mt-3">
            <div class="col-md-8">
                <div class="card">
                    @php
                        $header = "bg-dark";
                        $badge = "Pending";

                        if ( $post->status == 0) {
                            $header = "bg-warning";
                            $badge = "Pending";
                        } else if ( $post->status == 1) {
                            $header = "bg-success";
                            $badge = "Approved";
                        } else if ( $post->status == 2) {
                            $header = "bg-danger";
                            $badge = "Rejected";
                        }

                    @endphp
                    <div class="card-header text-white {{ $header }}">
                        {{ $post->name }}<br>
                        <small>{{ date('M d, Y', strtotime($post->created_at)); }} at {{ date('h:m:s', strtotime($post->created_at)); }}</small>
                        <br>
                        <span class="badge badge-primary bg-dark">
                            {{ $badge }}
                        </span>
                    </div>
    
                    <div class="card-body">
                        <h4 class="card-title">{{ $post->title }}</h4>
                        <p class="card-text">{{ $post->paragraph }}</p>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card p-5">
                    <h3 class="text-center">Post not yet available.</h3>
                </div>
            </div>
        </div>
    @endforelse
</div>

@section('scripts')

    <script>
        function post_status () {
            $(this).attr("disabled");
            $(this).text("Processing...");

            $("#post_status_form small").text("");
            $.ajax({
                url: "{{ route('post_status') }}",
                method: "POST",
                data: $("#post_status_form").serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (resp) {
                    if (!resp.error) {
                        $("#post_status_form")[0].reset();
                        alert(resp.message);

                        $(".post_lists").load(location.href + " .post_lists");

                    } else {
                        if (typeof resp.message === 'object' && resp.message !== null) {
                            $.each(resp.message, function(index, data) {
                                $("#post_status_form #" + index + "-error").text(data);
                            });
                        } else {
                            alert(resp.message);
                        }
                    }
                    $(".post_status").removeAttr("disabled");
                    $(".post_status").text("Post");
                },
                error: function (resp) {
                    alert(resp);
                    $(".post_status").removeAttr("disabled");
                    $(".post_status").text("Post");
                }
            });
        }
    </script>
@show
<!DOCTYPE html>
<html>
<head>
    <title>Laravel jQuery CRUD</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
<div class="container">
    <h2>Laravel jQuery CRUD</h2>
    <form id="postForm">
        <div class="form-group">
            <label>Title:</label>
            <input type="text" class="form-control" name="title" required>
        </div>
        <div class="form-group">
            <label>Body:</label>
            <textarea class="form-control" name="body" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <div id="postsList"></div>
</div>
<script>
    $(document).ready(function() {
        // AJAX Setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Fetch Posts
        fetchPosts();

        // Submit Form
        $('#postForm').on('submit', function(e) {
            e.preventDefault();
            let formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: '/posts',
                data: formData,
                success: function(response) {
                    fetchPosts();
                    $('#postForm')[0].reset();
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        // Fetch Posts Function
        function fetchPosts() {
            $.ajax({
                type: 'GET',
                url: '/posts/fetchPosts',
                success: function(response) {
                    $('#postsList').empty();
                    response.forEach(function(post) {
                        $('#postsList').append(
                            `<div class="post" data-id="${post.id}">
                                    <h4>${post.title}</h4>
                                    <p>${post.body}</p>
                                    <button class="btn btn-primary edit-post">Edit</button>
                                    <button class="btn btn-danger delete-post">Delete</button>
                                </div>`
                        );
                    });
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        // Delete Post
        $(document).on('click', '.delete-post', function() {
            let postId = $(this).parent().data('id');
            $.ajax({
                type: 'DELETE',
                url: `/posts/${postId}`,
                success: function(response) {
                    fetchPosts();
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        // Edit Post
        $(document).on('click', '.edit-post', function() {
            let post = $(this).parent();
            let postId = post.data('id');
            let postTitle = post.find('h4').text();
            let postBody = post.find('p').text();

            $('#postForm').find('input[name="title"]').val(postTitle);
            $('#postForm').find('textarea[name="body"]').val(postBody);
            $('#postForm').append(`<input type="hidden" name="post_id" value="${postId}">`);
            $('#postForm').find('button[type="submit"]').text('Update');
        });

        // Update Post
        $('#postForm').on('submit', function(e) {
            e.preventDefault();
            let postId = $(this).find('input[name="post_id"]').val();
            if (postId) {
                let formData = $(this).serialize();
                $.ajax({
                    type: 'PUT',
                    url: `/posts/${postId}`,
                    data: formData,
                    success: function(response) {
                        fetchPosts();
                        $('#postForm')[0].reset();
                        $('#postForm').find('input[name="post_id"]').remove();
                        $('#postForm').find('button[type="submit"]').text('Submit');
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        });
    });
</script>
</body>
</html>

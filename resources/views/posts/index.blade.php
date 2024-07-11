<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div class="container mt-4">
    <h2>Post List</h2>
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#postModal">Add New Post</button>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Body</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody id="postsList">
        <!-- Posts will be injected here by JavaScript -->
        </tbody>
    </table>
</div>

<!-- Modal for Add/Edit Post -->
<div class="modal fade" id="postModal" tabindex="-1" role="dialog" aria-labelledby="postModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="postModalLabel">Add New Post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="postForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="body">Body</label>
                        <textarea class="form-control" id="body" name="body" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="file">Image</label>
                        <input type="file" class="form-control" id="file" name="file">
                    </div>
                    <input type="hidden" name="post_id">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        // AJAX Setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Fetch Posts
        function fetchPosts() {
            $.ajax({
                type: 'GET',
                url: '/posts/fetchPosts',
                success: function(response) {
                    $('#postsList').empty();
                    if (response.length === 0) {
                        $('#postsList').append('<tr><td colspan="5" class="text-center">No posts available</td></tr>');
                    } else {
                        response.forEach(function(post) {
                            $('#postsList').append(
                                `<tr data-id="${post.id}">
                                        <td>${post.id}</td>
                                        <td>${post.title}</td>
                                        <td>${post.body}</td>
                                        <td><img src="{{ asset('storage/' . '${post.image_path}') }}" alt="Image" width="50"></td>
                                        <td>
                                            <button class="btn btn-warning btn-sm edit-post">Edit</button>
                                            <button class="btn btn-danger btn-sm delete-post">Delete</button>
                                        </td>
                                    </tr>`
                            );
                        });
                    }
                },
                error: function(error) {
                    console.log('Error fetching posts:', error);
                }
            });
        }

        // Call fetchPosts on page load
        fetchPosts();

        // Submit Form
        $('#postForm').on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);  // Create FormData object to handle file uploads
            let postId = $('input[name="post_id"]').val();

            if (postId) {
                // Update Post
                $.ajax({
                    type: 'POST',  // Change this to POST for updating
                    url: `/posts/${postId}`,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        fetchPosts();
                        $('#postModal').modal('hide');
                        $('#postForm')[0].reset();
                        $('input[name="post_id"]').val('');
                        $('button[type="submit"]').text('Submit');
                        $('#postModalLabel').text('Add New Post');  // Reset modal title for creating
                    },
                    error: function(error) {
                        console.log('Error updating post:', error);
                    }
                });
            } else {
                // Create Post
                $.ajax({
                    type: 'POST',
                    url: '/posts',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        fetchPosts();
                        $('#postModal').modal('hide');
                        $('#postForm')[0].reset();
                    },
                    error: function(error) {
                        console.log('Error creating post:', error);
                    }
                });
            }
        });

        // Edit Post
        $(document).on('click', '.edit-post', function() {
            let postId = $(this).closest('tr').data('id');
            $.ajax({
                type: 'GET',
                url: `/posts/${postId}`,
                success: function(response) {
                    $('#title').val(response.title);
                    $('#body').val(response.body);
                    $('input[name="post_id"]').val(response.id);
                    $('button[type="submit"]').text('Update');
                    $('#postModalLabel').text('Edit Post');  // Change modal title for editing
                    $('#postModal').modal('show');
                },
                error: function(error) {
                    console.log('Error fetching post details:', error);
                }
            });
        });

        // Delete Post
        $(document).on('click', '.delete-post', function() {
            let postId = $(this).closest('tr').data('id');
            if (confirm('Are you sure you want to delete this post?')) {
                $.ajax({
                    type: 'DELETE',
                    url: `/posts/${postId}`,
                    success: function(response) {
                        fetchPosts();
                    },
                    error: function(error) {
                        console.log('Error deleting post:', error);
                    }
                });
            }
        });
    });
</script>
</body>
</html>

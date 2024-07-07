<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel jQuery CRUD</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <style>
        .post-card {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <h2>Laravel jQuery CRUD</h2>

    <!-- Button to Open the Modal -->
    <button type="button" class="btn btn-primary mb-4" data-toggle="modal" data-target="#postModal">Add New Post</button>

    <!-- Table for Displaying Posts -->
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Body</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody id="postsList">
            <!-- Posts will be inserted here by jQuery -->
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="postModal" tabindex="-1" role="dialog" aria-labelledby="postModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="postModalLabel">Add New Post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="postForm">
                    <input type="hidden" name="post_id">
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" id="title" class="form-control" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="body">Body:</label>
                        <textarea id="body" class="form-control" name="body" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
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
        function fetchPosts() {
            $.ajax({
                type: 'GET',
                url: '/posts/fetchPosts',
                success: function(response) {
                    $('#postsList').empty();
                    if (response.length === 0) {
                        $('#postsList').append('<tr><td colspan="4" class="text-center">No posts available</td></tr>');
                    } else {
                        response.forEach(function(post) {
                            $('#postsList').append(
                                `<tr data-id="${post.id}">
                                        <td>${post.id}</td>
                                        <td>${post.title}</td>
                                        <td>${post.body}</td>
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
            let formData = $(this).serialize();
            let postId = $('input[name="post_id"]').val();

            if (postId) {
                // Update Post
                $.ajax({
                    type: 'PUT',
                    url: `/posts/${postId}`,
                    data: formData,
                    success: function(response) {
                        fetchPosts();
                        $('#postModal').modal('hide');
                        $('#postForm')[0].reset();
                        $('input[name="post_id"]').val('');
                        $('button[type="submit"]').text('Submit');
                        $('#postModalLabel').text('Add New Post'); // Reset modal title for creating
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

        // Delete Post
        $(document).on('click', '.delete-post', function() {
            let postId = $(this).closest('tr').data('id');
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
        });

        // Edit Post
        $(document).on('click', '.edit-post', function() {
            let post = $(this).closest('tr');
            let postId = post.data('id');
            let postTitle = post.find('td:nth-child(2)').text();
            let postBody = post.find('td:nth-child(3)').text();

            $('#title').val(postTitle);
            $('#body').val(postBody);
            $('input[name="post_id"]').val(postId);
            $('button[type="submit"]').text('Update');
            $('#postModalLabel').text('Edit Post'); // Change modal title for editing
            $('#postModal').modal('show');
        });

        // Open Modal for Creating a New Post
        $('#postModal').on('show.bs.modal', function () {
            $('button[type="submit"]').text('Submit');
            $('#postModalLabel').text('Add New Post'); // Reset modal title
            $('input[name="post_id"]').val('');
            $('#postForm')[0].reset();
        });
    });
</script>
</body>
</html>

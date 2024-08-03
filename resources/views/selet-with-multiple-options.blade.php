<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Belgilash</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 60px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

<button id="openModal" class="btn btn-primary">Open Modal</button>

<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Agent belgilash</h2>
        <form>
            <div class="form-group">
                <label for="agents">AGENTLARNI TANLANG</label>
                <select id="agents" name="agents[]" class="selectpicker" multiple data-live-search="true" title="Select agents">
                    <option value="agent1">Agent 1</option>
                    <option value="agent2">Agent 2</option>
                    <option value="agent3">Agent 3</option>
                    <option value="agent4">Agent 4</option>
                    <option value="agent5">Agent 5</option>
                </select>
            </div>
            <div class="form-group">
                <label for="services">SERVISLAR</label>
                <input type="checkbox" id="service1" name="service1" value="test">
                <label for="service1"> test servis</label>
            </div>
            <button type="button" onclick="submitForm()" class="btn btn-primary">Saqlash</button>
            <button type="button" class="close btn btn-secondary">Yopish</button>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#openModal').click(function() {
            $('#myModal').show();
        });

        $('.close').click(function() {
            $('#myModal').hide();
        });

        $(window).click(function(event) {
            if (event.target == document.getElementById('myModal')) {
                $('#myModal').hide();
            }
        });

        $('.selectpicker').selectpicker();
    });

    function submitForm() {
        // Add your form submission logic here
        alert('Form submitted!');
        $('#myModal').hide();
    }
</script>

</body>
</html>

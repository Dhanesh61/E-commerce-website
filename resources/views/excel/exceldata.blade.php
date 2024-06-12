<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DK Brothers</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        #fileInput {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }

        .btn-submit {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn-submit:hover {
            background-color: #0056b3;
        }

        .success-message {
            color: green;
            font-size: 14px;
            margin-top: 5px;
        }

        .back-link {
            color: #007bff;
            text-decoration: none;
            margin-bottom: 20px;
            display: inline-block;
            font-size: 14px;
            text-align: left;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js"></script>
</head>

<body>
    <div class="container">
        <a href="/home" class="back-link"><i class="fas fa-arrow-left"></i> Back To Home</a>
        <h2>Upload Excel File</h2>
        <form id="uploadForm" action="{{ route('excel.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="fileInput">Choose File:</label>
                <input type="file" name="file" id="fileInput">
                <div class="error" id="fileInput-error"></div>
            </div>
            <button type="submit" class="btn-submit">Submit</button>
            @if(session('success'))
                <div class="success-message">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="error">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                </div>
            @endif
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $('#uploadForm').validate({
                rules: {
                    file: {
                        required: true,
                    }
                },
                messages: {
                    file: {
                        required: "Please select a file",
                    }
                },
                errorPlacement: function(error, element) {
                    error.appendTo(element.parent().find('.error'));
                }
            });
        });
    </script>
</body>

</html>

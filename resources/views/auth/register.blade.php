    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Register</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <style>
        
            body {
                background-size: cover;
                background-color: #f3f4f6; 
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
                font-family: Arial, sans-serif;
            }

            .form-container {
                background-color: #ffffff; 
                border-radius: 20px; 
                padding: 40px;
                box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1); 
                max-width: 400px;
                width: 100%;
                box-sizing: border-box;
            }

            .form-title {
                font-size: 24px;
                font-weight: bold;
                text-align: center;
                margin-bottom: 30px;
            }

            .input-container {
                margin-bottom: 20px;
                position: relative;
            }

            .input-field {
                width: 100%;
                padding: 12px;
                border-radius: 8px;
                border: 1px solid #ccc;
                box-sizing: border-box;
                transition: border-color 0.3s ease;
            }

            .input-field:focus {
                outline: none;
                border-color: #4a90e2; 
            }

            .error-message {
                color: red;
                margin-top: 5px;
                font-size: 14px;
            }

            .submit-button {
                background-color: #4a90e2;
                color: #ffffff; 
                border: none;
                border-radius: 8px;
                padding: 12px;
                width: 100%;
                cursor: pointer;
                transition: background-color 0.3s ease;
                margin-top: 10px;
            }

            .submit-button:hover {
                background-color: #357bd8; 
            }

            .already-registered {
                text-align: center;
                margin-top: 10px;
            }

            .already-registered a {
                color: #4a90e2; 
                text-decoration: none;
                transition: color 0.3s ease;
            }

            .already-registered a:hover {
                color: #357bd8; 
            }

            .toggle-password {
                position: absolute;
                top: 50%;
                right: 10px;
                transform: translateY(-50%);
                background: none;
                border: none;
                cursor: pointer;
            }
            .register-icon{
                color: darkgray;
            }

            .generate-password-button{
                margin-left: 65px;
                padding: 8px 12px;
                border-radius: 8px;
                background-color: #1f8004;
                color: #ffffff;
                border: none;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            .generate-password-button:hover {
                background-color: #22df0d; 
            }

            .google-login {
                background-color: black;
                border: none;
                color: white;
                border-radius: 8px;
                padding: 0px;
                width: 100%;
                cursor: pointer;
                text-align: center;
                margin-top: 20px;
                transition: background-color 0.3s ease;
                text-decoration: none; 
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .google-login:hover {
                background-color:#333;
            }

            .google-icon {
                margin-right: 10px; 
            }

            .login-icon {
                color: slategray;
                font-size: 32px;
                margin-bottom: 20px;
            }

            .svg-inline--fa.fa-w-16 {
                width: 2em;
                color: black;
            }

            svg:not(:root).svg-inline--fa {
                overflow: visible;
                margin-block-end: -1px;
            }

            .line-container {
                display: flex;
                align-items: center;
                justify-content: center;
                margin-top: 20px;
                margin-bottom: 20px;
            }

            .line {
                height: 1px;
                background-color: #ccc;
                width: 40%; 
            }

            .line-text {
                margin-left: 10px;
                margin-right: 10px;
                color: black;
            }

            p{
                text-align: center;
            }

            .generate-password-button {
                background-color: #1f8004;
                color: #ffffff;
                border: none;
                border-radius: 8px;
                padding: 8px;
                width: 65%;
                cursor: pointer;
                transition: background-color 0.3s ease;
                margin-left: 55px;
            }

            .generate-password-button:hover {
                background-color: #22df0d;
            }

            .generate-password-button i {
                margin-right: 5px; 
            }

            .fa-envelope{
                margin-right: -7px;
            }

            .img-google {
                width: 20px;
                height: 20px;
                margin: 7px;
                background-color: white;
                border-radius: 50%;
                padding: 5px;
            }

            .loader {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border: 8px solid #f3f3f3;
            border-top: 8px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999; 
            display: none; 
        }
        </style>
    </head>
    <body style="background-image: url('dist/img/red.jpg');">
        <div class="form-container">
            <div class="form-title"><i class="fas fa-user-plus register-icon"></i> Registration</div>
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="input-container">
                    <input id="name" type="text" name="name" class="input-field" placeholder="Name" value="{{ old('name') }}"  autofocus>
                    <button type="button" class="toggle-password">
                        <i class="fas fa-user"></i>
                    </button>
                    @error('name')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-container">
                    <input id="email" type="email" name="email" class="input-field" placeholder="Email" value="{{ old('email') }}" >
                    <button type="button" class="toggle-password">
                        <i class="fas fa-envelope"></i>
                    </button>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-container">
                    <input id="password" type="password" name="password" class="input-field" placeholder="Password" >
                    <button type="button" class="toggle-password" onclick="togglePasswordVisibility()">
                        <i class="fas fa-eye"></i>
                    </button>
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-container">
                    <input id="password_confirmation" type="password" name="password_confirmation" class="input-field" placeholder="Confirm Password" >
                    @error('password_confirmation')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <button type="button" class="generate-password-button"><i class="fas fa-key"></i> Auto Generate Password</button>

                <button type="submit" class="submit-button">Register</button>

                <div class="line-container">
                    <div class="line"></div>
                    <span class="line-text"><b>Or</b></span>
                    <div class="line"></div>
                </div>

                <a href="{{ route('google.login') }}" class="google-login">
                    <img src="dist/img/google.jpg" alt="DK" class="img-google"> Login with Google
                </a>
            </form>
            <div class="overlay">
                <div class="loader"></div>
            </div>
            
            <div class="already-registered">
                <a href="{{ route('login') }}">Already registered?</a>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
        <script>
            function togglePasswordVisibility() {
                var passwordField = document.getElementById("password");
                var icon = document.querySelector(".toggle-password i");

                if (passwordField.type === "password") {
                    passwordField.type = "text";
                    icon.classList.remove("fa-eye");
                    icon.classList.add("fa-eye-slash");
                } else {
                    passwordField.type = "password";
                    icon.classList.remove("fa-eye-slash");
                    icon.classList.add("fa-eye");
                }
            }

            document.addEventListener("DOMContentLoaded", function () {
            var form = document.querySelector("form");
            var overlay = document.querySelector(".overlay");

            form.addEventListener("submit", function () {
                overlay.style.display = "block";
            });
        });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var passwordField = document.getElementById('password');
                var generatePasswordButton = document.querySelector('.generate-password-button');
                generatePasswordButton.addEventListener('click', function() {
                    var generatedPassword = generateRandomPassword(10); 
                    passwordField.value = generatedPassword;
                });
        
                function generateRandomPassword(length) {
                    var charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+~`|}{[]\:;?><,./-=";
                    var password = "";
                    for (var i = 0; i < length; i++) {
                        var charIndex = Math.floor(Math.random() * charset.length);
                        password += charset[charIndex];
                    }
                    return password;
                }
            });
        </script>
    </body>
    </html>

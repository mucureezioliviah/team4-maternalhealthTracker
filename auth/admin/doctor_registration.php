<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New User</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h2>Register New User</h2>
    <form id="user-form">
        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName" required><br>

        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <label for="type">User Type:</label>
        <select id="type" name="type">
            <option value="2">Doctor</option>
            <option value="1">Admin</option>
        </select><br>

        <button type="submit">Register</button>
    </form>

    <p id="message"></p>

    <script>
        $(document).ready(function() {
            $('#user-form').submit(function(event) {
                event.preventDefault();
                $.ajax({
                    url: '../ajax/ajax.php?action=save_user',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response == 1) {
                            $('#message').text('User added successfully!').css('color', 'green');
                            $('#user-form')[0].reset();
                        } else {
                            $('#message').text('Failed to add user.').css('color', 'red');
                        }
                    },
                    error: function() {
                        $('#message').text('Error in request.').css('color', 'red');
                    }
                });
            });
        });
    </script>
</body>
</html>

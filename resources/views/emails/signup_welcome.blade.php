<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp/Create User</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #F4F4F4;">
    <div style="max-width: 600px; margin: auto; background-color: #FFFFFF; border: 1px solid #DDDDDD;">
        <div style="background-color: red; color: white; padding: 20px; text-align: center;">
            <h2 style="max-width: 100%;"> Superior Crane Notification</h2>
        </div>
        <div style="padding: 20px;">
            <h2 style="color: #333333;">Hi {{@$user}},</h2>
            <p style="color: #555555;">{{@$text1}}</p>
            <p style="color: #555555;">
                Details:<br>
                -Username: {{@$username}}<br>
                -Email: {{@$email}}<br>
                @if(@$password)
                -Password: {{@$password}}<br>
                @endif
                -Role: {{@$role}}<br>
                @if(@$status)
                -Status: {{@$status}}<br>
                @endif
            </p>
            @if(@$text2)
            <p style="color: #555555;">{{@$text2}}</p>
            @endif
            
            <p style="color: #555555;">Best regards,<br>Admin Team</p>
        </div>
        <div style="background-color: #F4F4F4; padding: 10px; text-align: center; color: #999999;">
            &copy; {{ date('Y') }} Superior Crane. All rights reserved.
        </div>
    </div>
</body>
</html>

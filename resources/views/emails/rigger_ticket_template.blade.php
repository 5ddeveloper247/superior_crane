<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rigger Ticket Email</title>
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
                <b>-Job Number:</b> {{@$job_number}}<br>
                <b>-Ticket Number:</b> {{@$rigger_number}}<br>
                <b>-Ticket Submitted By:</b> {{@$rigger_name}}<br>
                <b>-Assigned Users:</b> {{@$assigned_user_names}}<br>

                <b>-Customer Name:</b> {{@$customer_name}}<br>
                <b>-Location:</b> {{@$location}}<br>
                <b>-Po Number:</b> {{@$po_number}}<br>
                <b>-Ticket Date:</b> {{@$ticket_date}}<br>
                <b>-Start Time:</b> {{@$start_time}}<br>
                <b>-End Time:</b> {{@$finish_time}}<br>
                @if(@$status != '')
                    <b>-Status:</b> {{@$status}}<br>
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

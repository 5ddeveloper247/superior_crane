<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transporter Ticket Email</title>
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
                <b>-Ticket Number:</b> {{@$ticket_number}}<br>
                <b>-Ticket Submitted By:</b> {{@$transporter_name}}<br>
                <b>-Assigned Users:</b> {{@$assigned_user_names}}<br>

                <b>-Pickup Address:</b> {{@$pickup_address}}<br>
                <b>-Delivery Address:</b> {{@$delivery_address}}<br>
                <b>-Po Number:</b> {{@$po_number}}<br>
                <b>-Ticket Date:</b> {{@$ticket_date}}<br>
                <b>-Time In:</b> {{@$time_in}}<br>
                <b>-Time Out:</b> {{@$time_out}}<br>
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

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,minimum-scale=1">
    <title>{{ $title }}</title>
</head>

<body
    style="background-color:#F5F6F8;font-family:-apple-system, BlinkMacSystemFont, 'segoe ui', roboto, oxygen, ubuntu, cantarell, 'fira sans', 'droid sans', 'helvetica neue', Arial, sans-serif;box-sizing:border-box;font-size:16px;">
    <div style="background-color:#fff;margin:0px;box-sizing:border-box;font-size:16px;">
        <h1 style="padding:40px;box-sizing:border-box;font-size:24px;color:#ffffff;background-color:#445aba;margin:0;">
            {{ $title }}</h1>
        <p style="padding:40px 40px 0px 40px;margin:0;box-sizing:border-box;font-size:16px;">
            Dear {{ $user['name'] ?? 'user' }},
        </p>
        <p style="padding:40px 40px 20px 40px;margin:0;box-sizing:border-box;font-size:16px;">
            Thank you for taking the time to fill out our recent survey.
            Your feedback is incredibly valuable to us, and we appreciate your input.
        </p>
    </div>
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <h1 style="color: green;text-align: center;font-weight: bold;font-style: italic;">HealthifyMe</h1>
    <div>
        <h3>Latest news from HealthifyMe, </h3>
        <p style="text-align: center;">{{ $newsLetter->title }}</p>
        <p>( {{ $newsLetter->title }} ) New blog added. Join us to stay fit and healthy for a better life.</p>
        <div>
            <h4>See the new blog now: </h4>
            <a href="https://healthifyme.top/blog/{{ $newsLetter->id }}" target="_blank">HealthifyMe</a>
        </div>

        <p>Best regards,<br>HealthifyMe</p>
</body>

</html>

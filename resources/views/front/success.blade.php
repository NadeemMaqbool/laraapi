<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Larapi Social</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >
</head>
<body>

    @if($resp)
        <div class="alert alert-success">
               <p> Your email has been verified. Please proceed with your profile setting</p>
        </div>
    @else
        <div class="alert alert-danger">
            <p> Oopps something went wrong. we cannot verify your account. Please try again</p>
        </div>
    @endif
</body>
</html>

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
        <main role="main" class="container">

                <div class="alert alert-success text-center">
                    <h1 class="mt-5">Verified Successfully</h1>
                    <p> Your email has been verified. Please proceed with your profile setting</p>
                </div>
        </main>

    @else

        <main role="main" class="container">

            <div class="alert alert-danger text-center">
                <h1 class="mt-5">Verified Failed</h1>
                <p> Oopps something went wrong. we cannot verify your account. Please try again</p>
            </div>
        </main>

    @endif
</body>
</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>403</title>
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/error.css') }}" />
</head>

<body>
    <div id="error">
        <div class="error-page container">
            <div class="col-md-8 col-12 offset-md-2">
                <div class="text-center">
                    <img class="img-error" src="{{ asset('assets/compiled/svg/error-403.svg') }}" alt="Not Found" />
                    <h1 class="error-title">Forbidden</h1>
                    <p class="fs-5 text-gray-600">
                        You are unauthorized to see this page.
                    </p>
                    <a href="{{ URL::previous() }}" class="btn btn-lg btn-outline-primary mt-3">Go Previous Page</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

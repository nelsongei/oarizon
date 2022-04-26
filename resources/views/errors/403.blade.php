<!DOCTYPE html>
<html lang="en-us" class="no-js">
<head>
    <meta charset="utf-8">
    <title>CBS | Xara CBS</title>
    <meta name="description" content="Able 7.0 404 Error page design" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{asset('assets/extra-pages/404/1/img/favicon.ico')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/extra-pages/404/1/css/style.css')}}" />
</head>

<body>
<?php
$organization = App\Models\Organization::find(1);
//echo "<pre>"; print_r($organization); "</pre>"; die();
?>
<div class="image"></div>

<!-- Your logo on the top left -->
<a href="#" class="logo-link" title="back home">

    <img src="{{asset('uploads/logo/'.$organization->logo)}}" class="logo" alt="Company's logo" />

</a>

<div class="content">

    <div class="content-box">

        <div class="big-content">

            <!-- Main squares for the content logo in the background -->
            <div class="list-square">
                <span class="square"></span>
                <span class="square"></span>
                <span class="square"></span>
            </div>

            <!-- Main lines for the content logo in the background -->
            <div class="list-line">
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
            </div>

            <!-- The animated searching tool -->
            <i class="fa fa-search" aria-hidden="true"></i>

            <!-- div clearing the float -->
            <div class="clear"></div>

        </div>

        <!-- Your text -->
        <h1>Oops! Error 403.</h1>

        <p>This action is unauthorized.</p>

    </div>

</div>

<footer class="light">

    <ul>
        <li><a href="#">Home</a></li>

        <li><a href="#">Search</a></li>

        <li><a href="#">Help</a></li>

        <li><a href="#">Trust & Safety</a></li>

        <li><a href="#">Sitemap</a></li>

        <li><a href="#"><i class="fa fa-facebook"></i></a></li>

        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
    </ul>

</footer>
<script src="{{ asset('assets/extra-pages/404/1/js/jquery.min.js')}}"></script>
<script src="{{ asset('assets/extra-pages/404/1/js/bootstrap.min.js')}}"></script>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>STOCK GRAM</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="Business india news, Market News, Indian stock Market News, Stock Market News, SENSEX live, Sensex Live News  Nifty News, BSE News, Breaking Business News, World Business News, Forex, IPO, Stocks." name="keywords">
        <meta content=" Indian stock market news and Updates, sensex live news & nifty news. Business including BSE, Forex, IPO, stocks, mutual funds to manage your finances, Business india news." name="description">
    
        <!-- Favicon -->
        <link href="img/favicon.ico" rel="icon">

        <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
        <link rel="manifest" href="site.webmanifest">
    
        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">  
    
        <!-- Font Awesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">
    
        <!-- Libraries Stylesheet -->
        <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    
        <!-- Customized Bootstrap Stylesheet -->
        <link href="{{asset('css/style.css')}}" rel="stylesheet">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        


   

        
    </head>
<body>

{{-- header start --}}
@include('header')
{{-- header end --}}

@yield('content')

{{-- footer start --}}
@include('footer')
{{-- footer end --}}





<!-- JavaScript Libraries -->
{{-- <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> --}}
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>

<!-- Template Javascript -->
<script src="js/main.js"></script>
</body>
</html>
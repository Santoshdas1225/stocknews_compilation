@extends('layout')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css"/>
<style>
    .alertify-notifier .ajs-message.ajs-error {
        color: black; /* Change this to your desired text color */
    }
</style>
<style>
    #data-wrapper {
        height: 500px; /* Adjust as needed */
        overflow-y: scroll;
        position: relative; /* Needed for positioning the loader */
    }

    .ajax-loading {
        display: flex;
        justify-content: center;
        align-items: center;
        position: absolute;
        bottom: 10px; /* Adjust as needed */
        left: 50%;
        transform: translateX(-50%);
        z-index: 9999; /* Ensures the spinner is above other content */
    }

    #data-wrapper::-webkit-scrollbar {
        width: 8px;
    }

    #data-wrapper::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0.2);
        border-radius: 4px;
    }
</style>

<!-- Navbar Start -->
<div class="container-fluid p-0">
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-2 py-lg-0 ">
      <a href="allnews" class="navbar-brand d-block d-lg-none">
          <h1 class="m-0 display-4 text-uppercase text-primary">Stock<span class="text-white font-weight-normal">Gram</span></h1>
      </a>
      <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
          <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-between px-0 px-lg-3" id="navbarCollapse">

          <div class="navbar-nav mr-auto py-0">
              
              <a href="allnews" class="nav-item nav-link ">Home</a>
              <a href="moneycontroldashboard" class="nav-item nav-link">MONEY CONTOL</a>
              <a href="thehindudashboard" class="nav-item nav-link active">THE HINDU</a>
              <a href="livemint" class="nav-item nav-link">LIVEMINT</a>
              <a href="zeebusiness" class="nav-item nav-link">Zee business</a>
              <a href="CNBCTV18" class="nav-item nav-link">CNBC-TV18</a>
              <a href="all" class="nav-item nav-link">ALL</a>   
          </div>
          {{-- <div class="navbar-nav ml-auto py-0 icon-container">
              <i class="fa-solid fa-arrows-rotate fetch-data-icon" style="color: #FFD43B;" title=""></i>
              <span class="tooltip-text">Fetch Data</span>
          </div>                 --}}
      </div>
  </nav>
</div>
<!-- Navbar End -->

<div class="container-fluid pt-5 mb-3">
    <div class="container">
        <div class="section-title">
            <h4 class="m-0 text-uppercase font-weight-bold">THE HINDU</h4>
        </div>

        <div id="data-wrapper" class="container-fluid">
            <div class="row" id="news-items">
                @include('thehindushow')
            </div>
        </div>

        <p id="error-message" style="display:none;color: purple" class=" text-center">END</p>

        {{-- <div class="col-lg-12 d-flex justify-content-end"> <!-- Align right -->
            <button class="btn btn-success load-more-data">Load More</button>
        </div> --}}
    </div>
</div>
    

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>

<script>
    var ENDPOINT = "{{ route('thehinduload') }}";
    var page = 1;

    $('#data-wrapper').scroll(function() {
        if ($('#data-wrapper').scrollTop() + $('#data-wrapper').height() >= $('#data-wrapper')[0].scrollHeight - 20) {
            page++;
            loadMore(page);
        }
    });

    function loadMore(page) {
        $.ajax({
            url: ENDPOINT + '?page=' + page,
            type: "GET",
            beforeSend: function() {
                $('.ajax-loading').show();
            }
        })
        .done(function(response) {
            if (response.html == '') {
                // alertify.error('No more News');
                $('#error-message').show(); 
                $('.ajax-loading').hide();
                return;
            }

            $('#news-items').append(response.html);
            $('.ajax-loading').hide();
        })
        .fail(function(jqXHR, ajaxOptions, thrownError) {
            alert('No Response found');
            $('.ajax-loading').hide();
        });
    }
</script>
    
@endsection
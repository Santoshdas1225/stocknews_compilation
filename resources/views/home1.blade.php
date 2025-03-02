@extends('layout')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

<style>
    .icon-container {
    position: relative;
    display: inline-block;
    cursor: pointer;
}

.tooltip-text {
    visibility: hidden;
    width: 120px;
    background-color: #FFD43B;
    color: #000000;
    text-align: center;
    border-radius: 6px;
    padding: 5px;
    position: absolute;
    z-index: 1;
    bottom: 125%;
    left: 50%;
    margin-left: -60px;
    opacity: 0;
    transition: opacity 0.3s;
}

.icon-container:hover .tooltip-text {
    visibility: visible;
    opacity: 1;
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
                    
                    <a href="allnews" class="nav-item nav-link active">Home</a>
                    <a href="moneycontroldashboard" class="nav-item nav-link">MONEY CONTOL</a>
                    <a href="thehindudashboard" class="nav-item nav-link">THE HINDU</a>
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

    <!-- Main News Slider Start -->
    {{-- to make this as before just add container-fluid in place of container --}}
    <div class="container-fluid">
        <div class="row">
          <div class="col-lg-8 px-0">
            <div class="owl-carousel main-carousel position-relative">
              @foreach($topnews as $news)
              <div class="position-relative overflow-hidden" style="height: 550px;">
                <img class="img-fluid h-100 lazy" src="{{ $news->media_url }}" style="object-fit: cover;">
                <div class="overlay">
                  <div class="mb-2">
                    @if ($news->source == 'thehindu')
                    <p class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2" style="background-color: rgba(25, 229, 229, 0.571)">THE HINDU</p><br>
                    @elseif ($news->source == 'zeebusiness')
                    <p class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2" href="" style="background-color: rgba(29, 220, 58, 0.792)">ZEE BUSINESS</p><br>
                    @elseif ($news->source == 'MONEYCONTROL')
                    <p class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2" href="" >MONEY CONTROL</p><br>
                    @elseif ($news->source == 'LiveMint')
                    <p class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2" href="" style="background-color: rgba(82, 117, 193, 0.847)">LIVEMINT</p><br>
                    @elseif ($news->source == 'CNBCTV18')
                    <p class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2" style="background-color: rgba(229, 173, 234, 0.847)">CNBC-TV18</p><br>
                    @endif
                    <a class="h3 m-0 text-white text-uppercase font-weight-bold responsive-text" href="{{$news->link}}" target="_blank">{!! $news->title !!}</a>
                  </div>
                  <p class="text-white" href="">{{ (new \DateTime($news->date))->format('d/m/Y h:i A') }}</p>
                </div>
              </div>
              @endforeach
            </div>
          </div>
      
          <div class="col-lg-4 px-0">
            <div class="scrollable-container">
              <div class="scrollable-div">
                <div class="section-title mb-0 sticky-title" style="border-radius: 0px">
                  <i><h4 class="m-0 text-uppercase font-weight-bold">trending News</h4></i>
                </div>
                <div class="bg-white border border-top-0 p-3">
                  <?php $count=0; ?>
                  @foreach ($trnews as $item)
                  <?php $count++; ?>
                  <div class="d-flex align-items-center bg-white mb-3" style="height: 150px;">
                    <a href="{{$item->link}}" target="_blank">
                      <img class="img-fluid lazy " src="{{$item->media_url}}" alt="" style=" border-top-right-radius: 10px; border-bottom-right-radius: 10px;">
                    </a>
                    <div class="w-100 h-100 px-3 d-flex flex-column justify-content-center border border-left-0">
                      <div class="mb-2">
                        @if ($item->source == 'thehindu')
                        <span class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2" style="background-color: rgba(25, 229, 229, 0.571)">THE HINDU</span><br>
                        @elseif ($item->source == 'zeebusiness')
                        <span class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2" style="background-color: rgba(29, 220, 58, 0.792)">ZEE BUSINESS</span><br>
                        @elseif ($item->source == 'MONEYCONTROL')
                        <span class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2">MONEY CONTROL</span><br>
                        @elseif ($item->source == 'LiveMint')
                        <span class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2" style="background-color: rgba(82, 117, 193, 0.847)">LIVEMINT</span><br>
                        @elseif ($item->source == 'CNBCTV18')
                        <span class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2" style="background-color: rgba(229, 173, 234, 0.847)">CNBC-TV18</span><br>
                        @endif
                        <a class="h6 text-secondary text-uppercase responsive-text" href="{{$item->link}}" target="_blank">
                          <small class="font-weight-bold">{!!substr($item->title, 0, 71)!!}...</small>
                        </a>
                      </div>
                      <span class="text-body"><small>{{ (new \DateTime($item->date))->format('d/m/Y h:i A') }}</small></span>
                    </div>
                  </div>
                  @if($count == 2)
                  <div class="row mb-3">
                    <div class="col-lg-12">
                      <a href="https://www.stockyfly.com/" target="_blank"><img src="{{asset('ad5.jpg')}}" alt="Ad" class="full-cover" style="height: 100px; border-radius: 20px"></a>
                    </div>
                  </div>
                  @endif
                  @if($count == 4)
                  <div class="row mb-3">
                    <div class="col-lg-12">
                      <a href="https://www.stockyfly.com/" target="_blank"></a><img src="{{asset('ad4.jpg')}}" alt="Ad" class="full-cover" style="height: 100px; border-radius: 20px">
                    </div>
                  </div>
                  @endif
                  @if($count == 6)
                  <div class="row mb-3">
                    <div class="col-lg-12">
                      <a href="https://www.stockyfly.com/" target="_blank"><img src="{{asset('ad6.jpg')}}" alt="Ad" class="full-cover" style="height: 100px; border-radius: 20px"></a>
                    </div>
                  </div>
                  @endif
                  @if($count == 8)
                  <div class="row mb-3">
                    <div class="col-lg-12">
                      <a href="https://www.stockyfly.com/" target="_blank"><img src="{{asset('ad7.jpg')}}" alt="Ad" class="full-cover" style="height: 100px; border-radius: 20px"></a>
                    </div>
                  </div>
                  @endif
                  @if($count == 10)
                  <div class="row mb-3">
                    <div class="col-lg-12">
                      <a href="https://www.stockyfly.com/" target="_blank"><img src="{{asset('ad8.jpg')}}" alt="Ad" class="full-cover" style="height: 100px; border-radius: 20px"></a>
                    </div>
                  </div>
                  @endif
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
    
    <!-- Main News Slider End -->
</div>

    <div class="container-fluid pt-5 mb-3">
        <div class="container">
            <div class="section-title">
                <h4 class="m-0 text-uppercase font-weight-bold">Today</h4>
            </div>
    
            <div id="data-wrapper-today" class="container-fluid">
                <div class="row" id="news-items">
                    @include('todaynew')
                </div>
            </div>
    
            <div class="col-lg-12 d-flex justify-content-end"> 
                <button class="btn btn-success btn-oval" id="loadmoretoday">Load More</button>
            </div>

            <div class="text-center" id="autoloadtoday" style="display: none;">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
   {{-- //Yesterday new start  --}}
   <div class="container-fluid pt-5 mb-3">
    <div class="container">
        <div class="section-title ">
            <h4 class="m-0 text-uppercase font-weight-bold">Yesterday</h4>

        </div>

        <div id="data-wrapper-ystpost" class="container-fluid">
            <div class="rowyst" id="news-items">
                @include('yesterday')
            </div>
            <div class="col-lg-12 d-flex justify-content-end"> 
                <button class="btn btn-success btn-oval" id="loadmoreystday">Load More</button>
            </div>
            <div class="text-center" id="autoloadystday" style="display: none;">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



   
    </div>
</div> 

    {{-- //Yesterday new end  --}}

    {{-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script> --}}

    
    {{-- Lazy loading START --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.min.js" integrity="sha512-jNDtFf7qgU0eH/+Z42FG4fw3w7DM/9zbgNPe3wfJlCylVDTT3IgKW5r92Vy9IHa6U50vyMz5gRByIu4YIXFtaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>

        $(document).ready(function(){
            $('img').lazyload();
        });
    
        </script>
    {{-- Lazy loading END --}}

    {{-- today load more start --}}
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script>
        var ENDPOINT = "{{ route('posts.index') }}";
        var todayPage = 1;
        var yesterdayPage = 1;
    
        $("#loadmoretoday").click(function() {
            todayPage++;
            loadMoreNews(todayPage, 'today');
        });
    
        $("#loadmoreystday").click(function() {
            yesterdayPage++;
            loadMoreNews(yesterdayPage, 'yesterday');
        });
    
        function loadMoreNews(page, type) {
            var url = ENDPOINT + "?page=" + page + "&type=" + type;
            var autoloadId = type === 'today' ? '#autoloadtoday' : '#autoloadystday';
            var dataWrapperId = type === 'today' ? '#data-wrapper-today' : '#data-wrapper-ystpost .rowyst';
    
            $.ajax({
                url: url,
                datatype: "html",
                type: "get",
                beforeSend: function() {
                    $(autoloadId).show();
                }
            })
            .done(function(response) {
                if (response.html == '') {
                    $(autoloadId).html("End 😞");
                    return;
                }
                $(autoloadId).hide();
                $(dataWrapperId).append("<div class='row'>" + response.html + "</div>");
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                console.log('Server error occurred');
            });
        }
    </script>
    

        {{-- today loadmore end --}}




        <script>
            document.addEventListener("DOMContentLoaded", function() {
            function setEqualHeight() {
            const topNewsDiv = document.querySelector('.owl-carousel');
            const scrollableDiv = document.querySelector('.scrollable-container');

            if (topNewsDiv && scrollableDiv) {
              const topNewsHeight = topNewsDiv.offsetHeight;
              scrollableDiv.style.height = `${topNewsHeight}px`;
            }
            }
  
        setEqualHeight();
  
            window.addEventListener('resize', setEqualHeight);
        });

        </script>
{{-- 
        <script>
            $(document).ready(function() {
                $('#toggle-button').on('click', function() {
                    $('#data-wrapper-ystpost').collapse('toggle');
                });
        
                $('#data-wrapper-ystpost').on('shown.bs.collapse', function() {
                    $('#toggle-icon').removeClass('fa-chevron-down').addClass('fa-chevron-up');
                });
        
                $('#data-wrapper-ystpost').on('hidden.bs.collapse', function() {
                    $('#toggle-icon').removeClass('fa-chevron-up').addClass('fa-chevron-down');
                });
            });
        </script>
         --}}

@endsection



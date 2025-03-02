@foreach ($zeebusiness as $n)
                <div class="col-lg-6">
                  
                    <div class="d-flex align-items-center bg-white mb-3 responsive-div" >
                        <a href="{{$n->link}}" target="_blank"><img class="img-fluid responsive-img" src="{{$n->media_url}}" alt=""></a>
                        <div class="w-100 h-100 px-3 d-flex flex-column justify-content-center border border-left-0">
                            <div class="mb-2">
                                <span class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2" href="" style="background-color: rgba(29, 220, 58, 0.792)">ZEE BUSINESS</span> <br>
                                <a class="h6 m-0 text-secondary text-uppercase font-weight-bold responsive-text" href="{{$n->link}}" target="_blank">{{substr($n->title,0, 82)}}...</a>
                              
                            </div>
                            <span class="text-body" href=""><small>{{ (new \DateTime($n->date))->format('d/m/Y h:i A')  }}</small></span>
                        </div>
                    </div>

                </div>
@endforeach
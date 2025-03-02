<!-- Footer Start -->
<div class="container-fluid py-4 px-sm-3 px-md-5" style="background: #111111;">
    <div class="row align-items-center">
        <div class="col-md-6 text-center text-md-left" style="padding-left: 50px">
            <p class="m-0">&copy; Copyright {{(new \DateTime())->format('Y')}} <span class="copyrightfooter">Stock Gram</span>. All Rights Reserved.</p>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <a href="{{url('/')}}/privacypolicy" class="mr-2" style="color: #9A9DA2" target="_blank">Privacy Policy</a>
            <a href="contactus" class="mr-2" style="color: #9A9DA2" target="_blank">Contact us</a>
        </div>
        
        <div class="col-md-5 text-center text-md-right">
            {{-- <span class="mr-2">Share</span> --}}
            <div class="d-flex justify-content-center justify-content-md-end py-2">
                <a class="btn btn-sm btn-secondary btn-sm-square mr-2" href="#" onclick="shareTwitter()"><i class="fab fa-twitter"></i></a>
                <a class="btn btn-sm btn-secondary btn-sm-square mr-2" href="#" onclick="shareFacebook()"><i class="fab fa-facebook-f"></i></a>
                <a class="btn btn-sm btn-secondary btn-sm-square mr-2" href="#" onclick="shareGooglePlus()"><i class="fab fa-google-plus"></i></a>
                <a class="btn btn-sm btn-secondary btn-sm-square mr-2" href="#" onclick="shareTelegram()"><i class="fab fa-telegram"></i></a>
            </div>
            
        </div>
    </div>
</div>
<!-- Footer End -->

<!-- Back to Top -->
<a href="#" class="btn btn-primary btn-square back-to-top"><i class="fa fa-arrow-up"></i></a>

{{-- share script --}}
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    function shareFacebook() {
        var url = encodeURIComponent(window.location.href);
        var facebookShareLink = "https://www.facebook.com/sharer/sharer.php?u=" + url;
        window.open(facebookShareLink, "_blank");
    }

    function shareTwitter() {
        var url = encodeURIComponent(window.location.href);
        var text = encodeURIComponent("Check this out!");
        var twitterShareLink = "https://twitter.com/intent/tweet?url=" + url + "&text=" + text;
        window.open(twitterShareLink, "_blank");
    }

    function shareGooglePlus() {
        var url = encodeURIComponent(window.location.href);
        var googlePlusShareLink = "https://plus.google.com/share?url=" + url;
        window.open(googlePlusShareLink, "_blank");
    }

    function shareTelegram() {
        var url = encodeURIComponent(window.location.href);
        var telegramShareLink = "https://t.me/share/url?url=" + url;
        window.open(telegramShareLink, "_blank");
    }
</script>

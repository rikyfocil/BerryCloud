@extends ('layouts.main')

@section ('content')

<div class="jumbotron" id="welcome-jumbotron">
    <div class="container text-center" id="welcome_info">
        <div class="col s8 m12">
            <h1>Keep it simple, your information in one click</h1>
            <h2>Get all the files wherever you are</h2>
            <a href="{{ url('/register') }}" class="btn" id="register-button">Register</a>
        </div>
        
    </div>
</div>

<div class="container-fluid text-center">
    <section id="feat">
        <h2 class="text-center">Why BerryCloud?</h2>
        <div class="row">
            <div class="col-sm-6 col-md-3 feats">
                <div class="circle">
                    <span class="glyphicon glyphicon-cloud glyph-welcome" aria-hidden="true"></span>
                </div>
                <h3>Cloud</h3>
                <h4>All your files everywhere</h4>
            </div>
            <div class="col-sm-6 col-md-3 feats">
                <div class="circle">
                    <span class="glyphicon glyphicon-duplicate glyph-welcome" aria-hidden="true"></span>
                </div>
                <h3>Version Control</h3>
                <h4>All your versions everywhere</h4>
            </div>
            <div class="col-sm-6 col-md-3 feats">
                <div class="circle">
                    <span class="glyphicon glyphicon-eye-close glyph-welcome" aria-hidden="true"></span>
                </div>
                <h3>End to end</h3>
                <h4>All your files encrypted</h4>
            </div>
            <div class="col-sm-6 col-md-3 feats">
                <div class="circle">
                    <span class="glyphicon glyphicon-user glyph-welcome" aria-hidden="true"></span>
                </div>
                <h3>Share</h3>
                <h4>Share your files with anyone</h4>
            </div>
        </div>
    </section>

    <!-- <section id="think"> -->
    <!--     <div class="col&#45;sm&#45;12 col&#45;md&#45;4"> -->
    <!--         <h2>Rethink the way you work</h2> -->
    <!--     </div> -->
    <!-- </section> -->

    
    <section id="save">
        <div class="col-sm-12 col-md-4 col-md-push-6">
            <h2>Save your files with a different point of view</h2>
        </div>
    </section>
</div>

@endsection 

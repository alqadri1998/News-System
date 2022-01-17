@extends('website.parent')

@section('content')
    <header>
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
                <!-- Slide One - Set the background image for this slide in the line below -->
                <div class="carousel-item active" style="background-image: url({{asset('website/img/1.jpg')}})">
                    <div class="carousel-caption d-none d-md-block">
                        <h3>news title can be here</h3>
                        <p>This is a description for the first slide of news title.</p>
                    </div>
                </div>
                <!-- Slide Two - Set the background image for this slide in the line below -->
                <div class="carousel-item" style="background-image: url({{asset('website/img/22.jpg')}})">
                    <div class="carousel-caption d-none d-md-block">
                        <h3>Second title can be here</h3>
                        <p>This is a description for the second slide.</p>
                    </div>
                </div>
                <!-- Slide Three - Set the background image for this slide in the line below -->
                <div class="carousel-item" style="background-image: url({{asset('website/img/1.jpg')}})">
                    <div class="carousel-caption d-none d-md-block">
                        <h3>Third title can be here</h3>
                        <p>This is a description for the third slide  of news title.</p>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </header>
    <!-- Page Content -->
    <section>
        <div class="container">

            <h3 class="my-4">last news</h3>

            <!-- Marketing Icons Section -->
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="card h-100">
                        <h4 class="card-header">news title</h4>
                        <div class="card-body">
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente esse
                                necessitatibus neque.</p>
                        </div>
                        <div class="card-footer">
                            <a href="../html/newsdetailes.html" class="btn btn-primary">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card h-100">
                        <h4 class="card-header">news title</h4>
                        <div class="card-body">
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis ipsam
                                eos,
                                nam perspiciatis natus commodi similique totam consectetur praesentium molestiae atque
                                exercitationem ut consequuntur, sed eveniet, magni nostrum sint fuga.</p>
                        </div>
                        <div class="card-footer">
                            <a href="../html/newsdetailes.html" class="btn btn-primary">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card h-100">
                        <h4 class="card-header">news title</h4>
                        <div class="card-body">
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente esse
                                necessitatibus neque.</p>
                        </div>
                        <div class="card-footer">
                            <a href="../html/newsdetailes.html" class="btn btn-primary">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
    </section>
    <section class="gray-sec">
        <div class="container">
            <!-- category Section -->
            <h3 class="my-4">local news</h3>

            <div class="row">
                <div class="col-lg-4 col-sm-6 portfolio-item">
                    <div class="card h-100">
                        <a href="#"><img class="card-img-top" src="{{asset('website/img/1.jpg')}}" alt=""></a>
                        <div class="card-body">
                            <h4 class="card-title">
                                <a href="#">news title One</a>
                            </h4>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam
                                aspernatur eum quasi sapiente nesciunt? Voluptatibus sit, repellat sequi itaque deserunt,
                                dolores in, nesciunt, illum tempora ex quae? Nihil, dolorem!</p>
                        </div>
                        <div class="card-footer">
                            <a href="../html/newsdetailes.html" class="btn btn-primary">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 portfolio-item">
                    <div class="card h-100">
                        <a href="#"><img class="card-img-top" src="{{asset('website/img/3.jpeg')}}" alt=""></a>
                        <div class="card-body">
                            <h4 class="card-title">
                                <a href="#">news title Two</a>
                            </h4>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra
                                euismod
                                odio, gravida pellentesque urna varius vitae.</p>
                        </div>
                        <div class="card-footer">
                            <a href="../html/newsdetailes.html" class="btn btn-primary">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 portfolio-item">
                    <div class="card h-100">
                        <a href="#"><img class="card-img-top" src="{{asset('website/img/2.jpg')}}" alt=""></a>
                        <div class="card-body">
                            <h4 class="card-title">
                                <a href="#">news title Three</a>
                            </h4>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos quisquam,
                                error
                                quod sed cumque, odio distinctio velit nostrum temporibus necessitatibus et facere atque
                                iure
                                perspiciatis mollitia recusandae vero vel quam!</p>
                        </div>
                        <div class="card-footer">
                            <a href="../html/newsdetailes.html" class="btn btn-primary">Learn More</a>
                        </div>
                    </div>
                </div>

            </div>
            <div align="center"><a class="btn btn-success" href="../html/all-news.html">more news</a></div>
        </div>
    </section>
    <section >
        <div class="container">

            <h3 class="my-4">sports news</h3>
            <div class="row">

                <div class="col-lg-3  portfolio-item">
                    <div class="card h-100">
                        <a href="#"><img class="card-img-top" src="{{asset('website/img/s4.jpg')}}" alt=""></a>
                        <div class="card-body">
                            <h4 class="card-title">
                                <a href="#">news title Four</a>
                            </h4>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra
                                euismod
                                odio, gravida pellentesque urna varius vitae.</p>
                        </div>
                        <div class="card-footer">
                            <a href="../html/newsdetailes.html" class="btn btn-primary">Learn More</a>
                        </div>

                    </div>
                </div>

                <div class="col-lg-3  portfolio-item">
                    <div class="card h-100">
                        <a href="#"><img class="card-img-top" src="{{asset('website/img/s1.jpg')}}" alt=""></a>
                        <div class="card-body">
                            <h4 class="card-title">
                                <a href="#">news title Four</a>
                            </h4>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra
                                euismod
                                odio, gravida pellentesque urna varius vitae.</p>
                        </div>
                        <div class="card-footer">
                            <a href="../html/newsdetailes.html" class="btn btn-primary">Learn More</a>
                        </div>

                    </div>
                </div>
                <div class="col-lg-3  portfolio-item">
                    <div class="card h-100">
                        <a href="#"><img class="card-img-top" src="{{asset('website/img/s2.jpg')}}" alt=""></a>
                        <div class="card-body">
                            <h4 class="card-title">
                                <a href="#">news title Five</a>
                            </h4>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra
                                euismod
                                odio, gravida pellentesque urna varius vitae.</p>
                        </div>
                        <div class="card-footer">
                            <a href="../html/newsdetailes.html" class="btn btn-primary">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3  portfolio-item">
                    <div class="card h-100">
                        <a href="#"><img class="card-img-top" src="{{asset('website/img/s3.jpg')}}" alt=""></a>
                        <div class="card-body">
                            <h4 class="card-title">
                                <a href="#">news title Six</a>
                            </h4>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Itaque earum
                                nostrum
                                suscipit ducimus nihil provident, perferendis rem illo, voluptate atque, sit eius in
                                voluptates,
                                nemo repellat fugiat excepturi! Nemo, esse.</p>
                        </div>
                        <div class="card-footer">
                            <a href="../html/newsdetailes.html" class="btn btn-primary">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <div align="center"><a class="btn btn-success" href="../html/all-news.html">more news</a></div>
            <br>
            <br>
        </div>
    </section>
    <section class="gray-sec">
        <div class="container">

            <!-- category Section -->
            <h3 class="my-4">International news</h3>

            <div class="row">
                <div class="col-lg-4 col-sm-6 portfolio-item">
                    <div class="card h-100">
                        <a href="#"><img class="card-img-top" src="{{asset('website/img/1.jpg')}}" alt=""></a>
                        <div class="card-body">
                            <h4 class="card-title">
                                <a href="#">news title One</a>
                            </h4>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam
                                aspernatur eum quasi sapiente nesciunt? Voluptatibus sit, repellat sequi itaque deserunt,
                                dolores in, nesciunt, illum tempora ex quae? Nihil, dolorem!</p>
                        </div>
                        <div class="card-footer">
                            <a href="../html/newsdetailes.html" class="btn btn-primary">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 portfolio-item">
                    <div class="card h-100">
                        <a href="#"><img class="card-img-top" src="{{asset('website/img/3.jpeg')}}" alt=""></a>
                        <div class="card-body">
                            <h4 class="card-title">
                                <a href="#">news title Two</a>
                            </h4>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra
                                euismod
                                odio, gravida pellentesque urna varius vitae.</p>
                        </div>
                        <div class="card-footer">
                            <a href="../html/newsdetailes.html" class="btn btn-primary">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 portfolio-item">
                    <div class="card h-100">
                        <a href="#"><img class="card-img-top" src="{{asset('website/img/2.jpg')}}" alt=""></a>
                        <div class="card-body">
                            <h4 class="card-title">
                                <a href="#">news title Three</a>
                            </h4>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos quisquam,
                                error
                                quod sed cumque, odio distinctio velit nostrum temporibus necessitatibus et facere atque
                                iure
                                perspiciatis mollitia recusandae vero vel quam!</p>
                        </div>
                        <div class="card-footer">
                            <a href="../html/newsdetailes.html" class="btn btn-primary">Learn More</a>
                        </div>
                    </div>
                </div>

            </div>
            <div align="center"><a class="btn btn-success" href="../html/all-news.html">more news</a></div>
        </div>
    </section>
    <section>
        <div class="container">
            <!--  Section -->
            <div class="row">
                <div class="col-lg-6">
                    <h3>main news title</h3>
                    <p>The Modern Business template by Start Bootstrap includes:</p>
                    <ul>
                        <li>
                            <strong>Bootstrap v4</strong>
                        </li>
                        <li>jQuery</li>
                        <li>Font Awesome</li>
                        <li>Working contact form with validation</li>
                        <li>Unstyled page elements for easy customization</li>
                    </ul>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corporis, omnis doloremque non cum id
                        reprehenderit, quisquam totam aspernatur tempora minima unde aliquid ea culpa sunt. Reiciendis quia
                        dolorum ducimus unde.</p>
                </div>
                <div class="col-lg-6">
                    <img class="img-fluid rounded full-width" src="{{asset('website/img/6.jpeg')}}" alt="" style="">
                </div>
            </div>
            <!-- /.row -->

            <hr>

            <!-- Call to Action Section -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestias, expedita, saepe, vero rerum
                        deleniti
                        beatae veniam harum neque nemo praesentium cum alias asperiores commodi.</p>
                </div>
                <div class="col-md-4">
                    <a class="btn btn-lg btn-secondary btn-block" href="#">contact us</a>
                </div>
            </div>
        </div>
        <!-- /.container -->

    </section>
@endsection

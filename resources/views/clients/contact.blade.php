@extends('clients.layouts.master')

@section('title', 'Liên hệ')
@section('content')
<div id="page-content"> 
                <!--Page Header-->
                <div class="page-header text-center">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-content-between align-items-center">
                                <div class="page-title"><h1>Liên hệ</h1></div>
                                <!--Breadcrumbs-->
                                <div class="breadcrumbs"><a href="index.html" title="Back to the home page">Home</a><span class="title"><i class="icon anm anm-angle-right-l"></i>Pages</span><span class="main-title fw-bold"><i class="icon anm anm-angle-right-l"></i>Contact Us Style2</span></div>
                                <!--End Breadcrumbs-->
                            </div>
                        </div>
                    </div>
                </div>
                <!--End Page Header-->

                <!--Main Content-->
                <div class="container contact-style2">
                    <!-- Contact Information -->
                    <div class="contact-information section pt-0">
                        <div class="row col-row row-cols-lg-4 row-cols-md-4 row-cols-sm-2 row-cols-2 text-center text-break">
                            <div class="icon-box col-item">
                                <div class="bg-block rounded-0 h-100">
                                    <div class="icon-box-icon icon-email mb-3">
                                        <i class="fs-1 icon anm anm-envelope-l"></i>
                                    </div>
                                    <div class="icon-box-content">
                                        <h3 class="icon-box-title mb-2">E-mail Address</h3>
                                        <p><a href="mailto:contact@example.com">contact@example.com</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="icon-box col-item">
                                <div class="bg-block rounded-0 h-100">
                                    <div class="icon-box-icon icon-email mb-3">
                                        <i class="fs-1 icon anm anm-phone-call-l"></i>
                                    </div>
                                    <div class="icon-box-content">
                                        <h3 class="icon-box-title mb-2">Phone Number</h3>
                                        <p><a href="tel:401234567890">(+86) 123 456 7890</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="icon-box col-item">
                                <div class="bg-block rounded-0 h-100">
                                    <div class="icon-box-icon icon-email mb-3">
                                        <i class="fs-1 icon anm anm-fax-r"></i>
                                    </div>
                                    <div class="icon-box-content">
                                        <h3 class="icon-box-title mb-2">Fax</h3>
                                        <p><a href="fax:+358.555.1234567">+358.555.1234567</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="icon-box col-item">
                                <div class="bg-block rounded-0 h-100">
                                    <div class="icon-box-icon icon-email mb-3">
                                        <i class="fs-1 icon anm anm-map-marker-al"></i>
                                    </div>
                                    <div class="icon-box-content">
                                        <h3 class="icon-box-title mb-2">Address</h3>
                                        <p>55 Gallaxy Enque, 2568 steet, 23568</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Contact Information -->

                    <!-- Contact Form - Details -->
                    <div class="contact-form-details section pt-0">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                <!-- Contact Form -->
                                <div class="formFeilds contact-form form-vertical mb-4 mb-lg-0">
                                    <div class="section-header">
                                        <h2>Send Us a Message</h2>
                                        <p>You can contact us any way that is convenient for you.</p>
                                    </div>

                                    <form action="https://www.annimexweb.com/items/hema/php/ajax_sendmail.php" name="contactus" method="post" id="contact-form" class="contact-form">	
                                        <div class="form-row">
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <input type="text" id="ContactFormName" name="name" class="form-control" placeholder="Name" />
                                                    <span class="error_msg" id="name_error"></span>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-6">                               
                                                <div class="form-group">
                                                    <input type="email" id="ContactFormEmail" name="email" class="form-control" placeholder="Email" />
                                                    <span class="error_msg" id="email_error"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <input class="form-control" type="tel" id="ContactFormPhone" name="phone" pattern="[0-9\-]*" placeholder="Phone Number"  />
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <input type="text" id="ContactSubject" name="subject" class="form-control" placeholder="Subject" />
                                                    <span class="error_msg" id="subject_error"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <textarea id="ContactFormMessage" name="message" class="form-control" rows="6" placeholder="Message"></textarea>
                                                    <span class="error_msg" id="message_error"></span>
                                                </div>
                                            </div>  
                                        </div>
                                        <div class="form-row">
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group mailsendbtn mb-0 w-100">	
                                                    <input class="btn btn-lg" type="submit" name="contactus" value="Send Message" />
                                                    <div class="loading"><img class="img-fluid" src="assets/images/icons/ajax-loader.gif" alt="loading"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="response-msg"></div>
                                </div>
                                <!-- End Contact Form -->
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                <!-- Contact Details -->
                                <div class="section-header">
                                    <h2>People usually ask these</h2>
                                    <p>We would be happy to answer your questions.</p>
                                </div>

                                <div class="contact-details faqs-style faqs-style1">
                                    <div class="accordion" id="accordionFaq">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingOne">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">How can I cancel my order?</button>
                                            </h2>
                                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionFaq">
                                                <div class="accordion-body">
                                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingTwo">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Why is my registration delayed?</button>
                                            </h2>
                                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionFaq">
                                                <div class="accordion-body">
                                                    <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingThree">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">What do I need to buy products?</button>
                                            </h2>
                                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionFaq">
                                                <div class="accordion-body">
                                                    <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingFour">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">How can I track an order?</button>
                                            </h2>
                                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionFaq">
                                                <div class="accordion-body">
                                                    <p>Nullam sed neque luctus, maximus diam sed, facilisis orci. Nunc ultricies neque a aliquam sollicitudin. Vivamus sit amet finibus sapien. Duis est dui, sodales nec pretium a interdum in lacus.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingFive">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">How can I get money back?</button>
                                            </h2>
                                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionFaq">
                                                <div class="accordion-body">
                                                    <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Contact Details -->
                            </div>
                        </div>
                    </div>
                    <!-- End Contact Form - Details -->

                    <!-- Contact Map -->
                    <div class="contact-maps section p-0">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="map-section ratio ratio-16x9">
                                    <iframe class="rounded-5" src="https://www.google.com/maps/embed?pb=" allowfullscreen="" height="650"></iframe>                             
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Contact Map -->
                </div>
                <!--End Main Content-->
            </div>
@endsection
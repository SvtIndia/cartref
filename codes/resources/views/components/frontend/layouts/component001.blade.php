<section id="component001">
    <div class="container">
        <div class="col-2-1">
            <div class="left">
                <h1>{{ setting('become-seller.title') }}</h1>
                {!! setting('become-seller.video') !!}
            </div>
            <div class="right">
                <div class="form-box">
                    <div class="tab tab-nav-simple tab-nav-boxed form-tab">
                        <ul class="nav nav-tabs nav-fill align-items-center border-no justify-content-center mb-5" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active border-no lh-1 ls-normal" href="#register">Become Seller</a>
                                <p>Fill this form to request a call from our vendor management team.</p>
                            </li>
                        </ul>
                        <div class="tab-content">
                            
                            <!-- Register start -->
                            <div class="tab-pane active" id="register">
                                <form action="{{  route('vendorsignup') }}" method="post">
                                    @csrf
            
                                    <div class="form-group mb-3">
                                        <input type="text" class="form-control" name="brand_name" value="{{ old('brand_name') }}" placeholder="Brand Name *"
                                            required autofocus/>
                                    </div>
            
                                    <div class="form-group mb-3">
                                        <input type="text" class="form-control" name="contact_name" value="{{ old('contact_name') }}" placeholder="Contact Name *"
                                            required />
                                    </div>
            
                                    <div class="form-group mb-3">
                                        <input type="text" class="form-control" name="contact_number" value="{{ old('contact_number') }}" placeholder="Contact Number *"
                                            required />
                                    </div>
            
                                    <div class="form-group mb-3">
                                        <input type="email" class="form-control" name="email_address" value="{{ old('email_address') }}" placeholder="Email Address *"
                                            required />
                                    </div>
                                
            
                                    <div class="form-group mb-3">
                                        <input type="text" class="form-control" name="registered_company_name" value="{{ old('registered_company_name') }}" placeholder="Registered Company Name "/>
                                    </div>
            
                                    <div class="form-group mb-3">
                                        <input type="text" class="form-control" name="gst_number" value="{{ old('gst_number') }}" placeholder="Company GST Number "/>
                                    </div>
            
                                    <div class="form-group mb-3">
                                        <label for="">Listed on any marketplaces?</label>
                                        <textarea name="marketplaces" id="marketplaces" cols="30" rows="5"></textarea>
                                    </div>
            
                                    <div class="form-footer">
                                        <div class="form-checkbox">
                                            <input type="checkbox" class="custom-checkbox" id="register-agree" name="register-agree"
                                                required />
                                            <label class="form-control-label" for="register-agree">I agree to the <a href="/page/privacy-policy" style="color: blue">privacy policy</a></label>
                                        </div>
                                        <br>
                                    </div>
                                    <button class="btn btn-dark btn-block btn-rounded" type="submit">Register</button>
                                </form>
                            </div>
                            <!-- Register end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>












#component001 {
    position: relative;
    background: black;
    padding: 2em 5em;
    overflow: hidden;
}

#component001 .col-2-1{
    display: grid;
    grid-template-columns: 2fr 1fr;
    grid-gap: 5em;
}

#component001 .left{

}

#component001 .left h1{
font-size: 5em;
/*   font-family: 'Poppins', sans-serif;
font-weight: 700; */
}

#component001 .left iframe{
width: 100%;
height: 55%;
}


#component001 .right .form-box{
background: #fff;
padding: 1em 2em;
border-radius: 10px;
box-shadow: 0 0 10px 5px gray;
}

#component001 .right .form-box .nav-item .nav-link{
font-size: 2.5em;
text-align: left;
padding: 0.5em 0 0.5em 0;
}

#component001 .right .form-box .nav-item p{
font-size: 1.2em;
margin: 0;
}


@media (max-width: 600px)
{

    #component001{
        padding: 2em 0px;
    }
    
    #component001 .container{
        padding: auto 0em;
    }

    #component001 .col-2-1{
        display: grid;
        grid-template-columns: 1fr;
        grid-gap: 3em 0;
    }

    #component001 .left{

    }

    #component001 .left h1{
        font-size: 2.5em;
    }

    #component001 .left iframe{
        width: 90vw;
        height: 35vh;
    }


    #component001 .right .form-box{
        padding: 1em 1em;
        max-width: 87vw;
        box-shadow: 0 0 5px 1px lightgray;
    }

    #component001 .right .form-box .nav-item .nav-link{
        font-size: 2em;
        padding: 0.5em 0 0.5em 0;
    }

    #component001 .right .form-box .nav-item p{
        font-size: 1.1em;
        margin: 0;
    }

}






@media only screen and (min-width:601px) and (max-width:900px)
{

    #component001{
        padding: 2em 1em;
    }
    
    #component001 .container{
        padding: auto 0em;
    }

    #component001 .col-2-1{
        display: grid;
        grid-template-columns: 1fr;
        grid-gap: 3em 0;
    }

    #component001 .left{

    }

    #component001 .left h1{
        font-size: 3em;
    }

    #component001 .left iframe{
        width: 93vw;
        height: 38vh;
    }


    #component001 .right .form-box{
        padding: 1em 1em;
        max-width: 93vw;
        box-shadow: 0 0 5px 1px lightgray;
    }
    

    #component001 .right .form-box .nav-item .nav-link{
        font-size: 2em;
        padding: 0.5em 0 0.5em 0;
    }

    #component001 .right .form-box .nav-item p{
        font-size: 1.1em;
        margin: 0;
    }

}







</style>
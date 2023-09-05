<section id="component003">
    <div class="container">
        <div class="title">
            <h2>{{ setting('seller-steps.title') }}</h2>
        </div>
        <div class="steps">
            
            @if (!empty(setting('seller-steps.widget_1_title')))
            <div class="item">
                <div class="image">
                    <img src="{{ Voyager::image(setting('seller-steps.widget_1_image')) }}" alt="{{ setting('seller-steps.widget_1_title') }}">
                </div>
                <div class="middleicon">
                    <img src="{{ Voyager::image(setting('seller-steps.widget_1_icon_image')) }}" alt="">
                </div>
                <div class="info">
                    <h3>{{ setting('seller-steps.widget_1_title') }}</h3>
                    {!! setting('seller-steps.widget_1_description') !!}
                </div>
            </div>
            @endif


            @if (!empty(setting('seller-steps.widget_2_title')))
            <div class="item">
              <div class="image">
                  <img src="{{ Voyager::image(setting('seller-steps.widget_2_image')) }}" alt="{{ setting('seller-steps.widget_2_title') }}">
              </div>
              <div class="middleicon">
                  <img src="{{ Voyager::image(setting('seller-steps.widget_2_icon_image')) }}" alt="">
              </div>
              <div class="info">
                  <h3>{{ setting('seller-steps.widget_2_title') }}</h3>
                  {!! setting('seller-steps.widget_2_description') !!}
              </div>
            </div>
            @endif


            @if (!empty(setting('seller-steps.widget_3_title')))
            <div class="item">
                <div class="image">
                    <img src="{{ Voyager::image(setting('seller-steps.widget_3_image')) }}" alt="{{ setting('seller-steps.widget_3_title') }}">
                </div>
                <div class="middleicon">
                    <img src="{{ Voyager::image(setting('seller-steps.widget_3_icon_image')) }}" alt="">
                </div>
                <div class="info">
                    <h3>{{ setting('seller-steps.widget_3_title') }}</h3>
                    {!! setting('seller-steps.widget_3_description') !!}
                </div>
            </div>
            @endif


            @if (!empty(setting('seller-steps.widget_4_title')))
                <div class="item">
                    <div class="image">
                        <img src="{{ Voyager::image(setting('seller-steps.widget_4_image')) }}" alt="{{ setting('seller-steps.widget_4_title') }}">
                    </div>
                    <div class="middleicon">
                        <img src="{{ Voyager::image(setting('seller-steps.widget_4_icon_image')) }}" alt="">
                    </div>
                    <div class="info">
                        <h3>{{ setting('seller-steps.widget_4_title') }}</h3>
                        {!! setting('seller-steps.widget_4_description') !!}
                    </div>
                </div>
            @endif


            @if (!empty(setting('seller-steps.widget_5_title')))
                <div class="item">
                    <div class="image">
                        <img src="{{ Voyager::image(setting('seller-steps.widget_5_image')) }}" alt="{{ setting('seller-steps.widget_5_title') }}">
                    </div>
                    <div class="middleicon">
                        <img src="{{ Voyager::image(setting('seller-steps.widget_5_icon_image')) }}" alt="">
                    </div>
                    <div class="info">
                        <h3>{{ setting('seller-steps.widget_5_title') }}</h3>
                        {!! setting('seller-steps.widget_5_description') !!}
                    </div>
                </div>
            @endif

        </div>
    </div>
</section>

<style>
    

    

    

    

    

    
    #component003{
  position: relative;
  background: #f5f5f5;
  padding: 3em 3em;
}

#component003 .title{
   padding: 0 0 1em 0;
}

#component003 .title h2{
  color: black;
  font-size: 1em;
  text-align: center !important;
  margin: auto;
  text-transform: capitalize;
}


#component003 .steps{
  display: grid;
  grid-template-columns: 1fr;
  grid-gap: 0;
}

#component003 .steps .item{
  display: grid;
  /* grid-template-columns: 1fr 0.2fr 1fr; */
  padding: 2em 0;
  grid-gap: 1em;
}

#component003 .steps .item:nth-child(odd){
  /* display: grid; */
  grid-template-areas: "image middleicon info";
  /* padding: 2em 0; */
/*   background: red; */
}

#component003 .steps .item:nth-child(even){
  /* display: grid; */
  grid-template-areas: "info middleicon image";
}

#component003 .steps .item .image{
  margin: auto;
  grid-area: image;
  width: 40vw;
}

#component003 .steps .item .image img{
  height: 20em;
  margin-left: 33%;
  margin-top: 0px;
}


#component003 .steps .item .middleicon{
    grid-area: middleicon;
    width: 10vw;
    margin: auto;
    margin-top: 0px;
}

#component003 .steps .item .middleicon img{
  
}


#component003 .steps .item .info{
    grid-area: info;
    width: 40vw;
}

#component003 .steps .item:nth-child(even) .info
{
  text-align: left;
}

#component003 .steps .item:nth-child(even) .info
{
  text-align: right;
}

#component003 .steps .item .info h3{
  color: red;
  font-size: 1.5em;
}


#component003 .steps .item .info ul li{
  font-size: 1.1em;
  line-height: 2;
}


@media (max-width: 600px)
{
  #component003{
    padding: 3em 0em;
  }
  
  #component003 .container{
    padding: 0 1em !important;
  }

  #component003 .title{
     padding: 0 0 1em 0;
  }

  #component003 .title h2{
    font-size: 1em;
  }


  #component003 .steps{
    display: grid;
    grid-template-columns: 1fr;
    grid-gap: 0;
  }

  #component003 .steps .item{
    display: grid;
    /* grid-template-columns: 1fr 0.2fr 1fr; */
    padding: 2em 1em;
    grid-gap: 1em;
    box-shadow: 0 0 9px 0.5px lightgray;
    margin-bottom: 3em;
  }

  #component003 .steps .item:nth-child(odd){
    /* display: grid; */
    grid-template-areas: 
      "image"
      "middleicon"
      "info"
      ;
  }

  #component003 .steps .item:nth-child(even){
    /* display: grid; */
    grid-template-areas: 
      "image"
      "middleicon"
      "info"
      ;
  }

  #component003 .steps .item .image{
    margin: auto;
    grid-area: image;
    width: 100%;
  }

  #component003 .steps .item .image img{
    height: 20em;
    margin-left: 1.5em;
    margin-top: 0px;
  }


  #component003 .steps .item .middleicon{
      grid-area: middleicon;
      width: 100%;
      margin: auto;
      margin-top: 0px;
      display: none;
  }

  #component003 .steps .item .middleicon img{

  }


  #component003 .steps .item .info{
      grid-area: info;
      width: 100%;
  }

  #component003 .steps .item:nth-child(even) .info
  {
    text-align: left;
  }

  #component003 .steps .item:nth-child(even) .info
  {
    text-align: left;
  }

  #component003 .steps .item .info h3{
    font-size: 1.5em;
  }


  #component003 .steps .item .info ul li{
    font-size: 1.1em;
    line-height: 2;
  }


}




@media only screen and (min-width:601px) and (max-width:900px)
{
  #component003{
    padding: 3em 0em;
  }
  
  #component003 .container{
    padding: 0 1em !important;
  }

  #component003 .title{
     padding: 0 0 0.5em 0;
  }

  #component003 .title h2{
    font-size: 1em;
  }


  #component003 .steps{
    display: grid;
    grid-template-columns: 1fr;
    grid-gap: 0;
  }

  #component003 .steps .item{
    display: grid;
    grid-template-columns: 1fr 0.2fr 1fr;
    padding: 2em 1em;
    grid-gap: 0em;
    box-shadow: 0 0 9px 0.5px lightgray;
    margin-bottom: 3em;
  }

  #component003 .steps .item:nth-child(odd){
    /* display: grid; */
/*     grid-template-areas: 
      "image"
      "middleicon"
      "info"
      ; */
  }

  #component003 .steps .item:nth-child(even){
    /* display: grid; */
/*     grid-template-areas: 
      "image"
      "middleicon"
      "info"
      ; */
  }

  #component003 .steps .item .image{
    margin: auto;
    grid-area: image;
    width: 100%;
  }

  #component003 .steps .item .image img{
    height: 20em;
    margin-left: 1.5em;
    margin-top: 0px;
  }


  #component003 .steps .item .middleicon{
      grid-area: middleicon;
      width: 100%;
      margin: auto;
      margin-top: 0px;
      display: none;
  }

  #component003 .steps .item .middleicon img{

  }


  #component003 .steps .item .info{
      grid-area: info;
      width: 100%;
  }

  #component003 .steps .item:nth-child(even) .info
  {
    text-align: left;
  }

  #component003 .steps .item:nth-child(even) .info
  {
    text-align: left;
  }

  #component003 .steps .item .info h3{
    font-size: 1.5em;
  }


  #component003 .steps .item .info ul li{
    font-size: 1.1em;
    line-height: 2;
  }


}


</style>
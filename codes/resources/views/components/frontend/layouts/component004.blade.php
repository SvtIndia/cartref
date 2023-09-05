<section id="component004">
    <div class="container">
        <div class="title">
            <h2>{{ setting('why-our-platform.title') }}</h2>
        </div>
        <div class="grid-4">

            @if (!empty(setting('why-our-platform.widget_1_title')))
              <div class="item">
                  <div class="image">
                      <img src="{{ Voyager::image(setting('why-our-platform.widget_1_image')) }}" alt="{{ setting('why-our-platform.widget_1_title') }}">
                  </div>
                  <div class="info">
                      <h3>{{ setting('why-our-platform.widget_1_title') }}</h3>
                      <p>{{ setting('why-our-platform.widget_1_description') }}</p>
                  </div>
              </div>
            @endif

            @if (!empty(setting('why-our-platform.widget_2_title')))
              <div class="item">
                  <div class="image">
                      <img src="{{ Voyager::image(setting('why-our-platform.widget_2_image')) }}" alt="{{ setting('why-our-platform.widget_1_title') }}">
                  </div>
                  <div class="info">
                      <h3>{{ setting('why-our-platform.widget_2_title') }}</h3>
                      <p>{{ setting('why-our-platform.widget_2_description') }}</p>
                  </div>
              </div>
            @endif

            @if (!empty(setting('why-our-platform.widget_3_title')))
              <div class="item">
                  <div class="image">
                      <img src="{{ Voyager::image(setting('why-our-platform.widget_3_image')) }}" alt="{{ setting('why-our-platform.widget_1_title') }}">
                  </div>
                  <div class="info">
                      <h3>{{ setting('why-our-platform.widget_3_title') }}</h3>
                      <p>{{ setting('why-our-platform.widget_3_description') }}</p>
                  </div>
              </div>
            @endif

            @if (!empty(setting('why-our-platform.widget_4_title')))
              <div class="item">
                  <div class="image">
                      <img src="{{ Voyager::image(setting('why-our-platform.widget_4_image')) }}" alt="{{ setting('why-our-platform.widget_1_title') }}">
                  </div>
                  <div class="info">
                      <h3>{{ setting('why-our-platform.widget_4_title') }}</h3>
                      <p>{{ setting('why-our-platform.widget_4_description') }}</p>
                  </div>
              </div>
            @endif


            @if (!empty(setting('why-our-platform.widget_5_title')))
              <div class="item">
                  <div class="image">
                      <img src="{{ Voyager::image(setting('why-our-platform.widget_5_image')) }}" alt="{{ setting('why-our-platform.widget_1_title') }}">
                  </div>
                  <div class="info">
                      <h3>{{ setting('why-our-platform.widget_5_title') }}</h3>
                      <p>{{ setting('why-our-platform.widget_5_description') }}</p>
                  </div>
              </div>
            @endif


            @if (!empty(setting('why-our-platform.widget_6_title')))
              <div class="item">
                  <div class="image">
                      <img src="{{ Voyager::image(setting('why-our-platform.widget_6_image')) }}" alt="{{ setting('why-our-platform.widget_1_title') }}">
                  </div>
                  <div class="info">
                      <h3>{{ setting('why-our-platform.widget_6_title') }}</h3>
                      <p>{{ setting('why-our-platform.widget_6_description') }}</p>
                  </div>
              </div>
            @endif

            @if (!empty(setting('why-our-platform.widget_7_title')))
              <div class="item">
                  <div class="image">
                      <img src="{{ Voyager::image(setting('why-our-platform.widget_7_image')) }}" alt="{{ setting('why-our-platform.widget_1_title') }}">
                  </div>
                  <div class="info">
                      <h3>{{ setting('why-our-platform.widget_7_title') }}</h3>
                      <p>{{ setting('why-our-platform.widget_7_description') }}</p>
                  </div>
              </div>
            @endif


            @if (!empty(setting('why-our-platform.widget_8_title')))
              <div class="item">
                  <div class="image">
                      <img src="{{ Voyager::image(setting('why-our-platform.widget_8_image')) }}" alt="{{ setting('why-our-platform.widget_1_title') }}">
                  </div>
                  <div class="info">
                      <h3>{{ setting('why-our-platform.widget_8_title') }}</h3>
                      <p>{{ setting('why-our-platform.widget_8_description') }}</p>
                  </div>
              </div>
            @endif
        </div>
    </div>
</section>


<style>
    

    

    

    

    

    
    #component004{
  padding: 5em 3em;
}

#component004 .title{
  margin-bottom: 1em;
}

#component004 .title h2{
  text-align: center;
  margin: auto;
  color: black;
}

#component004 .grid-4{
  display: grid;
  grid-template-columns: 1fr 1fr 1fr 1fr;
  grid-gap: 2em 0;
}


#component004 .grid-4 .item{
  
  text-align: center;
}

#component004 .grid-4 .item .image{
  
}

#component004 .grid-4 .item .image img{
  height: 7em;
}

#component004 .grid-4 .item .info{
  padding-top: 1em;
}

#component004 .grid-4 .item .info h3{
  color: #000c;
  font-size: 1.5em;
  margin: 0.5em 0;
}

#component004 .grid-4 .item .info p{
  font-size: 1.1em;
}




@media (max-width: 600px)
{
  
    


  #component004{
    padding: 4em 1em;
  }

  #component004 .title{
    margin-bottom: 1em;
  }

  #component004 .title h2{
    text-align: center;
    margin: auto;
    font-size: 1em;
  }

  #component004 .grid-4{
    display: grid;
    grid-template-columns: 1fr;
    grid-gap: 2em 0;
  }


  #component004 .grid-4 .item{
    text-align: center;
  }

  #component004 .grid-4 .item .image{

  }

  #component004 .grid-4 .item .image img{
    height: 7em;
  }

  #component004 .grid-4 .item .info{
    padding-top: 1em;
  }

  #component004 .grid-4 .item .info h3{
    font-size: 1.5em;
    margin: 0.2em 0;
  }

  #component004 .grid-4 .item .info p{
    font-size: 1.1em;
  }



}





@media only screen and (min-width:601px) and (max-width:900px)
{
  
    


  #component004{
    padding: 4em 1em;
  }

  #component004 .title{
    margin-bottom: 3em;
  }

  #component004 .title h2{
    text-align: center;
    margin: auto;
    font-size: 1em;
  }

  #component004 .grid-4{
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    grid-gap: 2em 1em;
  }


  #component004 .grid-4 .item{
    
  }

  #component004 .grid-4 .item .image{

  }

  #component004 .grid-4 .item .image img{
    height: 7em;
  }

  #component004 .grid-4 .item .info{
    padding-top: 1em;
  }

  #component004 .grid-4 .item .info h3{
    font-size: 1.5em;
    margin: 0.2em 0;
  }

  #component004 .grid-4 .item .info p{
    font-size: 1.1em;
  }



}



</style>
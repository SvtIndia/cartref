<section id="component002">
    <div class="container">
        <div class="grid-3">

            @if (setting('seller-benefits.widget_1_title'))
              <div class="item">
                  <div class="image">
                      <img src="{{ Voyager::image(setting('seller-benefits.widget_1_image')) }}" alt="">
                  </div>
                  <div class="info">
                      <h3>{{ setting('seller-benefits.widget_1_title') }}</h3>
                      <p>{{ setting('seller-benefits.widget_1_description') }}</p>
                  </div>
              </div>
            @endif

            @if (setting('seller-benefits.widget_2_title'))
            <div class="item">
              <div class="image">
                  <img src="{{ Voyager::image(setting('seller-benefits.widget_2_image')) }}" alt="">
              </div>
              <div class="info">
                  <h3>{{ setting('seller-benefits.widget_2_title') }}</h3>
                  <p>{{ setting('seller-benefits.widget_2_description') }}</p>
              </div>
            </div>
            @endif

          @if (setting('seller-benefits.widget_3_title'))
            <div class="item">
                <div class="image">
                    <img src="{{ Voyager::image(setting('seller-benefits.widget_3_image')) }}" alt="">
                </div>
                <div class="info">
                    <h3>{{ setting('seller-benefits.widget_3_title') }}</h3>
                    <p>{{ setting('seller-benefits.widget_3_description') }}</p>
                </div>
            </div>
          @endif

          @if (setting('seller-benefits.widget_4_title'))
            <div class="item">
                <div class="image">
                    <img src="{{ Voyager::image(setting('seller-benefits.widget_4_image')) }}" alt="">
                </div>
                <div class="info">
                    <h3>{{ setting('seller-benefits.widget_4_title') }}</h3>
                    <p>{{ setting('seller-benefits.widget_4_description') }}</p>
                </div>
            </div>
          @endif

          @if (setting('seller-benefits.widget_5_title'))
            <div class="item">
                <div class="image">
                    <img src="{{ Voyager::image(setting('seller-benefits.widget_5_image')) }}" alt="">
                </div>
                <div class="info">
                    <h3>{{ setting('seller-benefits.widget_5_title') }}</h3>
                    <p>{{ setting('seller-benefits.widget_5_description') }}</p>
                </div>
            </div>
          @endif

        </div>
    </div>
</section>


<style>
    



    


    

    
    #component002{
  padding: 3em 10em;
  background: #ffffff;
}

#component002 .grid-3{
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
  grid-gap: 2em;
}

#component002 .grid-3 .item{
  text-align: center;
  box-shadow: 0 0 5px 1px lightgray;
  padding: 3em 0;
/*   border-radius: 90%; */
}

#component002 .grid-3 .item .image{
  
}

#component002 .grid-3 .item .image img{
  height: 10em;
}

#component002 .grid-3 .item .info{
  padding: 1em;
}

#component002 .grid-3 .item .info h3{
  color: black;
  font-weight: 500;
  font-size: 2em;
  padding: 0;
  margin: 0;
}

#component002 .grid-3 .item .info p{
  font-size: 1.3em;
}


@media (max-width: 600px)
{
  
    
  #component002{
    padding: 6em 0em;
  }

  #component002 .grid-3{
    display: grid;
    grid-template-columns: 1fr;
    grid-gap: 3em 0;
  }

  #component002 .grid-3 .item{
    
  }

  #component002 .grid-3 .item .image{

  }

  #component002 .grid-3 .item .image img{
    
  }

  #component002 .grid-3 .item .info{
    
  }

  #component002 .grid-3 .item .info h3{
    
  }

  #component002 .grid-3 .item .info p{
    
  }

}



@media only screen and (min-width:601px) and (max-width:900px)
{
  
    
  #component002{
    padding: 6em 0em;
  }

  #component002 .grid-3{
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    grid-gap: 3em 1em;
  }

  #component002 .grid-3 .item{
    
  }

  #component002 .grid-3 .item .image{

  }

  #component002 .grid-3 .item .image img{
    
  }

  #component002 .grid-3 .item .info{
    
  }

  #component002 .grid-3 .item .info h3{
    font-size: 1.5em;
    margin-bottom: 0.4em;
  }

  #component002 .grid-3 .item .info p{
    font-size: 1.1em;
    line-height: 1.5;
  }

}




</style>
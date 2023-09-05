<script>
    $(document).ready(function(){

        // header fixed on scroll
        // var stickyOffset = $('.sticky').offset().top;

        // $(window).scroll(function(){
        //     var sticky = $('.sticky'),
        //         scroll = $(window).scrollTop();

        //     if (scroll >= stickyOffset) sticky.addClass('fixed');
        //     else sticky.removeClass('fixed');
        // });

        // show Quickview on button hover
        $(function(){
            $('body').on('click','.btnQuickView', function(e){
                e.preventDefault();
                var data = $(this).data();
                $('#quickViewModal #modal-product-name').html(data.productName);
                $('#quickViewModal #modal-product-image').attr('src', data.productImage);
                $('#quickViewModal #modal-product-offer-price').html(data.productOfferPrice);
                $('#quickViewModal #modal-product-mrp-price').html(data.productMrpPrice);
                $('#quickViewModal #modal-product-savings').html(data.productSavings);
                $('#quickViewModal #modal-product-description').html(data.productDescription);
                $('#modal').css("display", "block");
                $('#quickViewModal').css("display", "block");
                $('#quickViewModal').modal();
            });
        });

        // hide quickview on button hover leave
        // $(function(){
        //     $('body').on('mouseleave','.btnQuickView', function(e){
        //         $('#quickViewModal').css("display", "none");
        //         $('#modal').css("display", "none");
        //     });
        // });


        $(function(){
            $('body').on('click','.modelclose', function(e){
                e.preventDefault();
                $('#quickViewModal').css("display", "none");
                $('#modal').css("display", "none");
            });
        });

        // Home Images Slider
        $(".images-slider .owl-carousel").owlCarousel({
            loop:true,
            margin:10,
            center:true,
            autoplay:true,
            autoplayTimeout:2000,
            autoplayHoverPause:true,
            responsiveClass:true,
            responsive:{
                0:{
                    items:1,
                    nav:false
                },
                600:{
                    items:1,
                    nav:false
                },
                1000:{
                    items:1,
                    nav:false
                }
            }
        });

        // Home Products Slider
        $(".home-items-slider .owl-carousel").owlCarousel({
            loop:true,
            margin:10,
            center:true,
            autoplay:true,
            autoplayTimeout:2000,
            autoplayHoverPause:true,
            responsiveClass:true,
            responsive:{
                0:{
                    items:0,
                    nav:false
                },
                600:{
                    items:3,
                    nav:false
                },
                1000:{
                    items:5,
                    nav:false
                }
            }
        });


        

 
    });

</script>


<script>
    function toggleNav() {
        var x = document.getElementById("navs");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    } 

    function toggleSearch() {
        var x = document.getElementById("searchbar");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    } 
</script>



<script>
    var acc = document.getElementsByClassName("accordion");
    var i;
    
    for (i = 0; i < acc.length; i++) {
      acc[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var panel = this.nextElementSibling;
        panel.classList.toggle("show");
        // if (panel.style.display === "block") {
        //   panel.style.display = "none";
        // } else {
        //   panel.style.display = "block";
        // }
      });
    }
</script>
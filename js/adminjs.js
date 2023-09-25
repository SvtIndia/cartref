let horizontalScrollBtns = `
    <div class="sliding-btn-div">
        <nav>
            <ul class="pagination">
                <li class="page-item" id="left-button"><span class="page-link" aria-hidden="true">‹</span></li>
                <li class="page-item" id="right-button"><span class="page-link" aria-hidden="true">›</span></li>
            </ul>
        </nav>
    </div>
`;

$(document).ready(function () {
    $('.panel-bordered .panel-body').append(horizontalScrollBtns);

    $('.panel-bordered .panel-body').on('click', '#left-button', function () {
        $(".table-responsive").animate({
            scrollLeft: "-=500px"
        },
            "slow"
        );
    });

    $('.panel-bordered .panel-body').on('click', "#right-button", function () {
        $(".table-responsive").animate({
            scrollLeft: "+=500px"
        },
            "slow"
        );
    });

    // function GFG_Fun() {
    //     var div = document.getElementsByClassName('.panel-bordered .panel-body');
    //     var hs = div.scrollWidth > div.clientWidth;
    //     var vs = div.scrollHeight > div.clientHeight;
    //     return hs;
    //     // let ssss
    //     //         = "Horizontal Scrollbar - " + hs
    //     //         +"<br>Vertical Scrollbar - " + vs;

    //     //         console.log(ssss);
    // }

    // console.log(GFG_Fun());
});


Pusher.logToConsole = true;
var pusher = new Pusher(pusher_key, {
    cluster: 'ap2'
});
var channel = pusher.subscribe('my-channel@'+user_id);

let showcases = '';
let renderItems = '';
channel.bind('my-event', function (data) {
    console.log(JSON.stringify(data));
    let order_id = data.data;
    renderItems = '';

    $.ajax({
        type: "GET",
        url: "/api/fetch/showroom-orders/"+order_id,
        success: function(res) {
            showcases = res.showcases;
            showcases.forEach((item,index) => {
                renderItems += `
                <tr>
                    <td>
                        <div>
                            <a href="/seller/showcases?order_id=${item.order_id}">
                                ${item.order_id}
                            </a>
                        </div>
                        <br />
                        <div>
                            <!--5 mins ago-->
                            ${timeAgo(new Date(item.created_at))}
                        </div>
                    </td>
                    <td>
                        <div class="product-information">
                            <a href="${window.location.origin +'/product/'+ item.product.slug}" class="name" target="_blank">
                                <img
                                    src="${window.location.origin +'/storage/'+ item.product.image}"
                                    onerror="this.onerror=null;this.src='/images/placeholer.png';"
                                    alt="img"
                                />
                            </a>
                            <div class="info">
                                <a href="${window.location.origin +'/product/'+ item.product.slug}" class="name" target="_blank" 
                                    style="color:unset;text-overflow: ellipsis;overflow: hidden; white-space: nowrap;"
                                >
                                    ${item.product.name}
                                </a>
                                <div>
                                    <div>
                                        Size: ${item.size}
                                    </div>
                                    <div>
                                        Color: ${item.color}
                                    </div>
                                    <div>
                                        SKU: ${item.product_sku}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td style="text-align: center;">
                        Qty: ${item.qty}
                    </td>
        
                    <td>
                        <div>
                            ₹ ${item.price_sum}
                        </div>
                        <div>${item.order_method}</div>
                    </td>
                    <td>
                        <div>
                            ${item.customer_name}
                        </div>
                        <div>
                            ${item.dropoff_streetaddress1 +', '+ item.dropoff_streetaddress2 +', '+ item.dropoff_city +', '+ item.dropoff_state +' - '+ item.dropoff_pincode}
                        </div>
                        <div>
                            <a href="tel:91${item.customer_contact_number}">+91 ${item.customer_contact_number}</a>
                        </div>
                    </td>
                </tr>
            `   ;

                if(showcases.length == index + 1){
                    setData();
                    playBeep();
                    notifyMe(`#${item.order_id} Order`);
                }
            });
        }
    })
});
function notifyMe(title) {
    if (Notification.permission !== 'granted')
        Notification.requestPermission();
    else {
        var notification = new Notification(title, {
            icon: favicon,
            body: 'New Showroom At Home Order Recieved',
        });
    }
}
function playBeep()
{
    var audio=document.createElement('audio');
    audio.style.display="none";
    audio.src = window.location.origin+'/mp3/new_order_beep.wav';
    audio.autoplay=true;
    audio.loop = true;
    document.body.appendChild(audio);
}
const setData = () => {

    $('body').append(`
        <div class="modal fade modal-3d-slit modal-success in" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="exampleModalLongTitle">
                            <i class="voyager-bell"></i>
                            Heyyyy!! You just received a new Showroom At Home Order
                        </h4>
                    </div>
                    <div class="modal-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th style="border-right: none;">Product Information</th>
                                    <th></th>
                                    <th>Amount</th>
                                    <th>Buyer Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${renderItems}
                            </tbody>
                        </table>
                    </div>

                    </div>
                    <div class="modal-footer">
                        <form action="${window.location.origin}/showcase-at-home/my-orders/order/${showcases[0].order_id}/accept-order" method="get">
                            <button type="submit" class="btn btn-success flex" style="margin:auto;">Accept</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    `);

    //showm-modal
    $('#exampleModalCenter').modal('show');
}


const timeAgo = (date) => {
    const seconds = Math.floor((new Date() - date) / 1000);

    let interval = Math.floor(seconds / 31536000);
    if (interval > 1) {
        return interval + ' years ago';
    }

    interval = Math.floor(seconds / 2592000);
    if (interval > 1) {
        return interval + ' months ago';
    }

    interval = Math.floor(seconds / 86400);
    if (interval > 1) {
        return interval + ' days ago';
    }

    interval = Math.floor(seconds / 3600);
    if (interval > 1) {
        return interval + ' hours ago';
    }

    interval = Math.floor(seconds / 60);
    if (interval > 1) {
        return interval + ' minutes ago';
    }

    if(seconds < 10) return 'just now';

    return Math.floor(seconds) + ' seconds ago';
};


// request permission on page load
document.addEventListener('DOMContentLoaded', function() {
    if (!Notification) {
        alert('Desktop notifications not available in your browser. Try Chromium.');
        return;
    }
    if (Notification.permission !== 'granted')
        Notification.requestPermission();
});

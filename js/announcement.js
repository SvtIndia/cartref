let lists = '';
let bgColor = 'primary';

function fetchAnnouncements() {
    $.ajax({
        type: "GET",
        url: "/api/fetch/announcement",
        success: function (data) {
            if (data && data.length > 0) {
                data.forEach((item, index) => {
                    lists += `<li>${item.message}</li>`;
                    bgColor = item.color;
                });
                setAnnouncement && setAnnouncement();
            }
        }
    })
}

function setAnnouncement() {
    $('body').append(`
        <div class="modal fade modal-3d-slit modal-${bgColor} in" id="announcementModal" tabIndex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="exampleModalLongTitle">
                            <i class="voyager-bell"></i>
                            New Alert
                        </h4>
                    </div>
                    <div class="modal-body" style="padding:20px 0;">
                        <ul>
                            ${lists}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    `);

    //showm-modal
    $('#announcementModal').modal('show');
}


fetchAnnouncements && fetchAnnouncements();
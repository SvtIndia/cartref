const toastComponent = (id, bgClass, msg, icon) => {
    return `
        <div class="max-w-xs border border-gray-200 rounded-lg shadow-xl text-white mt-2 ${bgClass}" role="alert" id="${id}">
            <div class="flex p-4">
                <div class="flex items-center flex-shrink-0">
                    <i class="${icon} flex-shrink-0 h-5 w-5 text-white  mt-0.5"></i>
                </div>
                <div class="ms-3">
                    <p class="text-base">
                        ${msg}
                    </p>
                </div>
            </div>
        </div>
    `
}
const toast = {
    show_toast: (type, msg) => {
        const id = new Date().getTime()
        if (type === 'info' || type === 'primary') {
            $('#toast-div').append(toastComponent('toast_' + id, 'bg-blue-500', msg, 'fi fi-rr-info'))
        } else if (type === 'success') {
            $('#toast-div').append(toastComponent('toast_' + id, 'bg-green-500', msg, 'fi fi-rr-check-circle'))
        } else if (type === 'warning') {
            $('#toast-div').append(toastComponent('toast_' + id, 'bg-yellow-500', msg, 'fi fi-rr-triangle-warning'))
        } else if (type === 'danger' || type === 'error') {
            $('#toast-div').append(toastComponent('toast_' + id, 'bg-red-500', msg, 'fi fi-rr-exclamation'))
        }
        $('#toast_' + id).delay(5000).fadeOut(300);
    }
}

export default toast;
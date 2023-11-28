const formatDate = {
    formatSimpleDate(str) {
        if (!str) return;
        const monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];
        let date = new Date(str);
        let day = date.getDate();
        let month = date.getMonth();
        let year = date.getFullYear();

        return day + ' ' + monthNames[month] + ', ' + year;
    },
    formatTime(str) {
        if (!str) return;
        let date = new Date(str);
        let hour = (date.getHours()).toString().padStart(2, '0');
        let min = (date.getMinutes()).toString().padStart(2, '0');

        return hour + ':' + min;
    },
    formDateTime(str){
        const date = this.formatSimpleDate(str);
        const time = this.formatTime(str);

        return date + '<br> at '+ time;
    }
};
export default formatDate;
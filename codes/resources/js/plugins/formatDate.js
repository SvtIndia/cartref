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
        let hour = date.getHours();
        let min = date.getMinutes();

        return hour + ' : ' + min;
    },
};
export default formatDate;
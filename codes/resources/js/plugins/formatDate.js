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
};
export default formatDate;
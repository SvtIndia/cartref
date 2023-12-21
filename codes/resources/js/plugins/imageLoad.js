const imageLoad = {
    imageLoadError: (e) => {
        e.target.src = window.location.origin + '/images/placeholder.png';
    }
}

export default  imageLoad;
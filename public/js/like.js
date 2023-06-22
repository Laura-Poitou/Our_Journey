const like = {
        init:function() {
            let likeLinks = document.querySelectorAll('.js-like');

            for (const currentLink of likeLinks) {
                currentLink.addEventListener('click',like.handleOnClickBtnLike);
            }
        },

        handleOnClickBtnLike:function (event) {
        event.preventDefault();

        const url = this.href;

        axios.get(url).then(function(response) {
            console.log(response);
        })
        },
}


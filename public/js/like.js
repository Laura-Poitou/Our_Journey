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
        const spanCount = this.querySelector('span.js-likes');
        const icone = this.querySelector('i');

        axios.get(url).then(function(response) {
            const likes = response.data.likes;
            spanCount.textContent = likes;

            if(icone.classList.contains('fa-solid')) {
                icone.classList.replace('fa-solid', 'fa-regular');
            } else {
                icone.classList.replace('fa-regular', 'fa-solid');
            }

        })
        },
}


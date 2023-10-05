document.addEventListener('DOMContentLoaded', function () {
    const SERVER_URL = 'http://www.proyecto-laravel.com/';

    const likeImages = document.querySelectorAll('.btn-like, .btn-dislike');
    const likeImageSrc = SERVER_URL + 'img/heart-red.png';
    const dislikeImageSrc = SERVER_URL + 'img/heart-gray.png';

    likeImages.forEach(function (likeImage) {
        likeImage.addEventListener('click', function () {
            const postId = this.getAttribute('data-id');
            const currentSrc = this.getAttribute('src');

            if (currentSrc === likeImageSrc) {
                this.setAttribute('src', dislikeImageSrc);
                this.nextElementSibling.textContent = parseInt(this.nextElementSibling.textContent) - 1;

                // Agregar una llamada AJAX para registrar el "dislike" en el servidor.
                var xhr = new XMLHttpRequest();

                xhr.open('GET', SERVER_URL + 'dislike/' + postId, true);

                xhr.onreadystatechange = function () {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            if (JSON.parse(xhr.response).like) {
                                console.log('Diste dislike a la foto');
                            } else {
                                console.log('Error al dar like');
                            }
                        }
                    }
                };

                xhr.send();
            } else {
                this.setAttribute('src', likeImageSrc);
                this.nextElementSibling.textContent = parseInt(this.nextElementSibling.textContent) + 1;

                // Agregar una llamada AJAX para registrar el "like" en el servidor.
                var xhr = new XMLHttpRequest();

                xhr.open('GET', SERVER_URL + 'like/' + postId, true);

                xhr.onreadystatechange = function () {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            if (JSON.parse(xhr.response).like) {
                                console.log('Diste like a la foto');
                            } else {
                                console.log('Error al dar like');
                            }
                        }
                    }
                };

                xhr.send();
            }
        });
    });

    document.getElementById('buscador').addEventListener('submit', function (e) {
        e.preventDefault();

        window.location =  SERVER_URL + 'usuarios/' + document.getElementById('search').value;
    });


});

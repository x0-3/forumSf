import axios from "axios";

export default class Like {

    constructor(likeElements){

        this.likeElements = likeElements;

        if(this.likeElements){

            this.init()
        }
    }


    init() {

        this.likeElements.map(element => {

            element.addEventListener('click', this.onClick)
        })
    }

    // on click event
    onClick(e) {

        e.preventDefault(); // doesn't send to db
        const url = this.href; //get the url from the a element

        // make a get request to the controller
        axios.get(url).then((response) => {
        
            // get the nb of like from the response
            const nb = response.data.nbLike;
            const span = this.querySelector('span');

            this.dataset.nb = nb;
            span.innerHTML = nb + 'Like'; // update the like count

            // get the icon from the HTML script
            const thumbsUpFilled = this.querySelector('i.fa-solid.fa-thumbs-up');
            const thumbsUpUnfilled = this.querySelector('i.fa-regular.fa-thumbs-up');

            // toggle between the two icons
            thumbsUpFilled.classList.toggle('d-none');
            thumbsUpUnfilled.classList.toggle('d-none');
        })
    }
}
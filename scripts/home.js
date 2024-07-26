import {timeSince ,viewsRound} from '../components/roundingValue.js';

async function loadVideos() {
    try {
        const response = await fetch('http://localhost:8000/index.php');
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();

        let videosHTML = '';
        data.forEach(video => {
            const releaseDate = new Date(video.releaseDate);
            const timeDiff = timeSince(releaseDate); // Используем новую функцию
            videosHTML += `
            <div class="video-section__video-container">
                <p class="video-section__video-container__video-preview--duration">${video.duration}</p>
                <img class="video-section__video-container__video-preview--img" src="${video.thumbnail}" alt="">
                <div class="video-section__video-container__info">
                    <a href=""><img src="${video.channelIcon}" alt="" class="video-section__video-container__info--user-avatar"></a>
                    <div class="video-section__video-container__info__text-info">
                        <a href='' class="video-section__video-container__info__text-info--title">${video.title}</a>
                        <a href='' class="video-section__video-container__info__text-info--author-username">${video.author}</a>
                        <div class="video-section__video-container__info__text-info__watches-and-date">
                            <p class="video-section__video-container__info__text-info__watches-and-date--text">${viewsRound(video.views)}</p>
                            <span class="separator">•</span>
                            <p class="video-section__video-container__info__text-info__watches-and-date--date">${timeDiff}</p>
                        </div> 
                    </div>
                    <a href="" class="video-section__video-container__info__text-info--three-dots"><img src="image/icons/three-dots.svg" alt=""></a>
                </div>
            </div>
            `;
        });

        document.getElementById('video-section').innerHTML = videosHTML;
        
    } catch (error) {
        console.error(error.message);
    }
}

loadVideos();

const burgerMenu =document.getElementById('top-nav-burger-menu') 
burgerMenu.addEventListener('click', () => {
    const categoryBar = document.getElementById('category-bar')
    const sidebar = document.getElementById('side-bar')
    const fullSidebar = document.getElementById('full-side-bar')

    if (fullSidebar.classList.contains('hidden')) {
        sidebar.classList.add('hidden')
        fullSidebar.classList.remove('hidden')
        categoryBar.classList.replace('side-bar-padding', 'full-side-bar-padding')
        document.body.classList.replace('side-bar-padding', 'full-side-bar-padding')
    }else if (sidebar.classList.contains('hidden')){
        sidebar.classList.remove('hidden')
        fullSidebar.classList.add('hidden')
        categoryBar.classList.replace('full-side-bar-padding', 'side-bar-padding')
        document.body.classList.replace('full-side-bar-padding', 'side-bar-padding')
    }

})

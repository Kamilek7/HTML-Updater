const images = [{srcs:['imgs\\img-0.png', 'imgs\\img-1.png'], idx:0},
{srcs:['imgs\\img-2.png', 'imgs\\img-3.png'], idx:0},
{srcs:['imgs\\img-4.png', 'imgs\\img-5.png', 'imgs\\img-6.png'], idx:0},
{srcs: [], idx:0},
{srcs:['imgs\\img-7.png'], idx:0},
{srcs:['imgs\\img-8.png', 'imgs\\img-9.png'], idx:0},
{srcs:['imgs\\img-10.png', 'imgs\\img-11.png', 'imgs\\img-12.png'], idx:0},
{srcs:['imgs\\img-13.png', 'imgs\\img-14.png'], idx:0},
{srcs:['imgs\\img-15.png'], idx:0},
];
const pages = [document.getElementById("page1"),document.getElementById("page2"), document.getElementById("page3")];
const numPages = pages.length;
const cards = document.getElementsByClassName("mainBoxes");
const cardPlaceholder = document.getElementById("placeholder");

var currentPage = 1;
var shuffled = false;
var waitingCard = false;
var waitingPage = false;

function changeIMG(id)
{
    let img = document.getElementById(`images_${id}`);
    let idx = (images[id].idx+1)%(images[id].srcs.length);
    let src = images[id].srcs[idx];
    img.style.animationName = "imgChangeIn";
    setTimeout(() => {
        img.src = src;
        img.style.animationName = "imgChangeOut";
    }, 500)
    images[id].idx = idx;
    
    console.log(images);
}

function nextPage()
{
    
    if (currentPage<numPages && !waitingPage)
    {
        waitingPage = true;
        pages[currentPage].style.animationName = "scrollUp";
        pages[currentPage].addEventListener('animationend', () => {
            waitingPage=false;
        }, { once: true });
        currentPage++;
    }
}
function prevPage()
{
    
    if (currentPage>1  && !waitingPage)
    {
        waitingPage = true;
        currentPage--;
        pages[currentPage].style.animationName = "scrollDown";
        pages[currentPage].addEventListener('animationend', () => {
            waitingPage=false;
        }, { once: true });
        
    }
}

function changeIntroCard()
{
    if (!waitingCard)
    {
        waitingCard = true;
        shuffled = !shuffled;
        cards[+shuffled].childNodes[1].style.animationName = "cardToBack";
        cards[+(!shuffled)].childNodes[1].style.animationName = "cardToFront";
        cards[+shuffled].childNodes[1].addEventListener('animationend', () => {
            waitingCard=false;
        });
    }
}

cardPlaceholder.addEventListener("mouseenter", changeIntroCard);

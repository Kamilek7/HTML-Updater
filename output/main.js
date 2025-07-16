const pages = [document.getElementById("page1"),document.getElementById("page2"), document.getElementById("page3")];
const numPages = pages.length
const cards = document.getElementsByClassName("mainBoxes")
const cardPlaceholder = document.getElementById("placeholder")

var currentPage = 1;
var shuffled = false;
var waitingCard = false;
var waitingPage = false;

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

// var pageList = [document.getElementById("intro"), document.getElementById("projects"), document.getElementById("test")]

// var numberOfPages = 3;
// var currentPage = 0;

// var scrolling = 0;



// function scrollManager(eventDelta)
// {
//     wheelReset = setTimeout(() => scrolling=0, 100);
//     clearTimeout(wheelReset);
//     scrolling += eventDelta/ Math.abs(eventDelta)

//     if (scrolling < -3) 
//     {
//         scrolling = 0;
//         if (currentPage<numberOfPages-1)
//         {
//             currentPage+=1;
//             pageList[currentPage-1].style.animationName = "scrollDown";
//         }
            
        
//     }
//     else if (scrolling > 3) 
//     {
//         scrolling = 0;
//         if (currentPage>0)
//         {
//             currentPage-=1;
//             pageList[currentPage].style.animationName = "scrollUp";
//         }
            
//     }
// }

cardPlaceholder.addEventListener("mouseenter", changeIntroCard);
// window.addEventListener("wheel", (event)=> scrollManager(event.wheelDeltaY));


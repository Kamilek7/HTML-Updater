const pages = [document.getElementById("page1"),document.getElementById("page2"), document.getElementById("page3")];
const numPages = pages.length
var currentPage = 1;

function nextPage()
{
    
    if (currentPage<numPages)
    {
        console.log("test");
        pages[currentPage].style.animationName = "scrollUp";
        currentPage++;
    }
}
// var pageList = [document.getElementById("intro"), document.getElementById("projects"), document.getElementById("test")]

// var numberOfPages = 3;
// var currentPage = 0;
// var cards = document.getElementsByClassName("mainBoxes")
// var cardPlaceholder = document.getElementById("placeholder")
// var shuffled = false;
// var waiting = false;
// var scrolling = 0;

// function changeIntroCard()
// {
//     if (!waiting)
//     {
//         waiting = true;
//         shuffled = !shuffled;
//         console.log();
//         cards[+shuffled].childNodes[1].style.animationName = "cardToBack";
//         cards[+ (!shuffled)].childNodes[1].style.animationName = "cardToFront";
//         setTimeout(() => waiting=false, 2500);
//     }
// }

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

// cardPlaceholder.addEventListener("mouseenter", changeIntroCard);
// window.addEventListener("wheel", (event)=> scrollManager(event.wheelDeltaY));

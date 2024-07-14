var pages = {Introduction: 0};
var currentPage = pages.Introduction;
var cards = document.getElementsByClassName("mainBoxes")
var cardPlaceholder = document.getElementById("placeholder")
var shuffled = false;
var waiting = false;
var scrolling = 0;

function changeIntroCard()
{
    if (!waiting)
    {
        waiting = true;
        shuffled = !shuffled;
        console.log();
        cards[+shuffled].childNodes[1].style.animationName = "cardToBack";
        cards[+ (!shuffled)].childNodes[1].style.animationName = "cardToFront";
        setTimeout(() => waiting=false, 2500);
    }
}

function scrollManager(eventDelta)
{
    setTimeout(() => scrolling=0, 1000);
    scrolling += eventDelta/ Math.abs(eventDelta)
    if (scrolling<0)
    {
        if (scrolling<-4)
        {
            console.log("scrolledDown");
            scrolling = 0;
        }
        else
        {
            console.log("barelyDown");
        }
    }
    else if (scrolling>0)
    {
        if (scrolling>4)
        {
            console.log("scrolledUp");
            scrolling = 0;
        }
        else 
        {
            console.log("barelyUp");
        }
    }

}

cardPlaceholder.addEventListener("mouseenter", changeIntroCard);
window.addEventListener("wheel", (event)=> scrollManager(event.wheelDeltaY));

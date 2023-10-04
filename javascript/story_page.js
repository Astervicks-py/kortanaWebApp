function $(element) {
    return document.querySelector(element);
}


const views = document.querySelector(".views");
let open = false;
function displayViewers()
{
    if(!open)
    {
        $(".viewed_users").style.bottom = "70%";
        $(".viewers").style.bottom = "70%";
        open = true;
    }else
    {
        $(".viewed_users").style.bottom = "0%";
        $(".viewers").style.bottom = "0%";
        open = false;
    }

}
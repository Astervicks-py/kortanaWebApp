const form = document.querySelector('form');
const submitbtn = form.querySelector('.btn');
const error = document.querySelector('.error');
notific_Btn = document.getElementById('notifications'),
back_img = document.querySelectorAll(".background img"),
colors = document.querySelectorAll(".color"),
fonts = document.querySelectorAll(".font"),
root = document.querySelector(":root"),
notific_Popup = document.querySelector('.notification-popup'),
notific_Box = document.querySelector('.notification-box'),
body = document.querySelector("body"),
bodyWidth = parseInt(window.getComputedStyle(body).getPropertyValue("width"));


function $(element) {
    return document.querySelector(element);
}

console.log(error);

form.onsubmit = (e) =>{
    e.preventDefault();
}

$("textarea").style.background = "url(http://localhost/Kortana/background/background_1.jpg)";
$("textarea").style.backgroundPosition = "center";
$("textarea").style.backgroundSize = "cover";

// Get the selected background
function select(element)
{
    back_img.forEach(e => {
        e.classList.remove("selected");
    });
    element.classList.add("selected");
    $("textarea").style.background = "url('" + element.src + "')";
    $("textarea").style.backgroundPosition = "center";
    $("textarea").style.backgroundSize = "cover";
   
}

//get selected color
function color_select(element) 
{
    colors.forEach(e => {
        e.classList.remove("selected");
    });
    element.classList.add("selected");

    $("textarea").style.color = element.style.background;
}

//update selected Font
function font_select(element) 
{
    fonts.forEach(e => {
        e.classList.remove("selected");
    });
    element.classList.add("selected");

    $("textarea").style.fontFamily = element.style.fontFamily;
}

//get selcted
function get_selected(obj)
{
    let selected;
    obj.forEach(element => {
        if(element.classList.contains("selected"))
        {
            selected = element;
        }
    });
    return selected;
}

// Post story
submitbtn.onclick = () => {
    $(".individual-loader").style.display = "flex";
    
    let background = get_selected(back_img).src;
    let color = get_selected(colors).style.background;
    let font = get_selected(fonts).style.fontFamily;
    $(".background_value").value = background;
    $(".color_value").value = color;
    $(".font_value").value = font;
    // console.log(background,color);
    // return;
    setTimeout(() => {
        let xhr = new XMLHttpRequest();
        xhr.open('POST','./includes/story_post.inc.php',true);
        xhr.onload = () =>{
            if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
                let data = xhr.response;
                if(data == "Posted"){
                    location.href="./index.php";
                }else{
                    // console.log(data);
                    error.innerHTML = data;
                    error.style.display = "block";
                }
            }
        }
        let formInfo = new FormData(form);
        xhr.send(formInfo);
    }, 2000);
}

// Get Unread Message
setInterval(() => {
    let xhr = new XMLHttpRequest();
    xhr.open('GET','./includes/get_unread_message.inc.php',true);
    xhr.onload = () =>{
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            let data = xhr.response;
            // console.log(data);
            $(".messages-count").innerHTML = data;
        }
    }
    xhr.send();
}, 1000);


function get_notific(file) {
    let xhr = new XMLHttpRequest();
    xhr.open('GET',file,true);
    xhr.onload = () =>{
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            let data = xhr.response;
            // console.log(data);
            notific_Box.innerHTML = data;
        }
    }
    xhr.send();
}

// count Notification
setInterval(() => {
    let xhr = new XMLHttpRequest();
    xhr.open('GET','./includes/count_notification.inc.php',true);
    xhr.onload = () =>{
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            let data = xhr.response;
            // console.log(data);
            $(".notific_count").innerHTML = data;
        }
    }
    xhr.send();
}, 1000);

// Get Notification
setInterval(() => {
    get_notific('./includes/get_notification.php');
}, 1000);

// Navbar Config
if(bodyWidth < 700)
{
    const nonActive = document.querySelectorAll(".menu-item:not(.active)");
    let toggle = false;
    document.querySelector(".side-bar .active").onclick = ()=>
    {
        if(toggle == false)
        {
            for (let index = 0; index < nonActive.length; index++) 
            {
                nonActive[index].style.display = "flex";
                // console.log(nonActive[index]);
            }
            document.querySelector("main .container .left").style.opacity = 1;
            document.querySelector("main .container .left").style.top = "20vh";
            toggle = true;
        }else{
            for (let index = 0; index < nonActive.length; index++) 
            {
                nonActive[index].style.display = "none";
                // console.log(nonActive[index]);
            }
            document.querySelector("main .container .left").style.opacity = .6;
            document.querySelector("main .container .left").style.top = "75vh";
            toggle = false;
        }
        
        // alert("done");
    }
}

// get theme 
if(body.classList.contains("dark"))
{
    root.style.setProperty('--color-dark','hsl(252, 30%, 17%)');
    root.style.setProperty('--color-black','hsl(252,30%,10%)');
    root.style.setProperty('--color-border','var(--color-primary)');
    root.style.setProperty('--color-white','hsl(252,75%,64%)');
}else if(body.classList.contains("yellow"))
{
    root.style.setProperty('--color-dark','#000');
    root.style.setProperty('--color-black','#000');
    root.style.setProperty('--color-border','#fe0');
    root.style.setProperty('--color-text','#fe0');
    root.style.setProperty('--color-white','#fe0');
}else{
    root.style.setProperty('--color-dark','#000');
    root.style.setProperty('--color-black','#000');
    root.style.setProperty('--color-border','#0f0');
    root.style.setProperty('--color-white','#000');
}

// Read Nortification
notific_Btn.onclick = () =>{
    if(notific_Popup.style.display == "none")
    {
        notific_Popup.style.display = "block";

        /** XML REQUEST  */
        let xhr = new XMLHttpRequest();
        xhr.open('GET','./includes/get_notification.php',true);
        xhr.onload = () =>{
            if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
                let data = xhr.response;
                // console.log(data);
                notific_Box.innerHTML = data;
            }
        }
        xhr.send();
    }
    else if(notific_Popup.style.display == "block")
    {
        notific_Popup.style.display = "none";
    }
 
}
// console.log(get_selected(colors).style.background);

/** remove The Second .middle when th display screen is above */
if(bodyWidth > 1000)
{
    $(".middle:nth-child(3)").style.display = "none";
    $(".division_2").style.flexDirection = "column";
}

if(bodyWidth > 270 && bodyWidth < 800)
{
    $(".middle:nth-child(3)").style.display = "none";
}

/** Start Ajax on img change */
$("#new_background").onchange = () =>
{
    let image = $("#new_background").value;
    let xhr = new XMLHttpRequest();
    xhr.open("POST","includes/add_custom_background.php",true);
    xhr.onload = () =>
    {
        let data = xhr.response;
        console.log(data);
        if(data === true || data == 1)
        {
            location.href = "story_post.php";
        }
    }
    let form = new FormData($(".custom-background"))
    xhr.send(form)
}


/** If an Image has been added */
$(".img").onchange = () =>
{
    $("#main_form").onsubmit = (e) =>
    {
        e.preventDefault();
    }
    let xhr = new XMLHttpRequest();
    xhr.open("POST","includes/preview_post.inc.php",true);
    xhr.onload = () =>
    {
        let data = xhr.response;
        console.log(data);
        $(".preview").src = "includes/" + data;
    }
    let form = new FormData($("#main_form"))
    xhr.send(form);

    if(bodyWidth < 600)
    {
        $("#middle_2").style.display = "none";
        $("#middle_3").style.display = "none";
        console.log($(".middle:nth-child(2)"));
    }

    $("textarea").style.display = "none";
    $(".preview").style.display = "block";
    $(".img_caption").style.display = "block";
}
// console.log($("#new_background"));
const msg = document.getElementById('messages-notification'),
    body = document.querySelector('body'),
    themebtn = document.getElementById('theme'),
    themePage = document.querySelector('.theme-page'),
    right = document.querySelector('.right'),
    test = document.querySelector('.test'),
    root = document.querySelector(':root'),
    notific_Btn = document.getElementById('notifications'),
    notific_Box = document.querySelector('.notification-box');
    

function $(element) {
    return document.querySelector(element);
}

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

let notification_count = 0;
// Count notifications
setInterval(() => {
    let xhr = new XMLHttpRequest();
    xhr.open('GET','./includes/count_notification.inc.php',true);
    xhr.onload = () =>{
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            let data = xhr.response;
            // console.log(data);
            console.log(notification_count);
           
            if(data > notification_count)
            {
                $("#mySong").play();
                notification_count = data;
                console.log(notification_count);
            }
            $(".notification-count").innerHTML = data;
        }
    }
    xhr.send();
}, 1000);


let message_notification = 0;
// Get the unread message
setInterval(() => {
    let xhr = new XMLHttpRequest();
    xhr.open('GET','./includes/get_unread_message.inc.php',true);
    xhr.onload = () =>{
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            let data = xhr.response;
            console.log(message_notification);
            if(data > message_notification)
            {
                $("#mySong2").play();
                message_notification = data;
                console.log(message_notification);
            }
            $("#messages-count").innerHTML = data;
        }
    }
    xhr.send();
}, 1000);

// Read all notiiction when ckicked

$(".back-icon").onclick = (e) =>
{
    e.preventDefault();
    let xhr = new XMLHttpRequest();
    xhr.open('GET','./includes/read_notification.inc.php',true);
    xhr.onload = () =>{
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
        {
            let data = xhr.response;
            location.href = "index.php";
        }
    }
    xhr.send();
    
}



setTimeout(() => {
    get_notific('./includes/get_notification.php');
}, 1000);

// Check the body size of the window for responsiveness
let bodyWidth = parseInt(window.getComputedStyle(body).getPropertyValue("width"));
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
            document.querySelector("main .container .left").style.top = "15vh";
            document.querySelector("main .container .left .profile").style.display= "flex";
            toggle = true;
        }else{
            for (let index = 0; index < nonActive.length; index++) 
            {
                nonActive[index].style.display = "none";
                // console.log(nonActive[index]);
            }

            document.querySelector("main .container .left").style.opacity = .6;
            document.querySelector("main .container .left").style.top = "75vh";
            document.querySelector("main .container .left .profile").style.display = "none";
            toggle = false;
        }
        
        // alert("done");
    }
}


if(bodyWidth > 700)
{
    $(".menu-item:last-child").style.display = "none";
    $(".menu-item:nth-child(8)").style.display = "none";
}

function dontRef(form) {
    form.onsubmit = (e) =>{
        e.preventDefault();
    }
}


let size = parseInt(window.getComputedStyle(body).getPropertyValue('width'));
let display = false;

// Theme Selection
themebtn.onclick = () =>{
    if(display == false){
        themePage.style.display ='flex';
        display = true;
    }else{
        themePage.style.display ='none';
        display = false;
    }
    
    
    // alert(size);
}

// alert(typeof(parseInt(size)));
msg.onclick = () =>{
    window.location = "chat_users_page.php";

}

// Change Theme of the page
if(body.classList.contains("dark"))
{
    // $(".logo h1").style.color = "#000";
    root.style.setProperty('--color-dark','hsl(252, 30%, 17%)');
    root.style.setProperty('--color-black','hsl(252,30%,10%)');
    root.style.setProperty('--color-border','var(--color-primary)');
    root.style.setProperty('--color-white','hsl(252,75%,64%)');
}else{
    // $(".logo h1").style.color = "#fff";
    root.style.setProperty('--color-dark','#000');
    root.style.setProperty('--color-black','#000');
    root.style.setProperty('--color-border','yellow');
    root.style.setProperty('--color-white','#000');
}



function ajax(data)
{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./includes/theme.inc.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                // console.log(data);
                if(data == "updated"){
                    location.href = "./index.php";
                }
				
            }
        }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("theme=" + data);
}

$("#dark").addEventListener("click",()=>{
    ajax("dark");
})

$("#black").addEventListener("click",()=>{
    ajax("black");    
})



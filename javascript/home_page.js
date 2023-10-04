const feeds = document.getElementById('feeds'),
    messages = document.getElementById('messages'),
    friendRequest = document.getElementById('friend-request'),
    msg = document.getElementById('messages-notification'),
    messagesTab = document.getElementById('messages'),
    body = document.querySelector('body'),
    themebtn = document.getElementById('theme'),
    themePage = document.querySelector('.theme-page'),
    right = document.querySelector('.right'),
    test = document.querySelector('.test'),
    root = document.querySelector(':root'),
    form = document.querySelector('form'),
    notific_Btn = document.getElementById('notifications'),
    notific_Popup = document.querySelector('.notification-popup'),
    notific_Box = document.querySelector('.notification-box'),
    postBtn = form.querySelector('.post-btn'),
    desireeBar = document.querySelector("#desireeBar"),
    desiree = document.querySelector('.followers'),
    commentBtn = document.querySelector('.comment');


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

const counters = document.querySelectorAll(".notific_count");
let notification_count = 0;
// Count notifications
setInterval(() => {
    let xhr = new XMLHttpRequest();
    xhr.open('GET','./includes/count_notification.inc.php',true);
    xhr.onload = () =>{
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            let data = xhr.response;
            // console.log(data);
            // console.log(notification_count);
           
            if(data > notification_count)
            {
                $("#mySong").play();
                notification_count = data;
                // console.log(notification_count);
            }

            counters.forEach(element => {
                element.innerHTML = data;
                if(data == 0)
                {
                    element.style.display = "none";
                }else{
                    element.style.display = "block";
                }
                
            });

            
        }
    }
    xhr.send();
}, 1000);

setInterval(() => {
    let xhr = new XMLHttpRequest();
    xhr.open('GET','./includes/desiree.inc.php',true);
    xhr.onload = () =>{
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            let data = xhr.response;
            // console.log(data);
            desiree.innerHTML = data;
        }
    }
    xhr.send();
}, 500);

let message_notification = 0;
const msg_counters = document.querySelectorAll(".messages-count");
// Get the unread message
setInterval(() => {
    let xhr = new XMLHttpRequest();
    xhr.open('GET','./includes/get_unread_message.inc.php',true);
    xhr.onload = () =>{
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            let data = xhr.response;
            // console.log(message_notification);
            if(data > message_notification)
            {
                $("#mySong2").play();
                message_notification = data;
                // console.log(message_notification);
            }

            msg_counters.forEach(element => {
                element.innerHTML = data;
                if(data == 0 || !data)
                {
                    element.style.display = "none";
                }else{
                    element.style.display = "block";
                }
                
            });
        }
    }
    xhr.send();
}, 1000);

// Read all notiiction when ckicked
notific_Btn.onclick = () =>{
    if(notific_Popup.style.display == "none")
    {
        notific_Popup.style.display = "block";

        let xhr = new XMLHttpRequest();
        xhr.open('GET','./includes/read_notification.inc.php',true);
        xhr.onload = () =>{
            if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
                let data = xhr.response;

            }
        }
        xhr.send();
        /** XML REQUEST  */
        get_notific('./includes/get_notification.php');
        
    }
    else if(notific_Popup.style.display == "block")
    {
        notific_Popup.style.display = "none";
    }
 
}


setInterval(() => {
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

form.onsubmit = (e) =>{
    e.preventDefault();
}

// Post caption
postBtn.onclick = () =>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./includes/post-caption.inc.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                // console.log(data);
                if(data == "caption Posted"){
                    location.href = "./index.php";
                }
				
            }
        }
    }
    let formData = new FormData(form)
    xhr.send(formData);
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
const icons = document.querySelectorAll(".nav-icon");
if(body.classList.contains("dark"))
{
    $(".logo h1").style.color = "#000";
    root.style.setProperty('--color-dark','hsl(252, 30%, 17%)');
    root.style.setProperty('--color-black','hsl(252,30%,10%)');
    root.style.setProperty('--color-border','var(--color-primary)');
    root.style.setProperty('--color-white','hsl(252,75%,64%)');
}else if(body.classList.contains("yellow"))
{
    $(".logo h1").style.color = "#000";
    
    icons.forEach(element=>{
        element.style.color = "#000";
    });
    root.style.setProperty('--color-dark','#000');
    root.style.setProperty('--color-black','#000');
    root.style.setProperty('--color-border','#fe0');
    root.style.setProperty('--color-text','#fe0');
    root.style.setProperty('--color-white','#fe0');
}else{
    $(".logo h1").style.color = "#fff";
    root.style.setProperty('--color-dark','#000');
    root.style.setProperty('--color-black','#000');
    root.style.setProperty('--color-border','#0f0');
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

$("#yellow").addEventListener("click",()=>{
    ajax("yellow");    
})



// get home page chat users
setInterval(()=>{
    let xhr = new XMLHttpRequest();
    xhr.open('GET','./includes/home_user_chat.php',true);
    xhr.onload = () =>{
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            let data = xhr.response;
            // console.log(data);
            messagesTab.innerHTML = data;
        }
    }
    xhr.send();
},500)


// console.log(window.navigation.currentEntry.id);

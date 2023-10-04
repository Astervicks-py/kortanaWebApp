const friends = document.querySelector('.k-family'),
    desiree = document.querySelector('.followers'),
    notific_Btn = document.getElementById('notifications'),
    notific_Popup = document.querySelector('.notification-popup'),
    desireeBar = document.querySelector("#desireeBar"),
    kfamilyBar = document.querySelector("#kfamilyBar"),
    root = document.querySelector(":root"),
    notific_Box = document.querySelector('.notification-box');

const body = document.querySelector("body");
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

document.querySelector(".home-btn").onclick = ()=>
{
    location.href = "./index.php";
}

desireeBar.onkeyup = () =>
{
    let searchTerm = desireeBar.value;
    if(searchTerm != ""){
        desireeBar.classList.add("taken");
    }else{
        desireeBar.classList.remove("taken");
    }

    
    let xhr = new XMLHttpRequest();
    xhr.open("POST","includes/search.inc.php",true);
    xhr.onload = () =>
    {
        if(xhr.status === 200 && xhr.readyState === XMLHttpRequest.DONE)
        {
            let data = xhr.response;
            console.log(data);
            desiree.innerHTML = data;
        }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("searchTerm=" + searchTerm + "&section=" + "desiree");
	// xhr.send();
}

kfamilyBar.onkeyup = () =>
{
    let searchTerm = kfamilyBar.value;
    if(searchTerm != ""){
        kfamilyBar.classList.add("taken");
    }else{
        kfamilyBar.classList.remove("taken");
    }

    
    let xhr = new XMLHttpRequest();
    xhr.open("POST","includes/search.inc.php",true);
    xhr.onload = () =>
    {
        if(xhr.status === 200 && xhr.readyState === XMLHttpRequest.DONE)
        {
            let data = xhr.response;
            // console.log(data);
            friends.innerHTML = data;
        }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("searchTerm=" + searchTerm + "&section=" + "kfamily");
	// xhr.send();
}


/** Theme */

function $(element) {
    return document.querySelector(element);
}

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

setInterval(() => {
    ajax('./includes/get_unread_message.inc.php',$("#messages-count"))
    
}, 1000);


// setInterval(() => {
//     let xhr = new XMLHttpRequest();
//     xhr.open('GET','./includes/explore_users.inc.php',true);
//     xhr.onload = () =>{
//         if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
//             let data = xhr.response;
//             // console.log(data);
//             if(!kfamilyBar.classList.contains("taken"))
//             {
//                 friends.innerHTML = data;
//             }
            
//         }
//     }
//     xhr.send();
// }, 500);

// setInterval(() => {
//     let xhr = new XMLHttpRequest();
//     xhr.open('GET','./includes/desiree.inc.php',true);
//     xhr.onload = () =>{
//         if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
//             let data = xhr.response;
//             // console.log(data);
//             if(!desireeBar.classList.contains("taken"))
//             {
//                 desiree.innerHTML = data;
//             }
//         }
//     }
//     xhr.send();
// }, 500);


function ajax(file,display) {
    let xhr = new XMLHttpRequest();
    xhr.open('GET',file,true);
    xhr.onload = () =>{
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            let data = xhr.response;
            // console.log(data);
            display.innerHTML = data;
        }
    }
    xhr.send();
}

/** Count Notification */
setInterval(() => {
    ajax('./includes/count_notification.inc.php',$(".notification-count"));
}, 1000);

/** Get notification */
setInterval(() => {
    ajax('./includes/get_notification.php',notific_Box);
}, 1000);
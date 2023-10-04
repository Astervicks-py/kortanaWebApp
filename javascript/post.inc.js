const form = document.querySelector('form'),
    submitbtn = form.querySelector('.btn'),
    error = document.querySelector('.error'),
    root = document.querySelector(":root"),
    body = document.querySelector("body"),
    notific_Btn = document.getElementById('notifications'),
    notific_Popup = document.querySelector('.notification-popup'),
    notific_Box = document.querySelector('.notification-box');

function $(element)
{
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

console.log(error);
form.onsubmit = (e) =>{
    e.preventDefault();
}

submitbtn.onclick = () => {
    $(".individual-loader").style.display = "flex";
    setTimeout(() => {
        let xhr = new XMLHttpRequest();
        xhr.open('POST','./includes/post.inc.php',true);
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

setInterval(() => {
    let xhr = new XMLHttpRequest();
    xhr.open('GET','./includes/get_unread_message.inc.php',true);
    xhr.onload = () =>{
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            let data = xhr.response;
            // console.log(data);
            $("#messages-count").innerHTML = data;
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

setInterval(() => {
    let xhr = new XMLHttpRequest();
    xhr.open('GET','./includes/count_notification.inc.php',true);
    xhr.onload = () =>{
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            let data = xhr.response;
            // console.log(data);
            $(".notification-count").innerHTML = data;
        }
    }
    xhr.send();
}, 1000);

setInterval(() => {
    get_notific('./includes/get_notification.php');
}, 1000);

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

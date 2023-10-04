const form  = document.querySelector("form");
const submitBtn = document.querySelector('.submit');
const commentCont = document.querySelector('.comment_container');
const textarea = document.querySelector("textarea");
form.onsubmit = (e) =>
{
    e.preventDefault();
}



submitBtn.onclick = () =>
{
    xmlrequest();
}

/** Theme */

function $(element) {
    return document.querySelector(element);
}
let body = $("body");
if(body.classList.contains("dark"))
{
    $(":root").style.setProperty('--color-dark','hsl(252, 30%, 17%)');
    $(":root").style.setProperty('--color-black','hsl(252,30%,10%)');
    $(":root").style.setProperty('--color-border','var(--color-primary)');
    $(":root").style.setProperty('--color-white','hsl(252,75%,64%)');
}else{
    $(":root").style.setProperty('--color-dark','#000');
    $(":root").style.setProperty('--color-black','#000');
    $(":root").style.setProperty('--color-border','#00f');
    $(":root").style.setProperty('--color-white','#000');
}


function xmlrequest() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST","../includes/insert_comment.inc.php","true");
    xhr.onload = () =>
    {
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
        {
            let data = xhr.response;
            // console.log(data);
            textarea.value = "";
        }
    }
    let formInfo = new FormData(form);
    xhr.send(formInfo);
}


document.addEventListener('keydown',(e)=>{
    if(e.keyCode == 13){ // Key Code for "Enter" : to send message
        xmlrequest();
    }

    if(e.keyCode == 18){//keycode for alt : to move back to chat users page
        location.href = "../index.php";
    }
});

setInterval(() => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST","../includes/get_comment.inc.php","true");
    xhr.onload = () =>
    {
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
        {
            let data = xhr.response;
            // console.log(data);
            commentCont.innerHTML = data;

        }
    } 
    let formInfo = new FormData(form);
    xhr.send(formInfo);
}, 1000);
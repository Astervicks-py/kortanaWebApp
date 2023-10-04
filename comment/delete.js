const form  = document.querySelector("form");
const submitBtn = document.querySelector('.delete'),
body = document.querySelector("body"),
root = document.querySelector(":root");


form.onsubmit = (e) =>
{
    e.preventDefault();
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




submitBtn.onclick = () =>
{
    xmlrequest();
}

function xmlrequest() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST","../includes/delete_post.inc.php","true");
    xhr.onload = () =>
    {
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
        {
            let data = xhr.response;
            console.log(data);
            if(data == "Deleted")
            {
                location.href = "../profile.php";
            }
        }
    }
    let formInfo = new FormData(form);
    xhr.send(formInfo);
}


document.addEventListener('keydown',(e)=>{
    if(e.keyCode == 13){ // Key Code for "Delete" : to send message
        xmlrequest();
    }

    if(e.keyCode == 18){//keycode for alt : to move back to chat users page
        location.href = "../index.php";
    }
});

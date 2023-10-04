const form  = document.querySelector("form");
const submitBtn = document.querySelector('.submit');
form.onsubmit = (e) =>
{
    e.preventDefault();
}

submitBtn.onclick = () => { xmlrequest() }

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
    xhr.open("POST","../includes/share_post.inc.php","true");
    xhr.onload = () =>
    {
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
        {
            let data = xhr.response;
            console.log(data);
            if(data)
            {
                location.href = "../index.php";
            }else{
                data = "Something went wrong try again later";
                $(".error").innerHTML = data;
            }
            
        }
    }
    let formInfo = new FormData(form);
    xhr.send(formInfo);
}


document.addEventListener('keydown',(e)=>{
    if(e.keyCode == 13){ // Key Code for "Enter" : to send message
        xmlrequest();
    }

    if(e.keyCode == 18){//keycode for alt : to move back to Home page
        location.href = "../index.php";
    }
});


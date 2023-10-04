const form  = document.querySelector("form");
const submitBtn = document.querySelector('.submit');
const commentCont = document.querySelector('.comment_container');
form.onsubmit = (e) =>
{
    e.preventDefault();
}

// submitBtn.onclick = () =>
// {
//     if(submitBtn.classList.contains("liked"))
//     {
//         submitBtn.classList.remove("liked")
//     }else
//     {
//         submitBtn.classList.add("liked");  
//     }
    
//     xmlrequest();
// }

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
    xhr.open("POST","../includes/like_post.inc.php","true");
    xhr.onload = () =>
    {
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
        {
            let data = xhr.response;
            console.log(data);
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

setInterval(() => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST","../includes/get_likes.inc.php","true");
    xhr.onload = () =>
    {
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
        {
            let data = xhr.response;
            console.log(data);
            commentCont.innerHTML = data;

        }
    }
    let formInfo = new FormData(form);
    xhr.send(formInfo);
}, 1000);



    function ajax_data(e,ele) {
        e.preventDefault();
        var link = ele.href;
        let num = ele.querySelector(".like-count").textContent;
        console.log(num);
        // return;
        if(ele.style.color == "red")
        {
            ele.style.color = "#fff";
            num--;
            ele.querySelector(".like-count").innerHTML = num;      
        }else{
            ele.style.color = "red"; 
            num++;
            ele.classList.add('liked');
            setTimeout(() => {
                ele.classList.remove('liked');
            }, 1000);
            ele.querySelector(".like-count").innerHTML = num;  
        }

        let xhr = new XMLHttpRequest();
        xhr.open("POST","../includes/like_post.inc.php",true);
        xhr.onload = () =>
        {
            if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
            {
                let data = xhr.response;
                console.log(data);
                
            }
        }
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("link=" + link);
    }



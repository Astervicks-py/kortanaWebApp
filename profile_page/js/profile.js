const feed = document.querySelector('.main-content');
const Kortney = document.querySelector('#kortney');
const form = document.querySelector('.profile');
const profilePic = form.querySelector("input[type='file']");
const stats = document.querySelectorAll(".stats");
const body = document.querySelector("body"),
root = document.querySelector(':root');

function movePrimary(element) {
    stats.forEach(element => {
        element.style.borderBottom = "none";
    });

    element.style.borderBottom = "solid 3px var(--color-border)";
}
form.onsubmit = (e) =>{
    e.preventDefault();
}



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
    xhr.open("POST","./includes/like_post.inc.php",true);
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




// Change Theme of the page
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

profilePic.onchange= ()=>{
    let xhr = new XMLHttpRequest();
    xhr.open('POST','./includes/change-profilepic.php',true);
    xhr.onload = () =>{
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            let data = xhr.response;
            console.log(data);
            location.href = "./profile.php";
        }
    }
    let formInfo = new FormData(form);
    xhr.send(formInfo);
}

setTimeout(()=>{
    let xhr = new XMLHttpRequest();
    xhr.open('GET','./includes/get-user-post.php',true);
    xhr.onload = () =>{
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            let data = xhr.response;
            // console.log(data);
            feed.innerHTML = data;
        }
    }
    xhr.send();
},500)

// Kortney.onclick = () =>{
//     let xhr = new XMLHttpRequest();
//     xhr.open('GET','./includes/create_table.php',true);
//     xhr.onload = ()=>{
//         if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
//             let data = xhr.response;
//             console.log(data);
//             if(data == "success"){
//                 location.href = "./chat_with_kort.php"
//             }
            
//         } 
//     }
//     xhr.send();
// }

let bodyWidth = parseInt(window.getComputedStyle(body).getPropertyValue("width"));
if(bodyWidth < 700)
{
    const nonActive = document.querySelectorAll(".item:not(.active)");
    let toggle = false;
    document.querySelector(".side-bar .active").onclick = ()=>
    {
        if(toggle == false)
        {
            for (let index = 0; index < nonActive.length; index++) 
            {
                nonActive[index].style.display = "flex";
                console.log(nonActive[index]);
            }
            document.querySelector(".container .left").style.opacity = 1;
            document.querySelector(".container .left").style.top = "35vh";
            toggle = true;
        }else{
            for (let index = 0; index < nonActive.length; index++) 
            {
                nonActive[index].style.display = "none";
                console.log(nonActive[index]);
            }

            document.querySelector(".container .left").style.opacity = .6;
            document.querySelector(".container .left").style.top = "80vh";
            toggle = false;
        }
        
        // alert("done");
    }
}


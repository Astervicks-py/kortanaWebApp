const feed = document.querySelector('.main-content');
const form = document.querySelector('.profile');
const profilePic = form.querySelector("#file");
const stats = document.querySelectorAll(".stats");
const body = document.querySelector("body"),
root = document.querySelector(':root');


function movePrimary(element) {
    stats.forEach(element => {
        element.style.borderBottom = "none";
    });

    element.style.borderBottom = "solid 3px var(--color-border)";
}

window.onscroll = function() {
    scrollFunction()
}

function $(element) {
    return document.querySelector(element);
}

function scrollFunction()
{
    if(document.body.scrollTop > 50 || document.documentElement.scrollTop > 50)
    {
        $(".be-fixed").classList.add('scrolled');
    }else{
        $(".be-fixed").classList.remove('scrolled');
    }
}


form.onsubmit = (e) =>{
    e.preventDefault();
}
$("#info_box").onsubmit = (e) =>{
    e.preventDefault();
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
            // console.log(data);
            location.href = "./profile.php";
        }
    }
    let formInfo = new FormData(form);
    xhr.send(formInfo);
}


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
                // console.log(nonActive[index]);
            }
            document.querySelector(".container .left").style.opacity = 1;
            document.querySelector(".container .left").style.top = "35vh";
            toggle = true;
        }else{
            for (let index = 0; index < nonActive.length; index++) 
            {
                nonActive[index].style.display = "none";
                // console.log(nonActive[index]);
            }

            document.querySelector(".container .left").style.opacity = .6;
            document.querySelector(".container .left").style.top = "80vh";
            toggle = false;
        }
        
        // alert("done");
    }
}


$("#edit_btn").onclick = () =>
{
    $(".info-box").style.display = "block";
    $(".blackout").style.display = "block";
    $("body").style.maxHeight = "100vh";
    $("body").style.overflow ="hidden";
}


$("#cancel").onclick = () =>
{
    $(".info-box").style.display = "none";
    $(".blackout").style.display = "none";
    $("body").style.maxHeight = "";
    $("body").style.overflow ="auto";
    // is_open = false;
}


$("#confirm_operation").onclick = () =>
{
    $(".info-box").style.display = "none";
    $(".individual-loader").style.display = "flex";
    $("#operation_input").value = "edit_slogan";
    let xhr = new XMLHttpRequest();
    xhr.open("POST","./includes/chat_operation.inc.php",true);
    xhr.onload = () =>
    {
        if(xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200)
        {
            let data = xhr.response;
            if(data == "Operation successful")
            {
                let location_id = $("#incoming_id").value;
                location.replace("./group_info_page.php?id=" + location_id);
            }
            console.log(data)
        }
    }
    let formInfo= new FormData($("#info_box"));
    xhr.send(formInfo);
}

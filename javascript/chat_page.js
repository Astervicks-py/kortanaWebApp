const users = document.querySelector('.avaliable-users');
const form = document.querySelector('.typing-area form'),
submitbtn = form.querySelector('.submit'),
root = document.querySelector(':root'),
body = document.querySelector('body'),
chatDisplay = document.querySelector('.chat-display'),
nav = document.querySelector('nav'),
textarea = form.querySelector('textarea');
img = form.querySelector('.img');
let bodyWidth = parseInt(window.getComputedStyle(body).getPropertyValue("width"));
let bodyHeight = parseInt(window.getComputedStyle(body).getPropertyValue("height"));

function $(element) {
    return document.querySelector(element);
}

function $_All(element) {
    return document.querySelectorAll(element);
}


// console.log(root);
if(body.classList.contains("dark"))
{
    root.style.setProperty('--color-dark','hsl(252, 30%, 17%)');
    root.style.setProperty('--color-black','hsl(252,30%,10%)');
    root.style.setProperty('--color-border','var(--color-primary)');
    root.style.setProperty('--color-white','hsl(252,75%,64%)');
    $_All(".bar").forEach(element => {
        element.style.border = "solid 2px #fff";
    });
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
    $('nav').style.color = "var(--color-border)";
    // $('.setting').style.background = "var(--color-border)";
    // $('.setting').style.boxShadow = "10px 0px 0 var(--color-border), -10px 0px 0 var(--color-border)";
}


function imgChange(){
    $(".file button").style.color = "#0f0";
}

/**
 * GET CHAT USERS
 */
setInterval(()=>{
    let xhr = new XMLHttpRequest();
    xhr.open('GET','./includes/chat_users.inc.php',true);
    xhr.onload = () =>{
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            let data = xhr.response;
            // console.log(data);
            if(!$("#chat_name").classList.contains("taken"))
            {
                users.innerHTML = data;
            }
            
        }
    }
    xhr.send();
},500)



$("#chat_name").onkeyup = () =>
{
    let searchTerm = $("#chat_name").value;
    if(searchTerm != ""){
        $("#chat_name").classList.add("taken");
    }else{
        $("#chat_name").classList.remove("taken");
    }

    
    let xhr = new XMLHttpRequest();
    xhr.open("POST","includes/search.inc.php",true);
    xhr.onload = () =>
    {
        if(xhr.status === 200 && xhr.readyState === XMLHttpRequest.DONE)
        {
            let data = xhr.response;
            console.log(data);
            $(".avaliable-users").innerHTML = data;
        }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("searchTerm=" + searchTerm + "&section=" + "friend");
	// xhr.send();
}

function xmlrequest(){
    let xhr = new XMLHttpRequest();
    xhr.open('POST','./includes/chat_page.inc.php',true);
    xhr.onload = () => {
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            let data = xhr.response;
            console.log(data);
            textarea.value = '';
        }
    }
    let formInfo= new FormData(form);
    xhr.send(formInfo);
}

form.onsubmit = (e) =>{
    e.preventDefault();
}

/**
 * scroll to bottom automatically
 */
chatDisplay.onmouseover = () =>{
    chatDisplay.classList.add('active');
};

chatDisplay.onmouseleave = () =>{
    chatDisplay.classList.remove('active');
};

function scrollToBottom(){
    chatDisplay.scrollTop = chatDisplay.scrollHeight;
}

function insertChat(){
    let audio = new Audio();
    audio.src = "media/IMESSAGE.mp3";
    audio.play();
    xmlrequest();
    $(".file button").style.color = "#fff";
}

document.addEventListener('keydown',(e)=>{
    if(e.keyCode == 13){ // Key Code for "Enter" : to send message
        let audio = new Audio();
        audio.src = "media/IMESSAGE.mp3";
        audio.play();
        xmlrequest();
        
    }

    // if(e.keyCode == 18){//keycode for alt : to move back to chat users page
    //     location.href = "./chat_users_page.php";
    // }
});
 

/**
 * GETTING CHATS IN REAL TIME
 */

setInterval(() => {
    let xhr = new XMLHttpRequest();
    xhr.open('POST','./includes/get_chat.inc.php',true);
    xhr.onload = () => {
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            let data = xhr.response;
            // console.log(data);
            chatDisplay.innerHTML = data;
            if(!chatDisplay.classList.contains('active')){
                scrollToBottom();
            }
            
        }
    }
    let formInfo= new FormData(form);
    xhr.send(formInfo);
},2000);


/** Read Message */
setInterval(() => {
    let xhr = new XMLHttpRequest();
    xhr.open('POST','./includes/read_messages.inc.php',true);
    xhr.onload = () => {
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            let data = xhr.response;
            // console.log(data);
            
            
        }
    }
    let formInfo= new FormData(form);
    xhr.send(formInfo);
}, 1000);


/** Listen for chat long-press */
document.addEventListener("long-press",function(e){
    console.log(e.target)
})



let is_open = false;
$(".hamburger-menu").onclick = () =>{
    if(!is_open)
    {
        $(".dropdown-menu").style.height = "max-content";
        is_open = true;
    }else
    {
        $(".dropdown-menu").style.height = "0px";
        is_open = false;
    }
    
}

var operation;
$("#block").onclick = () =>{
    operation = $("#block").getAttribute("data-section");
    $(".info-box").style.display = "block";
    $(".blackout").style.display = "block";
    if(operation == "unblock")
    {
        $(".warning").innerHTML = "You are Unblocking this user. Will you like to proceed?";
    }else
    {$(".warning").innerHTML = "This user will no longer be able to text you. Will you like to proceed?";}
   
}

$("#unfollow").onclick = () =>{
    $(".info-box").style.display = "block";
    $(".blackout").style.display = "block";
    $(".warning").innerHTML = "Are you sure you want to Unfollow this user?";
    operation = $("#unfollow").getAttribute("data-section");
}

$("#report").onclick = () =>{
    $(".info-box").style.display = "block";
    $(".blackout").style.display = "block";
    $(".warning").innerHTML = "User will be blocked and reported. will you like to proceed?";
    operation = "report";
}

function unblock()
{
    operation = $("#block").getAttribute("data-section");
    $(".info-box").style.display = "block";
    $(".blackout").style.display = "block";
    if(operation == "unblock")
    {
        $(".warning").innerHTML = "You are Unblocking this user. Will you like to proceed?";
    }else
    {$(".warning").innerHTML = "This user will no longer be able to text you. Will you like to proceed?";}
   
}

// If operation is confirmed
$("#confirm_operation").onclick = () =>
{
    $(".info-box").style.display = "none";
    $(".individual-loader").style.display = "flex";
    $("#operation_input").value = operation;
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
                location.replace("./chat_page.php?id=" + location_id);
            }
            console.log(data)
        }
    }
    let formInfo= new FormData($("#operation_form"));
    xhr.send(formInfo);
}



$("#cancel").onclick = () =>
{
    $(".info-box").style.display = "none";
    $(".blackout").style.display = "none";
    // is_open = false;
}


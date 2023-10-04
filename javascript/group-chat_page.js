const users = document.querySelector('.avaliable-users');
const form = document.querySelector('.typing-area form'),
submitbtn = form.querySelector('.submit'),
root = document.querySelector(':root'),
body = document.querySelector('body'),
chatDisplay = document.querySelector('.chat-display'),
textarea = form.querySelector('textarea');
img = form.querySelector('.img');

// console.log(root);
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
    $('nav').style.color = "var(--color-border)";
    
}

function $(element) {
    return document.querySelector(element);
}

function hasChanged() {
 
    $(".file button").style.color = "#0f0";
   
}


function xmlrequest(){
    let xhr = new XMLHttpRequest();
    xhr.open('POST','./includes/group-chat_page.inc.php',true);
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
    xhr.open('POST','./includes/get_group_chat.inc.php',true);
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


/** 
 * Get the groups from the Groups database
 */

setInterval(() => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST","./includes/get_groups.inc.php",true);
    xhr.onload = () =>{
        if(xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200)
        {
            let data = xhr.response;
            // console.log(data);
            $(".available_groups").innerHTML = `
                <a href="./group_create.php" class="user_link" style="position:relative">
                <div class="user">
                    
                    <div class="details" style="width:100%;text-align:center;position:relative;padding:5px;">
                        <h5 style="width:100%;text-align:center;" class="user-name">Create new Group</h5>
                    </div>
                </div>
            </a>
            ` + data;
        }
    }
    xhr.send()
}, 1000);

/** Read Message */
// setInterval(() => {
//     let xhr = new XMLHttpRequest();
//     xhr.open('POST','./includes/read_messages.inc.php',true);
//     xhr.onload = () => {
//         if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
//             let data = xhr.response;
//             // console.log(data);
            
            
//         }
//     }
//     let formInfo= new FormData(form);
//     xhr.send(formInfo);
// }, 1000);


// /** Check Typing */
// setInterval(() => {
//     $friend_id = $(".friend_id").value;
//     let xhr = new XMLHttpRequest();
//     xhr.open('POST','./includes/get_typing.inc.php',true);
//     xhr.onload = () => {
//         if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
//             let data = xhr.response;
//             console.log(data);
//             $(".typing").innerHTML = data;
            
//         }
//     }
//     xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
//     xhr.send("friend_id=" + $friend_id);
// }, 200);

// /** updating typing on input */
// $("#chat_input").oninput = () =>
// {
//     $friend_id = $(".friend_id").value;
//     let xhr = new XMLHttpRequest();
//     xhr.open('POST','./includes/update_typing.inc.php',true);
//     xhr.onload = () => {
//         if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
//             let data = xhr.response;
//             console.log(data);
//             $(".typing").innerHTML = data;
            
//         }
//     }
//     xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
//     xhr.send("friend_id=" + $friend_id);
// }

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

$("#exit").onclick = () =>{
    $(".info-box").style.display = "block";
    $(".blackout").style.display = "block";
    $(".warning").innerHTML = "Are you sure you want to exist the group?";
}

$("#report").onclick = () =>{
    $(".info-box").style.display = "block";
    $(".blackout").style.display = "block";
    $(".warning").innerHTML = "Reporting the group also entails your exit from it. will you like to proceed?";
}


$("#cancel").onclick = () =>
{
    $(".info-box").style.display = "none";
    $(".blackout").style.display = "none";
    // is_open = false;
}


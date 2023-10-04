const users = document.querySelector('.avaliable-users');
const form = document.querySelector('.typing-area form'),
submitbtn = form.querySelector('.submit'),
chatDisplay = document.querySelector('.chat-display'),
textarea = form.querySelector('textarea');
img = form.querySelector('.img');


function $(element) {
    return document.querySelector(element);
}

img.onchange = () =>{
    $(".file button").style.color = "#0f0";
}


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

submitbtn.onclick = () => {
    xmlrequest();
    $(".file button").style.color = "#fff";
}

document.addEventListener('keydown',(e)=>{
    if(e.keyCode == 13){ // Key Code for "Enter" : to send message
        xmlrequest();
    }

    if(e.keyCode == 18){//keycode for alt : to move back to chat users page
        location.href = "./chat_users_page.php";
    }
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
}, 500);


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


/** Check Typing */
setInterval(() => {
    $friend_id = $(".friend_id").value;
    let xhr = new XMLHttpRequest();
    xhr.open('POST','./includes/get_typing.inc.php',true);
    xhr.onload = () => {
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            let data = xhr.response;
            console.log(data);
            $(".typing").innerHTML = data;
            
        }
    }
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send("friend_id=" + $friend_id);
}, 200);

/** updating typing on input */
$("#chat_input").oninput = () =>
{
    $friend_id = $(".friend_id").value;
    let xhr = new XMLHttpRequest();
    xhr.open('POST','./includes/update_typing.inc.php',true);
    xhr.onload = () => {
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            let data = xhr.response;
            console.log(data);
            $(".typing").innerHTML = data;
            
        }
    }
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send("friend_id=" + $friend_id);
} 
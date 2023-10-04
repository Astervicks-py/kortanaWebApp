const form = document.querySelector('form');
const textarea = document.querySelector('textarea');
const submitBtn = form.querySelector('button[type="submit"]');
const chatDisplay = document.querySelector('.chat-display');
const goBack = document.querySelector('#go-back');
form.onsubmit = (e) =>{
    e.preventDefault();
}

function scroll() {
    chatDisplay.scrollTop = chatDisplay.scrollHeight; 
}
submitBtn.onclick = ()=>{
    let xhr = new XMLHttpRequest();
    xhr.open('POST','./includes/insert_chatbot_chat.php',true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            let data = xhr.response;
            console.log(data);
            textarea.value = '';

        }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}

goBack.onclick = () =>{
    let xhr = new XMLHttpRequest();
    xhr.open('GET','./includes/destory_table.php',true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            let data = xhr.response;
            console.log(data);
            if(data == "success"){
                location.href = "./profile.php"
            }
            
        } 
    }
    xhr.send();
}


setInterval(()=>{
    let xhr = new XMLHttpRequest();
    xhr.open('GET','./includes/get-chatbot-chats.php',true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            let data = xhr.response;
            chatDisplay.innerHTML = data;
            scroll();
        } 
    }
    xhr.send();
},2000)



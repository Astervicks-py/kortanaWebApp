const back_img = document.querySelectorAll(".background img"),
form = document.querySelector("#container-form"),
submitbtn = form.querySelector("#submitBtn"),
ITC = document.querySelectorAll(".incoming_text_color"),
OTC = document.querySelectorAll(".outgoing_text_color"),
IBC = document.querySelectorAll(".incoming_background_color"),
OBC = document.querySelectorAll(".outgoing_background_color"),
fonts = document.querySelectorAll(".font");

form.onsubmit = (e) =>{
    e.preventDefault();
}

function $(element)
{
    return document.querySelector(element);
}

function select(element)
{ 
    back_img.forEach(e => {
        e.classList.remove("selected");
        e.setAttribute("data-choose","NULL");
    });
    element.setAttribute("data-choose","choosen");
    element.classList.add("selected");
    $(".preview_screen").style.backgroundImage = "url('" + element.src + "')";
}


function incoming_background_color_select(element){
    IBC.forEach(e => {
        e.classList.remove("selected");
        e.setAttribute("data-choose","NULL");
    });
    element.setAttribute("data-choose","choosen");
    element.classList.add("selected");
    $(".incoming .message").style.background = element.style.background;
}

function outgoing_background_color_select(element){
    OBC.forEach(e => {
        e.classList.remove("selected");
        e.setAttribute("data-choose","NULL");
    });
    element.setAttribute("data-choose","choosen");
    element.classList.add("selected");
    $(".outgoing").style.background = element.style.background;
}

function outgoing_color_select(element){
    OTC.forEach(e => {
        e.classList.remove("selected");
        e.setAttribute("data-choose","NULL");
    });
    element.setAttribute("data-choose","choosen");
    element.classList.add("selected");
    $(".outgoing .message_content").style.color = element.style.background;
}

//get selected color
function incoming_color_select(element) 
{
    ITC.forEach(e => {
        e.classList.remove("selected");
        e.setAttribute("data-choose","NULL");
    });
    element.setAttribute("data-choose","choosen");
    element.classList.add("selected");
    $(".incoming .message_content").style.color = element.style.background;
}

const messages = document.querySelectorAll(".message_content");
// console.log(messages);
//update selected Font
function font_select(element) 
{
    fonts.forEach(e => {
        e.classList.remove("selected");
        e.setAttribute("data-choose","NULL");
        
    });
    element.setAttribute("data-choose","choosen");
    console.log(element);
    element.classList.add("selected");

    // console.log(element.querySelector(".font-option").style.fontFamily);
    messages.forEach(item => {
        item.style.fontFamily = element.querySelector(".font-option").style.fontFamily;
    }); 
}

//get selcted
function get_selected(obj)
{
    let selected;
    obj.forEach(element => {
        if(element.classList.contains("selected"))
        {
           selected = element;
        }
    });
    return selected;
}



submitbtn.onclick = () => {
   
    // console.log(get_selected(back_img));
    // return/
    if(get_selected(back_img).getAttribute("data-choose") == "choosen")
    {
        let background = get_selected(back_img).src;
        $("#background_image_value").value = background;
    }

    if(get_selected(ITC).getAttribute("data-choose") == "choosen")
    {
        let ITcolor = get_selected(ITC).style.background;
        $("#incoming_text_color_value").value = ITcolor;
    }
    
    
    if(get_selected(OTC).getAttribute("data-choose") == "choosen")
    {
        let OTcolor = get_selected(OTC).style.background;
        $("#outgoing_text_color_value").value = OTcolor;
    }


    if(get_selected(IBC).getAttribute("data-choose") == "choosen")
    {
        
        let IBbackground = get_selected(IBC).style.background;
        $("#incoming_background_color_value").value = IBbackground;
    }
    

    if(get_selected(OBC).getAttribute("data-choose") == "choosen")
    {
        
        let OBbackground = get_selected(OBC).style.background;
        $("#outgoing_background_color_value").value = OBbackground;
    }
    

    if(get_selected(fonts).getAttribute("data-choose") == "choosen")
    {
        let font = get_selected(fonts).querySelector("p").style.fontFamily;
        $("#font_value").value = font;
    }

    let xhr = new XMLHttpRequest();
    xhr.open('POST','./includes/chat_setting.inc.php',true);
    xhr.onload = () =>{
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            let data = xhr.response;
            if(data == "updated"){
                location.href="./chat_users_page.php";
            }else{
                console.log(data);
                $(".error").innerHTML = data;
                $(".error").style.display = "block";
            }
        }
    }
    let formInfo = new FormData(form);
    xhr.send(formInfo);
}
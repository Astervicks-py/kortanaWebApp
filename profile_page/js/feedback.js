const form = document.querySelector('form'),
submitBtn = form.querySelector('button[type="submit"]');

form.onsubmit = (e) =>
{
    e.preventDefault();
}

submitBtn.onclick = ()=>
{
    let xhr = new XMLHttpRequest();
    xhr.open('POST','./includes/feedback.inc.php',true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            let data = xhr.response;
            console.log(data);
            if(data == "success"){
                location.href = "./profile.php";
            }
            
        } 
    }
    let formInfo = new FormData(form);
    xhr.send(formInfo)
}
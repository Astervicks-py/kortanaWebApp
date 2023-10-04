const form = document.querySelector('form');
const deleteBtn = form.querySelector('button[type="submit"]');

form.onsubmit = (e) =>
{
    e.preventDefault();
}

deleteBtn.onclick = () =>
{
    let xhr = new XMLHttpRequest();
    xhr.open('POST','./includes/delete_account.inc.php',true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            let data = xhr.response;
            console.log(data);
            if(data == "success"){
                location.href = "./signup.php";
            }
            
        } 
    }
    let formInfo = new FormData(form);
    xhr.send(formInfo)
}
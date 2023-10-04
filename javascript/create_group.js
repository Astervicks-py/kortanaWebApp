let selected = [];



function $(element) {
    return document.querySelector(element);
}


$("form").onsubmit = (e) =>{
    e.preventDefault();
}
$(".btn").onclick = () =>{
    $(".individual-loader").style.display = "flex"
    setTimeout(() => {
        let participants  = document.getElementsByName("selected")
    
        for(let i = 0; i < participants.length;i++)
        {
            if(participants[i].checked)
            {
                if(selected.indexOf(participants[i].getAttribute("data-userid")) == -1)
                {
                    selected.push(participants[i].getAttribute("data-userid"))
                }
                
            }
        }
        $("#added").value  = selected

        if($("#restriction").checked)
        {
            $("#restrict").value = true
        }else
        {
            $("#restrict").value = false
        }
        // ajax


        let xhr = new XMLHttpRequest();
        xhr.open("POST",'./includes/create_group.inc.php',true);
        xhr.onload = ()=>{
            if(xhr.readyState == XMLHttpRequest.DONE){
                if(xhr.status == 200){
                    let data = xhr.response;
                    // console.log(data)
                    if(data == "Successful")
                    {
                        location.href = "./chat_users_page.php";
                    }else{
                        $(".individual-loader").style.display = "none";
                        $(".error").innerHTML = "<i>" + data + "</i>";
                        $(".error").style.display = "block";
                    }
                }
            }
        }
        let formData = new FormData($("form"));
        xhr.send(formData);
        // console.log(selected)    
    }, 2000);
    
}

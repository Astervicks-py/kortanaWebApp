const video_column = document.getElementById('video');
// const like_btn = document.querySelector('.like-btn');
const comment_btn = document.querySelectorAll('.comment-btn');
const comment_cont = document.querySelector('.comments-cont');
const back_btn = document.querySelector('.back-btn');

function like(btn)
{
    // btn.style.color="red";
    btn.classList.add('red');
    let xhr = new XMLHttpRequest();
    xhr.open('POST','./includes/like_video.inc.php',true);
    xhr.onload = ()=>
    {
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
        {
            let data = xhr.response;
            console.log(data);
            // video_column.innerHTML = data;
        }
    }
    xhr.send();
}

function comment(btn)
{
    comment_btn.forEach(b =()=>{
        b.classList.remove('open');
    })
    btn.classList.add('open');
}

// comment_btn.onclick=()=>
// {
//     // btn.style.color="red";
//     comment_cont.style.height=90 +"%";
//     comment_cont.style.transform="translateX(0)";
// }

back_btn.onclick=()=>
{
    // btn.style.color="red";
    // comment_cont.style.display="none";
    comment_cont.style.transform="translateX(100%)";
    comment_cont.style.height=0;
    // back_btn.style.display="none"
}

setTimeout(() => 
{
    let xhr = new XMLHttpRequest();
    xhr.open('GET','./includes/get_video.inc.php',true);
    xhr.onload = ()=>
    {
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
        {
            let data = xhr.response;
            // console.log(data);
            video_column.innerHTML = data;
        }
    }
    xhr.send();
}, 1000);
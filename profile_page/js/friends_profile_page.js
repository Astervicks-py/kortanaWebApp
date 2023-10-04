const form = document.querySelector("form"),
	submit_btn = form.querySelector("button"),
	notific_Btn = document.getElementById("notifications"),
	notific_Popup = document.querySelector(".notification-popup"),
	notific_Box = document.querySelector(".notification-box");
const stats = document.querySelectorAll(".stats");

function movePrimary(element) {
	stats.forEach((element) => {
		element.style.borderBottom = "none";
	});

	element.style.borderBottom = "solid 3px var(--color-border)";
}

const body = document.querySelector("body");
let bodyWidth = parseInt(
	window.getComputedStyle(body).getPropertyValue("width")
);
if (bodyWidth < 700) {
	const nonActive = document.querySelectorAll(".item:not(.active)");
	let toggle = false;
	document.querySelector(".side-bar .active").onclick = () => {
		if (toggle == false) {
			for (let index = 0; index < nonActive.length; index++) {
				nonActive[index].style.display = "flex";
				// console.log(nonActive[index]);
			}
			document.querySelector(".container .left").style.opacity = 1;
			document.querySelector(".container .left").style.top = "15vh";
			toggle = true;
		} else {
			for (let index = 0; index < nonActive.length; index++) {
				nonActive[index].style.display = "none";
				// console.log(nonActive[index]);
			}

			document.querySelector(".container .left").style.opacity = 0.6;
			document.querySelector(".container .left").style.top = "80vh";
			toggle = false;
		}

		// alert("done");
	};
}

function get_notific(file) {
	let xhr = new XMLHttpRequest();
	xhr.open("GET", file, true);
	xhr.onload = () => {
		if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
			let data = xhr.response;
			// console.log(data);
			notific_Box.innerHTML = data;
		}
	};
	xhr.send();
}

notific_Btn.onclick = () => {
	if (notific_Popup.style.display == "none") {
		notific_Popup.style.display = "block";

		let xhr = new XMLHttpRequest();
		xhr.open("GET", "./includes/read_notification.inc.php", true);
		xhr.onload = () => {
			if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
				let data = xhr.response;
			}
		};
		xhr.send();
		/** XML REQUEST  */
		get_notific("./includes/get_notification.php");
	} else if (notific_Popup.style.display == "block") {
		notific_Popup.style.display = "none";
	}
};

function $(element) {
	return document.querySelector(element);
}

if (body.classList.contains("dark")) {
	$(":root").style.setProperty("--color-dark", "hsl(252, 30%, 17%)");
	$(":root").style.setProperty("--color-black", "hsl(252,30%,10%)");
	$(":root").style.setProperty("--color-border", "var(--color-primary)");
	$(":root").style.setProperty("--color-white", "hsl(252,75%,64%)");
} else {
	$(":root").style.setProperty("--color-dark", "#000");
	$(":root").style.setProperty("--color-black", "#000");
	$(":root").style.setProperty("--color-border", "#0f0");
	$(":root").style.setProperty("--color-white", "#000");
}

setInterval(() => {
	let xhr = new XMLHttpRequest();
	xhr.open("GET", "./includes/count_notification.inc.php", true);
	xhr.onload = () => {
		if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
			let data = xhr.response;
			console.log(data);
			$(".notification-count").innerHTML = data;
		}
	};
	xhr.send();
}, 1000);

setInterval(() => {
	get_notific("./includes/get_notification.php");
}, 1000);

// Get the unread message
setInterval(() => {
	let xhr = new XMLHttpRequest();
	xhr.open("GET", "./includes/get_unread_message.inc.php", true);
	xhr.onload = () => {
		if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
			let data = xhr.response;
			$("#messages-count").innerHTML = data;
		}
	};
	xhr.send();
}, 1000);

// ! Liking a post
function ajax_data(e, ele) {
	e.preventDefault();
	var link = ele.href;
	let num = ele.querySelector(".like-count").textContent;
	console.log(num);
	// return;
	if (ele.style.color == "red") {
		ele.style.color = "#fff";
		num--;
		ele.querySelector(".like-count").innerHTML = num;
	} else {
		ele.style.color = "red";
		num++;
		ele.classList.add("liked");
		setTimeout(() => {
			ele.classList.remove("liked");
		}, 1000);
		ele.querySelector(".like-count").innerHTML = num;
	}

	let xhr = new XMLHttpRequest();
	xhr.open("POST", "./includes/like_post.inc.php", true);
	xhr.onload = () => {
		if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
			let data = xhr.response;
			console.log(data);
		}
	};
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("link=" + link);
}

// ! Following a user
form.onsubmit = (e) => {
	e.preventDefault();
	let xhr = new XMLHttpRequest();
	xhr.open("POST", "./includes/follow.inc.php", true);
	xhr.onload = () => {
		if (xhr.status === 200 && xhr.readyState === XMLHttpRequest.DONE) {
			let data = xhr.response;
			if (data == "UNFOLLOWED") {
				$(".follow-btn").innerHTML = "Follow";
			} else if (data == "FOLLOWED") {
				$(".follow-btn").innerHTML = "Unfollow";
			}
		}
	};

	let formData = new FormData(form);
	xhr.send(formData);
};

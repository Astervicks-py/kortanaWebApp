const users = document.querySelector(".chat_users");
const body = document.querySelector("body");
const root = document.querySelector(":root"),
	notific_Btn = document.getElementById("notifications"),
	notific_Popup = document.querySelector(".notification-popup"),
	notific_Box = document.querySelector(".notification-box");
loader = document.querySelector(".loading-screen");

let bodyWidth = parseInt(
	window.getComputedStyle(body).getPropertyValue("width")
);
let bodyHeight = parseInt(
	window.getComputedStyle(body).getPropertyValue("height")
);

// console.log(bodyWidth)
// console.log(bodyHeight)
function $(element) {
	return document.querySelector(element);
}

if (bodyWidth > 600) {
	$(".section-selector-cont").style.display = "none";
	$("#desiree-section").style.display = "block";
	$("#groups-section").style.display = "block";
	$(".scroll-container").style.display = "grid";
	$(".scroll-container").style.gridTemplateColumns = "1fr 1fr 1fr";
	$(".scroll-container").style.gap = "20px";
	// alert(bodyWidth);
} else {
	let disappear = document.querySelectorAll(".to-disappear");
	disappear.forEach((element) => {
		element.style.display = "none";
	});
	// alert(bodyWidth);
}

if (bodyWidth > 620) {
	$(".scroll-container").style.display = "block";
	$("#desiree-section").style.display = "none";
	$("#groups-section").style.display = "none";
	// $("#chats-section").style.gridColumn = "span 2";
	$(".scroll-section-selector-cont").style.display = "grid";
	$(".scroll-section-selector-cont").style.gridTemplateColumns = "1fr 1fr 1fr";
	// $(".scroll-container").style.display = "grid";
	// $(".scroll-container").style.gap = "20px";

	// let disappear = document.querySelectorAll(".to-disappear");
	// disappear.forEach(element => {
	//     element.style.display = "block"
	// });
}

$("#chat_name").onkeyup = () => {
	let searchTerm = $("#chat_name").value;
	if (searchTerm != "") {
		$("#chat_name").classList.add("taken");
	} else {
		$("#chat_name").classList.remove("taken");
	}

	let xhr = new XMLHttpRequest();
	xhr.open("POST", "includes/search.inc.php", true);
	xhr.onload = () => {
		if (xhr.status === 200 && xhr.readyState === XMLHttpRequest.DONE) {
			let data = xhr.response;
			// console.log(data);
			$(".avaliable-users").innerHTML = data;
		}
	};
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("searchTerm=" + searchTerm + "&section=" + "friend");
	// xhr.send();
};

if (body.classList.contains("dark")) {
	root.style.setProperty("--color-dark", "hsl(252, 30%, 17%)");
	root.style.setProperty("--color-black", "hsl(252,30%,10%)");
	root.style.setProperty("--color-border", "var(--color-primary)");
	root.style.setProperty("--color-white", "hsl(252,75%,64%)");
} else if (body.classList.contains("yellow")) {
	root.style.setProperty("--color-dark", "#000");
	root.style.setProperty("--color-black", "#000");
	root.style.setProperty("--color-border", "#fe0");
	root.style.setProperty("--color-text", "#fe0");
	root.style.setProperty("--color-white", "#fe0");
} else {
	root.style.setProperty("--color-dark", "#000");
	root.style.setProperty("--color-black", "#000");
	root.style.setProperty("--color-border", "#0f0");
	root.style.setProperty("--color-white", "#000");
}

// Get the unread message
let message_notification = 0;
setInterval(() => {
	let xhr = new XMLHttpRequest();
	xhr.open("GET", "./includes/get_unread_message.inc.php", true);
	xhr.onload = () => {
		if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
			let data = xhr.response;
			// console.log(message_notification);
			if (data > message_notification) {
				$("#mySong2").play();
				message_notification = data;
				// console.log(message_notification);
			}

			let chatNotific = document.querySelectorAll(".chat-notific");
			if (data == 0 || !data) {
				$("#messages-count").style.display = "none";
				chatNotific.forEach((element) => {
					element.style.display = "none";
				});
			} else {
				$("#messages-count").style.display = "block";
				$("#messages-count").innerHTML = data;

				chatNotific.forEach((element) => {
					element.style.display = "flex";
					element.innerHTML = data;
				});
			}
		}
	};
	xhr.send();
}, 1000);
// Get the unread message
let group_notification = 0;
setInterval(() => {
	let xhr = new XMLHttpRequest();
	xhr.open("GET", "./includes/get_unread_group_message.inc.php", true);
	xhr.onload = () => {
		if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
			let data = xhr.response;
			// console.log(message_notification);
			if (data > group_notification) {
				$("#mySong2").play();
				group_notification = data;
				// console.log(message_notification);
			}

			let groupNotific = document.querySelectorAll(".group-notific");
			if (data == 0 || !data) {
				// $("#messages-count").style.display = "none";
				groupNotific.forEach((element) => {
					element.style.display = "none";
				});
			} else {
				// $("#messages-count").style.display = "block";
				// $("#messages-count").innerHTML = data;

				groupNotific.forEach((element) => {
					element.style.display = "flex";
					element.innerHTML = data;
				});
			}
		}
	};
	xhr.send();
}, 1000);

if (bodyWidth < 700) {
	const nonActive = document.querySelectorAll(".menu-item:not(.active)");
	let toggle = false;
	document.querySelector(".side-bar .active").onclick = () => {
		if (toggle == false) {
			for (let index = 0; index < nonActive.length; index++) {
				nonActive[index].style.display = "flex";
				// console.log(nonActive[index]);
			}
			document.querySelector("main .container .left").style.opacity = 1;
			document.querySelector("main .container .left").style.top = "20vh";
			document.querySelector("main .container .left .profile").style.display =
				"flex";
			toggle = true;
		} else {
			for (let index = 0; index < nonActive.length; index++) {
				nonActive[index].style.display = "none";
				// console.log(nonActive[index]);
			}

			document.querySelector("main .container .left").style.opacity = 0.6;
			document.querySelector("main .container .left").style.top = "75vh";
			document.querySelector("main .container .left .profile").style.display =
				"none";
			toggle = false;
		}

		// alert("done");
	};
}

// var size = window.getComputedStyle(users).getPropertyValue('height');
// alert(size);

//!
setTimeout(() => {
	let xhr = new XMLHttpRequest();
	xhr.open("GET", "./includes/chat_users.inc.php", true);
	xhr.onload = () => {
		if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
			let data = xhr.response;
			// console.log(data);
			if (!$("#chat_name").classList.contains("taken")) {
				users.innerHTML = data;
			}
		}
	};
	xhr.send();
}, 100);

/**
 * Get the groups from the Groups database
 */

setTimeout(() => {
	let xhr = new XMLHttpRequest();
	xhr.open("POST", "./includes/get_groups.inc.php", true);
	xhr.onload = () => {
		if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
			let data = xhr.response;
			// console.log(data);
			$(".available_groups").innerHTML =
				`
                <a href="./group_create.php" class="user_link" style="position:relative">
                <div class="user">
                    
                    <div class="details" style="width:100%;text-align:center;position:relative;padding:5px;">
                        <h5 style="width:100%;text-align:center;" class="user-name">Create new Group</h5>
                    </div>
                </div>
            </a>
            ` + data;
		}
	};
	xhr.send();
}, 100);

/**
 * Get the DEsiree from the Desirees database
 */

setTimeout(() => {
	let xhr = new XMLHttpRequest();
	xhr.open("POST", "./includes/desiree.inc.php", true);
	xhr.onload = () => {
		if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
			let data = xhr.response;
			// console.log(data);
			$(".available-desiree").innerHTML = data;
		}
	};
	xhr.send();
}, 100);

document.addEventListener("keydown", (e) => {
	// if(e.keyCode == 18){//keycode for alt : to move back to chat users page
	//     location.href = "./index.php";
	// }
});

notific_Btn.onclick = () => {
	if (notific_Popup.style.display == "none") {
		notific_Popup.style.display = "block";

		/** XML REQUEST  */
		let xhr = new XMLHttpRequest();
		xhr.open("GET", "./includes/get_notification.php", true);
		xhr.onload = () => {
			if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
				let data = xhr.response;
				// console.log(data);
				notific_Box.innerHTML = data;
			}
		};
		xhr.send();
	} else if (notific_Popup.style.display == "block") {
		notific_Popup.style.display = "none";
	}
};

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

let notification_count = 0;
/** Count notification */
setInterval(() => {
	let xhr = new XMLHttpRequest();
	xhr.open("GET", "./includes/count_notification.inc.php", true);
	xhr.onload = () => {
		if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
			let data = xhr.response;
			// console.log(data);
			if (data > notification_count) {
				$("#mySong").play();
				notification_count = data;
				// console.log(notification_count);
			}

			if (data == 0) {
				$(".notification-count").style.display = "none";
			} else {
				$(".notification-count").style.display = "block";
				$(".notification-count").innerHTML = data;
			}
		}
	};
	xhr.send();
}, 1000);

setInterval(() => {
	get_notific("./includes/get_notification.php");
}, 1000);

function activeSection(element) {
	let sectionPick = document.querySelectorAll(".section-selector");
	let sections = document.querySelectorAll(".middle");
	// console.log(sections);
	sectionPick.forEach((element) => {
		if (element.classList.contains("active-section")) {
			element.classList.remove("active-section");
		}
	});

	sections.forEach((element) => {
		element.style.display = "none";
	});

	element.classList.add("active-section");
	if (element.getAttribute("data-section") == "chats") {
		$("#chats-section").style.display = "block";
	} else if (element.getAttribute("data-section") == "groups") {
		$("#groups-section").style.display = "block";
	} else {
		$("#desiree-section").style.display = "block";
	}
}

function activeScrollSection(element) {
	let sectionPick = document.querySelectorAll(".scroll-section-selector");
	let sections = document.querySelectorAll(".middle");
	// console.log(sections);
	sectionPick.forEach((element) => {
		if (element.classList.contains("active-section")) {
			element.classList.remove("active-section");
		}
	});

	sections.forEach((element) => {
		element.style.display = "none";
	});

	element.classList.add("active-section");
	if (element.getAttribute("data-section") == "chats") {
		$("#chats-section").style.display = "block";
		// console.log(element.getAttribute("data-section"));
	} else if (element.getAttribute("data-section") == "groups") {
		$("#groups-section").style.display = "block";
		// console.log(element.getAttribute("data-section"));
	} else {
		$("#desiree-section").style.display = "block";
		// console.log(element.getAttribute("data-section"));
	}
}

function follow(element) {
	console.log(element);
}

function follow(elem) {
	var link = elem.getAttribute("data-id");
	if (elem.textContent == "Follow") {
		elem.textContent = "Unfollow";
	} else if (elem.textContent == "Follow Back") {
		elem.textContent = "Unfollow";
	} else {
		elem.textContent = "Follow";
	}
	// console.log(link);
	let xhr = new XMLHttpRequest();
	xhr.open("POST", "./includes/follow.inc.php", true);
	xhr.onload = () => {
		if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
			let data = xhr.response;
			console.log(data);
		}
	};
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("friend_id=" + link);
}

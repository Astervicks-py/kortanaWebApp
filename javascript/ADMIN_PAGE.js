"use-strict";
const body = document.querySelector("body");
const menuItems = document.querySelectorAll(".menu-item");
const pages = document.querySelectorAll(".page"),
	bugPages = document.querySelectorAll(".bugPage"),
	createBtns = document.querySelectorAll(".create-div button");
deleteBtns = document.querySelectorAll(".delete");
bugs = document.querySelectorAll(".bug");
function $(element) {
	return document.querySelector(element);
}

window.onload = () => {
	$(".loading-screen").style.display = "none";
};
// Check the body size of the window for responsiveness
let bodyWidth = parseInt(
	window.getComputedStyle(body).getPropertyValue("width")
);

let size = parseInt(window.getComputedStyle(body).getPropertyValue("width"));

// menuItems.forEach((item) => {
// 	item.onclick = (e) => {
// 		console.log(e.target.id);
// 	};
// });

pages.forEach((page) => {
	if (!page.classList.contains("active")) {
		page.style.display = "none";
	}
});

function changeDisplay(element) {
	menuItems.forEach((item) => {
		item.classList.remove("active");
	});
	let desiredPage = element.id;
	element.classList.add("active");
	pages.forEach((page) => {
		if (page.classList.contains(desiredPage)) {
			page.classList.add("active");
		} else {
			page.classList.remove("active");
		}
		if (!page.classList.contains("active")) {
			page.style.display = "none";
		}
	});
}

// AJAX fcro adding bug report
// $("#addBugReport").onsubmit =() =>{

// }

function changeBugView(element) {
	createBtns.forEach((btn) => {
		btn.classList.remove("active");
	});

	element.classList.add("active");
	let section = element.getAttribute("data-section");
	bugPages.forEach((page) => {
		if (page.id == section) {
			page.style.display = "block";
		} else {
			page.style.display = "none";
		}
	});
}

let actionBTNS = document.querySelectorAll(
	".action-btns button:nth-of-type(2)"
);

actionBTNS.forEach((btn) => {
	btn.onclick = (e) => {
		// actionBTNS.forEach((btnn) => {
		// 	btnn.innerHTML = "SHOW";
		// });
		let text = e.target.innerHTML;
		let id = e.target.getAttribute("data-id");
		if (text == "SHOW") {
			actionBTNS.forEach((btnn) => {
				btnn.innerHTML = "SHOW";
			});
			e.target.innerHTML = "HIDE";
			bugs.forEach((bug) => {
				if (bug.getAttribute("data-id") == id) {
					bug.style.height = "max-content";
				} else {
					bug.style.height = "60px";
				}
			});
		} else {
			actionBTNS.forEach((btnn) => {
				btnn.innerHTML = "SHOW";
			});
			e.target.innerHTML = "SHOW";
			bugs.forEach((bug) => {
				bug.style.height = "60px";
			});
		}
	};
});

/**
 * ADMIN AUTHENTICATION
 */

const loader = $(".individual-loader");

$(".serial_code").onsubmit = (e) => {
	e.preventDefault();
	loader.style.display = "flex";
	$("#checker").value = localStorage.getItem("secretToken");
	let xhr = new XMLHttpRequest();
	xhr.open("POST", "./includes/auth.inc.php", false);
	xhr.onload = () => {
		if (XMLHttpRequest.DONE === xhr.readyState && xhr.status === 200) {
			let data = xhr.response;
			console.log(data);
			if (data == "MATCHED") {
				$(".error").innerHTML = "SUCCESS";
				$(".error").style.background = "#0f0";
				$(".error").style.color = "#000";
				$(".error").style.display = "block";
				location.href = "./ADMIN_PAGE.php";
			} else {
				$(".error").innerHTML = data;
				$(".error").style.display = "block";
				loader.style.display = "none";
			}
		}
	};
	let formData = new FormData($(".serial_code"));
	xhr.send(formData);
};

let tokenBtns = document.querySelectorAll(".copy-btn");
function copyNote(e) {
	let note = e.target.getAttribute("data-content");
	navigator.clipboard.writeText(note);
	e.target.innerHTML = "COPIED";
}

if ($(".container").getAttribute("data-open") == "true") {
	$(".container").style.display = "block";
	$(".auth").style.display = "none";
}

// console.log(window);
// console.log(confirm("This issome shit to confirm"));

/**
 * DELETE BTN
 */

let opError = $(".op_error");

function deleteBug(element) {
	opError.innerHTML = "DELETING...";
	opError.style.top = "30%";
	let id = element.getAttribute("data-id");
	let deleteConfirmation = confirm(`Do you want to delete bug: ${id}`);
	if (deleteConfirmation) {
		let xhr = new XMLHttpRequest();
		xhr.open("POST", "./includes/bugOperation.inc.php", true);
		xhr.onload = () => {
			if (xhr.status === 200 && XMLHttpRequest.DONE === xhr.readyState) {
				let data = xhr.response;
				console.log(data);
				if (data == "SUCCESS") {
					opError.innerHTML = "DELETE SUCCESSFUL";
					opError.style.background = "green";
					opError.style.color = "#fff";
					setTimeout(() => {
						opError.style.top = "0";
					}, 3000);
					location.href = "./ADMIN_PAGE.php";
				} else {
					opError.style.background = "rgb(230, 138, 138)";
					opError.style.color = "rgb(190, 55, 55)";
					opError.innerHTML = data;
					setTimeout(() => {
						opError.style.top = "0";
					}, 3000);
				}
			}
		};
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send("id=" + id + "&type=delete");
	} else {
		alert(`Delete of bug: ${id} has been canceled`);
	}
}

/**
 * FIX BUG
 */

function fixBug(element) {
	opError.innerHTML = "FIXING...";
	opError.style.top = "30%";
	let id = element.getAttribute("data-id");
	let fixConfirmation = confirm(`Do you want to fix bug: ${id}`);
	if (fixConfirmation) {
		let xhr = new XMLHttpRequest();
		xhr.open("POST", "./includes/bugOperation.inc.php", true);
		xhr.onload = () => {
			if (xhr.status === 200 && XMLHttpRequest.DONE === xhr.readyState) {
				let data = xhr.response;
				console.log(data);
				if (data == "SUCCESS") {
					opError.innerHTML = "FIX SUCCESSFUL";
					opError.style.background = "green";
					opError.style.color = "#fff";
					setTimeout(() => {
						opError.style.top = "0";
					}, 3000);
					location.href = "./ADMIN_PAGE.php";
				} else {
					opError.style.background = "rgb(230, 138, 138)";
					opError.style.color = "rgb(190, 55, 55)";
					opError.innerHTML = data;
					setTimeout(() => {
						opError.style.top = "0";
					}, 3000);
				}
			}
		};
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send("id=" + id + "&type=fix");
	} else {
		alert(`Delete of bug: ${id} has been canceled`);
		opError.style.top = "0";
	}
}

/**
 * ! RESPONSIVENESS OF SIDEBAR
 */

let sidebarOpen = false;
$("#toggleSidebar").onclick = () => {
	if (!sidebarOpen) {
		$(".sidebar").style.width = "250px";
		$("#arrow").classList.remove("fa-arrow-right");
		$("#arrow").classList.add("fa-arrow-left");
		sidebarOpen = true;
	} else {
		$(".sidebar").style.width = "50px";
		$("#arrow").classList.add("fa-arrow-right");
		$("#arrow").classList.remove("fa-arrow-left");
		sidebarOpen = false;
	}
};

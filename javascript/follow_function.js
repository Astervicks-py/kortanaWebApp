let followBtns = document.querySelectorAll("#follow-btn");
function $(element) {
	return document.querySelector(element);
}
function follow(element) {
	let userId = element.getAttribute("data-id");
	let xhr = new XMLHttpRequest();
	xhr.open("POST", "./includes/follow.inc.php", true);
	xhr.onload = () => {
		if (xhr.status === 200 && xhr.readyState === XMLHttpRequest.DONE) {
			let data = xhr.response;
			if (data == "UNFOLLOWED") {
				followBtns.forEach((btn) => {
					if (btn.getAttribute("data-id") == userId) {
						btn.innerHTML = "Follow";
					}
				});
			} else if (data == "FOLLOWED") {
				followBtns.forEach((btn) => {
					if (btn.getAttribute("data-id") == userId) {
						btn.innerHTML = "Unfollow";
					}
				});
			}
		}
	};

	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("friend_id=" + userId);
}

const form = document.querySelector("form");
const submitbtn = form.querySelector(".btn");
const error = document.querySelector(".error"),
	loader = document.querySelector(".individual-loader");

form.onsubmit = (e) => {
	e.preventDefault();
};

submitbtn.onclick = () => {
	loader.style.display = "flex";
	setTimeout(() => {
		let xhr = new XMLHttpRequest();
		if (form.classList.contains("recover")) {
			xhr.open("POST", "./includes/recover_password.inc.php", true);
		} else if (form.classList.contains("newPassword")) {
			xhr.open("POST", "./includes/new_passsword.inc.php", true);
		} else {
			xhr.open("POST", "./includes/login.inc.php", true);
		}

		xhr.onload = () => {
			if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
				let data = xhr.response;
				console.log(data);
				if (data == "Matched") {
					if (form.classList.contains("recover")) {
						location.href = "./new_password.php";
					} else if (form.classList.contains("newPassword")) {
						location.href = "./index.php";
					} else {
						location.href = "./index.php";
					}
				} else {
					loader.style.display = "none";
					error.innerHTML = "<i>" + data + "</i>";
					error.style.display = "block";
				}
			} else {
				loader.style.display = "none";
				error.innerHTML = "<i>Something went wrong</i>";
				error.style.display = "block";
			}
		};
		let formData = new FormData(form);
		xhr.send(formData);
	}, 2000);
};

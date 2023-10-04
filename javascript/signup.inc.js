const form = document.querySelector("form");
const submitbtn = document.querySelector(".btn");
const error = document.querySelector(".error"),
	loader = document.querySelector(".individual-loader");

form.onsubmit = (e) => {
	e.preventDefault();
};

submitbtn.onclick = () => {
	loader.style.display = "flex";
	setTimeout(() => {
		let xhr = new XMLHttpRequest();
		xhr.open("POST", "./includes/signup.inc.php", true);
		xhr.onload = () => {
			if (xhr.readyState === XMLHttpRequest.DONE) {
				if (xhr.status === 200) {
					let data = xhr.response;
					if (data == "Login Successful") {
						location.href = "./index.php";
					} else {
						loader.style.display = "none";
						error.innerHTML = "<i>" + data + "</i>";
						error.style.display = "block";
					}
				} else {
					loader.style.display = "none";
					error.innerHTML = "<i> Something went wrong</i>";
					error.style.display = "block";
				}
			}
		};
		let formData = new FormData(form);
		xhr.send(formData);
	}, 2000);
};

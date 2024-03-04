const loginContainer = document.querySelector("#login-container");
const createAccountContainer = document.querySelector(
    "#create-account-container"
);
const linkToCreateAccount = document.querySelector("#link-to-create-account");
const linkToLogin = document.querySelector("#link-to-login");

linkToCreateAccount.addEventListener("click", () => {
    loginContainer.classList.remove("display-block");
    loginContainer.classList.add("display-none");
    createAccountContainer.classList.remove("display-none");
    createAccountContainer.classList.add("display-block");
});

linkToLogin.addEventListener("click", () => {
    loginContainer.classList.remove("display-none");
    loginContainer.classList.add("display-block");
    createAccountContainer.classList.remove("display-block");
    createAccountContainer.classList.add("display-none");
});

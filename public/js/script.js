function signOut() {
  window.location.href = "./signout.php";
}

document.addEventListener("DOMContentLoaded", function () {
  const productButton = document.querySelector("button[aria-expanded]");
  const flyoutMenu = productButton.nextElementSibling;

  let menuVisible = false;

  function toggleMenu() {
    menuVisible = !menuVisible;

    if (menuVisible) {
      flyoutMenu.classList.remove("hidden");
      gsap.fromTo(
        flyoutMenu,
        {
          opacity: 0,
          y: -10,
        },
        {
          opacity: 1,
          y: 0,
          duration: 0.3,
        }
      );
    } else {
      gsap.to(flyoutMenu, {
        opacity: 0,
        y: -10,
        duration: 0.3,
        onComplete: () => {
          flyoutMenu.classList.add("hidden");
        },
      });
    }

    productButton.setAttribute("aria-expanded", menuVisible);
  }

  productButton.addEventListener("click", toggleMenu);

  document.addEventListener("click", function (event) {
    if (
      !productButton.contains(event.target) &&
      !flyoutMenu.contains(event.target)
    ) {
      if (menuVisible) {
        toggleMenu();
      }
    }
  });
});

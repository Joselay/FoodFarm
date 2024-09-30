function signOut() {
  window.location.href = "./signout.php";
}
const userMenuButton = document.getElementById("user-menu-button");
const userMenu = document.getElementById("user-menu");
let isOpen = false;

userMenuButton.addEventListener("click", () => {
  isOpen = !isOpen;
  userMenu.setAttribute("aria-expanded", isOpen);

  if (isOpen) {
    gsap.to(userMenu, {
      duration: 0.2,
      opacity: 1,
      pointerEvents: "auto",
      ease: "power1.out",
    });
  } else {
    gsap.to(userMenu, {
      duration: 0.2,
      opacity: 0,
      pointerEvents: "none",
      ease: "power1.in",
    });
  }
});

document.addEventListener("click", (event) => {
  if (
    isOpen &&
    !userMenuButton.contains(event.target) &&
    !userMenu.contains(event.target)
  ) {
    isOpen = false;
    gsap.to(userMenu, {
      duration: 0.3,
      opacity: 0,
      pointerEvents: "none",
      ease: "power1.in",
    });
    userMenuButton.setAttribute("aria-expanded", "false");
  }
});
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

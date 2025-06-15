// Theme Toggle
const themeToggle = document.getElementById("themeToggle")
const html = document.documentElement

// Check for saved theme preference or default to light mode
const currentTheme = localStorage.getItem("theme") || "light"
if (currentTheme === "dark") {
  html.classList.add("dark")
}

themeToggle.addEventListener("click", () => {
  html.classList.toggle("dark")
  const newTheme = html.classList.contains("dark") ? "dark" : "light"
  localStorage.setItem("theme", newTheme)

  // Add animation to the toggle button
  themeToggle.style.transform = "scale(0.8)"
  setTimeout(() => {
    themeToggle.style.transform = "scale(1)"
  }, 150)
})

// Form Toggle
const showRegister = document.getElementById("showRegister")
const showLogin = document.getElementById("showLogin")
const loginForm = document.getElementById("loginForm")
const registerForm = document.getElementById("registerForm")
const registerLink = document.getElementById("registerLink")
const loginLink = document.getElementById("loginLink")

function animateFormTransition(hideElement, showElement, hideLink, showLink) {
  // Fade out current form
  hideElement.style.opacity = "0"
  hideElement.style.transform = "translateY(-20px)"
  hideLink.style.opacity = "0"
  hideLink.style.transform = "translateY(-20px)"

  setTimeout(() => {
    hideElement.classList.add("hidden")
    hideLink.classList.add("hidden")
    showElement.classList.remove("hidden")
    showLink.classList.remove("hidden")

    // Fade in new form
    setTimeout(() => {
      showElement.style.opacity = "1"
      showElement.style.transform = "translateY(0)"
      showLink.style.opacity = "1"
      showLink.style.transform = "translateY(0)"
    }, 50)
  }, 300)
}

showRegister.addEventListener("click", (e) => {
  e.preventDefault()
  animateFormTransition(loginForm, registerForm, registerLink, loginLink)
})

showLogin.addEventListener("click", (e) => {
  e.preventDefault()
  animateFormTransition(registerForm, loginForm, loginLink, registerLink)
})

// Form validation
document.querySelectorAll("form").forEach((form) => {
  form.addEventListener("submit", (e) => {
    const inputs = form.querySelectorAll("input[required]")
    let isValid = true

    inputs.forEach((input) => {
      if (!input.value.trim()) {
        isValid = false
        input.classList.add("border-red-500", "animate-pulse")
        input.classList.remove("border-gray-300", "dark:border-gray-600")

        // Remove error styling after 3 seconds
        setTimeout(() => {
          input.classList.remove("border-red-500", "animate-pulse")
          input.classList.add("border-gray-300", "dark:border-gray-600")
        }, 3000)
      } else {
        input.classList.remove("border-red-500", "animate-pulse")
        input.classList.add("border-green-500")

        setTimeout(() => {
          input.classList.remove("border-green-500")
          input.classList.add("border-gray-300", "dark:border-gray-600")
        }, 1000)
      }
    })

    if (!isValid) {
      e.preventDefault()
      // Shake animation for the form
      form.style.animation = "shake 0.5s ease-in-out"
      setTimeout(() => {
        form.style.animation = ""
      }, 500)
    }
  })
})

// Input focus effects
document.querySelectorAll("input").forEach((input) => {
  input.addEventListener("focus", () => {
    input.parentElement.style.transform = "scale(1.02)"
    input.parentElement.style.transition = "transform 0.2s ease"
  })

  input.addEventListener("blur", () => {
    input.parentElement.style.transform = "scale(1)"
  })
})

// Add shake animation keyframes
const style = document.createElement("style")
style.textContent = `
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }
`
document.head.appendChild(style)

// Smooth transitions for all elements
document.querySelectorAll("*").forEach((element) => {
  element.style.transition = "all 0.3s ease"
})

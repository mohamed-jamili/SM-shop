const b=document.body,t=document.getElementById("theme-toggle");
localStorage.getItem("sm-theme")==="light"&&b.classList.add("light");
t&&t.setAttribute("aria-pressed",String(b.classList.contains("light")));
t&&t.addEventListener("click",()=>{b.classList.toggle("light");localStorage.setItem("sm-theme",b.classList.contains("light")?"light":"dark");t.setAttribute("aria-pressed",String(b.classList.contains("light")));});

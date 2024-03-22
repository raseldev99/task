const bar = document.getElementById('mobile-bar')
const mobile_menu = document.getElementById('mobile-menu')
const mobile_menu_overlay = document.getElementById('mobile-menu-overlay')
const close = document.getElementById('close')
bar.addEventListener('click',()=>{
    mobile_menu.classList.toggle('active')
    mobile_menu_overlay.classList.toggle('active')
})
mobile_menu_overlay.addEventListener('click',()=>{
    mobile_menu.classList.toggle('active')
    mobile_menu_overlay.classList.toggle('active')
})
close.addEventListener('click',()=>{
    mobile_menu.classList.toggle('active')
    mobile_menu_overlay.classList.toggle('active')
})
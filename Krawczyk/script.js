/*const inputs = document.querySelectorAll('input[name=images]');
const pre = document.querySelectorAll('.pre');
const nxt = document.querySelectorAll('.nxt');
let selectedIndex=0;
function selectInput() {
    inputs[selectedIndex].checked=false;
    selectedIndex=(selectedIndex+1)%inputs.length;
    inputs[selectedIndex].checked=true;
} 
let interval=setInterval(selectInput, 5000);

pre.forEach((button)=> {
    button.addEventListener('click',()=>{
        if(selectedIndex===0){
            selectedIndex=inputs.length-1;
        }else{
        selectedIndex=selectedIndex-1;} //demokracja
        resetInterval();
    });
});

nxt.forEach((button)=> {
    button.addEventListener('click',()=> {
        selectedIndex=(selectedIndex+1)%inputs.length;
        resetInterval();
    });
});


function resetInterval(){
    clearInterval(interval);
        interval=setInterval(selectInput, 5000);
}
*/
/*-------------------*/
/*
let intervalId;

function resetInterval() {
    clearInterval(intervalId);
    intervalId=setInterval(selectInput, 2000);
}

function handleSlideChange() {
    resetInterval();
    inputs.forEach((input, index) => {
        if(input.getAttribute("checked")) {
            selectedIndex = index;
        }
    });
}

pre.forEach((button)=> {
    button.addEventListener('click', handleSlideChange);
});

nxt.forEach((button)=> {
    button.addEventListener('click', handleSlideChange);
});*/

const linkSprzet = document.querySelector('.link-sprzet');
const iFrame = document.querySelector('.strona-produktu');
let linkOpen = false;
linkSprzet.addEventListener('click', () => {
    if(!linkOpen){
        iFrame.classList.add('frame-open');
        linkOpen = true;
    } else {
        iFrame.classList.remove('frame-open');
        linkOpen = false;
    }
}); 
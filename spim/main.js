var number = 0;
var max_number = 39;

var down = false;

var img = document.getElementById("mainimg");


var last_x = 0;
var last_movement = 0;
function mouseDown(event) {
    last_movement = 0;
    last_x = event.clientX;
    if(typeof(event.clientX) == "undefined") {
        current_x = event.changedTouches[0]['clientX']
    }
    down = true;
    console.log("mouse down");
}

img.addEventListener("mousedown", mouseDown);
img.addEventListener("touchstart", mouseDown)

function mouseUp() {
    down = false;
    console.log("mouse up");
}

document.body.addEventListener("mouseup", mouseUp);
document.body.addEventListener("touchend", mouseUp);

console.log("uwu");

function shiftNum(way) {
    if(way == -1) {
        number--;
        if(number < 0) {
            number = max_number;
        }
    }
    if(way == 1) {
        number++;
        if(number > max_number) {
            number = 0;
        }
    }

    img.src = images[number];
}
function mouseMove(event) {
    if(down) {
        var current_x = event.clientX;
        if(typeof(event.clientX) == "undefined") {
            current_x = event.changedTouches[0]['clientX']
        }
        var movement = current_x - last_x;
        if(!isNaN(last_movement))
        movement = movement + last_movement;
        last_x = current_x;

        last_movement = movement;
        if(movement < -2) {
            shiftNum(-1);
            last_movement = 0;
        }
        if(movement > 2) {
            shiftNum(1);
            last_movement = 0;
        }
    }
}
document.body.addEventListener("mousemove", mouseMove);
document.body.addEventListener("touchmove", mouseMove);
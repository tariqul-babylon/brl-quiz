const canvas = document.getElementById("timeCanvas");
const context = canvas.getContext("2d");

function calculateGradientPoints(angleInDegrees) {
    const canvasWidth = canvas.width;
    const canvasHeight = canvas.height;
    const angleInRadians = angleInDegrees * (Math.PI / 180);
    const length = Math.sqrt(canvasWidth ** 2 + canvasHeight ** 2);
    const x1 = canvasWidth / 2 + Math.cos(angleInRadians) * (length / 2);
    const y1 = canvasHeight / 2 + Math.sin(angleInRadians) * (length / 2);
    const x2 = canvasWidth / 2 - Math.cos(angleInRadians) * (length / 2);
    const y2 = canvasHeight / 2 - Math.sin(angleInRadians) * (length / 2);
    return { x1, y1, x2, y2 };
}


var radius = 150;
var line = 50;
var x = (radius / 2) + (line * 2);
var y = (radius / 2) + (line * 2);


context.beginPath();
context.arc(x, y, radius, 0, Math.PI * 2, false);
context.strokeStyle = "rgba(123, 97, 255, 0.08)";
context.lineWidth = line;
context.stroke();



context.beginPath();
const gradientAngle = 205;
const gradientPoints = calculateGradientPoints(gradientAngle);
const gradient = context.createLinearGradient(gradientPoints.x1, gradientPoints.y1, gradientPoints.x2, gradientPoints.y2);

gradient.addColorStop(0, "#FAB2FF");
gradient.addColorStop(1, "#1904E5");



context.strokeStyle = gradient;
context.lineWidth = line;
context.stroke();


function degreesToRadians(degrees) {
    return (degrees * Math.PI) / 180;
}

var i = 360;
var start = degreesToRadians(0);
var end = degreesToRadians(i);

context.arc(x, y, radius, start, end, false);
context.lineCap = "round";
context.stroke();
const examTime = 10;
const examSecond = 0;
const examTimeSecond = examTime * 60 + examSecond;
const getInterval = 360 / examTimeSecond;
//moment js time

const totalTime = moment(examSecond, 'seconds');
totalTime.add(examTime, 'minutes');

$("#timeChange").html(totalTime.format('HH:mm:ss'));

function updateCanvas() {
    context.clearRect(0, 0, canvas.width, canvas.height);
    i -= getInterval;
    if (i > 0) {
        context.beginPath();
        context.arc(x, y, radius, 0, Math.PI * 2, false);
        context.strokeStyle = "rgba(123, 97, 255, 0.08)";
        context.lineWidth = line;
        context.stroke();

        context.beginPath();
        context.strokeStyle = gradient;
        context.lineWidth = line;
        var end = degreesToRadians(i);
        context.arc(x, y, radius, start, end, false);
        context.stroke();
    } else {
        context.clearRect(0, 0, canvas.width, canvas.height);

        context.beginPath();
        context.arc(x, y, radius, 0, Math.PI * 2, false);
        context.strokeStyle = "rgba(123, 97, 255, 0.08)";
        context.lineWidth = line;
        context.stroke();
        clearInterval(canvasInterval);
    }
    totalTime.subtract(1, 'seconds');
    $("#timeChange").html(totalTime.format('HH:mm:ss'));
}

const canvasInterval = setInterval(updateCanvas, 1000);
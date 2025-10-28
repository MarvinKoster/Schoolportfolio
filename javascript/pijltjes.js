let x = 2, y = 2;

function beweeg(e) {
    const table = document.getElementById("gameboard");
    table.rows[y].cells[x].style.backgroundColor = "#293548";

    switch (e.key) {
        case "ArrowLeft":  x = Math.max(0, x - 1); break;
        case "ArrowUp":    y = Math.max(0, y - 1); break;
        case "ArrowRight": x = Math.min(4, x + 1); break;
        case "ArrowDown":  y = Math.min(4, y + 1); break;
    }

    table.rows[y].cells[x].style.backgroundColor = "#000";
}

window.addEventListener("load", () => {
    document.body.addEventListener("keydown", beweeg);
});
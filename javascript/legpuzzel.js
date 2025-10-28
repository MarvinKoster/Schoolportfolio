function checkGewonnen () {
    const bord = document.getElementById('bord')
    const puzzelStukjesOpBord = bord.querySelectorAll('img');
    let juisteAntwoorden = 0;
    // for (const puzzelStuk of puzzelStukjesOpBord)
    for (let i = 0; i < puzzelStukjesOpBord.length; i++) {
        const puzzelStuk = puzzelStukjesOpBord[i];
        const stukNummer = puzzelStuk.id.split('-')[1];
        const vakNummer = puzzelStuk.parentElement.id.split('-')[1];
        if (stukNummer == vakNummer) {
            juisteAntwoorden++;
        }
    }
    if (juisteAntwoorden == 9) setTimeout(gewonnen, 200)
}

function onDrop (event) {
    event.preventDefault();
    const data = event.dataTransfer.getData('text');
    const imgElement = document.getElementById(data)
    event.target.appendChild(imgElement);
    if (event.target.appendChild)
        checkGewonnen();
}

function onDragOver(event) {
    event.preventDefault();
}

function onDragStart(event) {
    event.dataTransfer.setData("text", event.target.id);
}

function maakBord () {
    const container = document.getElementById('bord');
    for (let i = 1; i <= 9; i++) {
        const element = document.createElement('div');
        element.classList.add("bordstuk")
        element.id = "bordStuk-" + i;
        element.addEventListener('drop', onDrop)
        element.addEventListener('dragover', onDragOver)
        container.appendChild(element);
    }
}

function laadPuzzelstukjes () {
    const puzzelStukContainer = document.getElementById('puzzelStukjes');
    for (let i = 1; i <= 9; i++) {
        const imgElement = document.createElement('img');
        imgElement.src = '/image/' + i + '.gif';
        imgElement.draggable = true;
        imgElement.id = 'image-' + i;
        imgElement.addEventListener('dragstart', onDragStart)
        puzzelStukContainer.appendChild(imgElement)

    }
}

function gewonnen (){
    const audio = new Audio('/image/Toad Screaming (VOLUME WARNING!!!).mp3');
    audio.play();
    const video = document.getElementById('winVideo');
    video.style.display = 'block';
    video.play();

    window.alert('you win!')

}

maakBord();
laadPuzzelstukjes();
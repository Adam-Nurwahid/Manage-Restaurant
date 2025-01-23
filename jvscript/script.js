const containerr = document.getElementById("container");
const items = document.querySelectorAll("food-menu container");

container.addEventListener("input", (e) => containerData(e.target.value));

function containerData(search) {
    items.forEach((item) => {
        if (item.innerText.toLowerCase().includes(search.toLowerCase())) {
            item.classList.remove('d-none');
        } else {
            item.classList.add('d-none');
        }
    });
}

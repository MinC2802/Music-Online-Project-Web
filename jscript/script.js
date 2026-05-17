function combinedFilter() {
    const searchInput = document.getElementById("mySearch").value.toUpperCase();
    const searchMode = document.getElementById("searchMode").value;
    const items = document.getElementsByClassName("itemStock");

    let found = false;

    for (let i = 0; i < items.length; i++) {
        const item = items[i];
        const title = item.querySelector("h2").textContent.toUpperCase();
        const artist = item.getAttribute("data-artist").toUpperCase();
        const genre = item.getAttribute("data-genre").toUpperCase();
        const uploaded_by = item.getAttribute("data-uploaded-by").toUpperCase();

        let matches = false;

        switch (searchMode) {
            case "title":
                matches = title.includes(searchInput);
                break;
            case "artist":
                matches = artist.includes(searchInput);
                break;
            case "genre":
                matches = genre.includes(searchInput);
                break;
            case "uploaded_by":
                matches = uploaded_by.includes(searchInput);
                break;
            case "all":
                matches = title.includes(searchInput) || artist.includes(searchInput) || genre.includes(searchInput) || uploaded_by.includes(searchInput);
                break;
        }

        if (matches || searchInput === "") {
            item.style.display = "";
            found = true;
        }
        else {
            item.style.display = "none";
        }
    }

    const resultDiv = document.getElementById("results");
    if (resultDiv) {
        resultDiv.textContent = found ? "" : "No matching records found.";
    }
}



let currentIndex = 0; // global scope
let currentPage = 0;
const itemsPerPage = 3;

function updateSlider(listedItems) {
    const container = document.getElementById(listedItems);
    const totalItems = container.children.length;
    const totalPages = totalItems - 1;

    // Clamp currentPage
    if (currentPage < 0) currentPage = 0;
    if (currentPage >= totalPages) currentPage = totalPages - 1;

    // Move slider
    container.style.transform = `translateX(-${currentPage * 20}%)`;

    // Update dots
    const dots = document.getElementsByClassName("dot");
    for (let i = 0; i < dots.length; i++) {
        dots[i].classList.remove("active");
    }
    if (dots[currentPage]) dots[currentPage].classList.add("active");
}

//item scroll
function returnItem(direction, listedItems) {
    currentPage += direction;
    updateSlider(listedItems);
}

//item page
function goToPage(page, listedItems) {
    currentPage = page;
    updateSlider(listedItems);
}

function openLogoutModal() {
    document.getElementById("logoutModal").style.display = "block";
}

function openAccountModal() {
    document.getElementById("accountModal").style.display = "block";
}

function closeLogoutModal() {
    document.getElementById("logoutModal").style.display = "none";
}

function closeAccountModal() {
    document.getElementById("accountModal").style.display = "none";
}

function confirmLogout() {
    // Redirect to logout page
    window.location.href = "../logout.php"; // Change if your path is different



}
// Optional: Close modal when clicking outside modal content
window.onclick = function (event) {
    const modal = document.getElementById("logoutModal");
    if (event.target === modal) {
        closeLogoutModal();
    }
}

function confirmLogin() {
    // Redirect to logout page
    window.location.href = "../logout.php"; // Change if your path is different



}
// Optional: Close modal when clicking outside modal content
window.onclick = function (event) {
    const modal = document.getElementById("accountModal");
    if (event.target === modal) {
        closeLogoutModal();
    }
}

// 3.0 JS : Show popup if there's a success message
const message = "<?php echo $successMessage; ?>";
if (message) {
    const popup = document.getElementById("popup");
    popup.style.display = "block";
    setTimeout(() => {
        popup.style.display = "none";
    }, 4000);
}
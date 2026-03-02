 GAMES = [
    { id: 1, title: "Resident Evil Village", genre: "Horror", rating: 4.8, downloads: "1.2M", size: "42GB", image: "https://upload.wikimedia.org/wikipedia/en/2/2c/Resident_Evil_Village.png", desc: "Embark on an epic journey through dying constellations." },
    { id: 2, title: "Uncharted 4", genre: "Adventure", rating: 4.5, downloads: "850K", size: "28GB", image: "https://m.media-amazon.com/images/I/71B73lI4BjL._AC_UF1000,1000_QL80_.jpg", desc: "Tactical first-person shooter set in deep space." },
    { id: 3, title: "Poppy Playtime 3", genre: "Horror", rating: 4.7, downloads: "2.1M", size: "12GB", image: "https://i.ytimg.com/vi/ECE5PiHgicQ/maxresdefault.jpg", desc: "Build, conquer, and rule the medieval world." },
    { id: 4, title: "Naruto Ultimate Ninja Storm 4", genre: "Action", rating: 4.6, downloads: "320K", size: "15GB", image: "https://image.api.playstation.com/vulcan/ap/rnd/202512/1614/9e8a8ce118e97205caf982e794f340b2084cda7f4b0d5ce3.png", desc: "Survive the terrors lurking in the forest." },
    { id: 5, title: "Elden Ring Nightreign", genre: "Adventure", rating: 4.9, downloads: "5.4M", size: "35GB", image: "https://cdn.mos.cms.futurecdn.net/ckpbJfmNhTHjRY6S7fdzeE-1200-80.jpg", desc: "Underground street racing at its peak." },
    { id: 6, title: "God of War Ragnarök", genre: "Action", rating: 4.4, downloads: "150K", size: "800MB", image: "https://upload.wikimedia.org/wikipedia/en/e/ee/God_of_War_Ragnar%C3%B6k_cover.jpg", desc: "A retro-inspired platforming masterpiece." },
    { id: 7, title: "CupHead", genre: "Shooter", rating: 4.8, downloads: "900K", size: "25GB", image: "https://assets.nintendo.com/image/upload/q_auto/f_auto/store/software/switch/70010000016330/d94d2186ef03c930392253c83c84af0c73b7e57cd902a526b09b4155a25930fe", desc: "A gripping narrative-driven survival game." },
    { id: 8, title: "Forza Horizon 5", genre: "Racing", rating: 4.7, downloads: "1.8M", size: "50GB", image: "https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1551360/header.jpg?t=1746471508", desc: "A heartwarming tale of friendship and courage." },
    { id: 9, title: "It Takes Two", genre: "Indie", rating: 4.9, downloads: "600K", size: "20GB", image: "https://assets.nintendo.com/image/upload/c_fill,w_1200/q_auto:best/f_auto/dpr_2.0/store/software/switch/70010000049281/e7200824041808289d4a65589ed368f7e08dc2e538a5fd7ee9f8d39e58015c24", desc: "A visually stunning open-world RPG." },
    { id: 10, title: "Stray", genre: "Adventure", rating: 4.6, downloads: "1M", size: "18GB", image: "https://static.wikia.nocookie.net/stray/images/0/07/Stray.png/revision/latest/thumbnail/width/360/height/360?cb=20220310061247", desc: "A heartwarming tale of friendship and courage." },
    { id: 11, title: "Spider-Man 2", genre: "Action", rating: 4.8, downloads: "2.5M", size: "45GB", image: "https://gamingbolt.com/wp-content/uploads/2023/10/Marvels-Spider-Man-2-TV-spot.jpg", desc: "A thrilling adventure in the world of Spider-Man." }];
 CATEGORIES = ["All Games", "Action", "RPG", "Strategy", "Indie", "Shooter", "Racing", "Horror"];
let currentCategory = "All Games";

// Function to render the category filter buttons
function renderCategories() {
    const container = document.getElementById('category-container');
    container.innerHTML = CATEGORIES.map(cat => `
        <button onclick="setCategory('${cat}')" class="whitespace-nowrap rounded-full px-6 py-2 text-sm font-semibold transition-all ${currentCategory === cat ? 'bg-indigo-600 text-white shadow-lg' : 'bg-white/5 text-gray-400 hover:bg-white/10'}">
            ${cat}
        </button>
`).join('');
}

// Function to render the game cards based on filter
function loadgames() {
    const grid = document.getElementById('game-grid');
    grid.innerHTML = ''; // Clear the grid first
    
    // Filter games based on current category
    let filtered = [];
    for (let i = 0; i < GAMES.length; i++) {
        if (currentCategory === "All Games" || GAMES[i].genre === currentCategory) {
            filtered.push(GAMES[i]);
        }
    }
    
    // Create a card for each game
    for (let i = 0; i < filtered.length; i++) {
        const game = filtered[i];
        
        // Create the main card div
        const card = document.createElement('div');
        card.className = 'game-card group relative flex flex-col overflow-hidden rounded-xl bg-white/5 ring-1 ring-white/10 transition cursor-pointer';
        card.style.animationDelay = (i * 0.1) + 's';
        card.onclick = function() { openModal(game.id); };
        
        // Add the card content using innerHTML
        card.innerHTML = `
            <div class="relative aspect-[4/3] overflow-hidden">
                <img src="${game.image}" class="h-full w-full object-cover transition duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
            </div>
            <div class="p-4 flex flex-col flex-1">
                <div class="flex justify-between items-start mb-1">
                    <span class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest">${game.genre}</span>
                    <div class="flex items-center gap-1 text-yellow-400 text-xs font-bold"><i data-lucide="star" class="w-3 h-3 fill-current"></i> ${game.rating}</div>
                </div>
                <h3 class="font-bold text-white group-hover:text-indigo-400 transition">${game.title}</h3>
                <div class="mt-4 flex items-center justify-between border-t border-white/5 pt-4">
                    <div class="text-[10px] text-gray-400 ">Downloads: <span>${game.downloads}</span></div>
            </div>
        `;
        
        // Add the card to the grid
        grid.appendChild(card);
    }
    
    // Refresh icons
    lucide.createIcons();
}

function setCategory(cat) {
    currentCategory = cat;
    renderCategories();
    renderGames();
}

function openModal(id) {
    const game = GAMES.find(g => g.id === id);
    document.getElementById('modal-title').innerText = game.title;
    document.getElementById('modal-genre').innerText = game.genre;
    document.getElementById('modal-desc').innerText = game.desc;
    document.getElementById('modal-img').src = game.image;
    document.getElementById('game-modal').classList.remove('hidden');
    document.body.classList.add('modal-active');
    lucide.createIcons();
}

function closeModal() {
    document.getElementById('game-modal').classList.add('hidden');
    document.body.classList.remove('modal-active');
}

function openAddGameModal() {
    document.getElementById('add-game-modal').classList.remove('hidden');
    document.body.classList.add('modal-active');
}

function closeAddGameModal() {
    document.getElementById('add-game-modal').classList.add('hidden');
    document.body.classList.remove('modal-active');
    document.getElementById('add-game-form').reset();
}

function addNewGame(event) {
    event.preventDefault();
    
    const newGame = {
        id: Math.max(...GAMES.map(g => g.id), 0) + 1,
        title: document.getElementById('game-title').value,
        genre: document.getElementById('game-genre').value,
        rating: parseFloat(document.getElementById('game-rating').value),
        downloads: document.getElementById('game-downloads').value,
        size: document.getElementById('game-size').value,
        image: document.getElementById('game-image').value,
        desc: document.getElementById('game-desc').value
    };
    
    GAMES.push(newGame);
    closeAddGameModal();
    loadgames();
    lucide.createIcons();
}

// Initial App Start
document.addEventListener('DOMContentLoaded', () => {
    renderCategories();
    loadgames();
    lucide.createIcons();
    document.getElementById('add-game-form').addEventListener('submit', addNewGame);
});




